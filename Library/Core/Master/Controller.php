<?php

/**
 * Prot�tipo das classes Controller, respons�vel por fazer a dinamiza��o entre views e models.
 *
 * @category Library
 * @package  Master
 * @author   William Souto Faria
 *
 */

abstract class Controller {
	
	protected $view = null;
	
	function __construct() {
		$this->view = new View ();
	}
	
	/**
	 * Verifica se o model passado como par�metro existe,
	 * se sim, � criado uma inst�ncia dessa classe, se n�o, � lan�ado um erro.
	 * 
	 * @param string, nome do model
	 * 
	 * @return Objeto do model solicitado.
	 **/
	public function criarModelo($model) {
		try {
			
			$model .= "Model";
			
			if (file_exists("./App/Model/" . PERSISTENCIA . "/{$model}.php")) {
				require_once "./App/Model/" . PERSISTENCIA . "/{$model}.php";
				return new $model($model);
			} else {
				throw new Exception('Arquivo n&atilde;o encontrado.');
			}
			
		} catch (Exception $ex) {
			echo 'Erro: ', $ex->getMessage (), "\n";
		}
	}
	
	public abstract function index();
	
}