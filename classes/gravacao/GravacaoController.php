<?php
	class GravacaoController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$gravacao = new Gravacao();
			$this->povoarSimples($gravacao, $todosOsCampos, $_POST);
			
			if(isset($_POST['treinadores'])){
				$treinadorController = Util::makeService('treinador');
				$gravacao->setTreinadores($treinadorController->obterComIds($_POST['treinadores'],false));
			}
			
			$mapaController = Util::makeController('mapa');
			$gravacao->setMapaInicial($mapaController->obterComId($_POST['idMapa']));
			
			return $gravacao;
		}
	}
?>