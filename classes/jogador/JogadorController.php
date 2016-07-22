<?php
	class JogadorController extends Controller{

		public function __construct(){
			$this->setService($this->getServiceFactory()->buildJogadorService());
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'humano', 'dificuldade', 'idGravacao', 'idMapa', 'x', 'y', 'cor', 'dinheiro');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$jogador = new Jogador();
			$this->povoarSimples($jogador, $todosOsCampos, $_POST);
			return $jogador;
		}
	}
?>