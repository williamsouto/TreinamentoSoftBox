<?php

/**
 * Arquivo de validação de requisições via HTTP
 * *
 * @category Library
 * @package  Utilities
 * @author   William Souto Faria
 *
 */

class Request {
	
	/**
	 * Retorna todos os dados das requisições
	 * 
	 * @return Array, retorna um vetor com os dados da requisição atual
	 * 
	 */
	public function request() {
		
		$data['post'] = $this->post();
		$data['get'] = $this->get();
		$data['parametros'] = $this->params();
		$data['path_info'] = $this->path_info();
		$data['baseUrl'] = $this->baseUrl();
		
		return $data;
	}
	
	
	/**
	 * Checa ou retorna o tipo de requisição
	 *
	 * @param string $var o tipo da requisição
	 *
	 * @return  True/false, se $var for enviado como false no parametro $var retorna o metodo usado
	 *
	 */
	public function requestIs($var) {
		
		$request = $_SERVER['REQUEST_METHOD'];
		$request = strtolower($request);
		
		if ($var) {
			if ($request == $var) {
				return 'true';
			}
			return 'false';
		}
		
		return $request;
	}
	
	
	/**
	 * Retorna os dados enviados via post
	 *
	 * @return  Retorna os dados post
	 *
	 */
	private function post()
	{
		return $_POST;
	}
	
	
	/**
	 * Retorna os dados enviados via get
	 *
	 * @return  Retorna os dados get
	 *
	 */
	private function get()
	{
		return $_GET;
	}
	
	
	/**
	 * Retorna a path_info (usada para definir o MVC a se usar)
	 *
	 * @return String, Retorna a path_info
	 *
	 */
	private function path_info()
	{
		if (isset($_SERVER["PATH_INFO"])) {
			return $_SERVER["PATH_INFO"];
		}
	}
	
	
	/**
	 * Retorna os parâmetros enviados (através do path_info)
	 *
	 * @return Array, Retorna os parametros enviados
	 *
	 */
	private function params()
	{
		$params = explode('/', $_SERVER['REQUEST_URI']);
		unset($params['0']);
		unset($params['1']);
		$params = array_values($params);
		return $params;
	}
	
	
	/**
	 * Retorna a url completa que foi requisitada, através do REQUEST_URI
	 *
	 * @return String, Retorna a url completa que foi requisitada
	 *
	 */
	private function baseUrl(){
		return $_SERVER['REQUEST_URI'];
	}
}