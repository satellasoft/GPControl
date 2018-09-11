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

function MarcarComoResolvido() {

    if (confirm("Deseja realmente marcar o módulo como resolvido?")) {


        var obj = {
            u: $("#txtUserCod").val(),
            m: $("#txtModuloCod").val()
        };

        $.ajax({
            url: "App/Action/ModuloAction.php?req=1",
            data: obj,
            type: "post",
            dataType: "html",
            beforeSend: function () {
                $("#btnResolvido").prop("disabled", true);
            },
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    ShowModal("Modificado", "Módulo marcado como resolvido");
                    $("#btnResolvido, #btnComentar, #dvFormulario").css("display", "none");
                } else {
                    ShowErrorMessage();
                }
            },
            error: function (error) {
                console.log(error);
                ShowErrorMessage();
            }
        });

        function ShowErrorMessage() {
            ShowModal("Erro", "Não foi possível marcar o módulo como resolvido");
        }
    }
}