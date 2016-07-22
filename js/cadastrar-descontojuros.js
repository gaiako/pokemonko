$(document).ready(function(){
	$('#adicionarParcela').click(function(){
		adicionarParcela(contador,'');
		contador++;
		if(contador > 18)
			$(this).attr('disabled','disabled');
		else
			$('#removerParcela').removeAttr('disabled');
		$('#formulario-cadastro-descontojuros').mascarar();
	});

	$('#removerParcela').on('click',function(){
		$('.campos-desconto-juros:last').remove();
		contador--;
		if(contador == 2)
			$(this).attr('disabled','disabled');
		else
			$('#adicionarParcela').removeAttr('disabled');
	});
});
function adicionarParcela(vezes,valor){
	var string = '<div class="campos-desconto-juros"><div class="input-append"><input type="number" class="input-mini vezes" name="vezes[]" value="'+vezes+'" readonly="readonly" /><span class="add-on">x</span></div><div class="input-append"><input class="input-mini juros" type="text" name="valor[]" value="'+valor+'" placeholder="Juros*" data-mask="moeda" /><div class="add-on">%</div></div></div>';
	$('#listaParcela').append(string);
}