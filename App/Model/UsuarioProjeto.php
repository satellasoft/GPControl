<?php

namespace App\Model;
use App\Model\Usuario;
use App\Model\Projeto;
class usuarioProjeto {

    private $projeto;
    private $usuario;
    
    public function __construct() {
        $this->projeto = new Projeto();
        $this->usuario = new Usuario();
    }

    function getProjeto() {
        return $this->projeto;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setProjeto($projeto) {
        $this->projeto = $projeto;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

}
