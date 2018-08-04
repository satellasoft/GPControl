<?php

namespace App\Model;

use App\Model\Usuario;

class Projeto {

    private $cod;
    private $nome;
    private $descricao;
    private $thumb;
    private $data;
    private $status;
    private $usuario;

    function __construct() {
        $this->usuario = new Usuario();
    }

    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getThumb() {
        return $this->thumb;
    }

    function getData() {
        return $this->data;
    }

    function getStatus() {
        return $this->status;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setThumb($thumb) {
        $this->thumb = $thumb;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

}
