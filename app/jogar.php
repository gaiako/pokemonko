<link href="/app/assets/style/sprites.css" rel="stylesheet" />
<?php
$mapaController = Util::makeController('mapa');
$gravacaoController = Util::makeController('gravacao');
$treinadorController = Util::makeController('treinador');
$pokemonController = Util::makeController('pokemon');

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
		<div class="personagem looking-down ativo" data-looking="down" style="
		display:block;
		top:<?php echo ($treinador->getY()*32)-32; ?>px;
		left:<?php echo ($treinador->getX()*32)-32; ?>px;
		"></div>
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
		if(result.success == true){
			var div = $('.pokemon.clone').clone(1);
			div.attr('data-idPokemonBase',result.message.add.id);
			div.css('background-image','url("/app/assets/images/pokemon/overworld/'+result.message.add.looking+'/'+result.message.add.pokemonBase.id+'.png")');
			div.css('top',result.message.add.y*(32)-32+'px');
			div.css('left',result.message.add.x*(32)-32+'px');
			div.removeClass('clone');
			div.hide();
			$('#pokemons').append(div);
			div.fadeIn('slow');
			
			if(result.message.del != null){
				for(i=0;i<result.message.del.length;i++){
					$('.pokemon[data-idPokemon="'+result.message.del[i]+'"]').fadeOut('slow').remove();
				}
			}
		}
	},'json');
}

$(document).ready(function(){
	setInterval(criarPokemonAleatoriamente,20000);
});
</script>