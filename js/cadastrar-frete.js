var request = function(name, params, cb, err) {
    if (params == undefined)
        params = {};

    params['cmd'] = name;
    $.post('/php/__admin-cadastrar-frete.php', params, function (data) {
        var res = {};
		try {
			res = JSON.parse(data);
		} catch (ex) {
			//alert('Exception parsing data!');
			if (err != undefined) err('Exception parsing data!', ex);
			return;
		}
		if (res.success != undefined && res.success == true) {
			if(res.data == null) {
				alert('Erro indefinido');
			} else {
				cb(res.data);
			}
		}
    });
};

function hideAllBut(idTable, id) {
	$("#" + idTable + " > tr").each(
		function() {
			if($(this).attr("my-id") != id) {
				$(this).hide();
			} else {
				$(this).show();
			}
		}
	);
}

function showAll(idTable) {
	switch($("#button-div").attr('b-selected')) {
		case '1':
			$("#" + idTable + " > tr[my-attr=definido]").each(
				function() {
					$(this).show();
				}
			);
			break;
		case '2':
			$("#" + idTable + " > tr[my-attr=indefinido]").each(
				function() {
					$(this).show();
				}
			);
			break;
		case '0':
		default:
			$("#" + idTable + " > tr").each(
				function() {
					$(this).show();
				}
			);
			break;
	}
}

function setHTML(idSelect, idTable, data, classTag, dispStatus) {
	var html = '';
	var html2 = '';
	var t = '', f = '';
	switch(dispStatus) {
		case '1':
			f = " style='display:none' ";
			break;
		case '2':
			t = " style='display:none' ";
			break;
		case '0':
		default:
			break;
	}
	html += "<option value='" + data[0].id + "'>" + data[0].nome + "</option>";
	for(var i =1; i < data.length; i++) {
		html += "<option value='" + data[i].id + "'>" + data[i].nome + "</option>";
		var isset = selects[data[i].tipoFrete] != undefined;
		var sf =  (isset ? selects[data[i].tipoFrete]: undef);
		var vf = (data[i].valor == undefined ? '' : data[i].valor);
		var style = (isset) ? t : f;
		
		html2 += "<tr my-id= '" + data[i].id + "' my-attr='" + (isset ? 'definido' : 'indefinido') + "' " + style + "><td><a class='" + classTag + "'>" + data[i].nome + "</a></td><td>" + sf +
						"</td><td><input class='moeda' type='text' value='" + vf + "'></td><td><button class='btn-" + classTag + "'>Salvar</button></td></tr>";
	}
	$('#' + idSelect).html(html);
	$('#' + idTable).html(html2);
}

var selects = [];
var undef;
function loadTiposFrete() {
	request('tipos-frete', {}, 
		function(data) {
			if(data.error != undefined) {
				alert(data.error);
			} else {
				for(var i = 0; i < data.length; i++) {
					var select = "<select class='frete-select'> <option value='' >Não definido</option>";
					for(var j = 0; j < data.length; j++) {
						select += "<option value='" + data[j].id + "'" + (i == j ? "selected" : "") + ">" +  data[j].frete + "</option>";
					}
					select += "</select>";
					selects[data[i].id] = select;
				}
			
			undef = "<select class='frete-select'> <option value='' selected>Não definido</option>";
			for(var j = 0; j < data.length; j++) {
				undef += "<option value='" + data[j].id + "'>" +  data[j].frete + "</option>";
			}
			undef += "</select>";
		}
	});
}

function estadoSelected(estado) {
	if(estado > 0) {
			request('gerar-cidades', {idEstado: estado}, 
				function(data) {
					if(data.error != undefined) {
						alert(data.error);
					} else {
						setHTML('cidade', 'tr-cidades', data, 'cidade-click', $('#button-div').attr('b-selected'));
						mask();
						$('#cidades-table').show();
						hideAllBut("tr-estados", estado);
						cidadeClick();
						setFreteSelectCall();
						cidadeSalvar();
					}
				}
			);
		} else {
			$('#tr-cidades').html('');
			$('#cidades-table').hide();
			showAll("tr-estados");
		}
		$('#tr-bairros').html('');
		$('#bairros-table').hide();
}

function estadoClick() {
	$('.estado-click').click(function(){
		var estado =  $(this).closest('tr').attr('my-id');
		estadoSelected(estado);
		$('#estado').val(estado);
	});
}

function estadoSalvar() {
	$('.btn-estado-click').click(function() {
		var tr = $(this).closest('tr');
		request('salvar-frete-estado', {idEstado: tr.attr('my-id'), tipoFrete: tr.find('select').val(), valorFrete: tr.find('input').val()}, 
			function(data) {
				if(data.error != undefined) {
					alert(data.error);
				} else {
					alert(data.msg);
				}
			}
		);
	});
}

function cidadeSelected(cidade) {
	if(cidade > 0) {
			request('gerar-bairros', {idCidade: cidade}, 
				function(data) {
					if(data.error != undefined) {
						alert(data.error);
					} else {
						setHTML('bairro', 'tr-bairros', data, 'bairro-click', $('#button-div').attr('b-selected'));
						mask();
						
						$('#bairros-table').show();						
						hideAllBut("tr-cidades", cidade);
						bairroClick();
						setFreteSelectCall();
						bairroSalvar();
					}
				}
			);
		} else {
			$('#tr-bairros').html('');
			$('#bairros-table').hide();
			showAll("tr-cidades");
		}
}

function cidadeSalvar() {
	$('.btn-cidade-click').click(function() {
		var tr = $(this).closest('tr');
		request('salvar-frete-cidade', {idCidade: tr.attr('my-id'), tipoFrete: tr.find('select').val(), valorFrete: tr.find('input').val()}, 
			function(data) {
				if(data.error != undefined) {
					alert(data.error);
				} else {
					alert(data.msg);
				}
			}
		);
	});
}

function cidadeClick() {
	$('.cidade-click').click(function(){
		var cidade =  $(this).closest('tr').attr('my-id');
		cidadeSelected(cidade);
		$('#cidade').val(cidade);
	});
}

function bairroSelected(bairro) {
	if(bairro > 0) {
			hideAllBut("tr-bairros", bairro);
	} else {
		showAll("tr-bairros");
	}
}

function bairroClick() {
	$('.bairro-click').click(function(){
		var bairro =  $(this).closest('tr').attr('my-id');
		bairroSelected(bairro);
		$('#bairro').val(bairro);
	});
}

function bairroSalvar() {
	$('.btn-bairro-click').click(function() {
		var tr = $(this).closest('tr');
		request('salvar-frete-bairro', {idBairro: tr.attr('my-id'), tipoFrete: tr.find('select').val(), valorFrete: tr.find('input').val()}, 
			function(data) {
				if(data.error != undefined) {
					alert(data.error);
				} else {
					alert(data.msg);
				}
			}
		);
	});
}

function setFreteSelectCall() {
	$('.frete-select').each(function() {
		var input = $(this).closest('tr').find('input');
		if($(this).val() == '') {
			input.val('');
			input.attr('disabled','disabled');
		}
	});
	$('.frete-select').change(function() {
		var tr = $(this).closest('tr');
		var input = tr.find('input');
		if($(this).val() == '') {
			tr.attr('my-attr','indefinido');
			input.val('');
			input.attr('disabled','disabled');
		} else {
			input.removeAttr('disabled');
			tr.attr('my-attr','definido');
		}
	});
}

function showHideTr(tableId, dispStatus) {
	$('#' + tableId + ' > tr').each(function() {
		if(dispStatus == '' || $(this).attr('my-attr') == dispStatus) {
			$(this).show();
		} else {
			$(this).hide();
		}
	});
}

function updateDisplayingTr(dispStatus) {
	if($('#bairro').val() > 0) {
		//do nothing
	} else if($('#cidade').val() > 0) {
		showHideTr('tr-bairros', dispStatus);
	} else if($('#estado').val() > 0) {
		showHideTr('tr-cidades', dispStatus);
	} else {
		showHideTr('tr-estados', dispStatus);
	}
	
}

function mask() {
	$('.moeda').keyup(function(e) {
		v = $(this).val();
		v=v.replace(/\D/g,""); 
		v=v.replace(/[0-9]{12}/,"");
		v=v.replace(/(\d{1})(\d{1,2})$/,"$1.$2"); 
		$(this).val(v);
	});
}

$(document).ready(function(){
	
	loadTiposFrete();
	estadoClick();
	estadoSalvar();
	setFreteSelectCall();
	mask();
	
	$("#b-todos").click(function() {
		$(this).addClass("btn-primary");
		$("#b-definidos").removeClass("btn-primary");
		$("#b-indefinidos").removeClass("btn-primary");
		$("#button-div").attr('b-selected', 0);
		updateDisplayingTr('');
	});
	
	$("#b-definidos").click(function() {
		$(this).addClass("btn-primary");
		$("#b-todos").removeClass("btn-primary");
		$("#b-indefinidos").removeClass("btn-primary");
		$("#button-div").attr('b-selected', 1);
		updateDisplayingTr('definido');
	});
	
	$("#b-indefinidos").click(function() {
		$(this).addClass("btn-primary");
		$("#b-definidos").removeClass("btn-primary");
		$("#b-todos").removeClass("btn-primary");
		$("#button-div").attr('b-selected', 2);
		updateDisplayingTr('indefinido');
	});

	$("#estado").change(function(){
		estadoSelected($(this).val());	
	});
	$("#cidade").change(function(){
		cidadeSelected($(this).val());
	});
	
	$("#bairro").change(function(){
		bairroSelected($(this).val());
	});
	
	$('#redefinir').click(
		function() {
			$('#tr-cidades').html('');
			$('#cidades-table').hide();
			$('#tr-bairros').html('');
			$('#bairros-table').hide();
			showAll("tr-estados");
		}
	);
	
	$('#btnNovoBairro').click(function(){
		if($('#cidade').val()  > 0){
			$('#divNovoBairro').toggle('slow');
		} else {
			alert('Escolha a cidade.');
		}
	});
	
	$('#salvarNovoBairro').click(function(){
		var bairro = $('#novoBairro').val();
		if(bairro != ''){
			var existe = false;
			$('#bairro option').each(function(){
				if($(this).text().toLowerCase() == bairro.toLowerCase())
					existe = true;
			});
			if(!existe){
				request('salvar-novo-bairro', {idCidade: $('#cidade').val(), novoBairro: bairro}, 
					function(data) {
						if(data.error != undefined) {
							alert(data.error);
						} else {
							var selectedId;
							for(var i =0; i < data.length; i++) {
								if(data[i].nome == bairro) {
									selectedId = data[i].id;
								}
							}
							setHTML('bairro', 'tr-bairros', data, 'bairro-click');
							mask();
							$('#bairro').val(selectedId);
							bairroSelected(selectedId);
							$('#divNovoBairro').hide();
							$('#novoBairro').val('');
							setFreteSelectCall();
							bairroSalvar();
						}
					}
				);
			} else {
				alert('O valor informado já existe.');
			}
		} else {
			alert('Digite o nome do bairro.');
		}
	});
});