$(document).ready(function () {
    RetornaUsuarios();
});

$("#txtNome").keyup(function () {
    if ($("#txtNome").val().length >= 3) {
        BuscarUsuario($("#txtNome").val());
    } else {
        ClearGrid();
    }
});

function BuscarUsuario(nome) {
    $.ajax({
        url: "App/Action/UsuarioAction.php?req=3",
        data: {
            n: nome,
            pc: $("#txtProjetoCod").val()
        },
        dataType: "JSON",
        type: "POST",
        success: function (data) {
            if (data != null) {
                MontarGrid(data);
            }
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function MontarGrid(data) {
    var tbody = document.getElementById("tbody");
    tbody.innerHTML = "";

    for (var i = 0; i < data.length; i++) {
        var tr = document.createElement("tr");

        var tdNome = document.createElement("td");
        tdNome.innerText = data[i].nome;

        var tdEmail = document.createElement("td");
        tdEmail.innerText = data[i].email;

        var tdPermissao = document.createElement("td");
        tdPermissao.innerText = data[i].permissao === 1 ? "Administrador" : "Comum";


        var tdButton = document.createElement("td");
        var button = document.createElement("button");
        button.innerText = "Adicionar";
        button.className = "btn btn-success button-grid";
        var cod = data[i].cod;
        button.setAttribute("onclick", "AdicionarUsuario(" + cod + ", " + i + ");");

        tdButton.appendChild(button);

        tr.appendChild(tdNome);
        tr.appendChild(tdEmail);
        tr.appendChild(tdPermissao);
        tr.appendChild(tdButton);

        tbody.appendChild(tr);
    }
}

function ClearGrid() {
    document.getElementById("tbody").innerHTML = "";
}

function AdicionarUsuario(cod, index) {
    $("#txtNome").prop("disabled", true);
    document.getElementsByClassName("button-grid")[index].disabled = true;

    var obj = {
        pc: $("#txtProjetoCod").val(),
        uc: cod
    };

    $.ajax({
        url: $("#txtPath").val() + "App/Action/UsuarioProjetoAction.php?req=1",
        data: obj,
        dataType: "html",
        type: "POST",
        success: function (data) {
            if (data > 0) {
                $("#txtNome").prop("disabled", false);
                ShowModal("Cadastrado", "Permissão atribuida com sucesso!");
                var ele = document.getElementsByClassName("button-grid")[index];
                $(ele).prop("class", "btn btn-info button-grid");
                $(ele).text("Atribuído");
                $("#txtNome").val("");
                RetornaUsuarios();
            } else {
                ShowModal("Erro", "Houve um erro ao tentar atribuir a permissão.");
            }
            console.log(data);
        },
        error: function (error) {
            console.log(error);
            ShowModal("Erro", "Houve um erro ao tentar atribuir a permissão.");
        }
    });
}


//Retorna todos os usuários que tem permissão para manipular o sistema.
function RetornaUsuarios() {
    $.ajax({
        url: $("#txtPath").val() + "App/Action/UsuarioProjetoAction.php?req=2",
        data: {
            pc: $("#txtProjetoCod").val()
        },
        dataType: "JSON",
        type: "POST",
        success: function (data) {
            console.log(data);
            MontarGridUsuarios(data);
        },
        error: function (error) {
            console.log(error);
        }
    });
}

function MontarGridUsuarios(data) {
    var tbody = document.getElementById("tbodyAtribuidos");
    tbody.innerHTML = "";

    for (var i = 0; i < data.length; i++) {
        var tr = document.createElement("tr");
        tr.className = "tr-usuario";
        var tdNome = document.createElement("td");
        tdNome.innerText = data[i].UsuarioNome;

        var tdEmail = document.createElement("td");
        tdEmail.innerText = data[i].UsuarioEmail;

        var tdPermissao = document.createElement("td");
        tdPermissao.innerText = data[i].UsuarioPermissao === 1 ? "Administrador" : "Comum";


        var tdButton = document.createElement("td");
        var button = document.createElement("button");
        button.innerText = "Remover";
        button.className = "btn btn-danger";
        var usuarioCod = data[i].UsuarioCod;
        var projetoCod = data[i].ProjetoCod;
        button.setAttribute("onclick", "RemoverUsuario(" + usuarioCod + ", " + projetoCod + ", " + i + "); ");

        tdButton.appendChild(button);

        tr.appendChild(tdNome);
        tr.appendChild(tdEmail);
        tr.appendChild(tdPermissao);
        tr.appendChild(tdButton);

        tbody.appendChild(tr);
    }
}

function RemoverUsuario(usuarioCod, projetoCod, indice) {
    if (confirm("Deseja realmente remover a permissão para o usuário?")) {
        document.getElementsByClassName("tr-usuario")[indice].style.display = "none";

        $.ajax({
            url: $("#txtPath").val() + "App/Action/UsuarioProjetoAction.php?req=3",
            data: {
                pc: projetoCod,
                uc: usuarioCod
            },
            dataType: "HTML",
            type: "POST",
            success: function (data) {
                console.log(data);
                if (data == 1) {
                    ShowModal("Removido", "Usuário removido com sucesso.");
                } else {
                    ShowModal("Erro", "Houve um erro ao tentar remover o usuário.");
                }
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
}