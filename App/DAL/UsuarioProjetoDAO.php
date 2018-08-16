<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\usuarioProjeto;
use App\Model\ViewModel\UsuarioProjetoView\UsuarioProjetoConsultaView;

class UsuarioProjetoDAO {

    private $pdo;
    private $debug;

    function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(int $usuarioCod, int $projetoCod) {
        try {
            $sql = "INSERT INTO usuario_projeto (usuario_cod, projeto_cod) VALUES (:usuariocod, :projetocod)";
            $params = array(
                ":usuariocod" => $usuarioCod,
                ":projetocod" => $projetoCod
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return false;
        }
    }

    public function RetornarPermissoesProjetoCod(int $projetoCod) {
        try {
            $sql = "SELECT u.nome, u.email, u.status, u.permissao, up.usuario_cod, up.projeto_cod "
                    . "FROM usuario u INNER JOIN usuario_projeto up "
                    . "ON up.usuario_cod = u.cod AND up.projeto_cod = :projetocod "
                    . "ORDER BY u.nome, u.status";

            $param = array(
                ":projetocod" => $projetoCod
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaUsuario = array();

            foreach ($dt as $dr) {
                $ProjetoViewConsulta = new UsuarioProjetoConsultaView();
                $ProjetoViewConsulta->setProjetoCod($dr["projeto_cod"]);
                $ProjetoViewConsulta->setUsuarioCod($dr["usuario_cod"]);
                $ProjetoViewConsulta->setUsuarioNome($dr["nome"]);
                $ProjetoViewConsulta->setUsuarioEmail($dr["email"]);
                $ProjetoViewConsulta->setUsuarioPermissao($dr["permissao"]);
                $ProjetoViewConsulta->setUsuarioStatus($dr["status"]);


                $listaUsuario[] = $ProjetoViewConsulta;
            }

            return $listaUsuario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return null;
        }
    }

}
