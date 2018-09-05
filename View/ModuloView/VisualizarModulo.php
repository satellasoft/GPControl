<?php

use App\Controller\ModuloController;
use App\Controller\RespostaController;
use App\Model\ViewModel\RespostaView\RespostaView;

$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT); //Módulo cod
$moduloController = new ModuloController();
$respostaController = new RespostaController();

$modulo = $moduloController->RetornarCompletoCod(intval($cod));


//Começo Cadastro
if (filter_input(INPUT_POST, "txtResposta")) {
    $respostaView = new RespostaView();
    $respostaView->setDescricao(filter_input(INPUT_POST, "txtResposta", FILTER_SANITIZE_SPECIAL_CHARS));
    $respostaView->setUsuarioCod(intval($_SESSION["cod"]));
    $respostaView->setModuloCod($cod);

    $result = "c2";
    if ($respostaController->Cadastrar($respostaView)) {
        $result = "c1";
    }
    ?>
    <script>
        setCookie("result", "<?= $result; ?>", 1);
        document.location.href = "?p=visualizarmodulo&cod=<?= $cod ?>";
    </script>
    <?php
}
//Fim Cadastro

$listaResposta = $respostaController->RetornarTodosModuloCod($cod);


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
        <button id="btnComentar" class="btn btn-outline-dark">Comentar</button>
        <div id="dvFormulario">
            <form method="post" id="frmResposta">
                <textarea id="txtResposta" name="txtResposta"></textarea>
                <button type="submit" class="btn btn-success" style="margin-top: 5px;">Responder</button>
            </form>
        </div>
        <br>    <br>
        <!--Conteúdo para mostrar os comentários resposta do módulos.-->
        <div id="dvComentarios">
            <!------>
            <?php
            if ($listaResposta != null) {
                foreach ($listaResposta as $resposta) {
                    ?>
                    <div class="card">
                        <div class="card-header text-white bg-primary" style="width:100%;">
                            <span class="bold"><?= $resposta->getUsuarioNome(); ?></span> comentado em <span class="bold"><?= date("d/m/Y H:i:s", strtotime($resposta->getData())); ?></span> 
                        </div>
                        <div class="card-body">
                            <?= html_entity_decode($resposta->getDescricao()); ?>
                        </div>
                    </div>
            <hr>
                    <?php
                }
            }
            ?>
            <!------>
        </div>
    </div>
    <script src="<?= $base; ?>ckeditor/ckeditor.js" type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            CKEDITOR.replace("txtResposta");
            $("#dvFormulario").hide();

            var result = getCookie("result");
            DeleteCookie("result");
            if (result == "c1") {
                ShowModal("Sucesso", "<span class='text-success'>Resposta enviada com sucesso.</span>");
            } else if (result == "c2") {
                ShowModal("Erro", "<span class='text-success'>Não foi possível enviar a sua resposta.</span>");
            }

            $("#btnComentar").click(function () {
                $("#btnComentar").hide();
                $("#dvFormulario").toggle("fast");
            });


            //Enviar o formulário
            $("#frmResposta").submit(function (e) {
                if (!ValidarComentario()) {
                    e.preventDefault();
                    ShowModal("Inválido", "<span class='text-warning'>Seu comentário deve conter no minímo 5 caracteres.</span>");
                }
            });
        });

        function ValidarComentario() {
            var valido = true;
            var value = CKEDITOR.instances['txtResposta'].getData();
            if (value.length <= 5) {
                valido = false;
            }
            return valido;
        }
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