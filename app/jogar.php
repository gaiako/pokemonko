<?php
$_SESSION['vezIdTreinador'] = 8;
$mapaController = Util::makeController('mapa');
$gravacaoController = Util::makeController('gravacao');
$treinadorController = Util::makeController('treinador');
$pokemonController = Util::makeController('pokemon');

$gravacao = $gravacaoController->obterComId($_SESSION['gravacao'],true);

if(!isset($_SESSION['vezIdTreinador'])){
	$treinadores = $gravacao->getTreinadores();
	$treinador = $treinadores[0];
	$_SESSION['vezIdTreinador'] = $treinador->getId();
}else{
	$dado = 0;
	if($dado == 0)
		$gravacaoController->passarAVez();
	$treinador = $treinadorController->obterTreinadorDaVez();
}
$treinadores = $gravacao->getTreinadores();

$mapa = $mapaController->obterComId($treinador->getMapa()->getId());
$mapaPixels = $mapaController->obterTodosOsPixels($mapa);

$pokemons = $pokemonController->obterComRestricoes(array('idMapa'=>$mapa->getId()));
?>
<style>
div.personagem{
	position: relative;
	width: 64px;
	height: 64px;
	background-repeat: no-repeat;
	margin-bottom:-64px;
	z-index:1000;
}

<?php
foreach($gravacao->getTreinadores() as $k => $t){
	?>
	div.looking-down.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-down.png'; ?>');
	}div.looking-down.n<?php echo $k; ?>.water{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-down-w.png'; ?>');
	}div.looking-down.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-down;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-up.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-up.png'; ?>');
	}div.looking-up.n<?php echo $k; ?>.water{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-up-w.png'; ?>');
	}div.looking-up.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-up;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-right.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-right.png'; ?>');
	}div.looking-right.n<?php echo $k; ?>.water{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-right-w.png'; ?>');
	}div.looking-right.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-right;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-left.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-left.png'; ?>');
	}div.looking-left.n<?php echo $k; ?>.water{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-left-w.png'; ?>');
	}div.looking-left.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-left;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}
	<?php
}
?>

div.water{
	z-index:200;
}

@keyframes personagemAnimacao-down {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-down-f1.png'); }
	25% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-down-f2.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-down-f1.png'); }
	75% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-down-f2.png'); }
}

@keyframes personagemAnimacao-up {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-up-f1.png'); }
	25% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-up-f2.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-up-f1.png'); }
	75% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-up-f2.png'); }
}

@keyframes personagemAnimacao-left {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-left-f1.png'); }
	25% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-left-f2.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-left-f1.png'); }
	75% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-left-f2.png'); }
}

@keyframes personagemAnimacao-right {
	0% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-right-f1.png'); }
	25% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-right-f2.png'); }
	50% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-right-f1.png'); }
	75% { background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$treinador->getSprite() ?>-right-f2.png'); }
}

div.pokemon{
	position: relative;
	width: 64px;
	height: 64px;
	margin-bottom:-64px;
	z-index:1000;
}
</style>
<div class="wrapper">
	<div id="pokemons">
		<?php
		foreach($pokemons as $pokemon){
			?>
			<div class="pokemon" 
			data-idPokemon="<?php echo $pokemon->getId(); ?>" 
			style="
			display: block;
			background-image: url('/app/assets/images/pokemon/overworld/<?php echo $pokemon->getLooking(); ?>/<?php echo $pokemon->getPokemonBase()->getId(); ?>.png');
			top:<?php echo ($pokemon->getY()*64)-64; ?>px;
			left:<?php echo ($pokemon->getX()*64)-64; ?>px;
			"></div>
			<?php
		}
		?>
	</div>
	<div id="personagens">
		<?php
		foreach($gravacao->getTreinadores() as $k => $t){
			?>
			<div <?php if($t->getId() == $treinador->getId()) echo 'id="ativo"'; ?> class="personagem n<?php echo $k; ?> looking-<?php echo $t->getLooking(); if($t->getId() == $treinador->getId()) echo ' ativo'; ?>" data-looking="<?php echo $t->getLooking(); ?>" data-id="<?php echo $t->getId(); ?>" style="
			display:block;
			top:<?php echo ($t->getY()*64)-64; ?>px;
			left:<?php echo ($t->getX()*64)-64; ?>px;
			"></div>
			<?php
		}
		?>
	</div>
<?php require_once('mapa.php'); ?>
</div>

<div class="pokemon-capturado escondido">
	<div class="titulo">Capturado! <i class="icon-close"></i></div>
	<div class="gif-pokemon-capturado" style="background-image: url('/app/assets/images/pokemon/gif/pikachu.gif')">
	</div>
	<div class="nome" id="nome-pokemon-capturado">Pikachu</div>
	<div class="tipos">
		<span id="tipo1" class="label"></span>
		<span id="tipo2" class="label"></span>
	</div>
	<div class="nivel">Nível <span id="nivel"></span></div>
	<div class="status">
		<div class="hp">HP: <span id="hp"></span></div>
		<div class="ataque">Ataque: <span id="ataque"></span></div>
		<div class="defesa">Defesa: <span id="defesa"></span></div>
		<div class="ataqueEspecial">Atq. Especial: <span id="ataqueEspecial"></span></div>
		<div class="defesaEspecial">Def. Especial: <span id="defesaEspecial"></span></div>
		<div class="velocidade">Velocidade: <span id="velocidade"></span></div>
		<div class="links">
			<span class="fechar">fechar</span>
			<span class="divisor"> - </span>
			<span class="ver-pokemons"><a href="/treinador-painel">ver</a></span>
		</div>
	</div>
</div>

<div class="pokemon clone"></div>

<script src="/js/trainer.js"></script>

<script>
$(document).ready(function(){
	
});
</script>