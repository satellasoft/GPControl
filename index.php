<?php
session_start();
require_once("App/Util/autoloader.php");

use App\Controller\UsuarioController;

$retorno = "";

$m = filter_input(INPUT_GET, "m", FILTER_SANITIZE_NUMBER_INT);

if ($m == 1) {
    $retorno = "<div class='alert-warning'>Faça o login para acessar o painel</div>";
} elseif ($m == 2) {
    $retorno = "<div class='alert-info'>Você fez o logout</div>";
}


if (filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING)) {
    $usuarioController = new UsuarioController();
    $arr = $usuarioController->Autenticar(filter_input(INPUT_POST, "txtEmail", FILTER_SANITIZE_STRING), filter_input(INPUT_POST, "txtSenha", FILTER_SANITIZE_STRING));

    if (!is_null($arr)) {
        $retorno = "<div class='alert-success'>Redirecionando</div>";
        $_SESSION["cod"] = $arr["cod"];
        $_SESSION["permissao"] = $arr["permissao"];
        
        
        header("Location: painel.php");
    } else {
        $retorno = "<div class='alert-warning'>E-mail ou senha inválido</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="UTF-8">
        <title>Login</title>
        <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet" />
        <script src="js/Jquery.js" type="text/javascript"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
        <link rel="shortcut icon" href="img/favicon.ico" />
        <style>
            body#LoginForm{ 
                background-image: url("img/blur-wallpaper.jpg"); 
                background-position:center; 
                background-size:cover; 
                padding:10px;
                background-repeat: no-repeat;
                background-attachment: fixed;
            }

            .form-heading { color:#fff; font-size:23px;}
            .panel h2{ color:#444444; font-size:18px; margin:0 0 8px 0;}
            .panel p { color:#777777; font-size:14px; margin-bottom:30px; line-height:24px;}
            .login-form .form-control {
                background: #f7f7f7 none repeat scroll 0 0;
                border: 1px solid #d4d4d4;
                border-radius: 4px;
                font-size: 14px;
                height: 50px;
                line-height: 50px;
            }
            .main-div {
                background: #ffffff none repeat scroll 0 0;
                border-radius: 2px;
                margin: 10px auto 30px;
                max-width: 500px;
                width:100%;
                padding: 50px 10px 70px 10px;
            }

            .login-form .form-group {
                margin-bottom:10px;
            }
            .login-form{ text-align:center;}
            .forgot a {
                color: #777777;
                font-size: 14px;
                text-decoration: underline;
            }
            .login-form  .btn.btn-primary {
                background: #f0ad4e none repeat scroll 0 0;
                border-color: #f0ad4e;
                color: #ffffff;
                font-size: 14px;
                width: 100%;
                height: 50px;
                line-height: 50px;
                padding: 0;
            }
            .forgot {
                text-align: left; margin-bottom:30px;
            }
            .botto-text {
                color: #ffffff;
                font-size: 14px;
                margin: auto;
            }
            .login-form .btn.btn-primary.reset {
                background: #ff9900 none repeat scroll 0 0;
            }
            .back { text-align: left; margin-top:10px;}
            .back a {color: #444444; font-size: 13px;text-decoration: none;}

        </style>
    </head>
    <body id="LoginForm">
        <div class="container">
            <div class="login-form">
                <div class="main-div">
                    <div class="panel">
                        <h2>Login</h2>
                        <p>Por favor, informe o seu e-mail e senha</p>
                    </div>
                    <form id="Login" method="post">

                        <div class="form-group">
                            <input type="email" class="form-control" id="txtEmail" name="txtEmail" placeholder="email@dominio.com">

                        </div>

                        <div class="form-group">
                            <input type="password" class="form-control" id="txtSenha" name="txtSenha" placeholder="**********">
                        </div>
                        <button type="submit" class="btn btn-primary">Entrar</button>
                        <div class="clear">
                        </div>
                        <div style="margin-top:10px;"><?= $retorno; ?></div>
                    </form>
                </div>
                <p class="botto-text"><a href="https://bootsnipp.com/snippets/featured/login-form" taget="_blank" style="color: #FFF;">Designed by Sunil Rajput</a></p>
            </div>
        </div>
    </body>
</html>