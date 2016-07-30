<?php

class TipoAtaque implements Enum{
	const FISICO 			= 0;
	const ESPECIAL			= 1;
	const ESTRATEGICO	 	= 2;
	
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