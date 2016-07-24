<?php
	class Terreno{
		
		private $id = 0;
		private $nome = "";
		private $imagem = null;
		private $cor = "";
		private $bloqueadoUp = false;
		private $bloqueadoLeft = false;
		private $bloqueadoRight = false;
		private $bloqueadoDown = false;
		
		public function getId(){
			return $this->id;
		}

		public function setId($id){
			$this->id = $id;
		}

		public function getNome($imagem = false){
			if($imagem)
				return Util::formatarParaUrl($this->nome).'.png';
			return $this->nome;
		}

		public function setNome($nome){
			$this->nome = $nome;
		}

		public function getImagem(){
			return $this->imagem;
		}

		public function setImagem($imagem){
			$this->imagem = $imagem;
		}

		public function getCor(){
			return $this->cor;
		}

		public function setCor($cor){
			$this->cor = $cor;
		}

		public function getBloqueadoUp(){
			return $this->bloqueadoUp;
		}

		public function setBloqueadoUp($bloqueadoUp = true){
			$this->bloqueadoUp = $bloqueadoUp;
		}

		public function getBloqueadoLeft(){
			return $this->bloqueadoLeft;
		}

		public function setBloqueadoLeft($bloqueadoLeft = true){
			$this->bloqueadoLeft = $bloqueadoLeft;
		}

		public function getBloqueadoRight(){
			return $this->bloqueadoRight;
		}

		public function setBloqueadoRight($bloqueadoRight = true){
			$this->bloqueadoRight = $bloqueadoRight;
		}

		public function getBloqueadoDown(){
			return $this->bloqueadoDown;
		}

		public function setBloqueadoDown($bloqueadoDown = true){
			$this->bloqueadoDown = $bloqueadoDown;
		}

	}
?>