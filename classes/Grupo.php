<?php
	class Grupo{

		private $id = 0;
		private $nome = "";
		private $pokemons = array();

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getPokemons(){
			return $this->pokemons;
		}
		
		public function addPokemon($pokemon){
			array_push($this->pokemons,$pokemon);
		}

		public function setPokemons($pokemons){
			$this->pokemons = $pokemons;
		}
		
		public function temPokemon($idPokemon){
			foreach($this->getPokemons() as $p){
				if($p->getId() == $idPokemon)
					return true;
			}
			return false;
		}

	}
?>