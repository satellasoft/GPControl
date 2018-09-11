<?php

namespace App\Model\ViewModel\ModuloView;

class ModuloAbertoView {

    private $cod;
    private $titulo;
    private $data;
    private $usuarioNome;
    private $categoriaNome;
    private $projetoNome;
    private $respostas;
    
    function getCod() {
        return $this->cod;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getData() {
        return $this->data;
    }

    function getUsuarioNome() {
        return $this->usuarioNome;
    }

    function getCategoriaNome() {
        return $this->categoriaNome;
    }

    function getProjetoNome() {
        return $this->projetoNome;
    }

    function getRespostas() {
        return $this->respostas;
    }

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setUsuarioNome($usuarioNome) {
        $this->usuarioNome = $usuarioNome;
    }

    function setCategoriaNome($categoriaNome) {
        $this->categoriaNome = $categoriaNome;
    }

    function setProjetoNome($projetoNome) {
        $this->projetoNome = $projetoNome;
    }

    function setRespostas($respostas) {
        $this->respostas = $respostas;
    }

}
