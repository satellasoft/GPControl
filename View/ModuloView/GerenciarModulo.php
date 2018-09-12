<?php

use App\Controller\CategoriaController;
use App\Controller\ModuloController;
use App\Controller\ProjetoController;
use App\Model\ViewModel\ModuloView\ModuloView;
use App\Model\ViewModel\ModuloView\ModuloConsultaView;

$pCod = filter_input(INPUT_GET, "pcod", FILTER_SANITIZE_NUMBER_INT); //Código do projeto
$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT); //Código do módulo

$categoriaController = new CategoriaController();
$moduloController = new ModuloController();
$projetoController = new ProjetoController();

$usuarioCod = intval($_SESSION["cod"]);
$titulo = "";
$status = 1;
$categoriaCod = "";
$descricao = "";
$editando = false;
$result = "Preencha corretamente todos os campos";

if (filter_input(INPUT_POST, "txtTitulo", FILTER_SANITIZE_STRING)) {
    $moduloView = new ModuloView();

    $moduloView->setCod($cod);
    $moduloView->setTitulo(filter_input(INPUT_POST, "txtTitulo", FILTER_SANITIZE_STRING));
    $moduloView->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $moduloView->setDescricao(filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_SPECIAL_CHARS));

    $moduloView->setCategoriaCod(filter_input(INPUT_POST, "slCategoria", FILTER_SANITIZE_NUMBER_INT));
    $moduloView->setProjetoCod($pCod);
    $moduloView->setUsuarioCod(intval($_SESSION["cod"]));

    if (!$cod) {
        //Cadastrar
        $result = "c1";
        if (!$moduloController->Cadastrar($moduloView)) {
            $result = "c2";
        }
        ?>
        <script>
            setCookie("result", "<?= $result; ?>", 1);
            document.location.href = "?p=modulo&pcod=<?= $pCod ?>";
        </script>
        <?php
    } else {
        //Editar
        $result = "e1";
        if (!$moduloController->Alterar($moduloView)) {
            $result = "e2";
        }
        ?>
        <script>
            setCookie("result", "<?= $result; ?>", 1);
            document.location.href = "?p=modulo&pcod=<?= $pCod ?>";
        </script>
        <?php
    }
}

//Lista de busca
$listaModulo = [];
if (filter_input(INPUT_POST, "slStatusBusca")) {
    $listaModulo = $moduloController->BuscarModulo(
            filter_input(INPUT_POST, "txtTituloBusca", FILTER_SANITIZE_STRING), filter_input(INPUT_POST, "slStatusBusca", FILTER_SANITIZE_NUMBER_INT), filter_input(INPUT_POST, "slCategoriaBusca", FILTER_SANITIZE_NUMBER_INT), filter_input(INPUT_POST, "slQuantidadeBusca", FILTER_SANITIZE_NUMBER_INT));
} else {
    $listaModulo = $moduloController->BuscarModulo("", 1, 1, 10);
}

//Lista de categorias
$listaCategorias = $categoriaController->RetornarTodosProjetoCod(intval($pCod));


//Retorna as informações do projeto
$projeto = $projetoController->RetornarCod($pCod);

if ($cod) {
    $modulo = $moduloController->RetornaCod($usuarioCod, $cod);
    $editando = true;

    if ($modulo->getTitulo() != null) {
        $titulo = $modulo->getTitulo();
        $status = $modulo->getStatus();
        $categoriaCod = $modulo->getCategoriacod();
        $descricao = $modulo->getDescricao();
    } else {
        $result = "Não foi possível carregar as informações do módulo";
    }
}
?>

<h1>Gerenciar módulo</h1>
<button id="btnNovoModulo" class="btn btn-info">Novo módulo</button>
<button id="btnBuscarModulos" class="btn btn-info">Buscar módulos</button>
<a href="?p=mprojeto" class="btn btn-dark">Voltar</a>
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

<div id="dvFrmModulo" <?= ($editando ? "aqui" : "style='display: none;'"); ?>>
    <form method="post" id="frmGerenciarModulo">
        <input type="hidden" id="txtEditando" value="<?= ($editando ? "1" : "0"); ?>" />
        <div>
            <div class="form-group grid-60 mobile-grid-100">
                <label for="txtTitulo">Título</label>
                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo"  placeholder="Problemas ao gerar um novo certificado" value="<?= $titulo; ?>">
            </div>

            <div class="form-group grid-20 mobile-grid-100">
                <label for="slStatus">Status</label>
                <select class="custom-select" id="slStatus" name="slStatus">
                    <option value="1" <?= $status == 1 ? "selected" : ""; ?>>Ativo</option>
                </select>
            </div>

            <div class="form-group grid-20 mobile-grid-100">
                <label for="slCategoria">Categoria</label>
                <select class="custom-select" id="slCategoria" name="slCategoria">
                    <?php
                    foreach ($listaCategorias as $categoria) {
                        ?>
                        <option value="<?= $categoria->getCod(); ?>" <?= $categoriaCod == $categoria->getCod() ? "selected" : ""; ?>><?= $categoria->getNome(); ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
        </div>

        <div>
            <div class="form-group grid-100">
                <textarea id="txtDescricao" name="txtDescricao"><?= $descricao; ?></textarea>
            </div>
        </div>

        <div>
        </div>
        <div>
            <div class="form-group grid-60 mobile-grid-100">
                <div class="alert alert-warning" id="dvResult"><?= $result; ?></div>
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
<hr>

<div id="dvBuscarModulos">
    <h2>Buscar</h2>
    <form method="post" id="frmBuscar">
        <div class="form-group grid-40 mobile-grid-100">
            <label for="txtTituloBusca">Título</label>
            <input type="text" class="form-control" id="txtTituloBusca" name="txtTituloBusca" >
        </div>

        <div class="form-group grid-20 mobile-grid-100">
            <label for="slQuantidadeBusca">Quantidade</label>
            <select class="custom-select" id="slQuantidadeBusca" name="slQuantidadeBusca">
                <option value="10" selected>10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>
                <option value="150">150</option>
                <option value="200">200</option>
            </select>
        </div>

        <div class="form-group grid-20 mobile-grid-100">
            <label for="slStatusBusca">Status</label>
            <select class="custom-select" id="slStatusBusca" name="slStatusBusca">
                <option value="1" <?= $status == 1 ? "selected" : ""; ?>>Ativo</option>
                <option value="2" <?= $status == 2 ? "selected" : ""; ?>>Resolvido</option>
            </select>
        </div>

        <div class="form-group grid-20 mobile-grid-100">
            <label for="slCategoriaBusca">Categoria</label>
            <select class="custom-select" id="slCategoriaBusca" name="slCategoriaBusca">
                <?php
                foreach ($listaCategorias as $categoria) {
                    ?>
                    <option value="<?= $categoria->getCod(); ?>" <?= $categoriaCod == $categoria->getCod() ? "selected" : ""; ?>><?= $categoria->getNome(); ?></option>
                    <?php
                }
                ?>
            </select>
        </div>

        <div class="form-group grid-100 mobile-grid-100">
            <button type="submit" class="btn btn-success" id="btnBuscar">Buscar</button>
        </div>
    </form>
</div>
<hr>
<table class="table table-hover table-striped table-responsive-lg">
    <thead>
        <tr>
            <th>Título</th>
            <th>Usuário</th>
            <th>Data publicação</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (!is_null($listaModulo)) {
            foreach ($listaModulo as $modulo) {
                ?>
                <tr>
                    <td><?= $modulo->getTitulo(); ?></td>
                    <td><?= $modulo->getUsuarioNome(); ?></td>
                    <td><?= date("d/m/Y H:i:s", strtotime($modulo->getData())); ?></td>
                    <td>
                        <?php
                        if ($modulo->getUsuarioCod() == $usuarioCod && $modulo->getStatus() == 1) {
                            ?>
                            <a href='?p=modulo&pcod=<?= $pCod; ?>&cod=<?= $modulo->getCod(); ?>' class='btn btn-warning'>Editar</a>
                            <?php
                        }
                        ?>
                        <a href='?p=visualizarmodulo&cod=<?= $modulo->getCod(); ?>' class='btn btn-primary' target="_blank">Visualizar</a>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
    $(document).ready(function () {
        CKEDITOR.replace("txtDescricao");
        $("#dvBuscarModulos").hide("slow");

        $("#btnNovoModulo").click(function () {
            $("#dvFrmModulo").toggle("slow");
        });

        $("#btnBuscarModulos").click(function () {
            $("#dvBuscarModulos").toggle("slow");
        });

        var result = getCookie("result");
        DeleteCookie("result");
        if (result == "c1") {
            ShowModal("Sucesso", "<span class='text-success'>Módulo criado com sucesso.</span>");
        } else if (result == "c2") {
            ShowModal("Erro", "<span class='text-success'>Não foi possível criar um novo módulo.</span>");
        } else if (result == "e1") {
            ShowModal("Sucesso", "<span class='text-success'>Módulo alterado com sucesso.</span>");
        } else if (result == "e2") {
            ShowModal("Erro", "<span class='text-success'>Não foi possível alterar o Módulo.</span>");
        }

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
    });

    $("#frmGerenciarModulo").submit(function (event) {
        if (!Validar()) {
            event.preventDefault();
        }
    });

    function Validar() {
        var erros = 0;
        var ulErros = document.getElementById("ulErros");
        ulErros.innerHTML = "";

        if ($("#txtTitulo").val().length < 5 || $("#txtTitulo").val().length > 200) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe um título válido. (min. 5 e max. 200 caracteres)";
            ulErros.appendChild(li);
            erros++;
        }

        if ($("#slCategoria").val() == "") {
            var li = document.createElement("li");
            li.innerHTML = "- Selecione uma categoria";
            ulErros.appendChild(li);
            erros++;
        }

        var value = CKEDITOR.instances['txtDescricao'].getData();
        if (value.length < 5) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma descrição. (min. 5 caracteres)";
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