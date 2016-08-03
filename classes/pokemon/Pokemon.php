<?php
	class Pokemon{

		private $id = 0;
		private $idGravacao = 0;
		private $pokemonBase = 0;
		private $idTreinadorGravacao = null;
		private $idMapa = null;
		private $idGrupo = null;
		private $looking = "down";
		private $ataques = array();
		private $x = null;
		private $y = null;
		private $hp = 0;
		private $ataque = 0;
		private $defesa = 0;
		private $ataqueEspecial = 0;
		private $defesaEspecial = 0;
		private $velocidade = 0;
		private $exp = 0;
		private $nivel = 1;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getIdGravacao(){
			return $this->idGravacao;
		}
		
		public function setIdGravacao($idGravacao){
			$this->idGravacao = $idGravacao;
		}

		public function getPokemonBase(){
			return $this->pokemonbase;
		}

		public function setPokemonBase($pokemonbase){
			$this->pokemonbase = $pokemonbase;
		}

		public function getIdTreinadorGravacao(){
			return $this->idTreinadorGravacao;
		}

		public function setIdTreinadorGravacao($idTreinadorGravacao){
			$this->idTreinadorGravacao = $idTreinadorGravacao;
		}

		public function getIdMapa(){
			return $this->idMapa;
		}

		public function setIdMapa($idMapa){
			$this->idMapa = $idMapa;
		}

		public function getIdGrupo(){
			return $this->idGrupo;
		}

		public function setIdGrupo($idGrupo){
			$this->idGrupo = $idGrupo;
		}

		public function getLooking(){
			return $this->looking;
		}

		public function setLooking($looking){
			$this->looking = $looking;
		}
		
		public function getAtaques(){
			return $this->ataques;
		}
		
		public function addAtaque($ataque){
			array_push($this->ataques,$ataque);
		}
		
		public function setAtaques($ataques){
			$this->ataques = $ataques;
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

		public function getvelocidade(){
			return $this->velocidade;
		}

		public function setvelocidade($velocidade){
			$this->velocidade = $velocidade;
		}

		public function getExp(){
			return $this->exp;
		}

		public function setExp($exp){
			$this->exp = $exp;
		}

		public function getNivel(){
			return $this->nivel;
		}

		public function setNivel($nivel){
			$this->nivel = $nivel;
		}
	}
?>