<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\Modulo;
use App\Model\ViewModel\ModuloView\ModuloView;

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

}
?>