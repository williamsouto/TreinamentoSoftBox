<?php

/**
 * Classe respons�vel em verificar as requisi��es e criar o controle
 * correto, de acordo com os par�metros passados na Url
 * 
 * @category Library
 * @package  Core
 * @author   William Souto Faria
 *
 */

class Router
{
	private $request = null;
	private $controller;
	private $action;
	
	function __construct() {
		$this->request = new Request();
	}
	
	
	/**
	 *  Valida a requisi��o e carrega a view solicitada.
	 * 
	 *  @param void
	 *
	 *  @return  void
	 *  
	 */
	public function load() {
		
		/*
		 *  Obtem todas as informa��es de requisi��o do usu�rio 
		 *  e � passado como par�metro para a fun��o validaRota validar a url.
		*/
		$url = $this->request->request();
		$this->validaRota($url['parametros']); 
		
		if (file_exists("./App/Controller/{$this->controller}Controller.php")) {
			require_once "./App/Controller/{$this->controller}Controller.php";
		} else {
			echo "P&aacute;gina nao encontrada";
			exit;
		}
		
		$this->controller .= 'Controller';
		
		$classe = new $this->controller();
		
		if (method_exists($classe, $this->action)) {
			
			$metodo = $this->action;
			$classe->$metodo();
			echo $metodo;
			exit;
		} else {
			echo "P&aacute;gina nao encontrada";
			exit;
		}
	}
	
	
	/**
	 *  Verifica a rota solicitada.
	 *
	 *  @param string, Url passada via HTTP.
	 *
	 *  @return  void
	 *
	 */
	private function validaRota($url) {
		try {
			
			// Verifica se a url requisitada pelo usuario passou algum par�metro 
			if (!empty($url[0])) {
				$this->controller = ucwords(strtolower($url[0]));
			} else {
				$this->controller = "Home";
			}
			
			if (!empty($url[1])) {
				$this->action = $url[1];
			} else {
				$this->action = "index";
			}
			
		} catch (Exception $ex) {
			$ex->getMessage();
		}
	}
}