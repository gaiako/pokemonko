<?php
	class MapaController extends Controller{

		public function __construct(){
			$this->classe = str_replace('Controller','',get_class($this));
		}

		public function criar(){
			$todosOsCampos = array('id', 'nome', 'dimensaoX', 'dimensaoY', 'xInicial', 'yInicial');
			$this->verificaEnvio($todosOsCampos, $_POST);
			$mapa = new Mapa();
			$this->povoarSimples($mapa, $todosOsCampos, $_POST);
			
			if(isset($_POST['idTerrenoPadrao'])){
				$mapa->setTerrenoPadrao(Util::makeController('terreno')->obterComId($_POST['idTerrenoPadrao']));
			}
			
			return $mapa;
		}
	}
?>