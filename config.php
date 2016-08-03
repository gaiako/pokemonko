<?php
	session_start();
	
	error_reporting(E_ALL & ~(E_DEPRECATED|E_STRICT|E_NOTICE|E_WARNING));
	
	set_time_limit (300);
	
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

	$_->config = new stdClass();
	
	$_->config->gravacao = Util::makeController('gravacao')->obterComId($_SESSION['gravacao']);
	$_->config->minDificuldade = 1;
	$_->config->maxDificuldade = 7;
	$_->config->maxTamanhomapa = 100;
	$_->config->minDado = 1;
	$_->config->maxDado = 6;
	$_->config->pastaImagemObjeto = '/app/assets/images/objeto/';
	$_->config->pastaImagemTerreno = '/app/assets/images/terreno/';
	$_->config->pastaImagemPokemon = '/app/assets/images/pokemon/';
?>