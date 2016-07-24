<?php
$objetoController = Util::makeController('objeto');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$objeto = $objetoController->criar();
		$objetoController->salvar($objeto,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$objeto = null;
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$objetoController->desativarComId($_GET['id']);
	}elseif(isset($_GET['id'])){
		$objeto = $objetoController->obterComId($_GET['id']);
	}

	$objetos = $objetoController->obterTodos();
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}
?>

<form method="post" id="formularioObjeto method="post" action="/objeto-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($objeto)) echo $objeto->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Objeto</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($objeto)) echo $objeto->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>

<table class="table table-hover">
	<thead>
		<tr>
			<th>#</th>
			<th>Objeto</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($objetos as $o){
			?>
			<tr>
				<td><img src="/app/assets/images/objeto/<?php echo $o->getNome(true); ?>" alt="<?php echo $o->getNome(true); ?>" title="<?php echo $o->getNome(true); ?>" /></td>
				<td><?php echo $o->getNome(); ?></td>
				<td width="14"><a href="/objeto-gerenciar/<?php echo $o->getId(); ?>" class="alterar-objeto" href=""><i class="icon-edit"></i></a></td>
				<td width="14"><a href="/objeto-gerenciar/<?php echo $o->getId(); ?>/excluir>" class="remover-objeto" href=""><i class="icon-remove"></i></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>