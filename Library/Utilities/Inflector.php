<?php

class Inflector {
	
	public function upperCamelCase($string = NULL) {
		$string = strtolower($string);
		$string = ucwords($string);
		$string = str_replace(' ', '', $string);
		
		return $string;
	}
	
	public function slug($string = NULL, $separator = '-') {
		
		$string = strtolower($string);
		$string = str_replace(' ', $separator, $string);
		
		return $string;
	}
}