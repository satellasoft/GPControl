<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\Usuario;

class UsuarioDAO {

    private $pdo;
    private $debug;

    function __construct() {
        $this->pdo = new Banco();
        $this->debug = true;
    }

    function Cadastrar(Usuario $usuario) {
        try {
            $sql = "INSERT INTO usuario (nome, email, senha, status, permissao, data) VALUES (:nome, :email, :senha, :status, :permissao, :data)";
            $params = array(
                ":nome" => $usuario->getNome(),
                ":email" => $usuario->getEmail(),
                ":senha" => md5($usuario->getSenha()),
                ":status" => $usuario->getStatus(),
                ":permissao" => $usuario->getPermissao(),
                ":data" => date("d-m-Y H:i:s")
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
        }
    }
}
