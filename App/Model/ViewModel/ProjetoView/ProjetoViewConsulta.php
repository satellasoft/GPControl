<?php

namespace App\Model\ViewModel\ProjetoView;

class ProjetoViewConsulta {

    private $cod;
    private $nome;
    private $data;
    private $descricao;
    private $status;
    private $usuarioNome;
    private $thumb;

    function getThumb() {
        return $this->thumb;
    }

    function setThumb($thumb) {
        $this->thumb = $thumb;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getData() {
        return $this->data;
    }

    function getUsuarioNome() {
        return $this->usuarioNome;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setUsuarioNome($usuarioNome) {
        $this->usuarioNome = $usuarioNome;
    }

}
