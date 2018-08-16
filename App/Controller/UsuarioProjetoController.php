<?php

namespace App\Controller;

use App\DAL\UsuarioProjetoDAO;
use App\Model\usuarioProjeto;

class UsuarioProjetoController {

    private $usuarioProjetoDAO;

    public function __construct() {
        $this->usuarioProjetoDAO = new UsuarioProjetoDAO();
    }

    public function Cadastrar(int $usuarioCod, int $projetoCod) {
        if ($usuarioCod > 0 && $projetoCod > 0) {
            return $this->usuarioProjetoDAO->Cadastrar($usuarioCod, $projetoCod);
        } else {
            return false;
        }
    }

    public function RetornarPermissoesProjetoCod(int $projetoCod) {
        if ($projetoCod > 0) {
            return $this->usuarioProjetoDAO->RetornarPermissoesProjetoCod($projetoCod);
        } else {
            return null;
        }
    }

}
