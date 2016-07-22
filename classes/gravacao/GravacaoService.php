<?php
	class GravacaoService extends Service{

		public function __construct($gravacaoDAO){
			parent::__construct($gravacaoDAO);
		}

		public function validar($gravacao, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>