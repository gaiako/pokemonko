<?php
	$gravacaoController = Util::makeController('gravacao');
	
	if(isset($_GET['acao']) && $_GET['acao'] == 'excluir'){
		$gravacaoController->desativarComId($_GET['id']);
	}elseif(isset($_GET['acao']) && $_GET['acao'] == 'carregar'){
		$_SESSION['gravacao'] = $_GET['id'];
		echo "<div class='alert alert-success'>Carregado com sucesso</div>";
	}else{
		$gravacao = $gravacaoController->obterComId($_GET['id']);
	}

	$gravacoes = $gravacaoController->obterTodos();
	
	if(isset($_SESSION['mensagem'])){
		echo "<div class='alert alert-warning'>".$_SESSION['mensagem']."</div>";
		unset($_SESSION['mensagem']);
	}
?>

<a class="btn" href="/gravacao-cadastrar">Criar gravação</a>

<div class="modal-body lista-gravacoes" id="lista-gravacoes">
	<table class="table table-hover">
		<thead>
			<tr>
				<th>#</th>
				<th>Gravacao</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<?php
			foreach($gravacoes as $t){
				?>
				<tr>
					<td><?php echo $t->getId(); ?></td>
					<td><?php echo $t->getNome(); ?></td>
					<td width="14"><a href="/gravacao-gerenciar/<?php echo $t->getId(); ?>/carregar" href=""><img src="/app/assets/images/carregar.png" alt="Carregar" title="Carregar" /></a></td>
					<td width="14"><a href="/gravacao-gerenciar/<?php echo $t->getId(); ?>" href=""><i class="icon-edit"></i></a></td>
					<td width="14"><a href="/gravacao-gerenciar/<?php echo $t->getId(); ?>/excluir>" href=""><i class="icon-remove"></i></a></td>
				</tr>
				<?php
			}
			?>
		</tbody>
	</table>
</div>