<?php
namespace App\Model\ViewModel\ModuloView;

class ModuloView {

    private $cod;
    private $titulo;
    private $descricao;
    private $status;
    private $data;
    private $usuarioCod;
    private $usuarioNome;
    private $categoriaCod;
    private $categoriaNome;
    private $projetoCod;

    function getCategoriaNome() {
        return $this->categoriaNome;
    }

    function setCategoriaNome($categoriaNome) {
        $this->categoriaNome = $categoriaNome;
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

    function getUsuarioCod() {
        return $this->usuarioCod;
    }

    function getCategoriaCod() {
        return $this->categoriaCod;
    }

    function getProjetoCod() {
        return $this->projetoCod;
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

    function setUsuarioCod($usuarioCod) {
        $this->usuarioCod = $usuarioCod;
    }

    function setCategoriaCod($categoriaCod) {
        $this->categoriaCod = $categoriaCod;
    }

    function setProjetoCod($projetoCod) {
        $this->projetoCod = $projetoCod;
    }
    
    function getUsuarioNome() {
        return $this->usuarioNome;
    }

    function setUsuarioNome($usuarioNome) {
        $this->usuarioNome = $usuarioNome;
    }
}
