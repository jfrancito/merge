function abrirPdocSigner(id) {
    $.get("/exportar-pdf/" + id, function(data) {
        alert(data.mensaje); // opcional
    });
}
