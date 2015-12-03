<?php

class CadastroController extends Controller {
	
	public function index() {
		try {
			
			$model = $this->criarModelo('Categoria');
			$listCategorias = $model->getAll();
			
			// Constrói um grid com informações da base de dados.
			$categoria = '';
			foreach ($listCategorias as $item) {
				$categoria .= "<div class=\"item-categoria\"><button id=" . $item['ID_CATEG'] . " type=\"button\" class=\"list-group-item btnEditarCategoria\">" . $item['NOME'] . "</button></div>";
			}
			
			$this->view->set('titulo', 'Cadastro');
			$this->view->set('categorias', $categoria);
			
			$this->view->render('cadastro.phtml');
		
		} catch (Exception $e) {
			echo 'Não foi possível carregar a página. Verifique com o suporte.';
			exit;
		}
	}
	
	public function editar() {
		try {
			
			$model = $this->criarModelo('Categoria');
			$json = $model->update($_POST);
			
			echo $json;
			exit;
			
		} catch (Exception $e) {
			echo 'Não foi possível carregar a página. Verifique com o suporte.';
			exit;
		}
	}
	
	public function adicionar() {
		try {
			
			$model = $this->criarModelo('Categoria');
			$json = $model->add($_POST);
			
			echo $json;
			exit;
			
		} catch (Exception $e) {
			echo 'Não foi possível carregar a página. Verifique com o suporte.';
			exit;
		}
	}
	
	public function excluir() {
		try {
			
			$model = $this->criarModelo('Categoria');
			$json = $model->delete($_POST['idCategoria']);
			
			echo $json;
			exit;
		
		} catch (Exception $e) {
			echo 'Não foi possível carregar a página. Verifique com o suporte.';
			exit;
		}
	}
	
}