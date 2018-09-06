<?php

namespace App\Controller;

use App\DAL\RespostaDAO;
use App\Model\ViewModel\RespostaView\RespostaView;

class RespostaController {

    private $respostaDAO;

    public function __construct() {
        $this->respostaDAO = new RespostaDAO();
    }

    public function Cadastrar(RespostaView $resposta) {
        if (strlen($resposta->getDescricao()) >= 5 &&
                $resposta->getUsuarioCod() > 0 &&
                $resposta->getModuloCod() > 0) {
            return $this->respostaDAO->Cadastrar($resposta);
        } else {
            return false;
        }
    }

    public function RetornarTodosModuloCod(int $moduloCod) {
        if ($moduloCod > 0) {
            return $this->respostaDAO->RetornarTodosModuloCod($moduloCod);
        } else {
            return null;
        }
    }

    public function RetornarEmailsResposta(int $moduloCod) {
        if ($moduloCod > 0) {
            return $this->respostaDAO->RetornarEmailsResposta($moduloCod);
        } else {
            return null;
        }
    }

}
