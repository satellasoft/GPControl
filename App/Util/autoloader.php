<?php
$base = "/GerenciarProjeto/";
spl_autoload_register(function($classe) {
    $basedir = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR.$GLOBALS["base"];
    
    $file = str_replace('\\', DIRECTORY_SEPARATOR, $classe);

    if (file_exists($basedir.DIRECTORY_SEPARATOR.$file . ".php")) {
        require_once $basedir.DIRECTORY_SEPARATOR.$file . ".php";
    } else {
        die($basedir.DIRECTORY_SEPARATOR.$file . ".php");
    }
});
