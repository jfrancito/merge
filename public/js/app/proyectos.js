/**
 * LOTEAME - Gestión de Proyectos Inmobiliarios
 * Version: 0.02
 */

$(document).ready(function () {
    // Inicializar DataTable
    if ($('#proyectosTable').length && typeof $.fn.DataTable !== 'undefined') {
        $('#proyectosTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'desc']],
            language: window.dtSpanish || {
                "decimal": "",
                "emptyTable": "No hay proyectos registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ proyectos",
                "infoEmpty": "Mostrando 0 a 0 de 0 proyectos",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "lengthMenu": "Mostrar _MENU_ registros",
                "search": "Buscar proyecto:",
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

    // Previsualización de Foto del Proyecto
    $('#foto').on('change', function (e) {
        var file = e.target.files[0];
        if (file) {
            if (file.size > 3145728) { // 3MB
                Swal.fire({
                    icon: 'warning',
                    title: 'Archivo demasiado grande',
                    text: 'La foto no debe superar los 3MB.'
                });
                $(this).val('');
                $('#fotoPreview').hide();
                return;
            }
            var reader = new FileReader();
            reader.onload = function (event) {
                $('#fotoPreviewImg').attr('src', event.target.result);
                $('#fotoPreview').show();
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
