<?php

class HomeModel extends ModelArquivo {


	function __construct($model) {
		parent::__construct($model);
	}

	/**
	 * Retorna todas as tuplas da tabela Lancamento.
	 *
	 * @param void
	 *
	 * @return array, retorna um array associativo, contendo contendo os registros.
	 */
	public function getSumLancamentos() {

		$this->openFile();
		$data = $this->readFile();
		$this->closeFile();
		
		$lancamentos = array('receitas' => 0, 'despesas' => 0);
		$count = array('receitas' => 0, 'despesas' => 0);
		
		// Após ler o arquivo, é necessário agrupar os dados, etapa irá simular um group by do banco de dados.
		foreach ($data as $key => $value) {
			
			// Filtro que valida se a data do registro corrente esta entre o primeiro e o último dia do mês corrente.
			
			// Se atende aos filtros, é somado os valores por tipo.
			if ($value['DT_LANC'] >= date('Y-m-1 00:00:00') AND $value['DT_LANC'] <= date("Y-m-t 23:59:59") ) {
				if ($value['TIPO'] == 'R') {
					$lancamentos['receitas'] += $value['VALOR'];
					$count['receitas']++;
				} else {
					$lancamentos['despesas'] += $value['VALOR'];
					$count['despesas']++;
				}	
			}
		}
		
		$dados = array();
		
		array_push($dados, array('SOMA' => $lancamentos['despesas'], 'QUANTIDADE' => $count['despesas']));
		array_push($dados, array('SOMA' => $lancamentos['receitas'], 'QUANTIDADE' => $count['receitas']));
		
		return $dados;

	}

	public function getChartLancamentos() {

		$this->openFile();
		$data = $this->readFile();
		$this->closeFile();
		
		$despesas = array();
		$receitas = array();
		$lancamentos = array();
		
		// Após ler todo o arquivo, será construído um array, que agrupará os dados por mês e tipo, simulando um group by do banco de dados.
		// Esta primeira etapa, separa os dados em duas estruturas separadas por tipo, tendo como chave a data, e agrupar os valores caso a data seja a mesma.
		foreach ($data as $key => $value) {
			
			if ($value['TIPO'] == 'D') {
				$despesas[$value['DT_LANC']]['VALOR'][] = $value['VALOR'];
			} else {
				$receitas[$value['DT_LANC']]['VALOR'][] = $value['VALOR'];
			}
		}
		
		// Para cada data é somado os valores.
		foreach ($despesas as $key => $value){
			
			$despesas[$key]['VALOR'] = array_sum($value['VALOR']);
			$despesas[$key]['DT_LANC'] = $key;
			$despesas[$key]['TIPO'] = 'D';
			
		}
		
		// Para cada data é somado os valores.
		foreach ($receitas as $key => $value){
				
			$receitas[$key]['VALOR'] = array_sum($value['VALOR']);
			$receitas[$key]['DT_LANC'] = $key;
			$receitas[$key]['TIPO'] = 'R';
				
		}
		
		// Ordena os dados por data.
		ksort($despesas);
		ksort($receitas);
		
		// Junta os arrays ordenados para retorná-los.
		foreach ($receitas as $item) {
			array_push($despesas, $item);
		}
		
		return $despesas;
	}

}