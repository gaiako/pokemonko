<?php
	class Mapa{

		private $id = 0;
		private $nome = "";
		private $dimensaox = 50;
		private $dimensaoy = 50;
		private $terrenoPadrao = 1;
		private $xInicial = 1;
		private $yInicial = 1;

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

		public function getDimensaox(){
			return $this->dimensaox;
		}

		public function setDimensaox($dimensaox){
			$this->dimensaox = $dimensaox;
		}

		public function getDimensaoy(){
			return $this->dimensaoy;
		}

		public function setDimensaoy($dimensaoy){
			$this->dimensaoy = $dimensaoy;
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

	}
?>