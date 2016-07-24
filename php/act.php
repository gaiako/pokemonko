<?php
	session_start();
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	require_once($_->raiz.'/util/JSON.php');
	require_once($_->raiz.'/util/RTTI.php');
	$resposta = null;
	
	try{
		if(!isset($_POST['act'])){
			throw new AJAJException("Ação não enviada");
		}else{
			foreach($_POST as $k => $p){
				if(strpos(strtolower($k),'senha') === false)
					$_POST[$k] = Util::removerCaracteresPerigosos($p);
			}
			foreach($_POST['act'] as $k => $p){
				if(strpos(strtolower($k),'senha') === false)
					$_POST['act'][$k] = Util::removerCaracteresPerigosos($p);
			}
			$act = $_POST['act'];
			$target = $act['t'];
			$operation = $act['o'];
			if(isset($act['p']))
				$params = $act['p'];
			else $params = array();
			
			$obj = new $target;
			if(!method_exists($obj, $operation)){
				throw new AJAJException("Operação não encontrada");
			}
			$mensagem = call_user_func_array(array($obj, $operation), $params);
			/*if(is_array($mensagem))
				$resposta = new Response(true, $mensagem[0], $mensagem[1]);
			else*/
				$resposta = new Response(true, $mensagem);
		}
	}catch(Exception $e){
		$resposta = new Response(false, $e->getMessage());
	}
	
	echo JSON::encode($resposta);
?>