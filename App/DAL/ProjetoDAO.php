<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\Projeto;
use App\Model\ViewModel\ProjetoView\ProjetoViewConsulta;

class ProjetoDAO {

    private $pdo;
    private $debug;

    function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Projeto $projeto) {

        try {
            $sql = "INSERT INTO projeto (nome, descricao, thumb, data, status, usuario_cod) VALUES (:nome, :descricao, :thumb, :data, :status, :usuariocod)";
            $params = array(
                ":nome" => $projeto->getNome(),
                ":descricao" => $projeto->getDescricao(),
                ":thumb" => $projeto->getThumb(),
                ":data" => $projeto->getData(),
                ":status" => $projeto->getStatus(),
                ":usuariocod" => $projeto->getUsuario()->getCod()
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return false;
        }
    }

    public function RetornarTodosStatus(int $status) {
        try {
            $sql = "SELECT p.cod, p.nome, p.data, u.nome as unome FROM projeto p INNER JOIN usuario u ON u.cod = p.usuario_cod WHERE p.status = :status";
            $param = array(
                ":status" => $status
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaProjeto = [];

            foreach ($dt as $dr) {
                $projetoViewConsulta = new ProjetoViewConsulta();
                $projetoViewConsulta->setCod($dr["cod"]);
                $projetoViewConsulta->setData($dr["data"]);
                $projetoViewConsulta->setNome($dr["nome"]);
                $projetoViewConsulta->setUsuarioNome($dr["unome"]);

                $listaProjeto[] = $projetoViewConsulta;
            }

            return $listaProjeto;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return null;
        }
    }

}
