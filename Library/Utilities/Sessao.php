<?php

/**
 * Arquivo que manipula as sessões de usuário.
 * *
 * @category Library
 * @package  Utilities
 * @author   William Souto Faria
 *
 */

class Sessao {
	
	public function startSession() {
		
		session_start();
		
		if (!isset($_SESSION['usuario'])) {
		
			if (isset($_POST['usuario'])) {
		
				$_SESSION['usuario'] = $_POST['usuario'];
				header("Location: http://localhost/TreinamentoSoftbox/");
			} else {
				require_once './App/Template/login.phtml';
				exit;
			}
		
		} else {
			return 1;
		}
	}
	
	
	public function setSession($key, $value) {
		$_SESSION[$key] = $value;
	}
	
}