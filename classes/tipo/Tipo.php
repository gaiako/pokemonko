<?php
	class Tipo{

		private $id = 0;
		private $nome = "";
		private $cor = "";

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

		public function getCor(){
			return $this->cor;
		}

		public function setCor($cor){
			if(substr($cor,0,1) != '#')
				$cor = '#'.$cor;
			$this->cor = $cor;
		}

	}
?>