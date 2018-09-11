<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\Modulo;
use App\Model\ViewModel\ModuloView\ModuloView;
use App\Model\ViewModel\ModuloView\ModuloConsultaView;
use App\Model\ViewModel\ModuloView\ModuloAbertoView;

class ModuloDAO {

    private $pdo;
    private $debug;

    function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(ModuloView $modulo) {
        try {
            $sql = "INSERT INTO modulo "
                    . "(titulo, descricao, status, data, usuario_cod, categoria_cod, projeto_cod) VALUES "
                    . "(:titulo, :descricao, :status, :data, :usuariocod, :categoriacod, :projetocod)";
            $params = array(
                ":titulo" => $modulo->getTitulo(),
                ":descricao" => $modulo->getDescricao(),
                ":status" => $modulo->getStatus(),
                ":data" => date("Y-m-d H:i:s"),
                ":usuariocod" => $modulo->getUsuarioCod(),
                ":categoriacod" => $modulo->getCategoriaCod(),
                ":projetocod" => $modulo->getProjetoCod(),
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return false;
        }
    }

    public function Alterar(ModuloView $modulo) {
        try {
            $sql = "UPDATE modulo "
                    . "SET titulo = :titulo, descricao = :descricao, status = :status, categoria_cod = :categoriacod WHERE cod = :cod";
            $params = array(
                ":titulo" => $modulo->getTitulo(),
                ":descricao" => $modulo->getDescricao(),
                ":status" => $modulo->getStatus(),
                ":categoriacod" => $modulo->getCategoriaCod(),
                ":cod" => $modulo->getCod()
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return false;
        }
    }

    public function BuscarModulo(string $titulo, int $status, int $categoriaCod, int $quantidade = 10) {
        try {
            $sql = "SELECT m.cod as mcod, m.titulo, m.data, u.cod as ucod, u.nome FROM modulo m "
                    . "INNER JOIN usuario u ON u.cod = m.usuario_cod "
                    . "WHERE m.titulo LIKE :titulo AND m.status = :status "
                    . "AND m.categoria_cod = :categoriacod ORDER BY m.data DESC LIMIT :quantidade";

            $params = array(
                ":titulo" => "%{$titulo}%",
                ":status" => $status,
                ":categoriacod" => $categoriaCod,
                ":quantidade" => $quantidade,
            );

            $dt = $this->pdo->ExecuteQuery($sql, $params);
            $listaModulo = [];
            foreach ($dt as $dr) {
                $moduloConsultaView = new ModuloConsultaView();
                $moduloConsultaView->setCod($dr["mcod"]);
                $moduloConsultaView->setTitulo($dr["titulo"]);
                $moduloConsultaView->setData($dr["data"]);
                $moduloConsultaView->setUsuarioCod($dr["ucod"]);
                $moduloConsultaView->setUsuarioNome($dr["nome"]);

                $listaModulo[] = $moduloConsultaView;
            }

            return $listaModulo;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return null;
        }
    }

    function RetornaCod(int $usuarioCod, int $cod) {
        try {
            $sql = "SELECT titulo, descricao, status, categoria_cod FROM modulo WHERE cod = :cod AND usuario_cod = :usuariocod";
            $params = array(
                ":cod" => $cod,
                ":usuariocod" => $usuarioCod
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $params);

            $moduloView = new ModuloView();
            $moduloView->setTitulo($dr["titulo"]);
            $moduloView->setDescricao($dr["descricao"]);
            $moduloView->setCategoriaCod($dr["categoria_cod"]);
            $moduloView->setStatus($dr["status"]);

            return $moduloView;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return null;
        }
    }

    public function RetornarCompletoCod(int $cod) {
        try {
            $sql = "SELECT m.titulo, m.descricao, m.status, m.data, u.nome as usuarionome, m.usuario_cod as ucod, c.nome as categorianome "
                    . "FROM modulo m INNER JOIN usuario u ON u.cod = m.usuario_cod "
                    . "INNER JOIN categoria c ON c.cod = m.categoria_cod WHERE m.cod = :cod";
            $param = array(
                ":cod" => $cod
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);
            $moduloView = new ModuloView();

            $moduloView->setTitulo($dr["titulo"]);
            $moduloView->setDescricao($dr["descricao"]);
            $moduloView->setStatus($dr["status"]);
            $moduloView->setData($dr["data"]);

            $moduloView->setUsuarioCod($dr["ucod"]);
            $moduloView->setUsuarioNome($dr["usuarionome"]);
            $moduloView->setCategoriaNome($dr["categorianome"]);

            return $moduloView;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return null;
        }
    }

    public function MarcarComoResolvido(int $moduloCod, int $usuarioCod) {
        try {
            $sql = "UPDATE modulo SET status = 2 WHERE cod = :modulocod AND usuario_cod = :usuariocod";
            $params = array(
                ":modulocod" => $moduloCod,
                ":usuariocod" => $usuarioCod
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return false;
        }
    }

    public function RetornaModulosAberto(int $usuarioCod) {
        try {
            $sql = "SELECT " .
                    "m.titulo, " .
                    "m.cod as mcod, ".
                    "m.data, " .
                    "c.nome AS cnome, " .
                    "u.nome AS unome, " .
                    "p.nome AS pnome, " .
                    "(SELECT count(resposta.cod) FROM resposta WHERE modulo_cod = m.cod) as respostas " .
                    "FROM " .
                    "modulo m " .
                    "INNER JOIN usuario u ON " .
                    "u.cod = m.usuario_cod " .
                    "INNER JOIN categoria c ON " .
                    "c.cod = m.categoria_cod " .
                    "INNER JOIN projeto p ON " .
                    "p.cod = m.projeto_cod " .
                    "INNER JOIN usuario_projeto up ON " .
                    "up.projeto_cod = p.cod AND up.usuario_cod = :usuariocod " .
                    "WHERE " .
                    "m.status = 1 " .
                    "ORDER BY " .
                    "p.nome, c.nome ASC, " .
                    "m.data DESC " .
                    "LIMIT 15";

            $param = array(
                ":usuariocod" => $usuarioCod
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaModulo = [];

            foreach ($dt as $dr) {
                $moduloAbertoView = new ModuloAbertoView();

                $moduloAbertoView->setCod($dr["mcod"]);
                $moduloAbertoView->setTitulo($dr["titulo"]);
                $moduloAbertoView->setData($dr["data"]);
                $moduloAbertoView->setRespostas($dr["respostas"]);
                
                $moduloAbertoView->setUsuarioNome($dr["unome"]);
                $moduloAbertoView->setCategoriaNome($dr["cnome"]);
                $moduloAbertoView->setProjetoNome($dr["pnome"]);

                $listaModulo[] = $moduloAbertoView;
            }

            return $listaModulo;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return null;
        }
    }

}

?>