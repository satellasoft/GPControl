<?php

namespace App\Model;
use App\Model\Projeto;

class Categoria {

    private $cod;
    private $nome;
    private $status;
    private $projeto;

    public function __construct() {
        $this->projeto = new Projeto();
    }

    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getStatus() {
        return $this->status;
    }

    function getProjeto() {
        return $this->projeto;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setProjeto($projeto) {
        $this->projeto = $projeto;
    }

}
