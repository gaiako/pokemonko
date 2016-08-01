<?php
	class TreinadorService extends Service{

		public function __construct($treinadorDAO){
			parent::__construct($treinadorDAO);
		}

		public function validar($treinador, &$erro){
			if($treinador->getSprite() == '')
				$erro['sprite'] = 'Selecione o sprite';
			
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
		
		public function obterTreinadorDaVez(){
			return $this->getDao()->obterTreinadorDaVez();
		}
		
		public function mover($x,$y,$looking){
			return $this->getDao()->mover($x,$y,$looking);
		}
	}
?>