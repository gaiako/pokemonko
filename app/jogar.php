<?php
$_SESSION['vezIdTreinador'] = 1;
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
	$treinador = $treinadorController->obterTreinadorDaVez();
}

$mapa = $mapaController->obterComId($treinador->getMapa()->getId());
$mapaPixels = $mapaController->obterTodosOsPixels($mapa);

$pokemons = $pokemonController->obterComRestricoes(array('idMapa'=>$mapa->getId()));
?>
<style>
div.personagem{
	position: relative;
	width: 32px;
	height: 32px;
	background-repeat: no-repeat;
	margin-bottom:-30px;
	z-index:1000;
}

<?php
foreach($gravacao->getTreinadores() as $k => $t){
	?>
	div.looking-down.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-down.png'; ?>');
	}div.looking-down.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-down;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-up.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-up.png'; ?>');
	}div.looking-up.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-up;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-right.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-right.png'; ?>');
	}div.looking-right.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-right;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}

	div.looking-left.n<?php echo $k; ?>{
		background-image: url('<?php echo $config->pastaImagemSpriteAnimated.$t->getSprite().'-left.png'; ?>');
	}div.looking-left.n<?php echo $k; ?>.animated{
		animation-name: personagemAnimacao-left;
		animation-duration: 400ms;
		animation-timing-function: infinite;
	}
	<?php
}
?>

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
	width: 32px;
	height: 32px;
	margin-bottom:-32px;
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
			top:<?php echo ($pokemon->getY()*32)-32; ?>px;
			left:<?php echo ($pokemon->getX()*32)-32; ?>px;
			"></div>
			<?php
		}
		?>
	</div>
	<div id="personagens">
		<?php
		foreach($gravacao->getTreinadores() as $k => $t){
			?>
			<div class="personagem n<?php echo $k; ?> looking-<?php echo $t->getLooking(); if($t->getId() == $treinador->getId()) echo ' ativo'; ?>" data-looking="<?php echo $t->getLooking(); ?>" style="
			display:block;
			top:<?php echo ($t->getY()*32)-32; ?>px;
			left:<?php echo ($t->getX()*32)-32; ?>px;
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
		<div class="links">Fechar</div>
	</div>
</div>

<div class="pokemon clone"></div>

<script src="/js/trainer.js"></script>

<script>
var raiz = '<?php echo $raiz; ?>';
var idMapa = <?php echo $mapa->getId(); ?>;
var xAntes = '';
var yAntes = '';
var x = <?php echo $treinador->getX(); ?>;
var y = <?php echo $treinador->getY(); ?>;
var xMaximo = <?php echo $mapa->getDimensaoX(); ?>;
var yMaximo = <?php echo $mapa->getDimensaoY(); ?>;
var idTreinador = <?php echo $_SESSION['vezIdTreinador']; ?>;
var enviaPost = false;
var anda = true;
var posicao = '';
var boqueado = '';

function criarPokemonAleatoriamente(){
	var data = {
		act : {
			t : 'MapaController',
			o : 'criarPokemonAleatoriamente',
			p : {
				idMapa : idMapa
			}
		}
	}
	
	$.post('/php/act.php',data,function(result){
		//console.log(result);
		if(result.success == true){
			if(result.message.add != null){
				var div = $('.pokemon.clone').clone(1);
				div.attr('data-idPokemon',result.message.add.id);
				div.css('background-image','url("/app/assets/images/pokemon/overworld/'+result.message.add.looking+'/'+result.message.add.pokemonBase.id+'.png")');
				div.css('top',result.message.add.y*(32)-32+'px');
				div.css('left',result.message.add.x*(32)-32+'px');
				div.removeClass('clone');
				div.hide();
				$('#pokemons').append(div);
				div.fadeIn('slow');
			}
			
			if(result.message.del != null){
				delDivs(result.message.del);
			}
		}else{
			console.log(result.message);
		}
	},'json');
}

$(document).ready(function(){
	criarPokemonAleatoriamente();
	setInterval(criarPokemonAleatoriamente,<?php echo $mapa->getIntervaloCriacao()*1000; ?>);
	
	$('.links').click(function(){
		$('.pokemon-capturado').addClass('escondido');
	});
});
</script>