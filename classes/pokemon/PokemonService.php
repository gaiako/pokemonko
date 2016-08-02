<?php
	class PokemonService extends Service{

		public function __construct($pokemonDAO){
			parent::__construct($pokemonDAO);
		}

		public function validar($pokemon, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
		
		public function obterComRestricoes($restricoes,$orderBy = 'pokemon.id', $limit = null, $offset = null, $completo = true){
			return $this->getDao()->obterComRestricoes($restricoes,$orderBy, $limit, $offset, $completo);
		}
		
		public function capturar($looking){
			return $this->getDao()->capturar($looking);
		}
	}
?>