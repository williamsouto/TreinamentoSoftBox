<?php

class LancamentoModel extends ModelArquivo implements IModel {
	
	
	function __construct($model) {
		parent::__construct($model);
	}
	
	
	/**
	 * Retorna todas os registros do arquivo Lancamento.
	 *
	 * @param void
	 *
	 * @return array, retorna um array associativo, contendo nome da coluna e valor.
	 */
	public function getAll() {
	
		$this->openFile();
		
		$lancamentos = $this->readFile();
		
		$this->closeFile();
		
		// Abre o arquivo json Categoria e faz a leitura de todo conte�do, criando um array associativo
		$this->openFileAux('./App/DAO/tbcategoria.json', 'Categorias');
		$categorias = $this->readFileAux('Categorias');
		$this->closeFileAux('Categorias');
		
		// � verificado qual item do array $categorias possui a chave prim�ria igual a FK do array $dado, para fazer uma "jun��o"
		foreach ($lancamentos as $key => $value) {
			
			foreach ($categorias as $k => $v) {
				
				if ($value['ID_CATEG'] == $v['ID_CATEG']) {
					$lancamentos[$key]['NOME'] = $v['NOME'];
				}	
			}
		}
		
		return $lancamentos;
	}
	
	/**
	 * Retorna o registro do arquivo Lancamento que � igual a chave prim�ria passada.
	 *
	 * @param int, id do registro(chave prim�ria).
	 *
	 * @return array, retorna um array associativo.
	 */
	public function get($id) {
	
		// Abre o arquivo json Lancamento e faz a leitura de todo conte�do, criando um array associativo
		$this->openFile();
		$lancamentos = $this->readFile();
		$this->closeFile();
		
		// Abre o arquivo json Categoria e faz a leitura de todo conte�do, criando um array associativo
		$this->openFileAux('./App/DAO/tbcategoria.json', 'Categorias');
		$categorias = $this->readFileAux('Categorias');
		$this->closeFileAux('Categorias');
		
		
		$data = '';
		
		// Verifica qual registro dentro do array $lancamentos possui a chave prim�ria passada como par�metro na fun��o, para ser retornado.
		foreach ($lancamentos as $key => $value) {
			if ($value['ID_LANC'] == $id) {
				$data = $lancamentos[$key];
			}
		}
		
		 // � verificado qual item do array $categorias possui a chave prim�ria igual a FK do array $dado, para fazer uma "jun��o"
		foreach ($categorias as $key => $value) {
			if ($value['ID_CATEG'] == $data['ID_CATEG']) {
				$data['NOME'] = $value['NOME'];
			}
		}
			
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
	 * Adiciona o registro no arquivo Lan�amento e retorna um array associativo.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function add($dados) {
	
		$this->openFile();
		
		$data = $this->readFile();
		$this->closeFile();
		
		$lancamento = array(
				"ID_LANC" => $this->gerarSerial('ID_LANC'),
				"DESCRICAO" => $dados['descricao'],
				"VALOR" => str_replace(',', '.', $dados['valor']),
				"DT_LANC" => date('d-m-Y', strtotime(str_replace('/', '-', $dados['dtLanc']))),
				'ID_CATEG' => $dados['idCategoria'],
				'TIPO' => $dados['tipo']
		);
		
		// Ap�s criar um array no formato padr�o do arquivo, � inserido no final do array $data, onde o mesmo cont�m todos os registros que estava no arquivo.
		array_push($data, $lancamento);
		
		if ($this->writeFile($data)) {
			return json_encode(array(
					'nomeCategoria' => $dados['nomeCategoria'],
					'nomeTipo' => $dados['nomeTipo'],
					'idLanc' => $lancamento['ID_LANC'],
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
	 * Atualiza o registro no arquivo Lan�amento e retorna um array associativo.
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
				
			// Verifica qual registro que estava no arquivo, atende ao filtro, para atualizar os dados.
			if ($value['ID_LANC'] == $dados['idLanc']) {
				$data[$key]['DESCRICAO'] = $dados['descricao'];
				$data[$key]['VALOR'] = str_replace(',', '.', $dados['valor']);
				$data[$key]['DT_LANC'] = date('d-m-Y', strtotime(str_replace('/', '-', $dados['dtLanc'])));
				$data[$key]['ID_CATEG'] = $dados['idCategoria'];
				$data[$key]['TIPO'] = $dados['tipo'];
			}
		}
		
		if ($this->writeFile($data)) {
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
	 * Remove o registro no arquivo Lan�amento.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function delete($id) {
	
		$this->openFile();
		
		$data = $this->readFile();
		$this->closeFile();
		
		$novosDados = array();
		
		foreach ($data as $key => $value) {
				
			if ($value['ID_LANC'] != $id) {
				array_push($novosDados, $data[$key]);
			}
		}
		
		if ($this->writeFile($novosDados)) {
			return 1;
		}
		
		return 0;
	}
	
	/**
	 * Retorna todos os registros que est�o no arquivo Lan�amento que atende ao filtro, passado como par�metro.
	 *
	 * @param array, dados de categoria.
	 *
	 * @return array, retorna um array associativo.
	 */
	public function getReport($tipo) {
	
		$this->openFile();
		
		$lancamentos = $this->readFile();
		
		$this->closeFile();
		
		// Abre o arquivo json Categoria e faz a leitura de todo conte�do, criando um array associativo
		$this->openFileAux('./App/DAO/tbcategoria.json', 'Categorias');
		$categorias = $this->readFileAux('Categorias');
		$this->closeFileAux('Categorias');
		
		// � verificado qual item do array $categorias possui a chave prim�ria igual a FK do array $lancamentos, para simular uma jun��o do banco de dados.
		foreach ($lancamentos as $key => $value) {
		
			foreach ($categorias as $k => $v) {
		
				if ($value['ID_CATEG'] == $v['ID_CATEG']) {
					$lancamentos[$key]['NOME'] = $v['NOME'];
				}
			}
		}
		
		// Se o par�metro passado para o m�todo, for todos os registros, � retornado o array sem filtrar.
		if ($tipo == 'T') {
			return $lancamentos;
		} else {
			
			$newLancamentos = array();
			// Filtra os registros por tipo
			foreach ($lancamentos as $key => $value) {
				if ($value['TIPO'] == $tipo) {
					array_push($newLancamentos, $lancamentos[$key]);
				}
			}
			
			return $newLancamentos;
		}
	}
}