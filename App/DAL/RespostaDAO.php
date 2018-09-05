<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\ViewModel\RespostaView\RespostaView;

class RespostaDAO {

    private $pdo;
    private $debug;

    function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(RespostaView $resposta) {
        try {
            $sql = "INSERT INTO resposta (descricao, data, modulo_cod, usuario_cod) VALUES "
                    . "(:descricao, :data, :modulocod, :usuariocod)";
            $params = array(
                ":descricao" => $resposta->getDescricao(),
                ":data" => date("Y-m-d H:i:s"),
                ":modulocod" => $resposta->getModuloCod(),
                ":usuariocod" => $resposta->getUsuarioCod()
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return false;
        }
    }

    public function RetornarTodosModuloCod(int $moduloCod) {
        try {
            $sql = "SELECT u.nome, r.descricao, r.data FROM resposta r INNER JOIN usuario u ON u.cod = r.usuario_cod "
                    . "WHERE r.modulo_cod = :modulocod ORDER BY r.data DESC";
            $param = array(
                ":modulocod" => $moduloCod
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaResposta = [];

            foreach ($dt as $dr) {
                $respostaView = new RespostaView();
                $respostaView->setData($dr["data"]);
                $respostaView->setDescricao($dr["descricao"]);
                $respostaView->setUsuarioNome($dr["nome"]);

                $listaResposta[] = $respostaView;
            }

            return $listaResposta;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return null;
        }
    }

}
