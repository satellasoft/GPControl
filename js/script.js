function ShowModal(titulo, mensagem) {
    $("#modalContentTitle").html(titulo);
    $("#modalContent").html(mensagem);
    $('#modalResult').modal("show");
}