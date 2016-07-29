<?php
	class PokemonBase{

		private $id = 0;
		private $nome = "";
		private $foto = "";
		private $tipo = null;
		private $tipo2 = null;
		private $hp = 0;
		private $ataque = 0;
		private $defesa = 0;
		private $agilidade = 0;
		private $ataqueAtaqueEspecial = 0;
		private $defesaAtaqueEspecial = 0;
		private $exp = 0;
		private $sortePokeball = 0;
		private $nivel = 0;
		private $raridade = 0;

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
		
		public function getFoto(){
			return $this->foto;
		}
		
		public function setFoto($foto){
			$this->foto = $foto;
		}

		public function getTipo(){
			return $this->tipo;
		}

		public function setTipo($tipo){
			$this->tipo = $tipo;
		}

		public function getTipo2(){
			return $this->tipo2;
		}

		public function setTipo2($tipo2){
			$this->tipo2 = $tipo2;
		}

		public function getHp(){
			return $this->hp;
		}

		public function setHp($hp){
			$this->hp = $hp;
		}

		public function getAtaque(){
			return $this->ataque;
		}

		public function setAtaque($ataque){
			$this->ataque = $ataque;
		}

		public function getDefesa(){
			return $this->defesa;
		}

		public function setDefesa($defesa){
			$this->defesa = $defesa;
		}

		public function getAgilidade(){
			return $this->agilidade;
		}

		public function setAgilidade($agilidade){
			$this->agilidade = $agilidade;
		}

		public function getAtaqueEspecial(){
			return $this->ataqueEspecial;
		}

		public function setAtaqueEspecial($ataqueEspecial){
			$this->ataqueEspecial = $ataqueEspecial;
		}
		
		public function getDefesaEspecial(){
			return $this->defesaEspecial;
		}

		public function setDefesaEspecial($defesaEspecial){
			$this->defesaEspecial = $defesaEspecial;
		}

		public function getExp(){
			return $this->exp;
		}

		public function setExp($exp){
			$this->exp = $exp;
		}

		public function getSortePokeball(){
			return $this->sortePokeball;
		}

		public function setSortePokeball($sortePokeball){
			$this->sortePokeball = $sortePokeball;
		}

		public function getNivel(){
			return $this->nivel;
		}

		public function setNivel($nivel){
			$this->nivel = $nivel;
		}
		
		public function getRaridade(){
			return $this->raridade;
		}
		
		public function setRaridade($raridade){
			$this->raridade = $raridade;
		}

	}
?>