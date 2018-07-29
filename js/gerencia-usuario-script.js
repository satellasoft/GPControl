
$(document).ready(function () {
    //ShowModal("Teste", "TESTANDO_!_@_#");
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