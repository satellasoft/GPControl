<?php

require_once("../Util/autoloader.php");
$req = filter_input(INPUT_GET, "req", FILTER_SANITIZE_NUMBER_INT);

use App\Controller\ModuloController;

switch ($req) {
    case 1:
        $usuarioCod = filter_input(INPUT_POST, "u", FILTER_SANITIZE_NUMBER_INT);
        $moduloCod = filter_input(INPUT_POST, "m", FILTER_SANITIZE_NUMBER_INT);

        $moduloController = new ModuloController();

        if ($moduloController->MarcarComoResolvido($moduloCod, $usuarioCod)) {
            echo 1;
        } else {
            echo -1;
        }
        break;
}