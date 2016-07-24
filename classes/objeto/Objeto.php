<?php
	class Objeto{

		private $id = 0;
		private $nome = "";

		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNome($paraImagem = false){
			if($paraImagem)
				return Util::formatarParaUrl($this->nome).'.png';
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

	}
?>