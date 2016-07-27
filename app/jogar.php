<?php
$mapaController = Util::makeController('mapa');
$gravacaoController = Util::makeController('gravacao');
$treinadorController = Util::makeController('treinador');

$gravacao = $gravacaoController->obterComId($_SESSION['gravacao'],true);

if(!isset($_SESSION['vezIdTreinador'])){
	$treinador = current($gravacao->getTreinadores());
	$_SESSION['vezIdTreinador'] = $treinador->getId();
}else{
	/*foreach($gravacao->getTreinadores() as $t){
		if($t->getId() == $_SESSION['vezIdTreinador'])
			$_SE
	}*/
}

if(!$treinador instanceOf Treinador)
	$treinador = $treinadorController->obterComIdEGravacao($_SESSION['vezIdTreinador'],$gravacao);

$mapa = $mapaController->obterComId($treinador->getMapa()->getId());
$mapaPixels = $mapaController->obterTodosOsPixels($mapa);

?>
<style>
div.personagem{
	display:block;
	top:<?php echo ($treinador->getY()*32)-32; ?>px;
	left:<?php echo ($treinador->getX()*32)-32; ?>px;
}
</style>
<div class="wrapper">
<div class="personagem ativo" style=""></div>
<?php require_once('mapa.php'); ?>
</div>
<div id="mostraAcaos" class="mostra-acao">
	<div><img id="fotoAcao" width="80" src="/app/assets/images/pokemon.png" /></div>
	<div><h4 id="tituloAcao">Título ação</h4></div>
</div>

<script>
var xAntes = '';
var yAntes = '';
var x = <?php echo $treinador->getX(); ?>;
var y = <?php echo $treinador->getY(); ?>;
var xMaximo = <?php echo $mapa->getDimensaoX(); ?>;
var yMaximo = <?php echo $mapa->getDimensaoY(); ?>;
var idTreinador = <?php echo $_SESSION['vezIdTreinador']; ?>;
var enviaPost = false;
var posicao = '';
var anda = true;

$(document).ready(function(){
	$(document).keydown(function(event){
		if((event.keyCode >= 37 && event.keyCode <= 40) || event.keyCode == 116 || event.keyCode == 8 || event.keyCode == 13){
			event.preventDefault();
		}
		
		//Mover personagem
		if(event.keyCode >= 37 && event.keyCode <= 40 && anda == true){
			enviaPost = true;
			tecla = event.keyCode;
			
			xAntes = x;
			yAntes = y;
			if(tecla == 39)
				x = x+1;
			if(tecla == 37)
				x = x-1;
			if(tecla == 38)
				y = y-1;
			if(tecla == 40)
				y = y+1;
			
			if(x == 0){
				x = 1;
				enviaPost = false;
			}
			if(y == 0){
				y = 1;
				enviaPost = false;
			}
			
			if(enviaPost == true){
				if($('div[data-x="'+x+'"][data-y="'+y+'"]').attr('data-possivelCaminhar') == 1){
					$('#mostraAcao').hide();
					anda = false;
					posicao = $('div[data-x="'+x+'"][data-y="'+y+'"]').position();
				
					var data = {
						act : {
							t : 'TreinadorController',
							o : 'mover',
							p : {
								idTreinador : idTreinador,
								x : x,
								y : y
							}
						}
					}
					
					$.post('/php/act.php',data,function(result){
						if(result.success == true && result.message != null){
							$('#fotoAcao').attr('src','/app/assets/images/pokemon/'+result.message.foto);
							$('#tituloAcao').html(result.message.nome);
							$('#mostraAcao').show();
							anda = true;
						}
					},'json');
					$('div.personagem.ativo').animate({'top' : posicao.top+'px','left' : posicao.left+'px'},500,function(){	});
				}else{
					x = xAntes;
					y = yAntes;
				}
			}
		}
	});
});
</script>