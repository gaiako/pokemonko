<?php
	class JogadorService extends Service{

		public function __construct($jogadorDAO){
			parent::__construct($jogadorDAO);
		}

		public function validar($jogador, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>