<?php
	class TreinadorService extends Service{

		public function __construct($treinadorDAO){
			parent::__construct($treinadorDAO);
		}

		public function validar($treinador, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>