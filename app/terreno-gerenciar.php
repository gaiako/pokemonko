<?php
$terrenoController = Util::makeController('terreno');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$terreno = $terrenoController->criar();
		$terrenoController->salvar($terreno,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$terreno = null;
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$terrenoController->desativarComId($_GET['id']);
	}elseif(isset($_GET['id'])){
		$terreno = $terrenoController->obterComId($_GET['id']);
	}

	$terrenos = $terrenoController->obterTodos();
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}
?>

<form method="post" id="formularioTerreno method="post" action="/terreno-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($terreno)) echo $terreno->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Terreno</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($terreno)) echo $terreno->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['cor'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="cor">Cor</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="text" class='color' name='cor' value="<?php if(isset($terreno)) echo $terreno->getCor(); ?>" />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['bloqueadoUp'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="bloqueadoUp">Bloqueado Up</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="checkbox" name="bloqueadoUp" id="bloqueadoUp" value="1" <?php if(isset($terreno) && $terreno->getBloqueadoUp()) echo 'checked'; ?> />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['bloqueadoLeft'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="bloqueadoLeft">Bloqueado Left</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="checkbox" name="bloqueadoLeft" id="bloqueadoLeft" value="1" <?php if(isset($terreno) && $terreno->getBloqueadoLeft()) echo 'checked'; ?> />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['bloqueadoRight'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="bloqueadoRight">Bloqueado Right</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="checkbox" name="bloqueadoRight" id="bloqueadoRight" value="1" <?php if(isset($terreno) && $terreno->getBloqueadoRight()) echo 'checked'; ?> />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['bloqueadoDown'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="bloqueadoDown">Bloqueado Down</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="checkbox" name="bloqueadoDown" id="bloqueadoDown" value="1" <?php if(isset($terreno) && $terreno->getBloqueadoDown()) echo 'checked'; ?> />
				</div>
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
			<th>Terreno</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($terrenos as $t){
			?>
			<tr>
				<td><i class="preview-terreno" style="background-color:<?php echo $t->getCor(); ?>"></i></td>
				<td><?php echo $t->getNome(); ?></td>
				<td width="14"><a href="/terreno-gerenciar/<?php echo $t->getId(); ?>" class="alterar-terreno" href=""><i class="icon-edit"></i></a></td>
				<td width="14"><a href="/terreno-gerenciar/<?php echo $t->getId(); ?>/excluir>" class="remover-terreno" href=""><i class="icon-remove"></i></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>