<?php

require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
global $_;
require_once($_->raiz.'/util/autoload.php');

/*
 *	Classe imagem, do tipo readOnly, qualquer operação para ser salva deve ser realizada pela ImagemFactory
 */

class Imagem extends ImagemAbstrata {

	public function __construct($caminho, $real = false, $raiz = true) {
		global $_;
		if($raiz) {
			$src =  $_->raiz . $caminho;
		} else {
			$src = $caminho;
		}
		if(file_exists($src)) {
		
			if(is_file($src)){
			
				$size = getimagesize($src);
				$campos = explode("/", $caminho);
				$this->setNomeObjeto(array_pop($campos));
				$this->setPasta(implode("/", $campos));
				$this->setExtensao(pathinfo($this->nomeObjeto, PATHINFO_EXTENSION));
			
				if($real) {
					switch ($size['mime']) { 
						case "image/gif": 
							$this->setImagem(imagecreatefromgif($src));
							break; 
						case "image/jpeg" : 
							$this->setImagem(imagecreatefromjpeg($src));
							break; 
						case "image/png" : 
							$this->setImagem(imagecreatefrompng($src));
							break; 
						case "image/x-ms-bmp":
							$this->setImagem(ImagemFactory::imagecreatefrombmp($src));
							break;
						default:
							throw new InvalidArgumentException("Fomato da imagem Invalido: " .  $size['mime']);
					} 
				}
			} else {
				throw new InvalidArgumentException("O Caminho passado é uma pasta, esperava-se um arquivo:" . $src);
			}
		} else {
			throw new IOException("O Arquivo nao existe: " . $src);
		}
	}
	
	public function getCaminhoExibicao($subPasta = "") {
		if($subPasta == "") {
			return $this->getPasta() . '/' . $this->getNomeObjeto();
		} else {
			return $this->getPasta() . '/' . $subPasta . '/' .$this->getNomeObjeto();
		}
	}
}