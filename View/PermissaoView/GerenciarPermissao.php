<?php

use App\Controller\UsuarioController;
use App\Controller\ProjetoController;

$uarioController = new UsuarioController();
$projetoController = new ProjetoController();

$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$projeto = $projetoController->RetornarCod($cod);
?>
<h1>Permissões do projeto</h1>
<a href="?p=gvisualizaprojeto&cod=<?= $cod; ?>" class="btn btn-dark">Voltar</a>
<br><br>
<div class="bg-gray">
    <div class="grid-50 mobile-grid-100">
        <p><span class="bold">Projeto: </span><?= $projeto->getNome(); ?></p>
    </div>
    <div class="grid-50 mobile-grid-100">
        <p><span class="bold">Status: </span><?= $projeto->getStatus() == 1 ? "Ativo" : "Bloqueado"; ?></p>
    </div>
    <div class="clear"></div>
    <div class="grid-100">
        <p><span class="bold">Descrição: </span> <a href="#" id="btnExibirDescricao">Exibir</a></p>
        <div id="dvExibirDescricao" style="display: none;">
            <?= html_entity_decode($projeto->getDescricao()); ?>
        </div>
        <div class="clear"></div>
    </div>

</div>
<div class="grid-100 mobile-grid-100">
    <div class="box-permissao border-green">
        <div class="form-group grid-100">
            <label for="txtNome">Nome</label>
            <input type="text" class="form-control" id="txtNome" name="txtNome" placeholder="Nome o usuário">
        </div>
        <div class="clear"></div>
        <div class="">
            <table class="table table-responsive-lg table-hover table-striped">
                <thead>
                    <tr>
                        <th>Nome</th>
                        <th>E-mail</th>
                        <th>Permissão</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody id="tbody"></tbody>
            </table>
        </div>
    </div>
</div>
<div class="grid-100 mobile-grid-100">
    <div class="box-permissao border-red">
        <h2>Atribuidos</h2>
        <table class="table table-responsive-lg table-hover table-striped">
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>E-mail</th>
                    <th>Permissão</th>
                    <th></th>
                </tr>
            </thead>
            <tbody id="tbodyAtribuidos"></tbody>
        </table>
    </div>
</div>
<div class="clear"></div>
<input type="hidden" id="txtProjetoCod" value="<?= $cod; ?>"/>
<script src="<?= $base; ?>js/gerenciar-projeto-script.js" type="text/javascript"></script>
<script>

    var visible = false;
    $("#btnExibirDescricao").click(function () {
        $("#dvExibirDescricao").slideToggle("slow");

        visible = !visible;

        if (visible) {
            $("#btnExibirDescricao").text("Ocultar");
        } else {
            $("#btnExibirDescricao").text("Exibir");
        }
    });
</script>