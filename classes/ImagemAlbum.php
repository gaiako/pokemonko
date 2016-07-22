<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");

	class ImagemAlbum extends Imagem{

		private $id = 0;
		private $titulo = "";
		private $legenda = "";
		
		public function getId(){
			return $this->id;
		}
		
		public function setId($id){
			$this->id = $id;
		}
		
		public function getTitulo(){
			return $this->titulo;
		}
		
		public function setTitulo($titulo){
			$this->titulo = $titulo;
		}
		
		public function getLegenda(){
			return $this->legenda;
		}
		
		public function setLegenda($legenda){
			$this->legenda = $legenda;
		}
		
	}
?>