$(function() {
    console.log("JS de Asignación de Series cargado. v" + $('#js_version').val());

    $('.chk-serie').on('change', function() {
        const checkbox = $(this);
        const usuario_id = checkbox.data('usuario');
        const serie_id = checkbox.data('serie');
        const activo = checkbox.is(':checked') ? 1 : 0;
        const _token = $('meta[name="csrf-token"]').attr('content');

        console.log("Cambiando serie:", serie_id, "para usuario:", usuario_id, "a estado:", activo);

        // Bloquear checkbox mientras procesa
        checkbox.prop('disabled', true);

        $.ajax({
            url: window.baseUrl + "/ajax-asignar-serie", 
            type: "POST",
            data: {
                usuario_id: usuario_id,
                serie_id: serie_id,
                activo: activo,
                _token: _token
            },
            success: function(response) {
                if (response.success) {
                    Swal.fire({
                        icon: 'success',
                        title: '¡Éxito!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                    
                    // Visual feedback: cambiar color de la fila
                    if (activo) {
                        checkbox.closest('tr').addClass('bg-success bg-opacity-10');
                    } else {
                        checkbox.closest('tr').removeClass('bg-success bg-opacity-10');
                    }
                } else {
                    Swal.fire('Error', response.message, 'error');
                    checkbox.prop('checked', !activo); // Revertir
                }
            },
            error: function(xhr) {
                console.error("Error en AJAX:", xhr.responseText);
                Swal.fire('Error', 'No se pudo actualizar la asignación', 'error');
                checkbox.prop('checked', !activo); // Revertir
            },
            complete: function() {
                checkbox.prop('disabled', false);
            }
        });
    });
});
