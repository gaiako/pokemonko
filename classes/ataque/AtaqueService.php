<?php
	class AtaqueService extends Service{

		public function __construct($ataqueDAO){
			parent::__construct($ataqueDAO);
		}

		public function validar($ataque, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
		public function sortearAtaques($pokemon){
			return $this->getDao()->sortearAtaques($pokemon);
		}
	}
?>