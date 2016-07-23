<?php
	class Treinador{

		private $id = 0;
		private $nome = "";
		private $humano = 1;
		private $dificuldade = null;
		private $gravacao = null;
		private $idMapa = 0;
		private $x = 1;
		private $y = 1;
		private $cor = "";
		private $dinheiro = 0.0;

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

		public function setHumano($humano){
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

		public function getIdMapa(){
			return $this->idMapa;
		}

		public function setIdMapa($idMapa){
			$this->idMapa = $idMapa;
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

		public function getDinheiro(){
			return $this->dinheiro;
		}

		public function setDinheiro($dinheiro){
			$this->dinheiro = $dinheiro;
		}

	}
?>