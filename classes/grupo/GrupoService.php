<?php
	class GrupoService extends Service{

		public function __construct($grupoDAO){
			parent::__construct($grupoDAO);
		}

		public function validar($grupo, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>