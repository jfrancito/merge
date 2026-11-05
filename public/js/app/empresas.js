/**
 * LOTEAME - Gestión de Empresas e Inmobiliarias
 * Version: 0.02
 */

$(document).ready(function () {
    // Inicializar DataTable si existe la tabla
    if ($('#empresasTable').length && typeof $.fn.DataTable !== 'undefined') {
        $('#empresasTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc']],
            language: {
                "decimal": "",
                "emptyTable": "No hay empresas registradas",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ empresas",
                "infoEmpty": "Mostrando 0 a 0 de 0 empresas",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ registros",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron coincidencias",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                }
            }
        });
    }

    // Validación numérica en campo RUC
    $('#ruc').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 11);
    });

    // Validación numérica en campo Teléfono
    $('#telefono').on('input', function () {
        this.value = this.value.replace(/[^0-9+\s-]/g, '').slice(0, 15);
    });

    // Validación numérica en campo DNI Representante
    $('#representante_dni').on('input', function () {
        this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);
    });

    // Vista previa de logo seleccionado
    $('#logo').on('change', function (e) {
        var file = e.target.files[0];
        if (file) {
            if (file.size > 2097152) { // 2MB
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo demasiado grande',
                    text: 'El logo no debe superar los 2MB.'
                });
                $(this).val('');
                $('#logoPreview').hide();
                return;
            }
            var reader = new FileReader();
            reader.onload = function (event) {
                $('#logoPreviewImg').attr('src', event.target.result);
                $('#logoPreview').show();
            };
            reader.readAsDataURL(file);
        }
    });

    // Validación HTML5 de formularios
    const forms = document.querySelectorAll('.needs-validation');
    Array.from(forms).forEach(form => {
        form.addEventListener('submit', event => {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');
        }, false);
    });
});
