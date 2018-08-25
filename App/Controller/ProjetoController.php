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
                strlen($projeto->getDescricao()) >= 6) {
            return $this->projetoDAO->Cadastrar($projeto);
        } else {
            return false;
        }
    }

    public function Alterar(Projeto $projeto) {
        if (strlen($projeto->getNome()) >= 4 &&
                strlen($projeto->getDescricao()) >= 6 &&
                $projeto->getCod() > 0) {
            return $this->projetoDAO->Alterar($projeto);
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

    public function RetornarCod(int $cod) {
        if ($cod > 0) {
            return $this->projetoDAO->RetornarCod($cod);
        } else {
            return null;
        }
    }

    public function RetornarCompletoCod(int $cod) {
        if ($cod > 0) {
            return $this->projetoDAO->RetornarCompletoCod($cod);
        } else {
            return null;
        }
    }

    public function AlterarImagem(string $thumb, int $cod) {
        if (strlen($thumb) > 0 && $cod > 0) {
            return $this->projetoDAO->AlterarImagem($thumb, $cod);
        } else {
            return false;
        }
    }

    public function RetornaProjetosUsuario(int $usuarioCod) {
        if ($usuarioCod > 0) {
            return $this->projetoDAO->RetornaProjetosUsuario($usuarioCod);
        } else {
            return null;
        }
    }

}

?>