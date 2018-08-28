<?php

use App\Controller\CategoriaController;
use App\Controller\ModuloController;
use App\Model\ViewModel\ModuloView\ModuloView;

$pCod = filter_input(INPUT_GET, "pcod", FILTER_SANITIZE_NUMBER_INT); //Código do projeto
$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT); //Código do módulo

$categoriaController = new CategoriaController();
$moduloController = new ModuloController();

$listaCategorias = $categoriaController->RetornarTodosProjetoCod(intval($pCod));

$titulo = "";
$status = 1;
$categoriaCod = "";
$descricao = "";
$editando = false;

if (filter_input(INPUT_POST, "txtTitulo", FILTER_SANITIZE_STRING)) {
    $moduloView = new ModuloView();
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
    }
}
?>

<h1>Gerenciar módulo</h1>
<button id="btnNovoModulo" class="btn btn-info">Novo módulo</button>
<a href="?p=mprojeto" class="btn btn-dark">Voltar</a>
<br><br>
<div id="dvFrmModulo" <?= ($editando ? "aqui" : "style='display: none;'"); ?>>
    <form method="post" id="frmGerenciarModulo">
        <input type="hidden" id="txtEditando" value="<?= ($editando ? "1" : "0"); ?>" />
        <div>
            <div class="form-group grid-60 mobile-grid-100">
                <label for="txtNome">Título</label>
                <input type="text" class="form-control" id="txtTitulo" name="txtTitulo"  placeholder="Problemas ao gerar um novo certificado" value="<?= $titulo; ?>">
            </div>

            <div class="form-group grid-20 mobile-grid-100">
                <label for="slStatus">Status</label>
                <select class="custom-select" id="slStatus" name="slStatus">
                    <option value="1" <?= $status == 1 ? "selected" : ""; ?>>Ativo</option>
                    <option value="2" <?= $status == 2 ? "selected" : ""; ?>>Bloqueado</option>
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
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script>
            $(document).ready(function () {
                CKEDITOR.replace("txtDescricao");
                $("#btnNovoModulo").click(function () {
                    $("#dvFrmModulo").toggle("slow");
                });

                var result = getCookie("result");
                DeleteCookie("result");
                if (result == "c1") {
                    ShowModal("Sucesso", "<span class='text-success'>Módulo criado com sucesso.</span>");
                } else if (result == "c2") {
                    ShowModal("Erro", "<span class='text-success'>Não foi possível criar um novo módulo.</span>");
                } else if (result == "c3") {
                    ShowModal("Erro", "<span class='text-success'>Não foi possível fazer o upload da imagem.</span>");
                } else if (result == "e1") {
                    ShowModal("Sucesso", "<span class='text-success'>Projeto alterado com sucesso.</span>");
                } else if (result == "e2") {
                    ShowModal("Erro", "<span class='text-success'>Não foi possível alterar o Projeto.</span>");
                }
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