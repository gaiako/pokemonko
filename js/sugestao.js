var request = function(name, params, cbs, cbf, err) {
	 if (params == undefined)
        params = {};

    params['cmd'] = name;
	
    $.post('/php/get/__admin_sugestoes-prod.php', params, function (data) {
        var res = {};
        try {
            res = JSON.parse(data);
        } catch (ex) {
            //alert('Exception parsing data!');
            if (err != undefined) err('Exception parsing data!', ex);
            return;
        }
        if (res.success != undefined && res.success == true)
            cbs(res.data);
        else {
            if (err != undefined) err(res.message);
			cbf();
             alert(res.message);
        }
    });
};

var display = function (el, status) {
    if (status === undefined) status = true;
    el.css('display', status ? 'block' : 'none');
}

var disable = function (el, status) {
    if (status === undefined) status = true;
    el.prop('disabled', status).css('pointerEvents', !status ? 'auto' : 'none');
}

var loading = function (status, a, b) {
    disable(a, status);
    b.css('display', status ? 'inline-block' : 'none');
}

var lock = function () {
        display($('#loading-box'));
		display($('.loading'));
		display($('#field-search-p'), false);
};

var unlock = function () {
     display($('#loading-box'), false);
	 display($('.loading'), false);
	 display($('#field-search-p'));
};

$('#formulario-sugestao').submit(function(e){
	e.preventDefault();
	return false;
});

$('#formulario-sugestao').keypress(function(e){
	if(e.which == 13) {
		e.preventDefault();
		return false;
	}
});

$('.btn-remover').click(function(){
					var p = $(this).closest('tr');
					delete selectedIds[p.attr('id-p')] ;
					p.remove();
});

var selectedIds = {};

var init = function () {
	$('#selected-p > tr').each(function() {
		selectedIds[$(this).attr('id-p')] = true;
	});
}


$('#search-p').keypress(function(e) {
	if (e.which == 13) $('#btn-search-p').click();
});
$('#btn-search-p').click(function (e) {
		lock();
		var cbs = function(data) {
			$('#found-p').text('');
			for(var i=0; i < data.length; i++) {
				if(selectedIds[data[i].id] == undefined && data[i].id != $('#idProduto').val()) {
					var str = '<tr id="' + data[i].id + '"><td>' + data[i].referencia + '</td><td>' + data[i].nome + '</td><td>R$' + data[i].valor + '</td><td><button class="btn-adicionar">Adicionar</button></td></tr>';
					$('#found-p').append(str);
				}
			}
			$('.btn-adicionar').click(function(){
				var t = $(this);
				var p = $(this).closest('tr');
				var tds = p.find('td');	
				var str = '<tr id-p="' + p.attr('id') + '"><td>' + tds[0].innerHTML+ '</td><td>' + tds[1].innerHTML + '</td><td>R$' + tds[2].innerHTML + '</td><td><button class="btn-remover">Remover</button></td></tr>';
				$('#selected-p').append(str);
				selectedIds[p.attr('id')] = true;
				p.remove();
				$('.btn-remover').click(function(){
					var p = $(this).closest('tr');
					delete selectedIds[p.attr('id-p')] ;
					p.remove();
				});
			});
			unlock();
		};
		
		var cbf = function(data) { unlock(); };
	var cat = $('#filter-by-c').hasClass('active') ? 1 : 0;
	request('product_list', { 'busca': $('#search-p').val(), 'categoria': cat }, cbs, cbf);
});

$('#filter-by-p').click(function() {
	$(this).addClass('active');
	$('#filter-by-c').removeClass('active');
});

$('#filter-by-c').click(function() {
	$(this).addClass('active');
	$('#filter-by-p').removeClass('active');
});

$('#btn-limpar').click(function(e){
	$('#selected-p').text('');
	selectedIds = {};
});

$('#save-refs').click(function(e){
	var cbs = function(data) {
		alert(data.msg);
		display($('#sugestao-loading'), false);
	};
	var cbf = function(data) {
		display($('#sugestao-loading'), false);
	};
	var idSugestoes = [];
	for(var key in selectedIds) {
		idSugestoes.push(key);
	}
	var idProduto = $('#idProduto').val();
	request('save_refs', {'idProduto': idProduto, 'idSugestoes': JSON.stringify(idSugestoes)}, cbs, cbf);
	display($('#sugestao-loading'));
});

init();