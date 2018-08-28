<?php
namespace App\Model;

use App\Model\Categoria;
use App\Model\Projeto;
use App\Model\Usuario;

class Modulo {

    private $cod;
    private $titulo;
    private $descricao;
    private $status;
    private $data;
    private $usuario;
    private $categoria;
    private $projeto;

    function __construct() {
        $this->projeto = new Projeto();
        $this->usuario = new Usuario();
        $this->categoria = new Categoria();
    }

    function getCod() {
        return $this->cod;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getStatus() {
        return $this->status;
    }

    function getData() {
        return $this->data;
    }

    function getUsuario() {
        return $this->usuario;
    }

    function getCategoria() {
        return $this->categoria;
    }

    function getProjeto() {
        return $this->projeto;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setUsuario($usuario) {
        $this->usuario = $usuario;
    }

    function setCategoria($categoria) {
        $this->categoria = $categoria;
    }

    function setProjeto($projeto) {
        $this->projeto = $projeto;
    }
}
