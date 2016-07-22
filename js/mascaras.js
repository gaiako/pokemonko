/**
 * Mascaras
 *
 * @author
 *	Douglas Cardinot <douglas_cardinot@ig.com.br>
 * @version	1.2
 * 	Máscara cpfcnpj adicionada
 *
 * Utilitário para mascarar formulários
 */

$.fn.mascarar = function() { 
	$(this).find('input').each(function(){
		var mask = $(this).attr('data-mask');
		if(mask){
			switch(mask.toLowerCase()){
				case 'telefone' : //continue
				case 'celular' : 
					addOnKeyUp($(this), telefoneMask); break;
				case 'moeda' : addOnKeyUp($(this), moedaMask); break;
				case 'sonumeros' : addOnKeyUp($(this), soNumerosMask); break;
				case 'data' : addOnKeyUp($(this), dataMask); break;
				case 'cpf' : addOnKeyUp($(this), cpfMask); break;
				case 'cep' : addOnKeyUp($(this), cepMask); break;
				case 'cnpj' : addOnKeyUp($(this), cnpjMask); break;
				case 'url' : addOnKeyUp($(this), urlMask); break;
				case 'cpfcnpj' : addOnKeyUp($(this), cpfcnpjMask); break;
				default : alert('Máscara \"'+mask+'\" inválida');
			}
		}
	});
	
	function addOnKeyUp(element, callback){
		element.keyup(function(){
			callback(this);
		});
	}
	
	/**********************
	Máscaras
	**********************/

	function telefoneMask(z){
		v=z.value;
		v=v.substr(0,15);
		v=v.replace(/\D/g,"");
		v=v.replace(/^(\d\d)(\d)/g,"($1) $2"); 
		v=v.replace(/(\d{4})(\d)/,"$1-$2");
		v=v.substr(0,15);
		z.value = v;
	}
			
	function moedaMask(z){  
		v = z.value;
		v=v.replace(/\D/g,"");  //permite digitar apenas números
		v=v.replace(/[0-9]{12}/,"");   //limita pra máximo 999.999.999,99
		v=v.replace(/(\d{1})(\d{1,2})$/,"$1.$2");        //coloca virgula antes dos últimos 2 digitos
		z.value = v;
	}

	function soNumerosMask(z){
		v = z.value;
		v = v.replace(/\D/g,"");
		z.value = v;
	}

	function dataMask(z){
		v=z.value;
		v=v.substr(0, 10);
		v=v.replace(/\D/g,"");
		v=v.replace(/(\d{2})(\d)/,"$1/$2");
		v=v.replace(/(\d{2})(\d)/,"$1/$2");
		v=v.substr(0, 10);
		z.value = v;
	}

	function cpfMask(z){
		v=z.value;
		v=v.substr(0, 14);
		v=v.replace(/\D/g,"");
		v=v.replace(/(\d{3})(\d)/,"$1.$2");
		v=v.replace(/(\d{3})(\d)/,"$1.$2");
		v=v.replace(/(\d{3})(\d{1,2})$/,"$1-$2");
		v=v.substr(0, 14);
		z.value = v;
	}
	
	function cepMask(z){
		v=z.value;
		v=v.substr(0, 9);
		v=v.replace(/\D/g,"");
		v=v.replace(/^(\d{5})(\d)/,"$1-$2");
		v=v.substr(0, 9);
		z.value = v;
	}
	
	function cnpjMask(z){
		v=z.value;
		v=v.substr(0, 18);
		v=v.replace(/\D/g,"");
		v=v.replace(/^(\d{2})(\d)/,"$1.$2");
		v=v.replace(/^(\d{2})\.(\d{3})(\d)/,"$1.$2.$3");
		v=v.replace(/\.(\d{3})(\d)/,".$1/$2");
		v=v.replace(/(\d{4})(\d)/,"$1-$2");
		v=v.substr(0, 18);
		z.value = v;
	}

	function cpfcnpjMask(z){
		if(z.value.length > 14){
			cnpjMask(z);
		}else{
			cpfMask(z);
		}
	}
	
	function urlMask(z){
		v=z.value;
		v=v.toLowerCase();
		v=v.replace(/[^0-9a-z\-\.\_]/g,"");
		v=v.replace(" ","");
		z.value=v;
	}
};