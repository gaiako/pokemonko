<form id="formularioMapa method="post" action="/mapa-gerenciar" class='form-horizontal' enctype='multipart/form-data'>
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

		<div class="control-group <?php if(isset($erro)){ if(isset($erro['cor'])) echo "error"; else echo "success"; } ?>">
			<label class="control-label" for="cor">Cor</label>
			<div class="controls">
				<div class="input-append habilitado-duplicacao">
					<input type="text" class='color' name='cor' value="<?php if(isset($mapa)) echo $mapa->getCor(); ?>" />
				</div>
			</div>
		</div>
		
		<div class="form-actions">
			<button type="submit" class="btn btn-primary" name="enviar">Salvar</button>
		</div>
	</fieldset>
</form>