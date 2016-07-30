<?php
	class MapaService extends Service{

		public function __construct($mapaDAO){
			parent::__construct($mapaDAO);
		}

		public function validar($mapa, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
		
		public function obterTodosOsPixels($mapa){
			return $this->getDAO()->obterTodosOsPixels($mapa);
		}
		
		public function updateMapaPixel($idMapaPixel,$terreno,$objeto,$idAcao,$bloqueado){
			//if(!is_numeric($terreno) && !is_numeric($objeto) && !is_numeric($idAcao) && !is_numeric($dificuldade))
				//return false;
			return $this->getDAO()->updateMapaPixel($idMapaPixel,$terreno,$objeto,$idAcao,$bloqueado);
		}
		
		public function setPossivelCaminhar($idMapa,$possivelCaminhar,$x,$y){ //arrays
			return $this->getDAO()->setPossivelCaminhar($idMapa,$possivelCaminhar,$x,$y);
		}
		
		public function setIdGrupo($idMapa,$idGrupo,$x,$y){ //arrays
			if(!is_numeric($idGrupo) || $idGrupo == '0')
				$idGrupo = null;
			return $this->getDAO()->setIdGrupo($idMapa,$idGrupo,$x,$y);
		}
	}
?>