<?php

use App\Controller\ModuloController;
use App\Controller\RespostaController;
use App\Model\ViewModel\RespostaView\RespostaView;
use App\Util\MailSend;

$sendMailNotification = true;

$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT); //Módulo cod
$usuarioCod = intval($_SESSION["cod"]);

$moduloController = new ModuloController();
$respostaController = new RespostaController();

$modulo = $moduloController->RetornarCompletoCod(intval($cod));


//Começo Cadastro
if (filter_input(INPUT_POST, "txtResposta")) {
    $respostaView = new RespostaView();
    $respostaView->setDescricao(filter_input(INPUT_POST, "txtResposta", FILTER_SANITIZE_SPECIAL_CHARS));
    $respostaView->setUsuarioCod($usuarioCod);
    $respostaView->setModuloCod($cod);

    $result = "c2";
    if ($respostaController->Cadastrar($respostaView)) {
        $result = "c1";

        if ($sendMailNotification) {

            $emails = $respostaController->RetornarEmailsResposta($cod);

            if (count($emails) > 1) {
                $mailSend = new MailSend();
                $titulo = "Novo comentário em {$modulo->getTitulo()}.";
                $mailSend->SendMessageMultipleUser($emails, $modulo->getTitulo(), filter_input(INPUT_POST, "txtResposta", FILTER_SANITIZE_SPECIAL_CHARS), $titulo);
            }
        }
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
            <span class="bold">Status: </span> <?= $modulo->getStatus() == 2 ? "<span class='resolvido'>Resolvido</span>" : "Ativo" ?>
            <span class="bold">Categoria: </span> <?= $modulo->getCategoriaNome(); ?>             
        </p>

        <div>
            <?= html_entity_decode($modulo->getDescricao()); ?> 
        </div>

        <!--Exibe o formulário de resposta.-->
        <?php
        if ($usuarioCod == $modulo->getusuarioCod() && $modulo->getStatus() == 1) {
            ?>
            <button id="btnComentar" class="btn btn-outline-dark">Comentar</button>
            <button class="btn btn-outline-danger" onclick="MarcarComoResolvido();" id="btnResolvido">Marcar como resolvido</button>
            <input type="hidden" id="txtUserCod" value="<?= $usuarioCod; ?>" />
            <input type="hidden" id="txtModuloCod" value="<?= $cod; ?>" />

            <div id="dvFormulario">
                <form method="post" id="frmResposta">
                    <textarea id="txtResposta" name="txtResposta"></textarea>
                    <button type="submit" class="btn btn-success" style="margin-top: 5px;">Responder</button>
                </form>
            </div>
            <br>    <br>
            <?php
        }
        ?>
        <!--Conteúdo para mostrar os comentários resposta do módulos.-->
        <div id="dvComentarios">
            <!------>
            <?php
            if ($listaResposta != null) {
                foreach ($listaResposta as $resposta) {
                    ?>
                    <div class="card">
                        <div class="card-header text-white bg-primary" style="width:100%;">
                            <span>#<?= $resposta->getCod(); ?></span> <span class="bold"><?= $resposta->getUsuarioNome(); ?></span> comentado em <span class="bold"><?= date("d/m/Y H:i:s", strtotime($resposta->getData())); ?></span> 
                        </div>
                        <div class="card-body break">
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
    <script src="<?= $base; ?>js/highlight/highlight.pack.js"></script>
    <script src="<?= $base; ?>ckeditor/ckeditor.js"></script>
    <script src="<?= $base; ?>js/gerenciar-modulo-script.js"></script>

    <script>hljs.initHighlightingOnLoad();</script>
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