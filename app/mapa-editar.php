<style>
.mapa-pixel:hover{
	margin:-1px;
	border:1px solid #FF0000;
}
</style>
<div class="wrapper">
<?php
$mapaController = Util::makeController('mapa');
$grupoController = Util::makeController('grupo');

$mapa = $mapaController->obterComId($_GET['id']);
$mapaPixels = $mapaController->obterTodosOsPixels($mapa);
$editor = true;
require_once('mapa.php');

$terrenos = Util::todasAsImagensNaPasta('/app/assets/images/terreno/');
$objetos = Util::todasAsImagensNaPasta('/app/assets/images/objeto/');
$grupos = $grupoController->obterTodos();
require_once('mapa.php'); ?>
</div>

<div class="auxiliar-editor left">
	X: <span id="xDe"></span> - <span id="xAte"></span><br />
	Y: <span id="yDe"></span> - <span id="yAte"></span><br />
	<select name="idGrupo" id="idGrupo" class="input-small">
		<option value=""></option>
		<?php
		foreach($grupos as $grupo){
			?>
			<option value="<?php echo $grupo->getId(); ?>"><?php echo $grupo->getNome(); ?></option>
			<?php
		}
		?>
	</select> (G)<br />
	PC: <span id="possivelCaminhar">Sim</span> (y/n - espaço)<br />
	Bq: <span id="bloqueadoDirecional">null</span> (direcionais/L - click)
	<div>
		<div class="change-side"></div>
		<div class="terreno-editor" data-terreno="" style="background-image: url('/app/assets/images/manter.jpg');"></div>
		<?php
		foreach($terrenos as $terreno){
			?>
			<div class="terreno-editor" data-terreno="<?php echo $terreno->getNome(true); ?>" style="background-size: 32px 32px; background-image: url('<?php echo $config->pastaImagemTerreno.$terreno->getNome(true); ?>');"></div>
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
			<div class="objeto-editor" data-objeto="<?php echo $objeto->getNome(true); ?>" style="background-size: 32px 32px; background-image: url('<?php echo $config->pastaImagemObjeto.$objeto->getNome(true); ?>');"></div>
			<?php
		}
		?>
		<div class="change-side"></div>
	</div>
</div>
<script>
var idMapa = <?php echo $mapa->getId(); ?>;
var terreno = '';
var objeto = '';
var idMapaPixel = '';
var element = '';
var codigo = '';
var possivelCaminhar = 1;
var bloqueado = '';
var idGrupo = 0;
var posicaoSelecionada = 1;
var x = {};
var y = {};

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
		
		if(terreno == "" && objeto == ""){
			x[posicaoSelecionada] = $(this).attr('data-x');
			y[posicaoSelecionada] = $(this).attr('data-y');
			if(posicaoSelecionada == 1){
				$('#xDe').html(x[posicaoSelecionada]);
				$('#yDe').html(y[posicaoSelecionada]);
			}else{
				$('#xAte').html(x[posicaoSelecionada]);
				$('#yAte').html(y[posicaoSelecionada]);
			}
		}else{
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
						bloqueado : bloqueado
					}
				}
			}
			
			$.post('/php/act.php',data,function(result){
				if(result.message.style != '')
					element.attr('style',result.message.style);
				element.html(result.message.objeto);
			},'json');
		}
	});
	
	$(document).keydown(function(event){
		event.preventDefault();
		
		codigo = event.keyCode;
		console.log(codigo);
		
		if(codigo == 49){
			posicaoSelecionada = '1';
		}
		if(codigo == 50){
			posicaoSelecionada = '2';
		}
		
		if(codigo == 89){
			possivelCaminhar = 1;
			$('#possivelCaminhar').html('Sim');
		}
		if(codigo == 78){
			possivelCaminhar = 0;
			$('#possivelCaminhar').html('Não');
		}
		
		if(codigo == 37 || codigo == 38 || codigo == 39 || codigo == 40){
			bloqueado = codigo;
			$('#bloqueadoDirecional').html(bloqueado);
		}
		if(codigo == 76){
			bloqueado = null;
			$('#bloqueadoDirecional').html('null');
		}
		
		if(codigo == 32){//espaço
			var data = {
				act : {
					t : 'mapaController',
					o : 'setPossivelCaminhar',
					p : {
						idMapa : idMapa,
						possivelCaminhar : possivelCaminhar,
						x : x,
						y : y
					}
				}
			}
			
			$.post('/php/act.php',data,function(result){
				location.reload();
			},'json');
		}
		
		if(codigo == 71){//G - grupo
			idGrupo = $('#idGrupo').val();
			
			var data = {
				act : {
					t : 'mapaController',
					o : 'setIdGrupo',
					p : {
						idMapa : idMapa,
						idGrupo : idGrupo,
						x : x,
						y : y
					}
				}
			}
			
			$.post('/php/act.php',data,function(result){
				location.reload();
			},'json');
		}
	});
});
</script>