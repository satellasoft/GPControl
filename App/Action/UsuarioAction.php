<?php

require_once("../Util/autoloader.php");
$req = filter_input(INPUT_GET, "req", FILTER_SANITIZE_NUMBER_INT);

use App\Controller\UsuarioController;
use App\Util\ClassSerialization;

/*
 * 1 = Realiza uma consulta
 * 2 = Verifica se o e-mail existe
 * 3 = Retorna usuário pelo nome
 * 4 = Alterar senha
 */

switch ($req) {
    case 1:
        $permissao = filter_input(INPUT_POST, "p", FILTER_SANITIZE_NUMBER_INT);
        $status = filter_input(INPUT_POST, "s", FILTER_SANITIZE_NUMBER_INT);
        $nome = filter_input(INPUT_POST, "n", FILTER_SANITIZE_STRING);

        $usuarioController = new UsuarioController();
        $classSerialization = new ClassSerialization();

        $data = $usuarioController->RetornarUsuariosBusca($permissao, $status, $nome);
        echo $classSerialization->serialize($data);
        break;

    case 2:
        $email = filter_input(INPUT_POST, "e", FILTER_SANITIZE_STRING);
        $usuarioController = new UsuarioController();
        echo $usuarioController->VerificaEmailExiste($email);
        break;
    case 3:
        $nome = filter_input(INPUT_POST, "n", FILTER_SANITIZE_STRING);
        $projetoCod = filter_input(INPUT_POST, "pc", FILTER_SANITIZE_NUMBER_INT);
        $usuarioController = new UsuarioController();
        echo json_encode($usuarioController->RetornarTodosAtivosResumo($nome, $projetoCod));
        break;
    case 4:
        $senha = filter_input(INPUT_POST, "s", FILTER_SANITIZE_STRING);
        $usuarioCod = filter_input(INPUT_POST, "c", FILTER_SANITIZE_NUMBER_INT);
        $usuarioController = new UsuarioController();
        
        if ($usuarioController->AlterarSenha($senha, $usuarioCod)) {
            echo 1;
        } else {
            echo -1;
        }
        break;
}