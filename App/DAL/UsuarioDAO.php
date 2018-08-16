<?php

namespace App\DAL;

use App\DB\Banco;
use App\Model\Usuario;
use App\Model\ViewModel\UsuarioView\UsuarioViewConsulta;

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
                ":email" => strtolower($usuario->getEmail()),
                ":senha" => md5($usuario->getSenha()),
                ":status" => $usuario->getStatus(),
                ":permissao" => $usuario->getPermissao(),
                ":data" => date("Y-m-d H:i:s")
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return false;
        }
    }

    function Alterar(Usuario $usuario) {
        try {
            $sql = "UPDATE usuario SET nome = :nome, status = :status, permissao = :permissao WHERE cod = :cod";
            $params = array(
                ":nome" => $usuario->getNome(),
                ":status" => $usuario->getStatus(),
                ":permissao" => $usuario->getPermissao(),
                ":cod" => $usuario->getCod()
            );

            return $this->pdo->ExecuteNonQuery($sql, $params);
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return false;
        }
    }

    public function RetornarUsuariosBusca(int $permissao, int $status, string $nome) {
        try {
            $nome = strtoupper($nome);

            $sql = "SELECT cod, nome, email, data FROM usuario WHERE status = :status AND permissao = :permissao AND UPPER(nome) LIKE :nome ORDER BY nome ASC";
            $params = array(
                ":permissao" => $permissao,
                ":status" => $status,
                ":nome" => "%{$nome}%"
            );

            $dt = $this->pdo->ExecuteQuery($sql, $params);
            $listaUsuario = [];

            foreach ($dt as $dr) {
                $usuarioViewConsulta = new UsuarioViewConsulta();
                $usuarioViewConsulta->setCod($dr["cod"]);
                $usuarioViewConsulta->setData(date("d/m/Y H:i:s", strtotime($dr["data"])));
                $usuarioViewConsulta->setEmail($dr["email"]);
                $usuarioViewConsulta->setNome($dr["nome"]);

                $listaUsuario[] = $usuarioViewConsulta;
            }

            return $listaUsuario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return null;
        }
    }

    public function RetornaEdicaoCod(int $cod) {
        try {
            $sql = "SELECT nome, email, permissao, status FROM usuario WHERE cod = :cod";
            $params = array(
                ":cod" => $cod
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $params);

            $usuario = new Usuario();

            $usuario->setNome($dr["nome"]);
            $usuario->setEmail($dr["email"]);
            $usuario->setStatus($dr["status"]);
            $usuario->setPermissao($dr["permissao"]);

            return $usuario;
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return null;
        }
    }

    public function VerificaEmailExiste(string $email) {
        try {
            $sql = "SELECT cod FROM usuario WHERE UPPER(email) = :email";
            $param = array(
                ":email" => strtolower($email)
            );
            $dt = $this->pdo->ExecuteQueryOneRow($sql, $param);

            if ($dt["cod"] == null) {//Não existe
                return 1;
            } else {
                return -1;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }

            return -10;
        }
    }

    public function Autenticar(string $email, string $senha) {
        try {
            $sql = "SELECT cod, permissao FROM usuario WHERE LOWER(email) = :email AND senha = :senha AND status = :status";
            $params = array(
                ":email" => strtolower($email),
                ":senha" => md5($senha),
                ":status" => 1//ativo
            );

            $dr = $this->pdo->ExecuteQueryOneRow($sql, $params);

            if (!is_null($dr["cod"])) {
                $arr = array(
                    "cod" => $dr["cod"],
                    "permissao" => $dr["permissao"]
                );

                return $arr;
            } else {
                return null;
            }
        } catch (PDOException $ex) {
            if ($this->debug) {
                echo "ERRO: {$ex->getMessage()}";
            }
            return null;
        }
    }

    public function RetornarTodosAtivosResumo(string $nome, int $projetoCod) {
        try {
            $sql = "SELECT u.cod, u.nome, u.email, u.permissao FROM usuario u WHERE u.status = 1 AND u.nome LIKE :nome AND u.cod NOT IN (SELECT p.usuario_cod FROM usuario_projeto p WHERE p.usuario_cod = u.cod AND p.projeto_cod = :pc) ORDER BY u.nome ASC";
            $param = array(
                ":nome" => "%{$nome}%",
                ":pc" => $projetoCod
            );

            $dt = $this->pdo->ExecuteQuery($sql, $param);

            $listaUsuario = [];

            foreach ($dt as $dr) {
                $array = array(
                    "cod" => $dr["cod"],
                    "nome" => $dr["nome"],
                    "email" => $dr["email"],
                    "permissao" => $dr["permissao"]
                );

                $listaUsuario[] = $array;
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
