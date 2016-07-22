<div style="width:100%">
	<?php $logo = "/admin/img/logo.png"; ?>
	<a href="/admin/painel"><img border="0" width="100%" src="<?php echo $logo; ?>" /></a>
</div>

<br>

<div style="display:inline;">
	<div class="nav-meu-menu">

		<center>
			<div class="menu">
				<a title="Pedidos" class="icone-pedidos <?php if($conteudo == "gerenciar-pedido-pagamento-aprovado" || $conteudo == "gerenciar-pedido-em-analise" || $conteudo == "gerenciar-pedido-expedicao" || $conteudo == "gerenciar-pedido-em-transito" || $conteudo == "gerenciar-pedido-em-espera") echo "active"; ?>" href="/admin/painel/gerenciar-pedido-pagamento-aprovado"></a>
				<a title="Cadastro de produtos" class="icone-cadastro-produtos <?php if($conteudo == "cadastrar-produto") echo "active"; ?>" href="/admin/painel/produto/cadastrar"></a>
				<?php if($_SESSION['mobile']) echo "<br><br><br>"; ?>
				<a title="Lista de produtos" class="icone-produtos <?php if($conteudo == "gerenciar-produto" || $conteudo == "gerenciar-loja-produto") echo "active"; ?>" href="/admin/painel/produto/<?php if($qtdLojas == 1) echo "gerenciar-loja"; else echo "gerenciar"; ?>"></a>
				<a title="Lista de clientes" class="icone-clientes <?php if($conteudo == "gerenciar-cliente") echo "active"; ?>" href="/admin/painel/cliente/gerenciar"></a>
			</div><?php if($_SESSION['mobile']) echo "<br><br><br>"; ?>
		</center>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->administrador && $direitosDoAdministrador['administrador'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Administrador</li>
			<?php if($direitosDoAdministrador['administrador'] > 3){ ?>
				<li <?php if($conteudo == "cadastrar-administrador") echo "class='active'"; ?> ><a href="/admin/painel/administrador/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-administrador") echo "class='active'"; ?> ><a href="/admin/painel/administrador/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>
		
		<?php /* if(!$_HAS_MENU_JSON || $_menu->site && $direitosDoAdministrador['site'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Site</li>
			<li class='<?php if($conteudo == "mala-direta") echo " active"; ?>'><a href="/admin/painel/mala-direta">Mala direta</a></li>
			<li class='<?php if($conteudo == "gerenciar-clienteNewsletter") echo " active"; ?>' ><a href="/admin/painel/clienteNewsletter/gerenciar">Newsletter</a></li>
			<li class='<?php if($conteudo == "listar-emails-clienteNewsletter") echo " active'"; ?>' ><a href="/admin/painel/clienteNewsletter/listar-emails">Listar e-mails da newsletter</a></li>
			<li <?php if($conteudo == "gerenciar-album" || $conteudo == "gerenciar-fotos-album" || $conteudo == "excluir-foto-album" || $conteudo == "setar-foto-principal-album") echo "class='active'"; ?> ><a href="/admin/painel/album/gerenciar">Álbuns</a></li>
			<li><a href="https://www.facebook.com/De-Luka-Modascom-135483929949003/timeline" target="_new">Link para Fan Page</a></li>
			<li><a href="https://dashboard.zopim.com" target="_new">Chat Online</a></li>
			<!-- <li <?php if(!isset($conteudo) || $conteudo == "estatisticas") echo "class='active'"; ?>><a href="/admin/painel/estatisticas">Estatísticas de acessos</a></li> -->
			<li <?php if(!isset($conteudo) || $conteudo == "estatisticas") echo "class='active'"; ?>><a href="Http://www.google.com/analytics" target="_new">Google Analytics completo</a></li>
			<li <?php if(!isset($conteudo) || $conteudo == "estatisticas-tabs") echo "class='active'"; ?>><a href="/admin/painel/estatisticas-tabs">Estatísticas Gerais</a></li>
			<li <?php if($conteudo == "gerenciar-busca") echo "class='active'"; ?> ><a href="/admin/painel/busca/gerenciar">Últimos termos buscados</a></li>
			<li <?php if($conteudo == "top-busca") echo "class='active'"; ?> ><a href="/admin/painel/busca/top">Termos mais buscados</a></li>
		</ul>
		<?php } */ ?>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->cliente && $direitosDoAdministrador['clientes'] > 0 || $_menu->credito && $direitosDoAdministrador['creditos'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Cliente</li>
			<?php if($direitosDoAdministrador['clientes'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-cliente") echo "class='active'"; ?> ><a href="/admin/painel/cliente/cadastrar">Cadastrar cliente</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-cliente" || $conteudo == "view-cliente" || $conteudo == "gerenciar-endereco-cliente") echo "class='active'"; ?> ><a href="/admin/painel/cliente/gerenciar">Buscar cliente</a></li>
			<li <?php if($conteudo == "listar-emails-cliente") echo "class='active'"; ?> ><a href="/admin/painel/cliente/listar-emails">Listar e-mails</a></li>
			<?php if($direitosDoAdministrador['creditos'] >= 2){ ?>
				<li <?php if($conteudo == "cadastrar-credito") echo "class='active'"; ?> ><a href="/admin/painel/credito/cadastrar">Adicionar crédito</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-credito") echo "class='active'"; ?> ><a href="/admin/painel/credito/gerenciar">Clientes com crédito</a></li>
		</ul>
		<?php } ?>

		<ul class="nav nav-list">
			<li class="nav-header">Curso</li>
			<li <?php if($conteudo == 'cadastrar-curso') echo  "class='active'"; ?>><a href="/admin/painel/curso/cadastrar">Cadastrar</a></li>
			<li <?php if($conteudo == 'gerenciar-curso') echo  "class='active'"; ?>><a href="/admin/painel/curso/gerenciar">Gerenciar</a></li>
		</ul>

		<ul class="nav nav-list">
			<li class="nav-header">Módulo</li>
			<li <?php if($conteudo == 'cadastrar-modulo') echo  "class='active'"; ?>><a href="/admin/painel/modulo/cadastrar">Cadastrar</a></li>
			<li <?php if($conteudo == 'gerenciar-modulo') echo  "class='active'"; ?>><a href="/admin/painel/modulo/gerenciar">Gerenciar</a></li>
		</ul>

		<ul class="nav nav-list">
			<li class="nav-header">Aula</li>
			<li <?php if($conteudo == 'gerenciar-aula') echo  "class='active'"; ?>><a href="/admin/painel/aula/gerenciar">Gerenciar</a></li>
		</ul>

		<ul class="nav nav-list">
			<li class="nav-header">Turma</li>
			<li <?php if($conteudo == 'cadastrar-turma') echo  "class='active'"; ?>><a href="/admin/painel/turma/cadastrar">Cadastrar</a></li>
			<li <?php if($conteudo == 'gerenciar-turma') echo  "class='active'"; ?>><a href="/admin/painel/turma/gerenciar">Gerenciar</a></li>
		</ul>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->pedido && $direitosDoAdministrador['pedidos'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Pedido</li>
			<?php /*<li <?php if($conteudo == "cadastrar-pedido") echo "class='active'"; ?> ><a href="/admin/painel/pedido/cadastrar">Cadastrar</a></li>*/ ?>
			<li <?php if($conteudo == "matricular-pedido") echo "class='active'"; ?> ><a href="/admin/painel/pedido/matricular">Matricular</a></li>
			<?php if($_->loja['tempoRealPedido'] == true){ ?>
				<li <?php if($conteudo == "gerenciar-tempo-real-pedido") echo "class='active'"; ?> ><a href="/admin/painel/gerenciar-tempo-real-pedido">Tempo real</a></li>
				<li <?php if($conteudo == "gerenciar-loja-pedido") echo "class='active'"; ?> ><a href="/admin/painel/gerenciar-loja-pedido">Gerenciar</a></li>
			<?php }else{ ?>
				<li <?php if($conteudo == "gerenciar-pedido-pagamento-aprovado" || $conteudo == "gerenciar-pedido-em-analise" || $conteudo == "gerenciar-pedido-expedicao" || $conteudo == "gerenciar-pedido-em-transito" || $conteudo == "gerenciar-pedido-em-espera") echo "class='active'"; ?> ><a href="/admin/painel/gerenciar-pedido-pagamento-aprovado">Gerenciar</a></li>
				<li <?php if($conteudo == "gerenciar-pedido-aguardando-pagamento") echo "class='active'"; ?> ><a href="/admin/painel/gerenciar-pedido-aguardando-pagamento">Aguardando pagamento</a></li>
				<li <?php if($conteudo == "gerenciar-pedido-concluido") echo "class='active'"; ?> ><a href="/admin/painel/gerenciar-pedido-concluido">Concluídos</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-pedido-cancelado") echo "class='active'"; ?> ><a href="/admin/painel/gerenciar-pedido-cancelado">Cancelados</a></li>
			<li <?php if($conteudo == "listar-pedido") echo "class='active'"; ?> ><a href="/admin/painel/pedido/listar">Detalhes</a></li>
			<li <?php if($conteudo == "listar-refazer-carrinho") echo "class='active'"; ?> ><a href="/admin/painel/listar-refazer-carrinho">Carrinhos à refazer</a></li>
			<?php if($_->loja['antifraude'] == true){ ?>
				<li <?php if($conteudo == "antifraude-pedido") echo "class='active'"; ?> ><a href="/admin/painel/pedido/antifraude">Anti-Fraude</a></li>
			<?php } ?>
		</ul>
		<?php } ?>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->motoboy){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Motoboy</li>
			<li <?php if($conteudo == "cadastrar-motoboy") echo "class='active'"; ?> ><a href="/admin/painel/motoboy/cadastrar">Cadastrar</a></li>
			<li <?php if($conteudo == "gerenciar-motoboy") echo "class='active'"; ?> ><a href="/admin/painel/motoboy/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>
		
		<?php /* if(!$_HAS_MENU_JSON || $_menu->frete && $direitosDoAdministrador['frete'] > 2){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Frete</li>
			<li <?php if($conteudo == "cadastrar-frete") echo "class='active'"; ?> ><a href="/admin/painel/cadastrar-frete">Cadastrar/Gerenciar</a></li>
		</ul>
		<?php } */ ?>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->categoria && $direitosDoAdministrador['categoria'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Categoria</li>
			<?php if($direitosDoAdministrador['categoria'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-categoria") echo "class='active'"; ?> ><a href="/admin/painel/categoria/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-categoria" || $conteudo == "gerenciar-fotos-categoria") echo "class='active'"; ?> ><a href="/admin/painel/categoria/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->tamanho && $direitosDoAdministrador['tamanho'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Tamanho</li>
			<?php if($direitosDoAdministrador['tamanho'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-tamanho") echo "class='active'"; ?> ><a href="/admin/painel/tamanho/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-tamanho") echo "class='active'"; ?> ><a href="/admin/painel/tamanho/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->cor && $direitosDoAdministrador['corEstampa'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Cor / Textura</li>
			<?php if($direitosDoAdministrador['corEstampa'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-cor" || $conteudo == "excluir-foto-cor") echo "class='active'"; ?> ><a href="/admin/painel/cor/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-cor") echo "class='active'"; ?> ><a href="/admin/painel/cor/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->fabricante && $direitosDoAdministrador['fabricante'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Fabricante</li>
			<?php if($direitosDoAdministrador['fabricante'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-fabricante") echo "class='active'"; ?> ><a href="/admin/painel/fabricante/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-fabricante") echo "class='active'"; ?> ><a href="/admin/painel/fabricante/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->produto && $direitosDoAdministrador['produto'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Produto</li>
			<?php if($direitosDoAdministrador['produto'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<!--<li <?php if($conteudo == "destaque-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/destaque">Destaques</a></li>
			<li <?php if($conteudo == "lancamento-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/lancamento">Lancamento</a></li>
			<li <?php if($conteudo == "adicionar-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/adicionar">Adicionar à loja</a></li>-->
			<?php
			if($qtdLojas > 1)
				$label = "Gerenciar por loja";
			else
				$label = "Gerenciar";
			?>
			<li <?php if($conteudo == "gerenciar-loja-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/gerenciar-loja<?php //if(is_numeric($_SESSION['loja'])) echo "/".$_SESSION['loja']; ?>"><?php echo $label; ?></a></li>
			<li <?php if($conteudo == "gerenciar-producao-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/gerenciar-producao<?php //if(is_numeric($_SESSION['loja'])) echo "/".$_SESSION['loja']; ?>"><?php echo "Em produção"; ?></a></li>
			<li <?php if($conteudo == "gerenciar-estoque-total-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/gerenciar-estoque-total<?php //if(is_numeric($_SESSION['loja'])) echo "/".$_SESSION['loja']; ?>"><?php echo "Estoque total"; ?></a></li>
			<li <?php if($conteudo == "inativos-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/inativos<?php //if(is_numeric($_SESSION['loja'])) echo "/".$_SESSION['loja']; ?>"><?php if($qtdLojas > 1) echo 'Inativos na loja'; else echo 'Produtos incompletos'; ?></a></li>
			<?php if($qtdLojas > 1){ ?>
			<li <?php if($conteudo == "gerenciar-produto" || $conteudo == "gerenciar-fotos-produto" || $conteudo == "gerenciar-estoque" || $conteudo == "setar-foto-principal-produto" || $conteudo == "excluir-foto-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/gerenciar">Gerenciar produtos</a></li>
			<?php } ?>
			<li <?php if($conteudo == "retirada-estoque-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/retirada-estoque">Retiradas de estoque</a></li>
			<li <?php if($conteudo == "avise-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/avise">Aguardos de produtos</a></li>
			<li <?php if($conteudo == "acessos-produto") echo "class='active'"; ?> ><a href="/admin/painel/produto/acessos">Relatório de acessos de produtos</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->noticia && $direitosDoAdministrador['noticia'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Notícia</li>
			<?php if($direitosDoAdministrador['noticia'] > 1){ ?>
			<li <?php if($conteudo == "cadastrar-noticia" || $conteudo == "excluir-foto-noticia") echo "class='active'"; ?> ><a href="/admin/painel/noticia/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-noticia") echo "class='active'"; ?> ><a href="/admin/painel/noticia/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->evento){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Evento</li>
			<li <?php if($conteudo == "cadastrar-evento") echo "class='active'"; ?> ><a href="/admin/painel/evento/cadastrar">Cadastrar</a></li>
			<li <?php if($conteudo == "gerenciar-evento") echo "class='active'"; ?> ><a href="/admin/painel/evento/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->hotsite && $direitosDoAdministrador['hotsite'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Hotsites</li>
			<?php if($direitosDoAdministrador['hotsite'] > 1){ ?>
				<li <?php if($conteudo == "cadastrar-hotsite") echo "class='active'"; ?> ><a href="/admin/painel/hotsite/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-hotsite") echo "class='active'"; ?> ><a href="/admin/painel/hotsite/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->cupom){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Cupom de desconto</li>
			<li <?php if($conteudo == "cadastrar-cupom") echo "class='active'"; ?> ><a href="/admin/painel/cupom/cadastrar">Cadastrar</a></li>
			<li <?php if($conteudo == "gerenciar-cupom") echo "class='active'"; ?> ><a href="/admin/painel/cupom/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>
		
		<?php if(!$_HAS_MENU_JSON || $_menu->logdeerros){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Log de erros</li>
			<li <?php if($conteudo == "gerenciar-erros") echo "class='active'"; ?> ><a href="/admin/painel/ops/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

		<?php if(!$_HAS_MENU_JSON || $_menu->servico && $direitosDoAdministrador['servico'] > 0){ ?>
		<ul class="nav nav-list">
			<li class="nav-header">Serviço</li>
			<?php if($direitosDoAdministrador['servico'] > 1){ ?>
			<li <?php if($conteudo == "cadastrar-servico" || $conteudo == "excluir-foto-servico") echo "class='active'"; ?> ><a href="/admin/painel/servico/cadastrar">Cadastrar</a></li>
			<?php } ?>
			<li <?php if($conteudo == "gerenciar-servico") echo "class='active'"; ?> ><a href="/admin/painel/servico/gerenciar">Gerenciar</a></li>
		</ul>
		<?php } ?>

	</div>
	<br>
</div>

<script>
	$(document).ready(function(){
		$('.link').click(function(e){
			e.preventDefault();
			var href = $(this).attr('data-href');
			location.href=href;
		});
	});
</script>