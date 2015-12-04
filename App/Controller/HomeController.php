<?php

class HomeController extends Controller {
	
	public function index() {
		
		$model = $this->criarModelo('Home');
		$data = $model->getSumLancamentos();
		
		// Informações passadas como parâmetros, para serem renderizadas e exibidas no dashboard.
		$this->view->set('receitas', $data[1]['SOMA']);
		$this->view->set('despesas', $data[0]['SOMA']);
		$this->view->set('total', ($data[1]['SOMA'] - $data[0]['SOMA']));
		$this->view->set('quantidade', ($data[0]['QUANTIDADE'] + $data[1]['QUANTIDADE']));
		$this->view->set('titulo', 'Home');
		$this->view->render('index.phtml');
	}
	
	public function chart() {
		
		$model = $this->criarModelo('Home');
		$data = $model->getChartLancamentos();
		
		$receitas = array('name' => 'Receitas');
		$despesas = array('name' => 'Despesas');
		
		// É construido um array de despesas e receitas, no qual cada item, possui os valor somado do mês.
		foreach ($data as $key => $value) {
			
			if ($value['TIPO'] == 'R') {
				$receitas['data'][] = $value['VALOR'];
			} else {
				$despesas['data'][] = $value['VALOR'];
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