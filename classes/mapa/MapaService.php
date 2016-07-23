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
	}
?>