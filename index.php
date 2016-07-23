<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
?><!doctype html>
<html lang="">
<head>
	<meta charset="UTF-8" />
	<title>Pokémon KO</title>

	<link rel="icon" type="img/png" href="/app/assets/images/favicon.ico" />
	<link href="/bootstrap/css/bootstrap.css" rel="stylesheet" />
	<link href="/bootstrap/css/bootstrap-responsive.css" rel="stylesheet" />
	<link href="/bootstrap/css/estilo.css" rel="stylesheet" />
	<link href="/app/assets/style/estilo.css" rel="stylesheet" />
	<script src="/js/jquery.js"></script>
</head>
<body>
	<div class="navbar navbar-inverse navbar-fixed-top">
		<div class="navbar-inner">
			<div class="container">
				<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="brand" href="/">Pokémon KO</a>
				<div class="nav-collapse collapse">
					<ul class="nav">
						<!--<li class="">
							<a href="./index.html">Home</a>
						</li>-->
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-download-alt icon-white"></i> Gravação <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/gravacao-cadastrar"><i class="icon-plus"></i> Nova</a></li>
								<li><a href="/gravacao-gerenciar"><i class="icon-arrow-up"></i> Carregar</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i> Treinadores <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/treinador-gerenciar"><i class="icon-list"></i> Lista</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-qrcode icon-white"></i> Pokémons <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/pokemon-cadastrar"><i class="icon-plus"></i> Cadastrar</a></li>
								<li><a href="/pokemon-gerenciar"><i class="icon-list"></i> Lista</a></li>
								<li><a href="/tipo-gerenciar"><i class="icon-plus"></i> Tipos</a></li>
							</ul>
						</li>
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-map icon-ko"></i> Mapa <b class="caret"></b></a>
							<ul class="dropdown-menu">
								<li><a href="/terreno-gerenciar"><i class="icon-th-large"></i> Terreno</a></li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
    </div>
	
	<div style="margin-bottom:40px;"></div>
	
	<?php
	if(isset($_GET['file'])){
		require_once($_->raiz.'/app/'.$_GET['file'].'.php');
	}else{
		require_once($_->raiz.'/app/inicio.php');
	}
	?>
	
	<script src="/js/bootstrap/bootstrap.js"></script>
	<script>
		var RAIZ = "";
	</script>
	<script src="/js/getDefault.js"></script>
	<script src="/js/funcoes.js"></script>
	<script src="/js/mascaras.js"></script>
	<script src="/js/sortable.js"></script>
	<script src="/js/abas.js"></script>
	<script src="/js/notify.js"></script>
	<script>
		$(document).ready(function(){
			$('form').mascarar();
		});
	</script>
  
</body>
</html>