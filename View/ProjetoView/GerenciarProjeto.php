<?php

use App\Model\Projeto;
use App\Controller\ProjetoController;
use App\Util\Upload;

$projetoController = new ProjetoController();

$nome = "";
$status = 1;
$descricao = "";
$editando = false;

$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

if (filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) {

    $projeto = new Projeto();
    $projeto->setCod($cod);
    $projeto->setData(date("Y-m-d H:i:s"));
    $projeto->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
    $projeto->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));
    $projeto->setDescricao(filter_input(INPUT_POST, "txtDescricao", FILTER_SANITIZE_SPECIAL_CHARS));
    $projeto->getUsuario()->setCod($_SESSION["cod"]);

    if (!$cod) {
        //Cadastrando

        $dirImage = "img/projetos/";

        $upload = new Upload();

        $nomeImagem = null;
        $erroUpload = false;

        if (isset($_FILES["flImagem"]) && $_FILES["flImagem"]["tmp_name"] != null) {
            $nomeImagem = $upload->LoadFile($dirImage, "img", $_FILES["flImagem"]);
            if ($nomeImagem == "") {
                $erroUpload = true;
            }
        }

        if (!$erroUpload) {

            $projeto->setThumb($nomeImagem);

            if ($projetoController->Cadastrar($projeto)) {
                ?>
                <script>
                    setCookie("result", "c1", 1);
                    document.location.href = "?p=gprojeto";
                </script>
                <?php
            } else {
                ?>
                <script>
                    setCookie("result", "c2", 1);
                    document.location.href = "?p=gprojeto";
                </script>
                <?php
            }
        } else {
            ?>
            <script>
                setCookie("result", "c3", 1);
                document.location.href = "?p=gprojeto";
            </script>
            <?php
        }
    } else {
        //Editando
    }
}

$listaProjeto = [];
$statusBusca = filter_input(INPUT_POST, "slBuscaStatus", FILTER_SANITIZE_NUMBER_INT);
if ($statusBusca) {
    $listaProjeto = $projetoController->RetornarTodosStatus($statusBusca);
}
?>
<h1>Gerenciar projeto</h1>
<button id="btnNovoProjeto" class="btn btn-info">Novo projeto</button>
<a href="?p=home" class="btn btn-dark">Voltar</a>
<br><br>
<div id="dvFrmProjeto" <?= ($editando ? "aqui" : "style='display: none;'"); ?>>
    <form method="post" id="frmGerenciaProjeto" enctype="multipart/form-data">
        <input type="hidden" id="txtEditando" value="<?= ($editando ? "1" : "0"); ?>" />
        <div>
            <div class="form-group grid-40 mobile-grid-100">
                <label for="txtNome">Nome</label>
                <input type="text" class="form-control" id="txtNome" name="txtNome"  placeholder="Controle de projetos" value="<?= $nome; ?>">
            </div>

            <div class="form-group grid-20 mobile-grid-100">
                <label for="slStatus">Status</label>
                <select class="custom-select" id="slStatus" name="slStatus">
                    <option value="1" <?= $status == 1 ? "selected" : ""; ?>>Ativo</option>
                    <option value="2" <?= $status == 2 ? "selected" : ""; ?>>Bloqueado</option>
                </select>
            </div>

            <div class="grid-40 mobile-grid-100">
                <label for="flImagem">Imagem (png e jpg)</label>
                <input type="file" class="form-control-file" name="flImagem" id="flImagem" <?= !$editando ? "" : "disabled='true'" ?>>
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


<div id="dvConsulta">
    <h2>Consultar</h2>
    <form id="slBuscaStatus" method="post" action="#dvConsulta">
        <div class="form-group">
            <label for="slBuscaStatus">Status</label>
            <select class="custom-select" id="slBuscaStatus" name="slBuscaStatus">
                <option <?= $statusBusca == false ? "selected" : "" ?>>Selecione</option>
                <option value="1" <?= $statusBusca == 1 ? "selected" : "" ?>>Ativo</option>
                <option value="2" <?= $statusBusca == 2 ? "selected" : "" ?>>Bloqueado</option>
            </select>
        </div>
    </form>
    <table class="table table-hover table-striped table-responsive-lg">
        <thead>
            <tr>
                <th>Nome</th>
                <th>Criado por</th>
                <th>Data</th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php
            foreach ($listaProjeto as $projeto) {
                ?>
                <tr>
                    <td><?=$projeto->getNome();?></td>
                    <td><?=$projeto->getUsuarioNome();?></td>
                    <td><?=date("d/m/Y H:i:s", strtotime($projeto->getData()));?></td>
                    <td>
                        <a href='?p=gprojeto&cod=<?=$projeto->getCod();?>' class='btn btn-warning'>Editar</a>
                        <a href='?p=gvisualizaprojeto&cod=<?=$projeto->getCod();?>' class='btn btn-info'>Visualizar</a>
                    </td>
                </tr>
                <?php
            }
            ?>
        </tbody>
    </table>
</div>
<script src="ckeditor/ckeditor.js" type="text/javascript"></script>
<script>

                $(document).ready(function () {
                    CKEDITOR.replace("txtDescricao");

                    var result = getCookie("result");
                    DeleteCookie("result");
                    if (result == "c1") {
                        ShowModal("Sucesso", "<span class='text-success'>Projeto cadastrado com sucesso.</span>");
                    } else if (result == "c2") {
                        ShowModal("Erro", "<span class='text-success'>Não foi possível cadastrar o Projeto.</span>");
                    } else if (result == "c2") {
                        ShowModal("Erro", "<span class='text-success'>Não foi possível fazer o upload da imagem.</span>");
                    }
                });

                $("#slBuscaStatus").change(function () {
                    $("#slBuscaStatus").submit();
                });

                $("#frmGerenciaProjeto").submit(function (event) {
                    if (!Validar()) {
                        event.preventDefault();
                    }
                });

                $("#btnNovoProjeto").click(function () {
                    $("#dvFrmProjeto").toggle("slow");
                });

                function Validar() {
                    var erros = 0;
                    var ulErros = document.getElementById("ulErros");
                    ulErros.innerHTML = "";

                    if ($("#txtNome").val().length <= 3) {
                        var li = document.createElement("li");
                        li.innerHTML = "- Informe um nome válido. (min. 4 caracteres)";
                        ulErros.appendChild(li);
                        erros++;
                    }

                    var value = CKEDITOR.instances['txtDescricao'].getData();
                    if (value.length <= 5) {
                        var li = document.createElement("li");
                        li.innerHTML = "- Informe uma descrição. (min. 6 caracteres)";
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