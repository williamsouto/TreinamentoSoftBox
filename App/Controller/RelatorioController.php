<?php

class RelatorioController extends Controller {
	
	public function index() {
		
		$this->view->set('titulo', 'Relat&oacute;rio de Lan&ccedil;amentos');
		$this->view->render('relatorio.phtml');
		
	}
	
	public function relatorio() {
		
		$modelLancamento = $this->criarModelo('Lancamento');
		$listLancamentos = $modelLancamento->getReport($_POST['tipo']);
		
		$result = array();
		
		// Agrupa os dados por categoria.
		foreach ($listLancamentos as $key => $value) {
			$value['DT_LANC'] = date('d/m/Y' ,strtotime($value['DT_LANC']));
			$result[$value['ID_CATEG']][] = $value;
		}
		
		echo json_encode($result);
		exit;
	}
}