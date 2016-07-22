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