<?php
	class Treinador{

		private $id = 0;
		private $nome = "";
		private $humano = false;
		private $dificuldade = null;
		private $gravacao = null;
		private $mapa = 0; //Gravação
		private $x = 1; //Gravação
		private $y = 1; //Gravação
		private $cor = "";
		private $pokemonDollar = 0.0; //Gravação

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

		public function getHumano(){
			return $this->humano;
		}

		public function setHumano($humano = true){
			$this->humano = $humano;
		}

		public function getDificuldade(){
			return $this->dificuldade;
		}

		public function setDificuldade($dificuldade){
			$this->dificuldade = $dificuldade;
		}

		public function getGravacao(){
			return $this->idGravacao;
		}

		public function setGravacao($idGravacao){
			$this->idGravacao = $idGravacao;
		}

		public function getMapa(){
			return $this->mapa;
		}

		public function setMapa($mapa){
			$this->mapa = $mapa;
		}

		public function getX(){
			return $this->x;
		}

		public function setX($x){
			$this->x = $x;
		}

		public function getY(){
			return $this->y;
		}

		public function setY($y){
			$this->y = $y;
		}

		public function getCor(){
			return $this->cor;
		}

		public function setCor($cor){
			$this->cor = $cor;
		}

		public function getPokemonDollar(){
			return $this->pokemonDollar;
		}

		public function setPokemonDollar($pokemonDollar){
			$this->pokemonDollar = $pokemonDollar;
		}

	}
?>