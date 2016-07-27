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
		
		public function obterComIdEGravacao($idTreinador,$gravacao){
			return $this->getDao()->obterComIdEGravacao($idTreinador,$gravacao);
		}
		
		public function mover($jogador,$x,$y){
			return $this->getDao()->mover($jogador,$x,$y);
		}
	}
?>