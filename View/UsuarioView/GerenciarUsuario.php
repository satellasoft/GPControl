<?php

use App\Controller\UsuarioController;
use App\Model\Usuario;

$usuarioController = new UsuarioController();

$nome = "";
$email = "";
$status = 1;
$permissao = 2;
$editando = false;

if (filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING)) {
    $usuario = new Usuario();

    $usuario->setCod(filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT));
    $usuario->setNome(filter_input(INPUT_POST, "txtNome", FILTER_SANITIZE_STRING));
    $usuario->setEmail(filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING));
    $usuario->setSenha(filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING));
    $usuario->setPermissao(filter_input(INPUT_POST, "slPermissao", FILTER_SANITIZE_NUMBER_INT));
    $usuario->setStatus(filter_input(INPUT_POST, "slStatus", FILTER_SANITIZE_NUMBER_INT));

    if (!filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT)) {
        //Cadastrar
        if ($usuarioController->Cadastrar($usuario)) {
            ?>
            <script>
                ShowModal("Sucesso", "<span class='text-success'>Usuário cadastrado com sucesso.</span>");
            </script>
            <?php
        } else {
            ?>
            <script>
                ShowModal("Erro", "<span class='text-success'>Não foi possível cadastrar o usuário.</span>");
            </script>
            <?php
        }
    } else {
        //Editar
    }
}
?>

<h1>Gerenciar usuário</h1>
<button id="btnNovoUsuario" class="btn btn-info">Novo usuário</button>
<a href="?p=home" class="btn btn-dark">Voltar</a>
<br><br>
<div id="dvFormUsuario" <?= ($editando ? "aqui" : "style='display: none;'"); ?>>
    <form method="post" id="frmGerenciaUsuario">
        <input type="hidden" id="txtEditando" value="<?= ($editando ? "1" : "0"); ?>" />
        <div>
            <div class="form-group grid-50 mobile-grid-100">
                <label for="txtNome">Nome completo</label>
                <input type="text" class="form-control" id="txtNome" name="txtNome"  placeholder="João Dias" value="<?= $nome; ?>">
            </div>

            <div class="form-group grid-50 mobile-grid-100">
                <label for="txtEmail">E-mail</label>
                <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="email@dominio.com" value="<?= $email; ?>">
            </div>
        </div>

        <div>
            <div class="form-group grid-40 mobile-grid-100">
                <label for="txtSenha">Senha</label>
                <input type="text" class="form-control" id="txtSenha" name="txtSenha"  placeholder="*********" <?= ($editando ? "disabled='true'" : ""); ?>>
            </div>

            <div class="form-group grid-20 mobile-grid-100">
                <label for="slStatus">Status</label>
                <select class="custom-select" id="slStatus" name="slStatus">
                    <option value="1" <?= $status == 1 ? "selected" : ""; ?>>Ativo</option>
                    <option value="2" <?= $status == 2 ? "selected" : ""; ?>>Bloqueado</option>
                </select>
            </div>

            <div class="form-group grid-40 mobile-grid-100">
                <label for="slPermissao">Permissão</label>
                <select class="custom-select" id="slPermissao" name="slPermissao">
                    <option value="1" <?= $permissao == 1 ? "selected" : ""; ?>>Administrador</option>
                    <option value="2" <?= $permissao == 2 ? "selected" : ""; ?>>Comum</option>
                </select>
            </div>
        </div>
        <div>
            <div class="form-group grid-60 mobile-grid-100">
                <div class="alert alert-warning" id="dvResult">Preencha corretamente todos os campos</div>
            </div>
            <div class="form-group grid-40 mobile-grid-100">
                <button type="submit" class="btn btn-success"><?= $editando ? "Editar" : "Cadastrar" ?></button>
            </div>
            <div class="clear"></div>
        </div>
        <div>
            <ul id="ulErros"></ul>
        </div>
    </form>
</div>
<script src="js/gerencia-usuario-script.js" type="text/javascript"></script>