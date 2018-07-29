<?php

namespace App\Model\ViewModel\UsuarioView;

class UsuarioViewConsulta {

    private $cod;
    private $nome;
    private $email;
    private $data;

    function getCod() {
        return $this->cod;
    }

    function getNome() {
        return $this->nome;
    }

    function getEmail() {
        return $this->email;
    }

    function getData() {
        return $this->data;
    }

    function setCod($cod) {
        $this->cod = $cod;
    }

    function setNome($nome) {
        $this->nome = $nome;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function setData($data) {
        $this->data = $data;
    }

}
