<?php

interface ImagemFunctionsInterface{
	public function definirImagemPrincipal($idImagem);
	public function definirImagemCostas($idImagem);
	public function removerImagemCostas($idImagem);
	public function excluirImagem($imagem);
}