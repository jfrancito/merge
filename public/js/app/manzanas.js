/**
 * LOTEAME - Gestión de Manzanas y Secciones
 * Version: 0.02
 */

$(document).ready(function () {
    // Inicializar DataTable
    if ($('#manzanasTable').length && typeof $.fn.DataTable !== 'undefined') {
        $('#manzanasTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc'], [1, 'asc']],
            language: window.dtSpanish || {
                "decimal": "",
                "emptyTable": "No hay manzanas registradas",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ manzanas",
                "infoEmpty": "Mostrando 0 a 0 de 0 manzanas",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "lengthMenu": "Mostrar _MENU_ registros",
                "search": "Buscar manzana:",
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

    // Filtro por proyecto en lista
    $('#filtro_proyecto_id').on('change', function () {
        var proyectoId = $(this).val();
        var idopcion = $(this).data('idopcion');
        var url = '/loteame/gestion-de-manzanas/' + idopcion;
        if (proyectoId) {
            url += '?proyecto_id=' + proyectoId;
        }
        window.location.href = url;
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
