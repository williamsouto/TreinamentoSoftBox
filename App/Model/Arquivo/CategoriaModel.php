<?php

class CategoriaModel extends ModelArquivo implements IModel {
	
	
	function __construct($model) {
		parent::__construct($model);
	}
	
	
	/**
	 * Retorna todas os registros do arquivo categoria.
	 *
	 * @param void
	 *
	 * @return array, retorna um array associativo, contendo nome da coluna e valor.
	 */
	public function getAll() {
	
		$this->openFile();
		
		$data = $this->readFile();
		
		$this->closeFile();
		
		return $data;
	}
	
	/**
	 * Retorna o registro do arquivo categoria, que possui a chave primária passada como parâmetro.
	 *
	 * @param int, chave primária da tabela Categoria
	 *
	 * @return array, retorna um array associativo, contendo nome da coluna e valor.
	 */
	public function get($idCateg) {
	
		$this->openFile();
		
		$data = $this->readFile();
		
		$this->closeFile();
		
		$dado = '';
		foreach ($data as $key => $value) {
			if ($key['ID_CATEG'] == $idCateg) {
				$dado = $data[$key];
			}
		}
		
		return $dado;
	}
	
	/**
	 * Adiciona o registro no arquivo Categoria e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function add($dados) {
		
		$this->openFile();
		
		$data = $this->readFile();
		$this->closeFile();
		
		$dados = array(
				"ID_CATEG" => $this->gerarSerial('ID_CATEG'),
				"NOME" => $dados['nome']
		);
		
		array_push($data, $dados);
		
		if ($this->writeFile($data)) {
			return json_encode(array(
					'idCategoria' => $dados['ID_CATEG'],
					'nome' => $dados['NOME']
			));
		}
	
		return 0;
	}
	
	/**
	 * Atualiza o registro no arquivo Categoria e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function update($dados) {
	
		$this->openFile();
		
		$data = $this->readFile();
		$this->closeFile();
		
		foreach ($data as $key => $value) {
			
			if ($value['ID_CATEG'] == $dados['idCategoria']) {
				$data[$key]['NOME'] = $dados['nome'];
			}
		}
		
		if ($this->writeFile($data)) {
			return json_encode(array(
					'idCategoria' => $dados['idCategoria'],
					'nome' => $dados['nome']
			));
		}
	
		return 0;
	}
	
	/**
	 * Deleta o registro do arquivo Categoria que possui a chave primária passada como parâmetro.
	 *
	 * @param int, chave primária do registro.
	 *
	 * @return int, se não ocorrer erro retorna 1, caso contrário, retorna 0.
	 */
	public function delete($idCateg) {
	
		$this->openFile();
		
		$data = $this->readFile();
		$this->closeFile();
		
		$novosDados = array();
		
		foreach ($data as $key => $value) {
			
			if ($value['ID_CATEG'] != $idCateg) {
				array_push($novosDados, $data[$key]);
			}
		}
		
		if ($this->writeFile($novosDados)) {
			return 1;
		}
	
		return 0;
	}
}