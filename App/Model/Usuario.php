<?php
namespace App\Model;
class Usuario {

    private $cod;
    private $nome;
    private $email;
    private $senha;
    private $status;
    private $permissao;
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

    function getSenha() {
        return $this->senha;
    }

    function getStatus() {
        return $this->status;
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

    function setSenha($senha) {
        $this->senha = $senha;
    }

    function setStatus($status) {
        $this->status = $status;
    }

    function setData($data) {
        $this->data = $data;
    }
    function getPermissao() {
        return $this->permissao;
    }

    function setPermissao($permissao) {
        $this->permissao = $permissao;
    }


}
