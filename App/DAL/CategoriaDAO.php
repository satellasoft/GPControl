<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\Categoria;

class CategoriaDAO {

    private $pdo;
    private $debug;

    function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    public function Cadastrar(Categoria $categoria) {
        try {
            $sql = "INSERT INTO categoria (nome, status, projeto_cod) VALUES (:nome, :status, :projetocod)";
            $params = array(
                ":nome" => $categoria->getNome(),
                ":status" => $categoria->getStatus(),
                ":projetocod" => $categoria->getProjeto()->getCod()
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return false;
        }
    }

    public function Alterar(Categoria $categoria) {
        try {
            $sql = "UPDATE categoria SET nome = :nome, status = :status WHERE cod = :cod";
            $params = array(
                ":nome" => $categoria->getNome(),
                ":status" => $categoria->getStatus(),
                ":cod" => $categoria->getCod()
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return false;
        }
    }

    public function RetornarTodosProjetoCod(int $projetoCod) {
        try {
            $sql = "SELECT c.nome, c.cod, c.status FROM categoria c WHERE projeto_cod = :projeto ORDER BY c.nome ASC";
            $param = array(":projeto" => $projetoCod);

            $dt = $this->pdo->ExecuteQuery($sql, $param);
            $listaCategoria = [];

            foreach ($dt as $dr) {
                $categoria = new Categoria();

                $categoria->setCod($dr["cod"]);
                $categoria->setNome($dr["nome"]);
                $categoria->setStatus($dr["status"]);

                $listaCategoria[] = $categoria;
            }

            return $listaCategoria;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return null;
        }
    }

    public function RetornaCategoriaCod(int $categoriaCod) {
        try {
            $sql = "SELECT nome, status FROM categoria WHERE cod = :cod";
            $param = array(":cod" => $categoriaCod);

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $param);
            $categoria = new Categoria();

            $categoria->setNome($dr["nome"]);
            $categoria->setStatus($dr["status"]);

            return $categoria;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return null;
        }
    }

}
