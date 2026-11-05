$(document).ready(function() {
    
    $('#btnGenerarExcel').on('click', function() {
        const $btn = $(this);
        const $form = $('#formReporteVentas');
        const $overlay = $('#loadingOverlay');

        // Validaciones básicas
        const fechaDesde = $form.find('input[name="fecha_desde"]').val();
        const fechaHasta = $form.find('input[name="fecha_hasta"]').val();

        if (!fechaDesde || !fechaHasta) {
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor, seleccione un rango de fechas válido.'
            });
            return;
        }

        // Mostrar cargando
        $overlay.css('display', 'flex').hide().fadeIn();
        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Generando...');

        $.ajax({
            url: baseUrl + '/reporte-ventas/generar', 
            method: 'POST',
            data: $form.serialize(),
            success: function(response) {
                console.log("Respuesta del servidor:", response);
                if (response.success) {
                    // Crear un link temporal para la descarga del base64
                    const byteCharacters = atob(response.file);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], { type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' });
                    
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.style.display = 'none';
                    a.href = url;
                    a.download = response.filename;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    
                    Swal.fire({
                        icon: 'success',
                        title: 'Reporte Generado',
                        text: 'El Registro de Ventas se ha descargado correctamente.',
                        timer: 3000,
                        showConfirmButton: false
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: response.message || 'No se pudo generar el reporte.'
                    });
                }
            },
            error: function(xhr) {
                let msg = 'Error interno del servidor.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: msg
                });
            },
            complete: function() {
                $overlay.fadeOut();
                $btn.prop('disabled', false).html('<i class="material-icons me-2">download</i> Generar Registro de Ventas (Excel)');
            }
        });
    });

});
