<?php

namespace App\Controller;

use App\DAL\ProjetoDAO;
use App\Model\Projeto;

class ProjetoController {

    private $projetoDAO;

    public function __construct() {
        $this->projetoDAO = new ProjetoDAO();
    }

    public function Cadastrar(Projeto $projeto) {
        if (strlen($projeto->getNome()) >= 4 &&
                strlen($projeto->getNome()) >= 6) {
            return $this->projetoDAO->Cadastrar($projeto);
        } else {
            return false;
        }
    }

    public function RetornarTodosStatus(int $status) {
        if ($status >= 1 && $status <= 3) {
            return $this->projetoDAO->RetornarTodosStatus($status);
        } else {
            return null;
        }
    }

}

?>