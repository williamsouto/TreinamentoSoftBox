<?php

class CategoriaModel implements IModel {
	
	protected $connection;
	
	/**
	 * Construtor responsável por criar um objeto de conexão, 
	 * caso não ocorra como esperado, é lançado um erro PDOException.
	 * 
	 */
	function __construct() {
		try {
			$this->connection = Conexao::criarConexao();
		} catch ( PDOException $ex ) {
			echo $ex->getMessage ();
		}
	}
	
	/**
	 * Retorna todas as tuplas da tabela Categoria.
	 *
	 * @param void
	 *
	 * @return array, retorna um array associativo, contendo nome da coluna e valor.
	 */
	public function getAll() {
	
		$query = "SELECT * FROM TBCategoria";
		$cmd = $this->connection->prepare($query);
		$cmd->execute();
	
		return $cmd->fetchAll (PDO::FETCH_ASSOC);
	}
	
	/**
	 * Retorna a tupla da tabela Categoria que possui a chave primária passada como parâmetro.
	 *
	 * @param int, chave primária da tabela Categoria
	 *
	 * @return array, retorna um array associativo, contendo nome da coluna e valor.
	 */
	public function get($idCateg) {
	
		$query = "SELECT * FROM TBCategoria WHERE ID_CATEG = :idcateg";
		$cmd = $this->connection->prepare($query);
		
		$data = array(':idcateg' => $idCateg);
		$cmd->execute($data);
	
		return $cmd->fetchAll (PDO::FETCH_ASSOC);
	}
	
	/**
	 * Adiciona o registro na tabela Categoria e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function add($dados) {
		$query = "INSERT INTO TBCategoria (NOME) VALUES (:nome)";
		$cmd = $this->connection->prepare($query);
		
		$data = array(":nome" => $dados['nome']);
		
		if ($cmd->execute($data)) {
			return json_encode(array(
					"idCategoria" => $this->connection->lastInsertId(),
					"nome" => $dados['nome']
			));
		}
		
		return 0;
	}
	
	/**
	 * Atualiza o registro da tabela Categoria e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function update($dados) {
		
		$query = "UPDATE TBCategoria SET NOME = :nome WHERE ID_CATEG = :idcateg";
		$cmd = $this->connection->prepare($query);
		
		$data = array(
				":nome" => $dados['nome'],
				":idcateg" => $dados['idCategoria']
		);
		
		if ($cmd->execute($data)) {
			return json_encode(array(
				'idCategoria' => $dados['idCategoria'],
				'nome' => $dados['nome']	
			));
		}
		
		return 0;
	}
	
	
	/**
	 * Deleta o registro da tabela Categoria que possui a chave primária passada como parâmetro.
	 *
	 * @param int, chave primária do registro.
	 *
	 * @return int, se não ocorrer erro retorna 1, caso contrário, retorna 0.
	 */
	public function delete($idCateg) {
		
		$query = "DELETE FROM TBCategoria WHERE ID_CATEG = :idcateg";
		$cmd = $this->connection->prepare($query);
		
		$data = array(':idcateg' => $idCateg);
		
		if ($cmd->execute($data)) {
			return 1;
		}
		
		return 0;
	}	
}