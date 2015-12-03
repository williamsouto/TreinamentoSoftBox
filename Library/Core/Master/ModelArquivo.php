<?php

/**
 * Classe com funções para manipulação de arquivo.
 * *
 * @category Library
 * @package  Master
 * @author   William Souto Faria
 *
 */

class ModelArquivo {
	
	protected $file;
	protected $caminho;
	protected $serial;
	protected $fileAuxiliar = array();
	
	public function __construct($model) {
		
		if ($model == 'CategoriaModel') {
			$this->caminho = './App/DAO/tbcategoria.json';
			$this->serial = './App/DAO/serialCategoria.json';
		} else {
			$this->caminho = './App/DAO/tblancamento.json';
			$this->serial = './App/DAO/serialLancamento.json';
		}
		
	}
	
	
	/**
	 * Abre o arquivo no modo leitura, e seta o ponteiro no atributo file da classe.
	 *
	 * @param void
	 *
	 * @return void.
	 */
	public function openFile() {
		
		if (file_exists($this->caminho)){
			
			$this->file = fopen($this->caminho, 'r');
		} else {
			throw new Exception('Arquivo não encontrado');
		}
	}
	
	
	/**
	 * Abre o arquivo alternativo passado como parâmetro no modo leitura, e seta o ponteiro no atributo fileAuxiliar da classe.
	 *
	 * @param string, $caminho - url de onde se encontra o arquivo que deseja abrir.
	 * 
	 * @param string, $file - nome do arquivo.
	 *
	 * @return void.
	 */
	public function openFileAux($caminho, $file) {
		
		if (file_exists($caminho)){
				
			$this->fileAuxiliar[$file] = fopen($caminho, 'r');
			$this->fileAuxiliar['Caminho'] = $caminho;
			
		} else {
			throw new Exception('Arquivo não encontrado');
		}
	}
	
	
	/**
	 * Fecha o arquivo que esta aberto.
	 *
	 * @param void.
	 *
	 * @return void.
	 */
	public function closeFile() {
		fclose($this->file);
	}
	
	
	/**
	 * Fecha o arquivo arquivo alternativo que esta aberto.
	 *
	 * @param string, $file - nome do arquivo que deseja fechar.
	 * 
	 * @return void.
	 */
	public function closeFileAux($file) {
		fclose($this->fileAuxiliar[$file]);
	}
	
	
	/**
	 * Lê o arquivo arquivo que esta aberto.
	 *
	 * @param void.
	 *
	 * @return array, dados que estão escritos no arquivo, o retorno é um array associativo.
	 */
	public function readFile() {
		$data = fread($this->file, filesize($this->caminho));
		
		return json_decode($data, true);
	}
	
	
	/**
	 * Lê o arquivo arquivo alternativo que esta aberto.
	 *
	 * @param string, $file - nome do arquivo que deseja ler.
	 *
	 * @return array, dados que estão escritos no arquivo, o retorno é um array associativo.
	 */
	public function readFileAux($file) {
		$data = fread($this->fileAuxiliar[$file], filesize($this->fileAuxiliar['Caminho']));
		
		return json_decode($data, true);
	}
	
	
	/**
	 * Escreve no arquivo arquivo que esta aberto em formato json.
	 *
	 * @param string, $data - dados que serão escritos no arquivo.
	 *
	 * @return int, retorna 1 se a operação for executada com sucesso, caso contrario, 0.
	 */
	public function writeFile($data) {
		
		if (file_exists($this->caminho)) {
			
			$this->file = fopen($this->caminho, 'w');
			
			fwrite($this->file, json_encode($data));
			
			return 1;
		} else {
			throw new Exception('Arquivo não encontrado');
			return 0;
		}
	}
	
	
	/**
	 * É gerado um número unico, que sofre autoincremento, para ser utilizado como chave primária.
	 *
	 * @param string, $key - parâmetro utilizado para definir qual é o nome da chave primária, pois o arquivo esta no formato json.
	 *
	 * @return int, retorna o número gerado, sendo ele único.
	 */
	public function gerarSerial($key) {
		
		if (file_exists($this->serial)) {
			
			$this->file = fopen($this->serial, 'r');
			$data = fread($this->file, filesize($this->serial));
			fclose($this->file);
			
			$serial = json_decode($data, true);
			
			$serial = $serial[$key] + 1;
			
			$this->file = fopen($this->serial, 'w');
			fwrite($this->file, json_encode(array($key => $serial)));
			fclose($this->file);
			
			return $serial;
			
		} else {
			throw new Exception ('Arquivo não encontrado');
		}
	}
	
}