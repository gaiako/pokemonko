<?php
	require_once($_SERVER['DOCUMENT_ROOT']."/config.php");
	require_once($_->raiz."/classes/BancoDados.php");
	class BDSingleton {
		private static $bancoDados = null;
	
		private function __construct() {} // Privado para não ser possível instanciar a classe
	
		// Só instancia uma vez
		public static function get() {
			//TODO : não usar variavel global $use_test_bd
			global $use_test_bd;
			if ( null == self::$bancoDados ) {
				if (!$use_test_bd) {
					self::$bancoDados = new BancoDados();
				} else {
					self::$bancoDados = new TestBancoDados();
				}
			}
			return self::$bancoDados;
		}
	}
?>