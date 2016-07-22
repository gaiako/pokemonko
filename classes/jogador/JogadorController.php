<?php
	class JogadorController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'humano', 'dificuldade', 'x', 'y', 'cor', 'dinheiro');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$jogador = new Jogador();
			$this->povoarSimples($jogador, $todosOsCampos, $_POST);
			return $jogador;
		}
	}
?>