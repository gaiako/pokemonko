<?php
	class TipoController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'cor');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$tipo = new Tipo();
			$this->povoarSimples($tipo, $todosOsCampos, $_POST);
			return $tipo;
		}
	}
?>