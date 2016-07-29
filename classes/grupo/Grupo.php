<?php
	class Grupo{

		private $id = "";
		private $nome = "";
		private $pokemons = "";

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

		public function setPokemons($pokemons){
			$this->pokemons = $pokemons;
		}

	}
?>