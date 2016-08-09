<?php
$grupoController = Util::makeController('grupo');
$pokemonBaseController = Util::makeController('pokemonBase');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$grupo = $grupoController->criar();
		$grupoController->salvar($grupo,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$grupo = null;
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$grupoController->desativarComId($_GET['id']);
	}else{
		$grupo = $grupoController->obterComId($_GET['id']);
	}

	$grupos = $grupoController->obterTodos();
	$pokemons = $pokemonBaseController->obterOrdenadosPorForca();
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}

?>
<form id="formularioGrupo" method="post" action="/grupo-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($grupo)) echo $grupo->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Grupo</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($grupo)) echo $grupo->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['minNivel'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="minNivel">Nível mínimo</label>
			<div class="controls">
				<input type="number" min="1" max="100" class="input-mini" name="minNivel" id="minNivel" value="<?php if(isset($grupo)) echo $grupo->getMinNivel(); else echo '1'; ?>" />
				<span class="help-inline"><?php if(isset($erro['minNivel'])) echo $erro['minNivel']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['maxNivel'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="maxNivel">Nível máximo</label>
			<div class="controls">
				<input type="number" min="1" max="100" class="input-mini" name="maxNivel" id="maxNivel" value="<?php if(isset($grupo)) echo $grupo->getMaxNivel(); else echo '1'; ?>" />
				<span class="help-inline"><?php if(isset($erro['maxNivel'])) echo $erro['maxNivel']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['pokemons'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="pokemons">Pokemons</label>
			<div class="controls">
				<?php
				foreach($pokemons as $pokemon){
					?>
					<img class="ico-pokemon" data-id="<?php echo $pokemon->getId(); ?>" src="/app/assets/images/pokemon/icon/<?php echo $pokemon->getId(); ?>.png" />
					<input type="checkbox" data-id="<?php echo $pokemon->getId(); ?>" name="pokemons[]" id="pokemon<?php echo $pokemon->getId(); ?>" <?php if(isset($grupo) && $grupo->temPokemon($pokemon->getId())) echo 'checked'; ?> value="<?php echo $pokemon->getId(); ?>" />
					<?php
				}
				?>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>

<div class="modal-body lista-grupos" id="lista-grupos">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Grupo</th>
				<th>Pokémons</th>
				<th>Nível</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($grupos as $g){
				?>
				<tr>
					<td><?php echo $g->getId(); ?></td>
					<td><?php echo $g->getNome(); ?></td>
					<td>
						<?php
						foreach($g->getPokemons() as $p){
							?>
							<img class="popover-raridade" data-content="<input type='number' data-idGrupo='<?php echo $g->getId(); ?>' data-idPokemon='<?php echo $p->getId(); ?>' class='input-mini input-raridade' value='<?php echo $p->getRaridade(); ?>' />" title="" data-original-title="Raridade" style="cursor:pointer;" src="/app/assets/images/pokemon/icon/<?php echo $p->getId(); ?>.png" />
							<?php
						}
						?>
					</td>
					<td><?php echo $g->getMinNivel().' - '.$g->getMaxNivel(); ?></td>
					<td width="14"><a href="/grupo-gerenciar/<?php echo $g->getId(); ?>" class="alterar-grupo" href=""><i class="icon-edit"></i></a></td>
					<td width="14"><a href="/grupo-gerenciar/<?php echo $g->getId(); ?>/excluir" class="remover-grupo" href=""><i class="icon-remove"></i></a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>

<script>
$(document).ready(function(){
	$('.ico-pokemon').click(function(){
		var id = $(this).attr('data-id');
		
		if($('input[data-id="'+id+'"]').prop('checked')){
			$('input[data-id="'+id+'"]').prop('checked', false);
		}
		else{
			$('input[data-id="'+id+'"]').prop('checked', true);
		}
	});

	$('.popover-raridade').popover({placement : 'top',html : true});

	$(document).on('change','.input-raridade',function(){
		var idGrupo = $(this).attr('data-idGrupo');
		var idPokemon = $(this).attr('data-idPokemon');
		var raridade = $(this).val();

		var data = {
			act : {
				t : 'GrupoController',
				o : 'alterarRaridade',
				p : {
					idGrupo : idGrupo,
					idPokemon : idPokemon,
					raridade : raridade
				}
			}
		}

		$.post('/php/act.php',data,function(result){
			$.notify('Salvo com sucesso!', "success");
		},'json');
	});
});
</script>