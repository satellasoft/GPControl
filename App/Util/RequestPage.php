<?php

$pagina = filter_input(INPUT_GET, "p", FILTER_SANITIZE_STRING);

//echo $pagina;


$arrayPaginas = array(
    "home" => "View/home.php", //Página inicial
//Usuários
    "gusuario" => "View/UsuarioView/GerenciarUsuario.php",
    //Categorias
    "gcategoria" => "View/CategoriaView/GerenciarCategoria.php",
    //Projetos
    "gprojeto" => "View/ProjetoView/GerenciarProjeto.php",
    "gvisualizaprojeto" => "View/ProjetoView/VisualizarProjeto.php",
    "mprojeto" => "View/ProjetoView/ProjetoUsuario.php",
    //Permissões
    "gpermissao" => "View/PermissaoView/GerenciarPermissao.php",
    //Módulo
    "modulo" => "View/ModuloView/GerenciarModulo.php",
    "visualizarmodulo" => "View/ModuloView/VisualizarModulo.php",
);

if ($pagina) {
    $encontrou = false;

    foreach ($arrayPaginas as $page => $key) {
        if ($pagina == $page) {
            $encontrou = true;
            require_once($key);
        }
    }

    if (!$encontrou) {
        require_once("View/error.php");
    }
} else {
    require_once("View/home.php");
}
?>