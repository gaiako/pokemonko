<?php
$pokemonBaseController = Util::makeController('pokemonBase');

try{
	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$pokemonBaseController->desativarComId($_GET['id']);
	}else{
		$pokemonBase = $pokemonBaseController->obterComId($_GET['id']);
	}

	$pokemonsBase = $pokemonBaseController->obterTodos();
}catch(ServiceException $e){
	
}catch(Exception $e){
	echo $e->getMessage();
}

?>
<div class="modal-body lista-pokemonBases" id="lista-pokemonBases" style="max-height:595px;">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Foto</th>
				<th>Nome</th>
				<th>Tipo</th>
				<th>HP</th>
				<th>Ataque</th>
				<th>Defesa</th>
				<th>Agilidade</th>
				<th>Especial</th>
				<th>Nivel</th>
				<th>Raridade</th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($pokemonsBase as $p){
				?>
				<tr>
					<td><img src="/app/assets/images/pokemon/<?php echo str_pad($p->getId(),3,'0',STR_PAD_LEFT); ?>.png" width="50" height="50" /></td>
					<td><?php echo $p->getNome(); ?></td>
					<td>
						<span class="label" style="background-color:<?php echo $p->getTipo()->getCor(); ?>;"><?php echo $p->getTipo()->getNome(); ?></span>
						<?php
						if($p->getTipo2() instanceOf Tipo){
							?>
							<span class="label" style="background-color:<?php echo $p->getTipo2()->getCor(); ?>;"><?php echo $p->getTipo2()->getNome(); ?></span>
							<?php
						}
						?>
					</td>
					<td><?php echo $p->getHp(); ?></td>
					<td><?php echo $p->getAtaque(); ?></td>
					<td><?php echo $p->getDefesa(); ?></td>
					<td><?php echo $p->getAgilidade(); ?></td>
					<td><?php echo $p->getEspecial(); ?></td>
					<td><?php echo $p->getNivel(); ?></td>
					<td><?php echo $p->getRaridade(); ?></td>
					<td width="14"><a href="/pokemon-cadastrar/<?php echo $p->getId(); ?>" class="alterar-pokemonBase" href=""><i class="icon-edit"></i></a></td>
					<td width="14"><a href="/pokemon-gerenciar/<?php echo $p->getId(); ?>/excluir>" class="remover-pokemonBase" href=""><i class="icon-remove"></i></a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>