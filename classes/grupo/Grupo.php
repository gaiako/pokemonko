<?php
	class Grupo{

		private $id = 0;
		private $nome = "";
		private $minNivel = 0;
		private $maxNivel = 0;
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
		
		public function getMinNivel(){
			return $this->minNivel;
		}
		
		public function setMinNivel($minNivel){
			$this->minNivel = $minNivel;
		}
		
		public function getMaxNivel(){
			return $this->maxNivel;
		}
		
		public function setMaxNivel($maxNivel){
			$this->maxNivel = $maxNivel;
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