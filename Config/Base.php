<?php

/**
 * Arquivo de configuração para persistencia dos dados.
 *
 * @category Config
 * @package
 * @author   William Souto Faria
 *
 */

class Base {
	
	public static function persistencia($metodo) {
		
		if ($metodo == 'ARQUIVO') {
			DEFINE('PERSISTENCIA', 'Arquivo');
		} else {
			DEFINE('PERSISTENCIA', 'BD');
		}
	}
	
}