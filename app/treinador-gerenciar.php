<?php
$treinadorController = Util::makeController('treinador');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$treinador = $treinadorController->criar();
		$treinadorController->salvar($treinador,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso - <a href='gravacao-cadastrar'>Criar gravação</a></div>";
		$treinador = null;
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$treinadorController->desativarComId($_GET['id']);
	}elseif(isset($_GET['id'])){
		$treinador = $treinadorController->obterComId($_GET['id']);
	}

	$treinadores = $treinadorController->obterTodos();
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}

?>
<form id="formularioTreinador" method="post" action="/treinador-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($treinador)) echo $treinador->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Treinador</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($treinador)) echo $treinador->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['humano'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="humano">Humano</label>
			<div class="controls">
				<input type="checkbox" name="humano" id="humano" <?php if(!isset($treinador) || (isset($treinador) && $treinador->getHumano())) echo 'checked'; ?> />
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['dificuldade'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="dificuldade">Dificuldade</label>
			<div class="controls">
				<input type="number" class="input input-mini" name="dificuldade" id="dificuldade" min="<?php echo $_->config->minDificuldade; ?>" max="<?php echo $_->config->maxDificuldade; ?>" value="1" <?php if(!isset($treinador) || (isset($treinador) && $treinador->getHumano())) echo 'disabled'; ?> />
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['cor'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="cor">Cor</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="text" class='color' name='cor' value="<?php if(isset($treinador)) echo $treinador->getCor(); ?>" />
				</div>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>

<div class="modal-body lista-treinadores" id="lista-treinadores">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Treinador</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($treinadores as $t){
				?>
				<tr>
					<td><?php echo $t->getId(); ?></td>
					<td><span class="label" style="background-color:<?php echo $t->getCor(); ?>;"><?php echo $t->getNome(); ?></span></td>
					<td width="14"><a href="/treinador-gerenciar/<?php echo $t->getId(); ?>" class="alterar-treinador" href=""><i class="icon-edit"></i></a></td>
					<td width="14"><a href="/treinador-gerenciar/<?php echo $t->getId(); ?>/excluir>" class="remover-treinador" href=""><i class="icon-remove"></i></a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<script>
$(document).ready(function(){
	$('#humano').click(function(){
		if($(this).prop('checked')){
			$('#dificuldade').attr('disabled','disabled').val('1');
		}else{
			$('#dificuldade').removeAttr('disabled');
		}
	});
	
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