<?php
	class Gravacao{

		private $id = 0;
		private $nome = "";
		private $dataCadastro = "";

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

	}
?>