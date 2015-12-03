<?php

class LancamentoController extends Controller {
	
	public function index() {
		try {
			
			$modelCategoria = $this->criarModelo('Categoria');
			$listCategorias = $modelCategoria->getAll();
			
			$modelLancamento = $this->criarModelo('Lancamento');
			$listLancamentos = $modelLancamento->getAll();
			
			$lancamentos = '';
			$categoria = "<option value=''>Selecione...</option>";
			foreach ($listCategorias as $item) {
				$categoria .= "<option value=". $item['ID_CATEG'] .">" . $item['NOME'] . "</option>";
			}
			
			// Constr�i um gridview de acordo com os dados da base.
			foreach ($listLancamentos as $item) {
					
				$lancamentos .= "<tr id=\"" . $item['ID_LANC'] . "\">" .
						"<td>" . $item['NOME'] . "</td>" .
						"<td>" . ($item['TIPO'] == "D" ? "Despesa" : "Receita") . "</td>" .
						"<td>" . $item['VALOR'] . "</td>" .
						"<td>" . date('d-m-Y', strtotime($item['DT_LANC'])) . "</td>" .
						"<td>" . $item['DESCRICAO'] . "</td>" .
						"<td>&nbsp;&nbsp;" .
						"<a href=\"#\" class=\"btnEditar\" id=\"" . $item['ID_LANC'] . "\">" .
						"<i class=\"fa fa-pencil-square-o btn-success btn-circle\"></i>" .
						"</a>&nbsp;&nbsp;&nbsp;" .
						"<a href=\"#\" data-target=\"#mdlExcluirReg\" class=\"btnExcluir\" id=\"" . $item['ID_LANC'] . "\">" .
						"<i class=\"fa fa-times btn-danger btn-circle\"></i>" .
						"</a>" .
						"</td>" .
						"</tr>";
			}
			
			// Passados os dados criados como par�metro, para renderiza��o.
			$this->view->set('titulo', 'Lan&ccedil;amentos');
			$this->view->set('categorias', $categoria);
			$this->view->set('lancamentos', $lancamentos);
			
			$this->view->render('lancamento.phtml');
			
		} catch (Exception $e) {
			echo 'N�o foi poss�vel carregar a p�gina. Verifique com o suporte.';
			exit;
		}
	}
	
	public function adicionar() {
		try {
			
			$dataTela = date('Y-m-d', strtotime(str_replace('/', '-', $_POST['dtLanc'])));
			 
			$modelLancamento = $this->criarModelo('Lancamento');
			$listLancamentos = $modelLancamento->getAll();
			
			// � verificado se existe alguma descri��o igual na mesma data do novo registro.
			foreach ($listLancamentos as $lancamento) {

				$dataBanco = date('Y-m-d', strtotime(str_replace('/', '-', $lancamento['DT_LANC'])));
				
				// Se j� possui uma descri��o igual na mesma data do novo registro, � lan�ado uma exce��o.
				if($dataTela == $dataBanco && $_POST['descricao'] == $lancamento['DESCRICAO'] ) {
					throw new Exception('');
				}
			}
			
			$json = $modelLancamento->add($_POST);
			
			echo $json;
			exit;
			
		} catch (Exception $e) {
			echo json_encode(array());
			exit;
		}
	}
	
	public function editar() {
		try {
			
			$modelLancamento = $this->criarModelo('Lancamento');
			$json = $modelLancamento->get($_POST['idLanc']);
			
			echo $json;
			exit;
			
		} catch (Exception $e) {
			echo 'N�o foi poss�vel carregar a p�gina. Verifique com o suporte.';
			exit;
		}
	}
	
	public function atualizar() {
		try {
			
			$modelLancamento = $this->criarModelo('Lancamento');
			$json = $modelLancamento->update($_POST);
			
			echo $json;
			exit;
			
		} catch (Exception $e) {
			echo 'N�o foi poss�vel carregar a p�gina. Verifique com o suporte.';
			exit;
		}
	}
	
	public function excluir() {
		try {
			
			$modelLancamento = $this->criarModelo('Lancamento');
			$json = $modelLancamento->delete($_POST['idLanc']);
			
			echo $json;
			exit;
		
		} catch (Exception $e) {
			echo 'N�o foi poss�vel carregar a p�gina. Verifique com o suporte.';
			exit;
		}
	}
	
}