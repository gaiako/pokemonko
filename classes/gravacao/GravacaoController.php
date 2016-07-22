<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/init.php");
	require_once($_->raiz."/util/autoload.php");

	class GravacaoController extends Controller{

		public function __construct(){
			$this->setService($this->getServiceFactory()->buildGravacaoService());
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'dataCadastro');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$gravacao = new Gravacao();
			$this->povoarSimples($gravacao, $todosOsCampos, $_POST);
			return $gravacao;
		}
	}
?>