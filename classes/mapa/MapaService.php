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
		
		public function updateMapaPixel($idMapaPixel,$idTerreno,$idObjeto,$idAcao,$dificuldade){
			//if(!is_numeric($idTerreno) && !is_numeric($idObjeto) && !is_numeric($idAcao) && !is_numeric($dificuldade))
				//return false;
			return $this->getDAO()->updateMapaPixel($idMapaPixel,$idTerreno,$idObjeto,$idAcao,$dificuldade);
		}
	}
?>