<?php
	class FactorySingleton {
		private static $defaultDAOFactory = null;
		private static $defaultServiceFactory = null;
	
		private function __construct() {} // Privado para não ser possível instanciar a classe
	
		// Só instancia uma vez o DefaultDAOFactory
		public static function getDefaultDAOFactory() {
			if ( null == self::$defaultDAOFactory ) {
				self::$defaultDAOFactory = new DefaultDAOFactory();
			}
			return self::$defaultDAOFactory;
		}
	
		// Só instancia uma vez o DefaultDAOFactory
		public static function getDefaultServiceFactory($daoFactory) {
			if ( null == self::$defaultServiceFactory ) {
				self::$defaultServiceFactory = new DefaultServiceFactory($daoFactory);
			}
			return self::$defaultServiceFactory;
		}
	}
?>