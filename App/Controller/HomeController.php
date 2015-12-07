<?php

class HomeController extends Controller {
	
	public function index() {
		
		$model = $this->criarModelo('Home');
		$data = $model->getSumLancamentos();
        
		$despesa = ($data[0]['TIPO'] == 'D') ? $data[0] : $data[1];
		$receita = ($data[0]['TIPO'] == 'R') ? $data[0] : $data[1];
		
		// Informações passadas como parâmetros, para serem renderizadas e exibidas no dashboard.
		$this->view->set('receitas', $receita['SOMA']);
		$this->view->set('despesas', $despesa['SOMA']);
		$this->view->set('total', ($receita['SOMA'] - $despesa['SOMA']));
		$this->view->set('quantidade', ($despesa['QUANTIDADE'] + $receita['QUANTIDADE']));
		$this->view->set('titulo', 'Home');
		$this->view->render('index.phtml');
	}
	
	public function chart() {
		
		$model = $this->criarModelo('Home');
		$data = $model->getChartLancamentos();
		
		$receitas = array(
		    'name' => 'Receitas',    
		    'data' => array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 
		                      6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0)
		);
		
		$despesas = array(
		    'name' => 'Despesas',
		    'data' => array(0 => 0, 1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0, 
		                      6 => 0, 7 => 0, 8 => 0, 9 => 0, 10 => 0, 11 => 0)
		);
		
		// É construido um array de despesas e receitas, no qual cada item, possui os valor somado do mês.
		foreach ($data as $key => $value) {
			
		    // É retirado o mes da data, para ser utilizado como chave no array associativo.
		    $pos = substr($value['DT_LANC'], 5, 2);
		    $pos = ($pos == '10') ? $pos - 1 : (str_replace('0','',$pos)) - 1;
		    
			if ($value['TIPO'] == 'R') {
				$receitas['data'][$pos] = $value['VALOR'];
			} else {
				$despesas['data'][$pos] = $value['VALOR'];
			}
		}
		
		$dados = array();
		
		array_push($dados, $receitas);
		array_push($dados, $despesas);
		
		echo json_encode($dados, JSON_NUMERIC_CHECK);
		exit;
	}
	
	public function logout() {
		
		session_destroy();
		header("Location: http://localhost/TreinamentoSoftbox/");
	}
	
}