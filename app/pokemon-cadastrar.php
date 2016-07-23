<div  style="margin-top:40px;"></div>
<?php
	global $erro;
	$pokemonBaseController = Util::makeController("pokemonBase");
	$tipoController = Util::makeController('tipo');
	
	if(isset($_POST['enviar'])){
		$pokemonBase = $pokemonBaseController->criar();
		$pokemonBaseController->salvar($pokemonBase,$erro);
		
		$pokemonBase = null;
		echo "<div class='alert alert-success'>Salvo com sucesso</div>";
	}
	
	if(isset($_GET['id'])){
		$pokemonBase = $pokemonBaseController->obterComId($_GET['id']);
	}
	
	$tipos = $tipoController->obterTodos();
?>
<form id="formularioProduto" method="post" action="/pokemon-cadastrar" class='form-horizontal' enctype='multipart/form-data'>
	<input type="hidden" name="id" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getId(); ?>" />
	<fieldset>
		<legend>Cadastrar Pokémon</legend>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nome'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nome">Nome</label>
			<div class="controls">
				<input type="text" class="input-large" name="nome" id="nome" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getNome(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nome'])) echo $erro['nome']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['tipo'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="tipo">Tipo</label>
			<div class="controls">
				<select name="tipo" id="tipo">
					<option value=""></option>
					<?php
					foreach($tipos as $tipo){
						?>
						<option value="<?php echo $tipo->getId(); ?>"<?php if(isset($pokemonBase) && $pokemonBase->getTipo()->getId() == $tipo->getId()) echo ' selected="selected"'; ?>><?php echo $tipo->getNome(); ?></option>
						<?php
					}
					?>
				</select>
				<span class="help-inline"><?php if(isset($erro['tipo'])) echo $erro['tipo']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['tipo2'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="tipo2">Tipo2</label>
			<div class="controls">
				<select name="tipo2" id="tipo2">
					<option value=""></option>
					<?php
					foreach($tipos as $tipo){
						?>
						<option value="<?php echo $tipo->getId(); ?>"<?php if(isset($pokemonBase) && $pokemonBase->getTipo2() instanceOf Tipo && $pokemonBase->getTipo2()->getId() == $tipo->getId()) echo ' selected="selected"'; ?>><?php echo $tipo->getNome(); ?></option>
						<?php
					}
					?>
				</select>
				<span class="help-inline"><?php if(isset($erro['tipo2'])) echo $erro['tipo2']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['hp'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="hp">HP</label>
			<div class="controls">
				<input type="text" class="input-large" name="hp" id="hp" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getHp(); ?>" />
				<span class="help-inline"><?php if(isset($erro['hp'])) echo $erro['hp']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['ataque'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="ataque">Ataque</label>
			<div class="controls">
				<input type="text" class="input-large" name="ataque" id="ataque" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getAtaque(); ?>" />
				<span class="help-inline"><?php if(isset($erro['ataque'])) echo $erro['ataque']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['defesa'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="defesa">Defesa</label>
			<div class="controls">
				<input type="text" class="input-large" name="defesa" id="defesa" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getDefesa(); ?>" />
				<span class="help-inline"><?php if(isset($erro['defesa'])) echo $erro['defesa']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['agilidade'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="agilidade">Agilidade</label>
			<div class="controls">
				<input type="text" class="input-large" name="agilidade" id="agilidade" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getAgilidade(); ?>" />
				<span class="help-inline"><?php if(isset($erro['agilidade'])) echo $erro['agilidade']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['especial'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="especial">Especial</label>
			<div class="controls">
				<input type="text" class="input-large" name="especial" id="especial" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getEspecial(); ?>" />
				<span class="help-inline"><?php if(isset($erro['especial'])) echo $erro['especial']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['exp'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="exp">Taxa de experiência</label>
			<div class="controls">
				<input type="text" class="input-large" name="exp" id="exp" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getExp(); ?>" />
				<span class="help-inline"><?php if(isset($erro['exp'])) echo $erro['exp']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['sortePokeball'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="sortePokeball">Sorte pokeball</label>
			<div class="controls">
				<input type="text" class="input-large" name="sortePokeball" id="sortePokeball" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getSortePokeball(); ?>" />
				<span class="help-inline"><?php if(isset($erro['sortePokeball'])) echo $erro['sortePokeball']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['nivel'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="nivel">Nível</label>
			<div class="controls">
				<input type="number" class="input-mini" name="nivel" min="1" max="7" id="nivel" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getNivel(); ?>" />
				<span class="help-inline"><?php if(isset($erro['nivel'])) echo $erro['nivel']; ?></span>
			</div>
		</div>

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['raridade'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="raridade">Raridade</label>
			<div class="controls">
				<input type="number" class="input-mini" name="raridade" min="1" max="100" id="raridade" value="<?php if(isset($pokemonBase)) echo $pokemonBase->getRaridade(); ?>" />
				<span class="help-inline"><?php if(isset($erro['raridade'])) echo $erro['raridade']; ?></span>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>

	</fieldset>
</form>

<script>
$(document).ready(function(){
	$('#nome').focus();
});
</script>