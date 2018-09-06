
$(document).ready(function () {
    var result = getCookie("result");
    DeleteCookie("result");
    if (result == "c1") {
        ShowModal("Sucesso", "<span class='text-success'>Usuário cadastrado com sucesso.</span>");
    } else if (result == "c2") {
        ShowModal("Erro", "<span class='text-success'>Não foi possível cadastrar o usuário.</span>");
    } else if (result == "e1") {
        ShowModal("Sucesso", "<span class='text-success'>Usuário alterado com sucesso.</span>");
    } else if (result == "e2") {
        ShowModal("Erro", "<span class='text-success'>Não foi possível alterar o usuário.</span>");
    }
});

$("#btnNovoUsuario").click(function () {
    $("#dvFormUsuario").toggle("slow");
});

$("#txtEmail").focusout(function () {
    ValidarEmail();
});

$("#frmGerenciaUsuario").submit(function (event) {
    if (!Validar()) {
        event.preventDefault();
    }
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

    if (!ValidateEmail($("#txtEmail").val())) {
        var li = document.createElement("li");
        li.innerHTML = "- Informe um e-mail válido.";
        ulErros.appendChild(li);
        erros++;
    }

    if ($("#txtEditando").val() == 0) {
        if ($("#txtSenha").val().length < 7 || $("#txtSenha").val().length > 25) {
            var li = document.createElement("li");
            li.innerHTML = "- Informe uma senha válida. (min. 7 e max. 25 caracteres)";
            ulErros.appendChild(li);
            erros++;
        }
    }

    if (erros == 0) {
        return true;
    } else {
        return false;
    }
}

function Consultar() {

    if ($("#txtBuscaNome").val().length >= 3) {
        var obj = {
            p: $("#slBuscaPermissao").val(),
            s: $("#slBuscaStatus").val(),
            n: $("#txtBuscaNome").val()
        };

        $.ajax({
            url: "App/Action/UsuarioAction.php?req=1",
            data: obj,
            type: "post",
            dataType: "JSON",
            beforeSend: function () {
                $("#btnBuscar").prop("disabled", true);
            },
            success: function (data) {
                MontarTabela(data);
            },
            error: function (erro) {
                ShowModal("ERRO", "Houve um erro ao tentar fazer uma busca.");
                console.log(erro);
            }
        });
        console.log(obj);
    } else {
        ShowModal("ERRO", "Informe ao menos três caracteres.");
    }
}

function MontarTabela(data) {
    var tbody = document.getElementById("tbody");
    tbody.innerHTML = "";

    for (var i = 0; i < data.length; i++) {
        var d = "<tr>" +
                "<td>" + data[i].Nome + "</td>" +
                "<td>" + data[i].Email + "</td>" +
                "<td>" + data[i].Data + "</td>" +
                "<td><button onclick='ModalSenha(" + data[i].Cod + ")' class='btn btn-info margin-right'>Alterar senha</button>" +
                "<a href='?p=gusuario&cod=" + data[i].Cod + "' class='btn btn-warning'>Editar</a>" +
                "</td>" +
                "</tr>";
        tbody.innerHTML += d;
    }
}

function ValidarEmail() {
    if (ValidateEmail($("#txtEmail").val())) {

        var obj = {
            e: $("#txtEmail").val()
        };

        $.ajax({
            url: "App/Action/UsuarioAction.php?req=2",
            data: obj,
            type: "post",
            dataType: "HTML",

            success: function (data) {
                if (data == 1) {
                    $("#btnCadastrar").prop("disabled", false);
                    $("#txtEmail").css("border", "1px solid green");
                } else {
                    ShowModal("ATENÇÃO", "O e-mail informado já está em uso.");
                    $("#btnCadastrar").prop("disabled", true);
                    $("#txtEmail").css("border", "1px solid red");
                }
                console.log(data);
            },
            error: function (erro) {
                $("#btnCadastrar").prop("disabled", true);
                ShowModal("ERRO", "Houve um erro ao tentar verificar se o e-mail está em uso, atualize a página e tente novamente.");
                console.log(erro);
            }
        });
    } else {
        $("#btnCadastrar").prop("disabled", true);
        $("#txtEmail").css("border", "1px solid red");
        ShowModal("ATENÇÃO", "Informe um e-mail válido");
    }
}

function ModalSenha(cod) {
    $('#modalSenha').modal('show');
    $("#txtCode").val(cod);
}

function AlterarSenha() {
    if ($("#txtNovaSenha").val().length >= 7) {
        $("#dvResultSenha").text("");

        var obj = {
            c: $("#txtCode").val(),
            s: $("#txtNovaSenha").val()
        };

        $.ajax({
            url: "App/Action/UsuarioAction.php?req=4",
            data: obj,
            type: "post",
            dataType: "HTML",
            beforeSend: function () {
                $("#btnAlterarSenha").prop("disabled", true);
            },
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    $("#btnAlterarSenha").prop("disabled", false);
                    $("#dvResultSenha").prop("class", "alert alert-success");
                    $("#dvResultSenha").text("Senha alterada");
                    $("#txtNovaSenha").val("");
                } else {
                    $("#dvResultSenha").prop("class", "alert alert-danger");
                    $("#dvResultSenha").text("Não foi possível alterar a senha");
                }
            },
            error: function (erro) {
                console.log(erro);
            }
        });
    } else {
        $("#dvResultSenha").text("Senha inválida, minímo 7 caracteres.");
    }
}

function ValidateEmail(email)
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
}