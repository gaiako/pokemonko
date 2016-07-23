<?php
	class TerrenoService extends Service{

		public function __construct($terrenoDAO){
			parent::__construct($terrenoDAO);
		}

		public function validar($terreno, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>