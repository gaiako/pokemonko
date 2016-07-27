<style>
.mapa-pixel:hover{
	margin:-1px;
	border:1px solid #FF0000;
}
</style>
<div class="wrapper">
<?php
$mapaController = Util::makeController('mapa');

$mapa = $mapaController->obterComId($_GET['id']);
$mapaPixels = $mapaController->obterTodosOsPixels($mapa);
require_once('mapa.php');

$terrenos = Util::todasAsImagensNaPasta('/app/assets/images/terreno/');
$objetos = Util::todasAsImagensNaPasta('/app/assets/images/objeto/');
require_once('mapa.php'); ?>
</div>

<div class="auxiliar-editor left">
	<div>
		<div class="change-side"></div>
		<div class="terreno-editor" data-terreno="" style="background-image: url('/app/assets/images/manter.jpg');"></div>
		<?php
		foreach($terrenos as $terreno){
			?>
			<div class="terreno-editor" data-terreno="<?php echo $terreno->getNome(true); ?>" style="background-size: 32px 32px; background-image: url('<?php echo $_->config->pastaImagemTerreno.$terreno->getNome(true); ?>');"></div>
			<?php
		}
		?>
	</div>
	<div>
		<div class="change-side"></div>
		<div class="objeto-editor" data-objeto="" style="background-image: url('/app/assets/images/manter.jpg');"></div>
		<?php
		foreach($objetos as $objeto){
			?>
			<div class="objeto-editor" data-objeto="<?php echo $objeto->getNome(true); ?>" style="background-size: 32px 32px; background-image: url('<?php echo $_->config->pastaImagemObjeto.$objeto->getNome(true); ?>');"></div>
			<?php
		}
		?>
		<div class="change-side"></div>
	</div>
</div>
<script>
var terreno = '';
var objeto = '';
var idMapaPixel = '';
var element = '';

$(document).ready(function(){
	$('.terreno-editor').click(function(){
		$('.terreno-editor').removeClass('selecionado');
		$(this).addClass('selecionado');
		terreno = $(this).attr('data-terreno');
	});
	
	$('.objeto-editor').click(function(){
		$('.objeto-editor').removeClass('selecionado');
		$(this).addClass('selecionado');
		objeto = $(this).attr('data-objeto');
	});
	
	$('.change-side').click(function(){
		$('.auxiliar-editor').toggleClass('left');
		$('.auxiliar-editor').toggleClass('right');
	});
	
	$('.mapa-pixel').click(function(){
		idMapaPixel = $(this).attr('data-idMapaPixel');
		
		element = $(this);
		
		var data = {
			act : {
				t : 'mapaController',
				o : 'updateMapaPixel',
				p : {
					idMapaPixel : idMapaPixel,
					terreno : terreno,
					objeto : objeto,
					idAcao : null,
					dificuldade : null
				}
			}
		}
		
		$.post('/php/act.php',data,function(result){
			if(result.message.style != '')
				element.attr('style',result.message.style);
			element.html(result.message.objeto);
		},'json');
	});
});
</script>