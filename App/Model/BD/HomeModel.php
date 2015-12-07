<?php

class HomeModel {
	
	protected $connection;
	
	/**
	 * Construtor responsável por criar um objeto de conexão,
	 * caso não ocorra como esperado, é lançado um erro PDOException.
	 *
	 */
	function __construct($model) {
		try {
			$this->connection = Conexao::criarConexao();
		} catch ( PDOException $ex ) {
			echo $ex->getMessage ();
		}
	}
	
	/**
	 * Retorna todas as tuplas da tabela Lancamento.
	 *
	 * @param void
	 *
	 * @return array, retorna um array associativo, contendo contendo os registros.
	 */
	public function getSumLancamentos() {
	
		$query = "SELECT TIPO, SUM(VALOR) AS SOMA, COUNT(ID_LANC) AS QUANTIDADE 
					FROM TBLancamento 
					WHERE DT_LANC BETWEEN DATE_SUB(CURRENT_DATE(),INTERVAL (EXTRACT(DAY FROM CURRENT_DATE())-1) DAY) AND LAST_DAY(CURRENT_DATE())
					GROUP BY TIPO";
		
		$cmd = $this->connection->prepare($query);
		$cmd->execute();
	
		return $cmd->fetchAll (PDO::FETCH_ASSOC);
	}
	
	public function getChartLancamentos() {
		
		$query = "SELECT TIPO, DT_LANC, SUM(VALOR) AS VALOR
					FROM TBLancamento 
					GROUP BY TIPO, EXTRACT(YEAR_MONTH FROM DT_LANC)";
		
		$cmd = $this->connection->prepare($query);
		$cmd->execute();
		
		return $cmd->fetchAll (PDO::FETCH_ASSOC);
		
	}
	
}