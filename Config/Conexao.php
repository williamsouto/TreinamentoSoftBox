<?php

/**
 * Arquivo de configura��o para conex�o com o banco de dados.
 *
 * @category Config
 * @package  
 * @author   William Souto Faria
 *
 */

class Conexao {
	
	public static function criarConexao() {
		return new PDO ( 'mysql:host=localhost; dbname=treinamento; charset=utf8', 'root', '' );
	}
}