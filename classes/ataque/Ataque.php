<?php
	class Ataque{

		private $id = 0;
		private $nome = "";
		private $json = "";
		private $descricao = "";
		private $categoria = 0;
		private $tipo = 0;
		private $dano = 0;
		private $recuperacao = 0;
		private $precisao = 0;
		private $sempreAcerta = false;
		private $prioridade = false;
		private $numeroAtaques = 1;
		private $idEfeito = 0;
		private $precisaoEfeito = 0;
		private $habilitado = 1;

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

		public function getJson(){
			return $this->json;
		}

		public function setJson($json){
			$this->json = $json;
		}

		public function getDescricao(){
			return $this->descricao;
		}

		public function setDescricao($descricao){
			$this->descricao = $descricao;
		}

		public function getCategoria(){
			return $this->categoria;
		}

		public function setCategoria($categoria){
			$this->categoria = $categoria;
		}

		public function getTipo(){
			return $this->tipo;
		}

		public function setTipo($tipo){
			$this->tipo = $tipo;
		}

		public function getDano(){
			return $this->dano;
		}

		public function setDano($dano){
			$this->dano = $dano;
		}

		public function getRecuperacao(){
			return $this->recuperacao;
		}

		public function setRecuperacao($recuperacao){
			$this->recuperacao = $recuperacao;
		}

		public function getPrecisao(){
			return $this->precisao;
		}

		public function setPrecisao($precisao){
			$this->precisao = $precisao;
		}

		public function getSempreAcerta(){
			return $this->sempreAcerta;
		}

		public function setSempreAcerta($sempreAcerta){
			$this->sempreAcerta = $sempreAcerta;
		}

		public function getPrioridade(){
			return $this->prioridade;
		}

		public function setPrioridade($prioridade){
			$this->prioridade = $prioridade;
		}

		public function getNumeroAtaques(){
			return $this->numeroAtaques;
		}

		public function setNumeroAtaques($numeroAtaques){
			$this->numeroAtaques = $numeroAtaques;
		}

		public function getIdEfeito(){
			return $this->idEfeito;
		}

		public function setIdEfeito($idEfeito){
			$this->idEfeito = $idEfeito;
		}

		public function getPrecisaoEfeito(){
			return $this->precisaoEfeito;
		}

		public function setPrecisaoEfeito($precisaoEfeito){
			$this->precisaoEfeito = $precisaoEfeito;
		}

		public function getHabilitado(){
			return $this->habilitado;
		}

		public function setHabilitado($habilitado){
			$this->habilitado = $habilitado;
		}

	}
?>