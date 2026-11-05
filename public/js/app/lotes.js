/**
 * LOTEAME - Gestión de Lotes y Disponibilidad
 * Version: 0.02
 */

$(document).ready(function () {
    // Inicializar DataTable
    if ($('#lotesTable').length && typeof $.fn.DataTable !== 'undefined') {
        $('#lotesTable').DataTable({
            responsive: true,
            autoWidth: false,
            order: [[0, 'asc'], [1, 'asc'], [2, 'asc']],
            language: window.dtSpanish || {
                "decimal": "",
                "emptyTable": "No hay lotes registrados",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ lotes",
                "infoEmpty": "Mostrando 0 a 0 de 0 lotes",
                "infoFiltered": "(filtrado de _MAX_ registros totales)",
                "lengthMenu": "Mostrar _MENU_ registros",
                "search": "Buscar lote:",
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

    // Filtros dependientes de Proyecto -> Manzana en la lista
    $('#filtro_proyecto_id').on('change', function () {
        var proyectoId = $(this).val();
        var idopcion = $(this).data('idopcion');
        var url = '/loteame/gestion-de-lotes/' + idopcion;
        if (proyectoId) {
            url += '?proyecto_id=' + proyectoId;
        }
        window.location.href = url;
    });

    $('#filtro_manzana_id, #filtro_estado').on('change', function () {
        var proyectoId = $('#filtro_proyecto_id').val();
        var manzanaId = $('#filtro_manzana_id').val();
        var estado = $('#filtro_estado').val();
        var idopcion = $('#filtro_proyecto_id').data('idopcion');

        var params = [];
        if (proyectoId) params.push('proyecto_id=' + proyectoId);
        if (manzanaId) params.push('manzana_id=' + manzanaId);
        if (estado) params.push('estado=' + estado);

        var queryString = params.length > 0 ? '?' + params.join('&') : '';
        window.location.href = '/loteame/gestion-de-lotes/' + idopcion + queryString;
    });

    // Carga dinámica de Manzanas al cambiar Proyecto en formularios
    $('#proyecto_id').on('change', function () {
        var proyectoId = $(this).val();
        var $manzanaSelect = $('#manzana_id');
        $manzanaSelect.empty().append('<option value="">-- Cargando manzanas... --</option>');

        if (!proyectoId) {
            $manzanaSelect.empty().append('<option value="">-- Primero elija un Proyecto --</option>');
            return;
        }

        $.ajax({
            url: '/loteame/ajax-manzanas-por-proyecto',
            type: 'GET',
            data: { proyecto_id: proyectoId },
            dataType: 'json',
            success: function (res) {
                $manzanaSelect.empty().append('<option value="">-- Seleccione una Manzana --</option>');
                if (res.success && res.manzanas.length > 0) {
                    $.each(res.manzanas, function (i, mz) {
                        $manzanaSelect.append('<option value="' + mz.id + '">' + mz.nombre + '</option>');
                    });
                } else {
                    $manzanaSelect.append('<option value="" disabled>No hay manzanas registradas en este proyecto</option>');
                }
            },
            error: function () {
                $manzanaSelect.empty().append('<option value="">Error al cargar manzanas</option>');
            }
        });
    });

    // Cálculo automático de Precio Total = Área m2 * Precio x m2
    function calcularPrecioTotal() {
        var area = parseFloat($('#area_m2').val()) || 0;
        var precioM2 = parseFloat($('#precio_m2').val()) || 0;
        if (area > 0 && precioM2 > 0) {
            var total = (area * precioM2).toFixed(2);
            $('#precio_total').val(total);
        }
    }

    $('#area_m2, #precio_m2').on('input', calcularPrecioTotal);

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
