<?php
require_once("App/Util/autoloader.php");
session_start();

if (!isset($_SESSION["cod"]) || !isset($_SESSION["permissao"])) {
    header("Location: index.php?m=1");
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Gerenciador de projetos</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <link href="css/unsemantic-grid-responsive.min.css" rel="stylesheet"/>
        <link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
        <link rel="shortcut icon" href="img/favicon.ico" />
    </head>
    <body>
        <div class="maxWidth content">
            <header>
                <div class="padding border-5-bottom">
                    <div class="grid-50">
                        <a href="?p=home"><img src="img/logo.png" alt="Logo da empresa" class="logo"/></a>
                    </div>

                    <div class="grid-50 text-right hide-on-mobile small-font">
                        <p class="margin-2"><span class="bold">Telefone:</span> (018) 00000-0000</p>
                        <p class="margin-2"><span class="bold">E-mail:</span> <a href="mailto:gunnercorrea@gmail.com">gunnercorrea@gmail.com</a></p>
                        <p class="margin-2"><span class="bold">Site:</span> <a href="https://www.satellasoft.com" target="_blank">www.satellasoft.com</a></p>
                    </div>
                    <div class="clear"></div>
                </div>
            </header>

<!--            <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
            <script src="js/Jquery.js" type="text/javascript"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
            <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
            <script src="js/script.js"></script>
            <main class="maxHeight padding-larger">
                <?php require_once("App/Util/RequestPage.php") ?>            
            </main>

            <footer class="footer">
                <div class="padding">
                    <div class="grid-50">
                        <p>&copy SatellaSoft 2009 - <?= date("Y") ?>, Todos os Direitos Reservados</p>
                    </div>

                    <div class="grid-50">
                        <p class="margin-2"><span class="bold">Telefone:</span> (018) 00000-0000</p>
                        <p class="margin-2"><span class="bold">E-mail:</span> <a href="mailto:gunnercorrea@gmail.com">gunnercorrea@gmail.com</a></p>
                        <p class="margin-2"><span class="bold">Site:</span> <a href="https://www.satellasoft.com" target="_blank">www.satellasoft.com</a></p>
                    </div>
                    <div class="clear"></div>
                </div>
            </footer>
        </div>

        <div class="modal fade" id="modalResult" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalContentTitle"></h5>
                    </div>
                    <div class="modal-body" id="modalContent">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
<!--
Icones from: https://www.flaticon.com
-->