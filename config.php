<?php
	session_start();
	
	error_reporting(E_ALL & ~(E_DEPRECATED|E_STRICT|E_NOTICE|E_WARNING));
	
	global $_;
	global $_service;
	global $_dao;
	$_ = new stdClass();
	
	if(substr($_SERVER['DOCUMENT_ROOT'], -1) == '/')
		$_->raiz = substr($_SERVER['DOCUMENT_ROOT'], 0, -1);
	else $_->raiz = $_SERVER['DOCUMENT_ROOT'];

	if(file_exists($_->raiz."/util/autoload.php"))
		include_once($_->raiz."/util/autoload.php");
	if(file_exists($_->raiz."/util/Util.php"))
		include_once($_->raiz."/util/Util.php");
	if(file_exists($_->raiz."/classes/ImagemFactory.php"))
		include_once($_->raiz."/classes/ImagemFactory.php");

	spl_autoload_register('__autoload');
		
	if(!isset($_SESSION['gravacao']) && ($_GET['file'] != 'gravacao-cadastrar' && $_GET['file'] != 'gravacao-gerenciar' && $_GET['file'] != 'treinador-gerenciar')){
		$_SESSION['mensagem'] = "Bem-vindo ao Pokémon KO! Crie ou carregue uma gravação para começar";
		header('Location:/gravacao-gerenciar');
	}

	$config = new stdClass();
	
	$config->gravacao = Util::makeController('gravacao')->obterComId($_SESSION['gravacao']);
	$config->minDificuldade = 1;
	$config->maxDificuldade = 7;
	$config->maxTamanhomapa = 100;
	$config->minDado = 1;
	$config->maxDado = 6;
	$config->pastaImagemObjeto = '/app/assets/images/objeto/';
	$config->pastaImagemTerreno = '/app/assets/images/terreno/';
	$config->pastaImagemPokemon = '/app/assets/images/pokemon/';
	$config->pastaImagemSprite = '/app/assets/images/sprite/';
	$config->pastaImagemSpriteAnimated = '/app/assets/images/sprite/animated/';
?>