<?php
$gravacaoController = Util::makeController('gravacao');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$gravacao = $gravacaoController->criar();
		$gravacaoController->salvar($gravacao,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$gravacao = null;
	}
	
	if(isset($_GET['id'])){
		$gravacao = $gravacaoController->obterComId($_GET['id']);
	}
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}

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
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>