<?php

/**
 * Arquivo que manipula as sessões de usuário.
 * *
 * @category Library
 * @package  Utilities
 * @author   William Souto Faria
 *
 */
class Sessao {
    public $titulo;
    public $conteudo;
    protected $request;

    function __construct() {
        $this->request = new Request();
    }

    public function startSession() {
        session_start();
        $url = $this->request->request();
        
        
        if (! isset($_SESSION['usuario'])) {
            
            if (isset($_POST['usuario'])) {
                echo 'dfasd';
                $_SESSION['usuario'] = $_POST['usuario'];
                header("Location: http://localhost/TreinamentoSoftbox/");
                
            } else if ($url['parametros'][0] == 'cadastro') {
                
                ob_start();
                include './App/View/cadastroUsuario.phtml';
                $this->titulo = 'Cadastro de Usu&aacute;rio';
                $this->conteudo = ob_get_contents();
                ob_end_clean();
                
                require './App/Template/baseLogin.phtml';
                exit();
                
            } else {
                
                require_once './App/View/login.phtml';
                $this->titulo = 'Login';
                $this->conteudo = ob_get_contents();
                ob_end_clean();
                
                require_once './App/Template/baseLogin.phtml';
                exit();
            }
            
        } else {
            return 1;
        }
    }

    public function setSession($key, $value) {
        $_SESSION[$key] = $value;
    }
}