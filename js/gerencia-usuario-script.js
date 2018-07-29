
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

function ValidateEmail(email)
{
    var re = /\S+@\S+\.\S+/;
    return re.test(email);
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
                //$("#btnBuscar").prop("disabled", true);
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

    //result = JSON.parse(data);

    console.log(data);
    //console.log(result);

    var tbody = document.getElementById("tbody");
    tbody.innerHTML = "";

    for (var i = 0; i < data.length; i++) {
        var d = "<tr>" +
                "<td>" + data[i].Nome + "</td>" +
                "<td>" + data[i].Email + "</td>" +
                "<td>" + data[i].Data + "</td>" +
                "<td><a href='?p=gusuario&cod=" + data[i].Cod + "' class='btn btn-warning'>Editar</a></td>" +
                "</tr>";
        tbody.innerHTML += d;
    }
}