<?php

class CategoriaAtaque implements Enum{
	const FISICO 			= 1;
	const ESPECIAL			= 2;
	const ESTRATEGICO	 	= 3;
	
	public static function isValid($status) {
		
		if($status === null) {
			return false;
		}
		
		switch($status) {
			case self::FISICO:
			case self::ESPECIAL:
			case self::ESTRATEGICO:
				return true;
			default:
				return false;
		}
	}
	
	public static function numOptions() {
		return count(self::toArray());
	}

	public static function toArray() {
		return array(
			self::FISICO => "Físico",
			self::ESPECIAL => "Especial",
			self::ESTRATEGICO => "Estratégico"
		);
	}

	public static function toString($enum) {
		$array = self::toArray();
		return $array[$enum];
	}

	public statis function icone($status){
		
	}
}
?>