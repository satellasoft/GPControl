<?php

namespace App\Controller;

use App\DAL\ModuloDAO;
use App\Model\Modulo;
use App\Model\ViewModel\ModuloView\ModuloView;
use App\Model\ViewModel\ModuloView\ModuloConsultaView;

class ModuloController {

    private $moduloDAO;

    public function __construct() {
        $this->moduloDAO = new ModuloDAO();
    }

    public function Cadastrar(ModuloView $modulo) {

        if (strlen($modulo->getTitulo()) >= 5 && strlen($modulo->getTitulo()) <= 200 &&
                $modulo->getCategoriaCod() > 0 && $modulo->getProjetoCod() > 0 &&
                $modulo->getUsuarioCod() > 0 &&
                $modulo->getStatus() >= 1 && $modulo->getStatus() <= 2 &&
                strlen($modulo->getDescricao()) >= 5) {
            return $this->moduloDAO->Cadastrar($modulo);
        } else {
            return false;
        }
    }

    public function Alterar(ModuloView $modulo) {
        if (strlen($modulo->getTitulo()) >= 5 && strlen($modulo->getTitulo()) <= 200 &&
                $modulo->getCategoriaCod() > 0 && $modulo->getProjetoCod() > 0 &&
                $modulo->getStatus() >= 1 && $modulo->getStatus() <= 2 &&
                strlen($modulo->getDescricao()) >= 5 &&
                $modulo->getCod() > 0) {
            return $this->moduloDAO->Alterar($modulo);
        } else {
            return false;
        }
    }

    public function BuscarModulo(string $titulo = "%%%", int $status, int $categoriaCod, int $quantidade = 10) {
        if ($status >= 1 && $status <= 2 &&
                $categoriaCod > 0 &&
                $quantidade >= 10 && $quantidade <= 200) {
            return $this->moduloDAO->BuscarModulo($titulo, $status, $categoriaCod, $quantidade);
        } else {
            return null;
        }
    }

    function RetornaCod(int $usuarioCod, int $cod) {
        if ($usuarioCod > 0 && $cod > 0) {
            return $this->moduloDAO->RetornaCod($usuarioCod, $cod);
        } else {
            return null;
        }
    }

    public function RetornarCompletoCod(int $cod) {
        if ($cod > 0) {
            return $this->moduloDAO->RetornarCompletoCod($cod);
        } else {
            return null;
        }
    }

    public function MarcarComoResolvido(int $moduloCod, int $usuarioCod) {
        if ($moduloCod > 0 && $usuarioCod > 0) {
            return $this->moduloDAO->MarcarComoResolvido($moduloCod, $usuarioCod);
        } else {
            return false;
        }
    }

    public function RetornaModulosAberto(int $usuarioCod) {
        if ($usuarioCod > 0) {
            return $this->moduloDAO->RetornaModulosAberto($usuarioCod);
        } else {
            return null;
        }
    }

}

?>   