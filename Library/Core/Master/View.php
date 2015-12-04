<?php

/**
 * Arquivo responsável em renderizar páginas html com valores recebido da base de dados.
 *
 * @category Library
 * @package  Master
 * @author   William Souto Faria
 *
 */

class View {
	
	private $dados = array();
	public $conteudo;
	public $mensagem;
	public $chat;
	
	/**
	 * Retorna o valor da chave passada como parâmetro, caso não passe, retorna todo array.
	 *
	 * @param $key, chave do array de dados.
	 *
	 * @return se o parâmetro chave não for passado, retorna o array, se a chave for encontrada, 
	 * retorna o valor da mesma, e se o valor da chave for vazia, retorna ''.
	 */
	public function get($key = '') {
		
		if (empty($key)) {
			return $this->dados;
		} else {
			if (isset($this->dados[$key]) && !empty($this->dados[$key])) {
				return $this->dados[$key];
			} else {
				return '';
			}
		}
	}
	
	
	/**
	 * Seta o novo valor e chave no array de dados.
	 *
	 * @param $key, chave que será criada no array dados.
	 * 
	 * @param $value, valor que será associado a chave criada.
	 *
	 * @return void.
	 */
	public function set($key, $value) {
		$this->dados[$key] = $value;
	}
	
	
	/**
	 * Renderiza a view passada como parâmetro, juntamente com os dados que estão no array dados.
	 *
	 * @param $view, página html que será renderizada.
	 *
	 * @return void.
	 */
	public function render($view) {
		
		foreach ($this->get() as $key=>$value) {
			$$key = $value;
		}

		if (file_exists("./App/View/{$view}")) {
			
			ob_start();
			include "./App/Template/chat.phtml";
			$this->chat = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			include "./App/Template/mensagem.phtml";
			$this->mensagem = ob_get_contents();
			ob_end_clean();
			
			ob_start();
			include "./App/View/{$view}";
			$this->conteudo = ob_get_contents();
			ob_end_clean();
			
			require_once './App/Template/base.phtml';
		}
	}
}