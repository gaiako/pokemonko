<?php
$tipoController = Util::makeController('tipo');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$tipo = $tipoController->criar();
		$tipoController->salvar($tipo,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$tipo = null;
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$tipoController->desativarComId($_GET['id']);
	}else{
		$tipo = $tipoController->obterComId($_GET['id']);
	}

	$tipos = $tipoController->obterTodos();
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}

?>
<form id="formularioProduto" method="post" action="/tipo-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($tipo)) echo $tipo->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Tipo</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($tipo)) echo $tipo->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['cor'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="cor">Cor</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="text" class='color' name='cor' value="<?php if(isset($tipo)) echo $tipo->getCor(); ?>" />
				</div>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>

<div class="modal-body lista-tipos" id="lista-tipos">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Tipo</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($tipos as $t){
				?>
				<tr>
					<td><?php echo $t->getId(); ?></td>
					<td><span class="label" style="background-color:<?php echo $t->getCor(); ?>;"><?php echo $t->getNome(); ?></span></td>
					<td width="14"><a href="/tipo-gerenciar/<?php echo $t->getId(); ?>" class="alterar-tipo" href=""><i class="icon-edit"></i></a></td>
					<td width="14"><a href="/tipo-gerenciar/<?php echo $t->getId(); ?>/excluir" class="remover-tipo" href=""><i class="icon-remove"></i></a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<script>
$(document).ready(function(){
	$('form').on("click", '.habilitado-duplicacao .duplicar', function(){

		if($(this).parent().parent().find(".duplicar").length >= 4){
			return false;
		}

		var parent = $(this).parent();
		var clone = parent.clone(1);
		var myPicker = new jscolor.color(clone.find("input")[0]);
		myPicker.fromString('FFFFFF')
		parent.after(clone);
		return false;

	}).on("click", '.habilitado-duplicacao .remover', function(){

		if($(this).parent().parent().find(".remover").length <= 1){
			$(this).parent().find("input").val("");
		}else{
			$(this).parent().remove();
		}
		return false;

	});
});
</script>