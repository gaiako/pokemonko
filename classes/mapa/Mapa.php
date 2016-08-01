<?php
	class Mapa{

		private $id = 0;
		private $nome = "";
		private $dimensaoX = 50;
		private $dimensaoY = 50;
		private $terrenoPadrao = 1;
		private $xInicial = 1;
		private $yInicial = 1;
		private $maxPokemons = 150;
		private $intervaloCriacao = 10;
		private $intervaloMovimento = 3;

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

		public function getDimensaoX(){
			return $this->dimensaoX;
		}

		public function setDimensaoX($dimensaoX){
			$this->dimensaoX = $dimensaoX;
		}

		public function getDimensaoY(){
			return $this->dimensaoY;
		}

		public function setDimensaoY($dimensaoY){
			$this->dimensaoY = $dimensaoY;
		}

		public function getTerrenoPadrao(){
			return $this->terrenoPadrao;
		}

		public function setTerrenoPadrao($terrenoPadrao){
			$this->terrenoPadrao = $terrenoPadrao;
		}

		public function getXInicial(){
			return $this->xInicial;
		}

		public function setXInicial($xInicial){
			$this->xInicial = $xInicial;
		}

		public function getYInicial(){
			return $this->yInicial;
		}

		public function setYInicial($yInicial){
			$this->yInicial = $yInicial;
		}
		
		public function getMaxPokemons(){
			return $this->maxPokemons;
		}
		
		public function setMaxPokemons($maxPokemons){
			$this->maxPokemons = $maxPokemons;
		}
		
		public function getIntervaloCriacao(){
			return $this->intervaloCriacao;
		}
		
		public function setIntervaloCriacao($intervaloCriacao){
			$this->intervaloCriacao = $intervaloCriacao;
		}
		
		public function getIntervaloMovimento(){
			return $this->intervaloMovimento;
		}
		
		public function setIntervaloMovimento($intervaloMovimento){
			$this->intervaloMovimento = $intervaloMovimento;
		}

	}
?>