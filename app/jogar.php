<link href="/app/assets/style/sprites.css" rel="stylesheet" />
<?php
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
		foreach($gravacao->getTreinadores() as $t){
			?>
			<div class="personagem looking-<?php echo $t->getLooking(); if($t->getId() == $treinador->getId()) echo ' ativo'; ?>" data-looking="<?php echo $t->getLooking(); ?>" style="
			display:block;
			background-image: url('/app/assets/images/sprite/<?php echo $t->getSprite(); ?>');
			top:<?php echo ($t->getY()*32)-32; ?>px;
			left:<?php echo ($t->getX()*32)-32; ?>px;
			"></div>
			<?php
		}
		?>
	</div>
<?php require_once('mapa.php'); ?>
</div>

<div class="pokemon clone"></div>

<script src="/js/trainer.js"></script>

<script>
var idMapa = <?php echo $mapa->getId(); ?>;
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
				for(i=0;i<result.message.del.length;i++){
					var delDiv = $('#pokemons').find('div.pokemon[data-idPokemon="'+result.message.del[i]+'"]').fadeOut('slow').remove();
					//var delDiv = $('#pokemons').find('div:first').fadeOut('slow').remove();
				}
			}
		}else{
			console.log(result.message);
		}
	},'json');
}

$(document).ready(function(){
	criarPokemonAleatoriamente();
	setInterval(criarPokemonAleatoriamente,<?php echo $mapa->getIntervaloCriacao()*1000; ?>);
});
</script>