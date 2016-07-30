<link href="/app/assets/style/sprites.css" rel="stylesheet" />
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
<div class="personagem looking-down ativo" data-looking="down" style=""></div>
<?php require_once('mapa.php'); ?>
</div>
<div id="mostraAcaos" class="mostra-acao">
	<div><img id="fotoAcao" width="80" src="/app/assets/images/pokemon.png" /></div>
	<div><h4 id="tituloAcao">Título ação</h4></div>
</div>

<script src="/js/trainer.js"></script>

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
var boqueado = '';

$(document).ready(function(){
	
});
</script>