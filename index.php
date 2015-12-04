<?php

require_once './Library/Core/Router.php';
require_once './Library/Core/Master/View.php';
require_once './Library/Utilities/Request.php';
require_once "./Library/Core/Master/Controller.php";
require_once "./Library/Core/Master/IModel.php";
require_once './Library/Core/Master/ModelArquivo.php';
require_once "./Config/Conexao.php";
require_once "./Library/Utilities/Inflector.php";
require_once './Config/Base.php';
require_once './Library/Utilities/Sessao.php';

// Flag para mudar a persistencia dos dados.
Base::persistencia('ARQUIVO');
date_default_timezone_set('America/Sao_Paulo');

$session = new Sessao();

if ($session->startSession()) {
	
	$router = new Router();
	$router->load();
}