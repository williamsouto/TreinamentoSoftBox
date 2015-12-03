<?php

class LancamentoModel implements IModel {
	
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
	 * Retorna todas as tuplas da tabela Lançamento.
	 *
	 * @param void
	 *
	 * @return array, retorna um array associativo, contendo nome da coluna e valor.
	 */
	public function getAll() {
	
		$query = "SELECT * 
					FROM TBLancamento l INNER JOIN TBCategoria c ON l.ID_CATEG = c.ID_CATEG 
					ORDER BY DT_LANC";
		
		$cmd = $this->connection->prepare($query);
		$cmd->execute();
	
		return $cmd->fetchAll (PDO::FETCH_ASSOC);
	}
	
	
	/**
	 * Retorna a tupla da tabela Lançamento que é igual a chave primária passada.
	 *
	 * @param int, id do registro(chave primária).
	 *
	 * @return array, retorna um array associativo.
	 */
	public function get($id) {
		
		$query = "SELECT * 
					FROM TBLancamento l INNER JOIN TBCategoria c ON c.ID_CATEG = l.ID_CATEG 
					WHERE ID_LANC = :idlanc
					ORDER BY DT_LANC";
		
		$cmd = $this->connection->prepare($query);
		$cmd->bindParam(":idlanc", $id, PDO::PARAM_INT);
		$cmd->execute();
		$data = $cmd->fetch();
		
		return json_encode(array(

				'idLanc' => $id,
				'descricao' => $data['DESCRICAO'],
				'valor' => $data['VALOR'],
				'dtLanc' => date('d-m-Y', strtotime($data['DT_LANC'])),
				'idCategoria' => $data['ID_CATEG'],
				'tipo' => $data['TIPO']
		));
	}

	
	/**
	 * Adiciona o registro na tabela Lançamento e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function add($dados) {
		
		$query = "INSERT INTO TBLancamento ( DESCRICAO, VALOR, DT_LANC, ID_CATEG, TIPO) 
					VALUES ( :descricao, :valor, :dtlanc, :idcategoria, :tipo)";
		
		$cmd = $this->connection->prepare($query);
		
		$data = array(
				':descricao' => $dados['descricao'],
				':valor' => str_replace(',', '.', $dados['valor']),
				':dtlanc' => date('Y-m-d', strtotime(str_replace('/', '-', $dados['dtLanc']))),
				':idcategoria' => $dados['idCategoria'],
				':tipo' => $dados['tipo']
		);
		
		if ($cmd->execute($data)) {
			return json_encode(array(
					'nomeCategoria' => $dados['nomeCategoria'],
					'nomeTipo' => $dados['nomeTipo'],
					'idLanc' => $this->connection->lastInsertId(),
					'descricao' => $dados['descricao'],
					'valor' => str_replace(',', '.', $dados['valor']),
					'dtLanc' => date('d-m-Y', strtotime(str_replace('/', '-', $dados['dtLanc']))),
					'idCategoria' => $dados['idCategoria'],
					'tipo' => $dados['tipo']
			));
		}
		
		return 0;
	}
	
	
	/**
	 * Atualiza o registro na tabela Lançamento e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function update($dados) {
		
		$query = "UPDATE TBLancamento SET DESCRICAO = :descricao, VALOR = :valor, DT_LANC = :dtlanc, ID_CATEG = :idcategoria, TIPO = :tipo WHERE ID_LANC = :idlanc";
		$cmd = $this->connection->prepare($query);
		
		$data = array(
				':descricao' => $dados['descricao'],
				':valor' => str_replace(',', '.', $dados['valor']),
				':dtlanc' => date('Y-m-d', strtotime(str_replace('/', '-', $dados['dtLanc']))),
				':idcategoria' => $dados['idCategoria'],
				':tipo' => $dados['tipo'],
				':idlanc' => $dados['idLanc']
		);
		
		if ($cmd->execute($data)) {
			return json_encode(array(
					'nomeCategoria' => $dados['nomeCategoria'],
					'nomeTipo' => $dados['nomeTipo'],
					'idLanc' => $dados['idLanc'],
					'descricao' => $dados['descricao'],
					'valor' => str_replace(',', '.', $dados['valor']),
					'dtLanc' => date('d-m-Y', strtotime(str_replace('/', '-', $dados['dtLanc']))),
					'idCategoria' => $dados['idCategoria'],
					'tipo' => $dados['tipo']
			));
		}
		
		return 0;
	}
	
	
	/**
	 * Remove o registro na tabela Lançamento.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function delete($id) {
		
		$query = "DELETE 
					FROM TBLancamento 
					WHERE ID_LANC = :idlanc";
		$cmd = $this->connection->prepare($query);
		
		$data = array(':idlanc' => $id);
		
		if ($cmd->execute($data)) {
			return json_encode(array(
					':idLanc' => $id
			));
		}
		
		return 0;
	}
	
	
	/**
	 * Retorna os registros da tabela Lançamento.
	 *
	 * @param string, filtro para a consulta do banco.
	 *
	 * @return array, registros que atendem ao filtro passado como parâmetro.
	 */
	public function getReport($tipo) {
		
		$clausula = $tipo == 'T' ? "" : " WHERE l.TIPO = :tipo";
		
		$query = "SELECT * 
					FROM TBLancamento l INNER JOIN TBCategoria c ON l.ID_CATEG = c.ID_CATEG" . $clausula;
					
		$cmd = $this->connection->prepare($query);
		
		$data = array(':tipo' => $tipo);
		$cmd->execute($data);
		return $cmd->fetchAll(PDO::FETCH_ASSOC);
	}
}