<?php

namespace App\Model\ViewModel\ModuloView;

class ModuloConsultaView {

    private $cod;
    private $titulo;
    private $data;
    private $usuarioCod;
    private $usuarioNome;
    private $status;

    function getStatus() {
        return $this->status;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function getCod() {
        return $this->cod;
    }

    function getTitulo() {
        return $this->titulo;
    }

    function getData() {
        return $this->data;
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

    function setTitulo($titulo) {
        $this->titulo = $titulo;
    }

    function setData($data) {
        $this->data = $data;
    }

    function setUsuarioCod($usuarioCod) {
        $this->usuarioCod = $usuarioCod;
    }

    function setUsuarioNome($usuarioNome) {
        $this->usuarioNome = $usuarioNome;
    }

}
