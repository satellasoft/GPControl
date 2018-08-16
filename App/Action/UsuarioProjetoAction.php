<?php

require_once("../Util/autoloader.php");
$req = filter_input(INPUT_GET, "req", FILTER_SANITIZE_NUMBER_INT);

use App\Controller\UsuarioProjetoController;

//use App\Util\ClassSerialization;

/*
 * 1 = Cadastra um novo registro
 * 2 = 
 * 3 = 
 */

switch ($req) {
    case 1:
        $usuarioProjetoController = new UsuarioProjetoController();
        $projetoCod = filter_input(INPUT_POST, "pc", FILTER_SANITIZE_NUMBER_INT);
        $usuarioCod = filter_input(INPUT_POST, "uc", FILTER_SANITIZE_NUMBER_INT);

        if($usuarioProjetoController->Cadastrar($usuarioCod, $projetoCod)){
            echo "1";
        }else{
            echo "-1";
        }
        break;
}
?>