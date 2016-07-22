<?php
	class PokemonBaseService extends Service{

		public function __construct($pokemonBaseDAO){
			parent::__construct($pokemonBaseDAO);
		}

		public function validar($pokemonBase, &$erro){
			if(count($erro) > 0){
				$erro['validado'] = true;
				throw new ServiceException('Corrija os campos abaixo para efetuar o cadastro');
			}
		}
	}
?>