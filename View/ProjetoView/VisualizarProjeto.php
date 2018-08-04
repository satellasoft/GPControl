<?php

use App\Controller\ProjetoController;

$projetoController = new ProjetoController();
$cod = (int) filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$projeto = $projetoController->RetornarCompletoCod($cod);
?>

<?php
if ($projeto != null && $projeto->getNome() != null) {
    ?>
    <h1><?= $projeto->getNome(); ?></h1>
    <br><br>
    <div>
        <div class="grid-30 mobile-grid-100">
            <img class="img-fluid rounded" alt="<?= $projeto->getNome(); ?>" src="<?= ($projeto->getThumb() == null ? "img/icones/noimage.png" : "img/projetos/{$projeto->getThumb()}") ?>"/>
            <a href="#" class="btn btn-info" style="width:100%; margin-top:10px;">Alterar imagem</a>
            <a href='?p=gprojeto&cod=<?= $cod; ?>' class='btn btn-warning'style="width:100%; margin-top:10px;">Editar</a>
            <hr>
            <a href='?p=#&cod=<?= $cod; ?>' class='btn btn-dark'style="width:100%; margin-top:10px;">Permissões</a>
            <a href='?p=#&cod=<?= $cod; ?>' class='btn btn-success'style="width:100%; margin-top:10px;">Categorias</a>
        </div>

        <div class="grid-70 mobile-grid-100">
            <p><span class='bold'>Criado por: </span><?= $projeto->getUsuarioNome(); ?></p>
            <p><span class='bold'>Data: </span><?= date("d/m/Y H:i:s", strtotime($projeto->getData())); ?></p>
            <p><span class='bold'>Status: </span><?= $projeto->getStatus() == 1 ? "Ativo" : "Bloqueado"; ?></p>
            <div>
                <?= html_entity_decode($projeto->getDescricao()); ?>
            </div>
        </div>
        <div class="clear"></div>
    </div>
    <?php
} else {
    ?>
    <h1>Nada encontrado</h1>
    <a href="?p=gprojeto" class="btn btn-dark">Voltar</a>
    <p>O projeto que você procura não foi encontrado, talves ele não exista ou tenha sido removido.</p>
    <?php
}
?>
<br><br>
