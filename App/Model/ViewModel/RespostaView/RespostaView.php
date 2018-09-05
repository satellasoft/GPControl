<?php

namespace App\Model\ViewModel\RespostaView;

class RespostaView {

    private $cod;
    private $descricao;
    private $data;
    private $moduloCod;
    private $usuarioCod;
    private $usuarioNome;

    
    function getCod() {
        return $this->cod;
    }

    function getDescricao() {
        return $this->descricao;
    }

    function getData() {
        return $this->data;
    }

    function getModuloCod() {
        return $this->moduloCod;
    }

    function getUsuarioCod() {
        return $this->usuarioCod;
    }

    function getUsuarioNome() {
        return $this->usuarioNome;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setDescricao($descricao) {
        $this->descricao = $descricao;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setModuloCod($moduloCod) {
        $this->moduloCod = $moduloCod;
    }

    function setUsuarioCod($usuarioCod) {
        $this->usuarioCod = $usuarioCod;
    }

    function setUsuarioNome($usuarioNome) {
        $this->usuarioNome = $usuarioNome;
    }
}
