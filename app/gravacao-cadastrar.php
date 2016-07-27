<?php
$gravacaoController = Util::makeController('gravacao');
$mapaController = Util::makeController('mapa');
$treinadorController = Util::makeController('treinador');

try{
	global $erro;
	
	if(isset($_POST['enviar'])){
		$gravacao = $gravacaoController->criar();
		$gravacaoController->salvar($gravacao,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$gravacao = null;
	}
}catch(ServiceException $e){
	echo "<div class='alert alert-error'>Preencha os campos abaixo</div>";
}catch(Exception $e){
	echo $e->getMessage();
}

if(isset($_GET['id'])){
	$gravacao = $gravacaoController->obterComId($_GET['id']);
}

$mapas = $mapaController->obterTodos();
$treinadores = $treinadorController->obterTodos();

?>
<form id="formularioGravacao" method="post" action="/gravacao-cadastrar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($gravacao)) echo $gravacao->getId(); ?>" />
	<fieldset>
		<legend>Nova Gravação</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($gravacao)) echo $gravacao->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['idMapa'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="idMapa">Mapa</label>
			<div class="controls">
				<select name="idMapa" id="idMapa">
					<?php
					foreach($mapas as $mapa){
						?>
						<option value="<?php echo $mapa->getId(); ?>"><?php echo $mapa->getNome(); ?></option>
						<?php
					}
					?>
				</select>
				<span class="help-inline"><?php if(isset($erro['idMapa'])) echo $erro['idMapa']; ?></span>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['treinadores'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="treinadores">Treinadores</label>
			<div class="controls">
				<select name="treinadores[]" id="treinadores" multiple>
					<?php
					foreach($treinadores as $treinador){
						?>
						<option value="<?php echo $treinador->getId(); ?>"><?php echo $treinador->getNome(); ?></option>
						<?php
					}
					?>
				</select>
				<span class="help-inline"><?php if(isset($erro['treinadores'])) echo $erro['treinadores']; ?></span>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>