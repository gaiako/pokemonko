<?php
	class ObjetoController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$objeto = new Objeto();
			$this->povoarSimples($objeto, $todosOsCampos, $_POST);
			return $objeto;
		}
	}
?>