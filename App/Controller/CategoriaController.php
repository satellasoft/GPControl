<?php

namespace App\Controller;

use App\DAL\CategoriaDAO;
use App\Model\Categoria;

class CategoriaController {

    private $categoriaDAO;

    public function __construct() {
        $this->categoriaDAO = new CategoriaDAO();
    }

    public function Cadastrar(Categoria $categoria) {
        if ($categoria->getStatus() >= 1 || $categoria->getStatus() <= 2 &&
                strlen($categoria->getNome()) >= 3 &&
                $categoria->getProjeto()->getCod() > 0) {
            return $this->categoriaDAO->Cadastrar($categoria);
        } else {
            return false;
        }
    }

    public function Alterar(Categoria $categoria) {
        if ($categoria->getStatus() >= 1 || $categoria->getStatus() <= 2 &&
                strlen($categoria->getNome()) >= 3 &&
                $categoria->getCod() > 0) {
            return $this->categoriaDAO->Alterar($categoria);
        } else {
            return false;
        }
    }

    public function RetornarTodosProjetoCod(int $projetoCod) {
        if ($projetoCod > 0) {
            return $this->categoriaDAO->RetornarTodosProjetoCod($projetoCod);
        } else {
            return null;
        }
    }

    public function RetornaCategoriaCod(int $categoriaCod) {
        if ($categoriaCod > 0) {
            return $this->categoriaDAO->RetornaCategoriaCod($categoriaCod);
        } else {
            return null;
        }
    }

}
