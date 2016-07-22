//Função que recebe um elemento do tipo input/text ou textarea e o seu texto padrão e apaga ou atribui o texto padrão
//Deve ser chamada tanto pelo onfocus quanto pelo onblur
function clique(elemento, texto){
	if(elemento.value == texto)
		elemento.value = "";
	else if(elemento.value == ""){
		elemento.value = texto;
	}
}

/**
* Função que retorna o parâmetro get enviado.
* Para que funcione, é necessário que esteja da forma simples o GET na URL
* Ex.: minha-pagina.html?id=2&c=12
* Assim, $_GET(id) retornará '2'
*/
function $_GET(q){
	loc = window.location.href.toString();
	qS = loc.substring(loc.indexOf('?')+1, loc.length);
	sqS = qS.split('&');
	fGV = sqS;
	rA = new Array();
	for(i = 0; i < fGV.length; i++){
		nowEd = fGV[i];
		ioE = nowEd.indexOf('=');
		a = nowEd.substring(0, ioE);
		d = nowEd.substring(ioE+1, nowEd.length);
		rA[a] = d;
	}
	return rA[q];
}

Number.prototype.formatNumber = function(decimals, sepDecimals, sepThousand){
	if(decimals==null) decimals=2;  
	if(sepDecimals==null) sepDecimals=',';
	if(sepThousand==null) sepThousand='.';  
	
	var n = new String(this.toFixed(decimals)).replace('.','').split('');
	n.reverse();
	var fn = new Array();
	var cont = decimals+1;
	for(this.i=0;this.i<n.length;this.i++){
		if(this.i==decimals-1 && n.length>decimals-1){
			fn.unshift(sepDecimals+n[this.i]);
		}else{
			if(cont--==0 && this.i != n.length-1){
				fn.unshift(sepThousand+n[this.i]);
				cont = 2;
			}else fn.unshift(n[this.i]);
		} 
	}
	return fn.join('');
}

function str_pad (input, pad_length, pad_string, pad_type) {
    // Returns input string padded on the left or right to specified length with pad_string
    //
    // version: 1009.2513
    // discuss at: http://phpjs.org/functions/str_pad
    // +   original by: Kevin van Zonneveld (http://kevin.vanzonneveld.net)
    // + namespaced by: Michael White (http://getsprink.com)
    // +      input by: Marco van Oort
    // +   bugfixed by: Brett Zamir (http://brett-zamir.me)
    // *     example 1: str_pad('Kevin van Zonneveld', 30, '-=', 'STR_PAD_LEFT');
    // *     returns 1: '-=-=-=-=-=-Kevin van Zonneveld'
    // *     example 2: str_pad('Kevin van Zonneveld', 30, '-', 'STR_PAD_BOTH');
    // *     returns 2: '------Kevin van Zonneveld-----'
    var half = '', pad_to_go;
 
    var str_pad_repeater = function (s, len) {
        var collect = '', i;
 
        while (collect.length < len) {collect += s;}         collect = collect.substr(0,len);           return collect;     };       input += '';     pad_string = pad_string !== undefined ? pad_string : ' ';          if (pad_type != 'STR_PAD_LEFT' && pad_type != 'STR_PAD_RIGHT' && pad_type != 'STR_PAD_BOTH') { pad_type = 'STR_PAD_RIGHT'; }     if ((pad_to_go = pad_length - input.length) > 0) {
        if (pad_type == 'STR_PAD_LEFT') { input = str_pad_repeater(pad_string, pad_to_go) + input; }
        else if (pad_type == 'STR_PAD_RIGHT') { input = input + str_pad_repeater(pad_string, pad_to_go); }
        else if (pad_type == 'STR_PAD_BOTH') {
            half = str_pad_repeater(pad_string, Math.ceil(pad_to_go/2));
            input = half + input + half;
            input = input.substr(0, pad_length);
        }
    }
 
    return input;
}

function addCharCount(id, max) {
    $(id).keyup(function(){
        $(id).siblings('.help-inline').html('Você digitou '+$(this).val().length+' caracteres. Este campo deve ser preenchido com, no máximo, '+max+' caracteres.')
        if($(this).val().length > max)
            $(id).parents('.control-group').addClass('error').removeClass('success');
        else
            $(id).parents('.control-group').removeClass('error').addClass('success');
    });
}

function validarFormularioAnuncie(){
	var form = $("#formulario-anuncie");
	var valido = true;
	form.find(".obrigatorio").each(function(){
		if($(this).val() == ""){
			$(this).css("borderColor", "red");
			valido = false;
		}else{
			$(this).css("borderColor", "#91C556");
		}
	});
	return valido;
}

function gerarEndereco(endereco){
	var texto = endereco.endereco;
	texto += ", nº "+endereco.numero;
	texto += " - "+endereco.bairro.bairro;
	return texto;
}