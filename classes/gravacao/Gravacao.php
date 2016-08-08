<?php
	class Gravacao{

		private $id = 0;
		private $treinadores = array();
		private $mapaInicial = 0;
		private $nome = "";
		private $dataCadastro = "";
		private $vezTreinadorGravacao = null;
		private $dado = null;

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}
		
		public function getTreinadores(){
			return $this->treinadores;
		}
		
		public function addTreinador($treinador){
			array_push($this->treinadores,$treinador);
		}
		
		public function setTreinadores($treinadores){
			$this->treinadores = $treinadores;
		}
		
		public function getMapaInicial(){
			return $this->mapaInicial;
		}
		
		public function setMapaInicial($mapaInicial){
			$this->mapaInicial = $mapaInicial;
		}

		public function getNome(){
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getDataCadastro($format = Y-m-d){
			if($this->dataCadastro == null || $this->dataCadastro == '')
				return null;
			if($format != ''){
				return date($format,strtotime($this->dataCadastro));
			}
			return $this->dataCadastro;
		}

		public function setDataCadastro($dataCadastro){
			$dataCadastro = str_replace('/','-',$dataCadastro);
			$this->dataCadastro = $dataCadastro;
		}
		
		public function getVezTreinadorGravacao(){
			return $this->vezTreinadorGravacao;
		}
		
		public function setVezTreinadorGravacao($vezTreinadorGravacao){
			$this->vezTreinadorGravacao = $vezTreinadorGravacao;
		}
		
		public function getDado(){
			return $this->dado;
		}
		
		public function setDado($dado){
			$this->dado = $dado;
		}
	}
?>