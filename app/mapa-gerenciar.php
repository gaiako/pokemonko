<?php
$mapaController = Util::makeController('mapa');

try{
	global $erro;
	if(isset($_POST['enviar'])){
		$mapa = $mapaController->criar();
		$mapaController->salvar($mapa,$erro);
		
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
		$mapa = null;
	}

	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$mapaController->desativarComId($_GET['id']);
	}elseif(isset($_GET['id'])){
		$mapa = $mapaController->obterComId($_GET['id']);
	}

	$mapas = $mapaController->obterTodos();
	$terrenos = Util::todasAsImagensNaPasta('/app/assets/images/terreno/');
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}
?>

<form id="formularioMapa" method="post" action="/mapa-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($mapa)) echo $mapa->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Mapa</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($mapa)) echo $mapa->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['dimensaoX'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="dimensaoX">Dimensão X</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="number" class='input-mini' name='dimensaoX' min="1" max="<?php echo $_->config->maxTamanhomapa; ?>" value="<?php if(isset($mapa)) echo $mapa->getDimensaoX(); else echo '50'; ?>" />
				</div>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['dimensaoY'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="dimensaoY">Dimensão Y</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="number" class='input-mini' name='dimensaoY' min="1" max="<?php echo $_->config->maxTamanhomapa; ?>" value="<?php if(isset($mapa)) echo $mapa->getDimensaoY(); else echo '50'; ?>" />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['dimensao'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="dimensao">Terreno padrão</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<select name="idTerrenoPadrao" id="idTerrenoPadrao">
						<?php
						foreach($terrenos as $terreno){
							?>
							<option value="<?php echo $terreno->getId(); ?>"><?php echo $terreno->getNome(); ?></option>
							<?php
						}
						?>
					</select>
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['xInicial'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="xInicial">X inicial</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="number" class='input-mini' name='xInicial' min="1" max="<?php echo $_->config->maxTamanhomapa; ?>" value="<?php if(isset($mapa)) echo $mapa->getXInicial(); else echo '1'; ?>" />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['xInicial'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="xInicial">Y inicial</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="number" class='input-mini' name='yInicial' min="1" max="<?php echo $_->config->maxTamanhomapa; ?>" value="<?php if(isset($mapa)) echo $mapa->getYInicial(); else echo '1'; ?>" />
				</div>
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['maxPokemons'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="maxPokemons">Max Pokémons</label>
			<div class="controls">
					<input type="number" class='input-mini' name='maxPokemons' value="<?php if(isset($mapa)) echo $mapa->getMaxPokemons(); else echo '1'; ?>" />
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['intervaloCriacao'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="intervaloCriacao">Intervalo criação</label>
			<div class="controls">
					<input type="number" class='input-mini' name='intervaloCriacao' value="<?php if(isset($mapa)) echo $mapa->getIntervaloCriacao(); else echo '1'; ?>" />
			</div>
		</div>
		
		<div class="control-group <?php if(isset($erro)){ if(isset($erro['intervaloMovimento'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="intervaloMovimento">Intervalo movimento</label>
			<div class="controls">
					<input type="number" class='input-mini' name='intervaloMovimento' value="<?php if(isset($mapa)) echo $mapa->getIntervaloMovimento(); else echo '1'; ?>" />
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
			<th>Mapa</th>
			<th>Dimensões</th>
			<th>Editor de mapas</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		<?php
		foreach($mapas as $m){
			?>
			<tr>
				<td><?php echo $m->getId(); ?></td>
				<td><?php echo $m->getNome(); ?></td>
				<td><?php echo $m->getDimensaoX().' x '.$m->getDimensaoY(); ?></td>
				<td><a href="/mapa-editar/<?php echo $m->getId(); ?>" class="alterar-mapa">Editar mapa</a></td>
				<td width="14"><a href="/mapa-gerenciar/<?php echo $m->getId(); ?>" class="alterar-mapa"><i class="icon-edit"></i></a></td>
				<td width="14"><a href="/mapa-gerenciar/<?php echo $m->getId(); ?>/excluir>" class="remover-mapa"><i class="icon-remove"></i></a></td>
			</tr>
			<?php
		}
		?>
	</tbody>
</table>