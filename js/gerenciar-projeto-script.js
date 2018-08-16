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
    console.log(data);
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
                $(ele).innerText = "Atribuído";
                $("#txtNome").val("");
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