<?php

class Looking implements Enum{
	const LEFT 		= 37;
	const UP		= 38;
	const RIGHT	 	= 39;
	const DOWN		= 40;
	
	public static function isValid($status) {
		
		if($status === null) {
			return false;
		}
		
		switch($status) {
			case self::LEFT:
			case self::UP:
			case self::RIGHT:
			case self::DOWN:
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
			self::LEFT => "left",
			self::UP => "up",
			self::RIGHT => "right",
			self::DOWN => "down"
		);
	}

	public static function toString($enum) {
		$array = self::toArray();
		return $array[$enum];
	}

	public function sortear(){
		return self::toString(rand(37,40));
	}
}
?>