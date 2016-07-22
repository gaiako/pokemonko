<?php
	class TipoService extends Service{

		public function __construct($tipoDAO){
			parent::__construct($tipoDAO);
		}

		public function validar($tipo, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>