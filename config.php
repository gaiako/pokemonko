<?php
	//ini_set('memory_limit', '1280M');
	session_start();

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