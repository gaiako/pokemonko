<?php
	class GravacaoService extends Service{

		public function __construct($gravacaoDAO){
			parent::__construct($gravacaoDAO);
		}

		public function validar($gravacao, &$erro){
			if(strlen($gravacao->getNome()) < 1)
				$erro['nome'] = 'Preencha o nome da gravação';
						
			if(!count($gravacao->getTreinadores()))
				$erro['treinadores'] = 'Escolha ao menos 1 treinador para começar';
			
			if(!$gravacao->getMapaInicial() instanceOf Mapa)
				$erro['mapaInicial'] = 'Mapa inicial não selecionado';
			
			if(count($erro) > 0){
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
		
		public function passarAVez($idJogador){
			return $this->getDao()->passarAVez($idJogador);
		}
	}
?>