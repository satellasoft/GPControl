<?php

use App\Controller\UsuarioController;

$uarioController = new UsuarioController();
$cod = filter_input(INPUT_GET, "cod", FILTER_SANITIZE_NUMBER_INT);
?>
<h1>Permissões do projeto</h1>
<a href="?p=gvisualizaprojeto&cod=<?= $cod; ?>" class="btn btn-dark">Voltar</a>
<br><br>
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
    </div>
</div>
<div class="clear"></div>
<script src="<?= $base; ?>js/gerenciar-projeto-script.js" type="text/javascript"></script>