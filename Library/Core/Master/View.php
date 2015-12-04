<?php

/**
 * Arquivo respons�vel em renderizar p�ginas html com valores recebido da base de dados.
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
	 * Retorna o valor da chave passada como par�metro, caso n�o passe, retorna todo array.
	 *
	 * @param $key, chave do array de dados.
	 *
	 * @return se o par�metro chave n�o for passado, retorna o array, se a chave for encontrada, 
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
	 * @param $key, chave que ser� criada no array dados.
	 * 
	 * @param $value, valor que ser� associado a chave criada.
	 *
	 * @return void.
	 */
	public function set($key, $value) {
		$this->dados[$key] = $value;
	}
	
	
	/**
	 * Renderiza a view passada como par�metro, juntamente com os dados que est�o no array dados.
	 *
	 * @param $view, p�gina html que ser� renderizada.
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