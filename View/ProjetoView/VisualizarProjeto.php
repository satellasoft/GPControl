<?php

use App\Controller\ProjetoController;
use App\Util\Upload;

$projetoController = new ProjetoController();
$cod = (int) filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);

if (filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT)) {
    $codProjeto = filter_input(INPUT_POST, "txtCod", FILTER_SANITIZE_NUMBER_INT);
    $imagemAntiga = filter_input(INPUT_POST, "txtImagemAntiga", FILTER_SANITIZE_STRING);

    $upload = new Upload();

    $dirImage = "img/projetos/";
    $nomeImagem = $upload->LoadFile($dirImage, "img", $_FILES["flImagem"], true);
    $result = "";
    //echo "TESTE: ". $nomeImagem;
    if ($nomeImagem != "") {
        
        //################################################################
        if ($projetoController->AlterarImagem($nomeImagem, $codProjeto)) {
            $result = "e1";
            $img = $imagemAntiga;
            if (file_exists($img)) {
                unlink($img);
            }
        } else {
            $img = ("{$dirImage}/{$nomeImagem}");
            if (file_exists($img)) {
                unlink($img);
            }
            $result = "e2"; //Erro ao tentar alterar 
        }
    } else {
        $result = "e3"; //Não carregou
    }
    ?>
    <script>
        setCookie("result", "<?= $result; ?>", 1);
      document.location.href = "?p=gvisualizaprojeto&cod=<?= $cod; ?>";
    </script>
    <?php
}

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
            <a href="#" class="btn btn-info" style="width:100%; margin-top:10px;" data-toggle="modal" data-target="#modalAlterarImagem">Alterar imagem</a>
            <a href='?p=gprojeto&cod=<?= $cod; ?>' class='btn btn-warning'style="width:100%; margin-top:10px;">Editar</a>
            <hr>
            <a href='?p=gpermissao&cod=<?= $cod; ?>' class='btn btn-dark'style="width:100%; margin-top:10px;">Permissões</a>
            <a href='?p=gcategoria&cod=<?= $cod; ?>' class='btn btn-success'style="width:100%; margin-top:10px;">Categorias</a>
        </div>

        <div class="grid-70 mobile-grid-100">
            <p><span class='bold'>Criado por: </span><?= $projeto->getUsuarioNome(); ?></p>
            <p><span class='bold'>Data: </span><?= date("d/m/Y H:i:s", strtotime($projeto->getData())); ?></p>
            <p><span class='bold'>Status: </span><?= $projeto->getStatus() == 1 ? "Ativo" : "Bloqueado"; ?></p>
            <div style='word-wrap: break-word'>
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

<div class="modal fade" id="modalAlterarImagem" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="post" enctype="multipart/form-data" id='frmAlteraImagem'>
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Alterar imagem</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div>
                        <div class="grid-100">
                            <label for="flImagem">Imagem (png e jpg)</label>
                            <input type="file" class="form-control-file" name="flImagem" id="flImagem">
                            <input type="hidden" name='txtImagemAntiga' value='<?= ($projeto->getThumb() == null ? "" : "img/projetos/{$projeto->getThumb()}") ?>' />
                            <input type="hidden" name="txtCod" value="<?= $cod; ?>" />
                        </div>
                        <br>
                        <div class="grid-100">
                            <img id="blah" src="<?= ($projeto->getThumb() == null ? "img/icones/noimage.png" : "img/projetos/{$projeto->getThumb()}") ?>" alt="your image" style="width:100%; max-width:450px;"/>
                        </div>
                        <div class="clear"></div>
                        <br>
                        <div class="grid-100">
                            <div class='alert alert-warning' id='alertImage'>&nbsp;</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Fechar</button>
                    <button type="submit" class="btn btn-primary">Alterar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    function readURL(input) {

        if (input.files && input.files[0]) {
            var reader = new FileReader();

            reader.onload = function (e) {
                $('#blah').attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }
    }

    $("#flImagem").change(function () {
        readURL(this);
    });

    $("#frmAlteraImagem").submit(function (event) {
        if (!validaImagem()) {
            event.preventDefault();
            $("#alertImage").text("Carregue uma imagem para alterar.");
        }
    });

    function validaImagem() {
        if ($("#flImagem").val() != "") {
            return true;
        } else {
            return false;
        }
    }

    $(document).ready(function () {
        var result = getCookie("result");
        DeleteCookie("result");
        if (result == "e1") {
            ShowModal("Sucesso", "<span class='text-success'>Imagem alterada com sucesso.</span>");
        } else if (result == "e2") {
            ShowModal("Erro", "<span class='text-success'>Não foi possível alterar a imagem.</span>");
        } else if (result == "e3") {
            ShowModal("Erro", "<span class='text-success'>Não foi possível carregar a imagem.</span>");
        }
    });
</script>