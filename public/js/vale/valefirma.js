function abrirPdocSigner(id) {

    $.get("/exportar-pdf/" + id, function(response) {

        if (response.tieneFirma) {
            // El PDF ya está firmado → solo recargar tabla
            location.reload();
            return;
        }

        // Si NO tiene firma → abrir PdocSigner en nueva pestaña
        const nuevaPestana = window.open(response.url, "_blank");

        // Y recargar la tabla
        location.reload();
    });
}
