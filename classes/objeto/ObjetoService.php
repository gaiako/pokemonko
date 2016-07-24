<?php
	class ObjetoService extends Service{

		public function __construct($objetoDAO){
			parent::__construct($objetoDAO);
		}

		public function validar($objeto, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>