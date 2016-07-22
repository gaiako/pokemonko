<?php

class Page {
	public $title = 'Pokémon KO';
	public $titleSeparator = ' | ';

	public function generateTitle($text = ''){
		return $title . $titleSeparator . $text;
	}
}