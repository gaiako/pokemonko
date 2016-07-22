<?php
	session_start("erro");
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	if(!isset($_SESSION['erro'])){
		if(isset($e)){
			$exception = array(
				"mensagem" => $e->getMessage(),
				"trace" => $e->getTraceAsString(),
				"arquivo" => $e->getFile() );
			$_SESSION['erro'] = serialize($exception);
			die("<script type='text/javascript'>location.href = '"."/classes/CriaOErro.php'; </script>");
		}else{
			die("<script type='text/javascript'>location.href = '"."/'; </script>");
		}
	}
	else{
		$exception = unserialize($_SESSION['erro']);
		require_once($_->raiz."/classes/ops/OpsController.php");
		$opsController = Util::makeController('ops');
		try{
			if(!isset($_GET['erro'])){
				$ops = $opsController->criarOps($exception);
				$opsController->salvar($ops);
			}
		}catch(Exception $e){
			echo $e->getMessage();
		}
		unset($_SESSION['erro']);
		echo "Houve um erro... :(";
		if(isset($_SESSION['administrador'])){
			echo "<br /><br /><a href='"."/admin/painel/ops/gerenciar'>Veja o erro</a>";
		}
	}
?>