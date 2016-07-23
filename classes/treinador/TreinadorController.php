<?php
	class TreinadorController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'humano', 'dificuldade', 'x', 'y', 'cor', 'dinheiro');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$treinador = new Treinador();
			$this->povoarSimples($treinador, $todosOsCampos, $_POST);
			
			$gravacaoController = Util::makeController('gravacao');
			$treinador->setGravacao($gravacaoController->obterComId($_SESSION['gravacao']);
			
			return $treinador;
		}
	}
?>