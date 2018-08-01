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
                strlen($usuario->getPermissao()) >= 1 && strlen($usuario->getPermissao()) <= 2 &&
                $this->VerificaEmailExiste($usuario->getEmail()) == 1) {
            return $this->usuarioDAO->Cadastrar($usuario);
        } else {
            return false;
        }
    }

    function Alterar(Usuario $usuario) {
        if (
                strlen($usuario->getNome()) >= 4 && strlen($usuario->getNome()) <= 100 &&
                strlen($usuario->getStatus()) >= 1 && strlen($usuario->getStatus()) <= 2 &&
                strlen($usuario->getPermissao()) >= 1 && strlen($usuario->getPermissao()) <= 2) {
            return $this->usuarioDAO->Alterar($usuario);
        } else {
            return false;
        }
    }

    public function RetornarUsuariosBusca(int $permissao, int $status, string $nome) {
        if ($permissao > 0 && $status > 0 && strlen($nome) >= 3) {
            return $this->usuarioDAO->RetornarUsuariosBusca($permissao, $status, $nome);
        } else {
            return null;
        }
    }

    public function RetornaEdicaoCod(int $cod) {
        if ($cod > 0) {
            return $this->usuarioDAO->RetornaEdicaoCod($cod);
        } else {
            return null;
        }
    }

    public function VerificaEmailExiste(string $email) {
        if (strlen($email) >= 5) {
            return $this->usuarioDAO->VerificaEmailExiste($email);
        } else {
            return -10;
        }
    }

}
