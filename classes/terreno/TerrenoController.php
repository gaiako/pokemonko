<?php
	class TerrenoController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id','nome', 'cor');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$terreno = new Terreno();
			$this->povoarSimples($terreno, $todosOsCampos, $_POST);
			
			if(isset($_POST['bloqueadoUp']))
				$terreno->setBloqueadoUp();
			if(isset($_POST['bloqueadoLeft']))
				$terreno->setBloqueadoLeft();
			if(isset($_POST['bloqueadoRight']))
				$terreno->setBloqueadoRight();
			if(isset($_POST['bloqueadoDown']))
				$terreno->setBloqueadoDown();
			
			return $terreno;
		}
	}
?>