<?php

namespace App\Controller;

use App\DAL\ModuloDAO;
use App\Model\Modulo;
use App\Model\ViewModel\ModuloView\ModuloView;

class ModuloController {

    private $moduloDAO;

    public function __construct() {
        $this->moduloDAO = new ModuloDAO();
    }

    public function Cadastrar(ModuloView $modulo) {

        if (strlen($modulo->getTitulo()) >= 5 && strlen($modulo->getTitulo()) <= 200 &&
                $modulo->getCategoriaCod() > 0 && $modulo->getProjetoCod() > 0 && $modulo->getUsuarioCod() > 0 &&
                $modulo->getStatus() >= 1 && $modulo->getStatus() <= 2 &&
                strlen($modulo->getDescricao()) >= 5) {
            return $this->moduloDAO->Cadastrar($modulo);
        } else {
            return false;
        }
    }

}

?>   