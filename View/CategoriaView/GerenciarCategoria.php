<?php

use App\Controller\CategoriaController;
use App\Controller\ProjetoController;
use App\Model\Categoria;

$categoriaController = new CategoriaController();
$projetoController = new ProjetoController();

$codProjeto = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
$codCategoria = filter_input(INPUT_GET, "cat", FILTER_SANITIZE_NUMBER_INT);

$editando = false;
$nome = "";
$status = 1;


if (filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) {
    $categoria = new Categoria();
    $categoria->setCod($codCategoria);
    $categoria->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
    $categoria->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $categoria->getProjeto()->setCod($codProjeto);

    if (!$codCategoria) {
        //Cadastrando
        $result = "";
        if ($categoriaController->Cadastrar($categoria)) {
            $result = "c1";
        } else {
            $result = "c2";
        }
        ?>
        <script>
            setCookie("result", "<?= $result; ?>", 1);
            document.location.href = "?p=gcategoria&cod=<?= $codProjeto ?>";
        </script>
        <?php
    } else {
        //Editando

        $result = "";
        if ($categoriaController->Alterar($categoria)) {
            $result = "e1";
        } else {
            $result = "e2";
        }
        ?>
        <script>
            setCookie("result", "<?= $result; ?>", 1);
            document.location.href = "?p=gcategoria&cod=<?= $codProjeto ?>";
        </script>
        <?php
    }
}

if ($codCategoria) {
    $categoria = $categoriaController->RetornaCategoriaCod($codCategoria);
    $editando = true;
    $nome = $categoria->getNome();
    $status = $categoria->getStatus();
}

$projeto = $projetoController->RetornarCod($codProjeto);
$listaCategorias = $categoriaController->RetornarTodosProjetoCod($codProjeto);
?>
<h1>Gerenciar categoria</h1>
<button id="btnNovaCategoria" class="btn btn-info">Nova Categoria</button>
<a href="?p=gvisualizaprojeto&cod=<?= $codProjeto; ?>" class="btn btn-dark">Voltar</a>
<br>
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
<br><br>
<div id="dvFrmCategoria" class="bg-gray" <?= ($editando ? "aqui" : "style='display: none;'"); ?>>
    <form method="post" id="frmGerenciaCategoria">
        <div>
            <div class="form-group grid-80 mobile-grid-100">
                <label for="txtNome">Nome</label>
                <input type="text" class="form-control" id="txtNome" name="txtNome"  placeholder="Implementar" value="<?= $nome; ?>">
            </div>

            <div class="form-group grid-20 mobile-grid-100">
                <label for="slStatus">Status</label>
                <select class="custom-select" id="slStatus" name="slStatus">
                    <option value="1" <?= $status == 1 ? "selected" : ""; ?>>Ativo</option>
                    <option value="2" <?= $status == 2 ? "selected" : ""; ?>>Bloqueado</option>
                </select>
            </div>
        </div>

        <div>
            <div class="form-group grid-60 mobile-grid-100">
                <div class="alert alert-warning" id="dvResult">Preencha corretamente todos os campos</div>
            </div>
            <div class="form-group grid-40 mobile-grid-100">
                <button type="submit" class="btn btn-success" id="btnCadastrar"><?= $editando ? "Editar" : "Cadastrar" ?></button>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <ul id="ulErros"></ul>
        </div>
    </form>
</div>
<h2>Consulta</h2>
<table class="table table-hover table-striped table-responsive-lg">
    <thead>
        <tr>
            <th>Nome</th>
            <th>Status</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($listaCategorias as $categoria) {
            ?>
            <tr>
                <td><?= $categoria->getNome(); ?></td>
                <td><?= $categoria->getStatus() == 1 ? "Ativo" : "Bloquado" ?></td>
                <td>
                    <a href='?p=gcategoria&cod=<?= $codProjeto; ?>&cat=<?= $categoria->getCod(); ?>' class='btn btn-warning'>Editar</a>
                </td>
            </tr>
            <?php
        }
        ?>
    </tbody>
</table>

<script>
    $(document).ready(function () {

        var result = getCookie("result");
        DeleteCookie("result");
        if (result == "c1") {
            ShowModal("Sucesso", "<span class='text-success'>Categoria cadastrada com sucesso.</span>");
        } else if (result == "c2") {
            ShowModal("Erro", "<span class='text-success'>Não foi possível cadastrar a categoria.</span>");
        } else if (result == "e1") {
            ShowModal("Sucesso", "<span class='text-success'>Categoria alterada com sucesso.</span>");
        } else if (result == "e2") {
            ShowModal("Erro", "<span class='text-success'>Não foi possível alterar a categoria.</span>");
        }

    });


    $("#btnNovaCategoria").click(function () {
        $("#dvFrmCategoria").slideToggle("slow");
    });

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

    $("#frmGerenciaCategoria").submit(function (event) {
        if (!Validar()) {
            event.preventDefault();
        }
    });

    function Validar() {
        var erros = 0;
        var ulErros = document.getElementById("ulErros");
        ulErros.innerHTML = "";

        if ($("#txtNome").val().length <= 2) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um nome válido. (min. 4 caracteres)";
            ulErros.appendChild(li);
            erros++;
        }

        if ($("#slStatus").val() < 1 || $("#slStatus").val() > 2) {
            var li = document.createElement("li");
            li.innerHTML = "- Selecione um status válido.";
            ulErros.appendChild(li);
            erros++;
        }

        if (erros == 0) {
            return true;
        } else {
            return false;
        }
    }
</script>
