<?php

use App\Controller\ModuloController;
use App\Model\ViewModel\ModuloView\ModuloView;

$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$moduloController = new ModuloController();

$modulo = $moduloController->RetornarCompletoCod(intval($cod));



if ($modulo != null && $modulo->getTitulo() != null) {
    ?>
    <h1><?= $modulo->getTitulo(); ?></h1>

    <!--Carrega as informações do módulo.-->
    <div class="bg-gray">
        <p>
            <span class="bold">Criado por: </span> <?= $modulo->getUsuarioNome(); ?> 
            <span class="bold">Data de criação: </span> <?= date("d/m/Y H:i:s", strtotime($modulo->getData())); ?> 
            <span class="bold">Status: </span> <?= $modulo->getStatus() == 1 ? "Ativo" : "Bloqueado"; ?> 
            <span class="bold">Categoria: </span> <?= $modulo->getCategoriaNome(); ?>             
        </p>

        <div>
            <?= html_entity_decode($modulo->getDescricao()); ?> 
        </div>

        <!--Exibe o formulário de resposta.-->
        <div>
            <form method="post" id="frmResposta">
                <textarea id="txtResposta"></textarea>
                <button type="submit" class="btn btn-success" style="margin-top: 5px;">Responder</button>
            </form>
        </div>
    </div>
    <script src="<?=$base;?>ckeditor/ckeditor.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace("txtResposta");
        });
    </script>
    <?php
} else {
    ?>
    <h1>Visualizar módulo</h1>
    <br><br>
    <div class="bg-gray">
        A informação que você procura não foi encontrado ou a URL informada é inválida.
    </div>
    <?php
}
?>