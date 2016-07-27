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

$terrenoController = Util::makeController('terreno');
$objetoController = Util::makeController('objeto');
$terrenos = $terrenoController->obterTodos();
$objetos = $objetoController->obterTodos();
?>
<?php require_once('mapa.php'); ?>
</div>

<div class="auxiliar-editor">
	<div class="terreno-editor" data-idTerreno="" style="background-image: url('/app/assets/images/manter.jpg');"></div>
	<?php
	foreach($terrenos as $terreno){
		?>
		<div class="terreno-editor" data-idTerreno="<?php echo $terreno->getId(); ?>" style="background-size: 30px 30px; background-image: url('<?php echo $_->config->pastaImagemTerreno.$terreno->getNome(true); ?>');"></div>
		<?php
	}
	?>
	<select name="idObjeto" id="idObjeto">
		<option value="">Nenhum</option>
		<option value="0">Manter</option>
		<?php
		foreach($objetos as $objeto){
			?>
			<option value="<?php echo $objeto->getId(); ?>"><?php echo $objeto->getNome(); ?></option>
			<?php
		}
		?>
	</select>
</div>
<script>
var idTerreno = '';
var idObjeto = '';
var idMapaPixel = '';
var element = '';

$(document).ready(function(){
	$('.terreno-editor').click(function(){
		$('.terreno-editor').removeClass('selecionado');
		$(this).addClass('selecionado');
		idTerreno = $(this).attr('data-idTerreno');
	});
	
	$('.mapa-pixel').click(function(){
		idMapaPixel = $(this).attr('data-idMapaPixel');
		idObjeto = $('#idObjeto').val();
		
		element = $(this);
		
		var data = {
			act : {
				t : 'mapaController',
				o : 'updateMapaPixel',
				p : {
					idMapaPixel : idMapaPixel,
					idTerreno : idTerreno,
					idObjeto : idObjeto,
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