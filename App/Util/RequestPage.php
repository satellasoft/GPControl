<?php

$pagina = filter_input(INPUT_GET, "p", FILTER_SANITIZE_STRING);
$permissao = intval($_SESSION['permissao']);

$arrayPaginas = array(
    "home" => "View/home.php", //Página inicial
    "ajuda" => "View/ajuda.php",
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

$arrayProtegidas = array(
    "gusuario",
    "gcategoria",
    "gprojeto",
    "gvisualizaprojeto",
    "gpermissao"
);

if ($pagina) {
    $encontrou = false;
    $pageLoad = "";

    foreach ($arrayPaginas as $page => $key) {
        if ($pagina == $page) {
            $encontrou = true;
            $pageLoad = $key;
        }
    }

    if (!$encontrou) {
        $pageLoad = "View/error.php";
    } else {
        foreach ($arrayProtegidas as $pageProtected) {
            if ($pageProtected == $pagina && $permissao == 2) {
                $pageLoad = "View/permission.php";
            }
        }
    }
    require_once($pageLoad);
} else {
    require_once("View/home.php");
}
?>