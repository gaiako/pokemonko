<?php
	session_start();
	
	if(!isset($_SESSION['gravacao']) && ($_GET['file'] != 'gravacao-cadastrar' && $_GET['file'] != 'gravacao-gerenciar')){
		$_SESSION['mensagem'] = "Bem-vindo ao Pokémon KO! Crie ou carregue uma gravação para começar";
		header('Location:/gravacao-gerenciar');
	}
	
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
?>