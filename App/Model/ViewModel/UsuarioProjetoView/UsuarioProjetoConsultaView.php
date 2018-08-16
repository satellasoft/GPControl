<?php
namespace App\Model\ViewModel\UsuarioProjetoView;
class UsuarioProjetoConsultaView {

    private $usuarioCod;
    private $projetoCod;
    private $usuarioNome;
    private $usuarioEmail;
    private $usuarioPermissao;
    private $usuarioStatus;

    function getUsuarioCod() {
        return $this->usuarioCod;
    }

    function getProjetoCod() {
        return $this->projetoCod;
    }

    function getUsuarioNome() {
        return $this->usuarioNome;
    }

    function getUsuarioEmail() {
        return $this->usuarioEmail;
    }

    function getUsuarioPermissao() {
        return $this->usuarioPermissao;
    }

    function getUsuarioStatus() {
        return $this->usuarioStatus;
    }

    function setUsuarioCod($usuarioCod) {
        $this->usuarioCod = $usuarioCod;
    }

    function setProjetoCod($projetoCod) {
        $this->projetoCod = $projetoCod;
    }

    function setUsuarioNome($usuarioNome) {
        $this->usuarioNome = $usuarioNome;
    }

    function setUsuarioEmail($usuarioEmail) {
        $this->usuarioEmail = $usuarioEmail;
    }

    function setUsuarioPermissao($usuarioPermissao) {
        $this->usuarioPermissao = $usuarioPermissao;
    }

    function setUsuarioStatus($usuarioStatus) {
        $this->usuarioStatus = $usuarioStatus;
    }
}
