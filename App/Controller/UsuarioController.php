<?php

namespace App\Controller;

use App\DAL\UsuarioDAO;
use App\Model\Usuario;

class UsuarioController {

    private $usuarioDAO;

    public function __construct() {
        $this->usuarioDAO = new UsuarioDAO();
    }

    function Cadastrar(Usuario $usuario) {
        if (
                strlen($usuario->getNome()) >= 4 && strlen($usuario->getNome()) <= 100 &&
                strlen($usuario->getEmail()) >= 1 && strlen($usuario->getEmail()) <= 100 &&
                strlen($usuario->getSenha()) >= 7 && strlen($usuario->getSenha()) <= 25 &&
                strlen($usuario->getStatus()) >= 1 && strlen($usuario->getStatus()) <= 2 &&
                strlen($usuario->getPermissao()) >= 1 && strlen($usuario->getPermissao()) <= 2) {
            return $this->usuarioDAO->Cadastrar($usuario);
        } else {
            return false;
        }
    }

}
