<?php

use App\Controller\ModuloController;

$moduloController = new ModuloController();

$listaModulosabertos = $moduloController->RetornaModulosAberto(intval($_SESSION["cod"]));
?>
<div class="icones-menu">
    <div class="alert alert-info grid-100" role="alert">Menu</div>

    <?php
    if ($_SESSION["permissao"] == 1) {
        ?>
        <div class="grid-20 mobile-grid-100 margin-5-bottom">
            <a href="?p=gusuario">
                <img src="img/icones/usuario.png" alt="Gerenciar Usuário" /> Gerenciar Usuário
            </a>
        </div>

        <div class="grid-20 mobile-grid-100 margin-5-bottom">
            <a href="?p=gprojeto">
                <img src="img/icones/gerenciaprojeto.png" alt="Gerenciar Projet" />  Gerenciar Projetos
            </a>
        </div>
        <?php
    }
    ?>

    <div class="grid-20 mobile-grid-100 margin-5-bottom">
        <a href="?p=mprojeto">
            <img src="img/icones/projetousuario.png" alt="Meus projetos" />  Meus projetos
        </a>
    </div>

    <div class="grid-20 mobile-grid-100 margin-5-bottom">
        <a href="logout.php">
            <img src="img/icones/sair.png" alt="Sair" />  Sair
        </a>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="alert alert-warning grid-100" role="alert">Notificações</div>
    <table class="table table-hover table-striped table-responsive-lg">
        <thead>
            <tr>
                <th>Projeto</th>
                <th>Módulo</th>
                <th>Criado por</th>
                <th>Data</th>
                <th>Categoria</th>
                <th>Respostas</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (count($listaModulosabertos) > 0) {
                foreach ($listaModulosabertos as $modulo) {
                    ?>
                    <tr>
                        <td><?= $modulo->getProjetoNome(); ?></td>
                        <td><?= $modulo->getTitulo(); ?></td>
                        <td><?= $modulo->getUsuarioNome(); ?></td>
                        <td><?= date("d/m/Y H:i:s", strtotime($modulo->getData())); ?></td>
                        <td><?= $modulo->getCategoriaNome(); ?></td>
                        <td><?= $modulo->getRespostas(); ?></td>
                    </tr>
                    <?php
                }
            }
            ?>
        </tbody>
    </table>
</div>