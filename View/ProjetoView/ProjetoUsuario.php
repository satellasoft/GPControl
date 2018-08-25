<?php

use App\Controller\ProjetoController;

$projetoController = new ProjetoController();
$listaProjeto = $projetoController->RetornaProjetosUsuario(intval($_SESSION["cod"]));
?>
<h1>Projetos Usuário</h1>
<a href="?p=home" class="btn btn-dark">Voltar</a>
<br><br>
<div>
    <table class="table table-hover table-striped table-responsive-lg">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Status</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($listaProjeto as $projeto) {
                ?>
                <tr>
                    <td>
                        <img class="img-fluid rounded" style="max-width:75px;" alt="<?= $projeto->getNome(); ?>" src="<?= ($projeto->getThumb() == null ? "img/icones/noimage.png" : "img/projetos/{$projeto->getThumb()}") ?>"/>
                        <?= $projeto->getNome(); ?>
                    </td>
                    <td>
                        <?= $projeto->getStatus() == 1 ? "Ativo" : "Desativado"; ?>
                    </td>
                    <td><?= date("d/m/Y H:i:s", strtotime($projeto->getData())); ?></td>
                    <td>
                        <a href='?p=#<?= $projeto->getCod(); ?>' class='btn btn-info' target='_blank'>Acessar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>