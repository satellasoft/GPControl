<?php

require_once("../Util/autoloader.php");
$req = filter_input(INPUT_GET, "req", FILTER_SANITIZE_NUMBER_INT);

use App\Controller\UsuarioProjetoController;
use App\Util\ClassSerialization;

//use App\Util\ClassSerialization;

/*
 * 1 = Cadastra um novo registro
 * 2 = Retorna usuários pelo projeto
 * 3 = Remove permissão
 */

switch ($req) {
    case 1:
        $usuarioProjetoController = new UsuarioProjetoController();
        $projetoCod = filter_input(INPUT_POST, "pc", FILTER_SANITIZE_NUMBER_INT);
        $usuarioCod = filter_input(INPUT_POST, "uc", FILTER_SANITIZE_NUMBER_INT);

        if ($usuarioProjetoController->Cadastrar($usuarioCod, $projetoCod)) {
            echo "1";
        } else {
            echo "-1";
        }
        break;

    case 2:
        $usuarioProjetoController = new UsuarioProjetoController();
        $classSerialization = new ClassSerialization();
        $projetoCod = filter_input(INPUT_POST, "pc", FILTER_SANITIZE_NUMBER_INT);

        $listaUsuarios = $usuarioProjetoController->RetornarPermissoesProjetoCod($projetoCod);
        echo $classSerialization->serialize($listaUsuarios);
        break;
    case 3:
        $usuarioProjetoController = new UsuarioProjetoController();
        $usuarioCod = filter_input(INPUT_POST, "uc", FILTER_SANITIZE_NUMBER_INT);
        $projetoCod = filter_input(INPUT_POST, "pc", FILTER_SANITIZE_NUMBER_INT);

        if ($usuarioProjetoController->Remover($usuarioCod, $projetoCod)) {
            echo "1";
        } else {
            echo "2";
        }
        break;
}
?>