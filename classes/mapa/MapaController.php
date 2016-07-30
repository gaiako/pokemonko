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
			
			if(isset($_POST['terrenoPadrao'])){
				$mapa->setTerrenoPadrao(Util::makeController('terreno')->obterComId($_POST['terrenoPadrao']));
			}
			
			return $mapa;
		}
		
		public function obterTodosOsPixels($mapa){
			return Util::makeService($this->classe)->obterTodosOsPixels($mapa);
		}
		
		public function updateMapaPixel($idMapaPixel,$terreno,$objeto,$idAcao,$bloqueado){
			return Util::makeService($this->classe)->updateMapaPixel($idMapaPixel,$terreno,$objeto,$idAcao,$bloqueado);
		}
		
		public function setPossivelCaminhar($idMapa,$possivelCaminhar,$x,$y){ //arrays
			return Util::makeService($this->classe)->setPossivelCaminhar($idMapa,$possivelCaminhar,$x,$y);
		}
		
		public function setIdGrupo($idMapa,$idGrupo,$x,$y){ //arrays
			return Util::makeService($this->classe)->setIdGrupo($idMapa,$idGrupo,$x,$y);
		}
	}
?>