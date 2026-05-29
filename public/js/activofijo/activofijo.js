$(document).ready(function(){

    var carpeta = $("#carpeta").val();

    function cargarLista() {
        var _token = $('#token').val();
        var data = { 
            _token: _token,
            fecha_inicio: window.fecha_inicio_val || '',
            fecha_fin: window.fecha_fin_val || ''
        };

        $.ajax({
            type: "POST",
            url: carpeta + "/ajax-listar-activos-fijos",
            data: data,
            success: function (data) {
                $('.listajax').html(data);
                
                // Inicializar datatable localmente para evitar problemas de caché con app-tables-datatables.js
                $("#tabla-obras").dataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'csvHtml5',
                            text: '<i class="mdi mdi-file-text"></i> CSV',
                            className: 'btn btn-primary btn-space',
                            exportOptions: { columns: ':not(:eq(0))' }
                        },
                        {
                            extend: 'excelHtml5',
                            text: '<i class="mdi mdi-file-excel"></i> Excel',
                            className: 'btn btn-success btn-space',
                            title: 'GESTION DE OBRAS',
                            extension: '.xlsx',
                            exportOptions: { columns: ':not(:eq(0))' },
                            customize: function(xlsx) {
                                var sheet = xlsx.xl.worksheets['sheet1.xml'];

                                // Ajustar el ancho de las columnas (reparado el bug de innerHTML en XML)
                                var cols = sheet.getElementsByTagName('cols')[0];
                                if (!cols) {
                                    cols = sheet.createElement('cols');
                                    var sheetData = sheet.getElementsByTagName('sheetData')[0];
                                    sheetData.parentNode.insertBefore(cols, sheetData);
                                } else {
                                    while (cols.firstChild) {
                                        cols.removeChild(cols.firstChild);
                                    }
                                }
                                // Definimos los anchos, la columna B (nombre) tendrá un ancho de 55
                                var colWidths = [15, 55, 18, 18, 18, 20, 20, 18, 18, 18, 18, 18, 18, 18, 18, 18];
                                colWidths.forEach(function(w, index) {
                                    var col = sheet.createElement('col');
                                    col.setAttribute('min', index + 1);
                                    col.setAttribute('max', index + 1);
                                    col.setAttribute('width', w);
                                    col.setAttribute('customWidth', '1');
                                    cols.appendChild(col);
                                });

                                // Estilo premium Excel:
                                // Cabecera con fondo gris oscuro, letras negritas y centradas (style 42)
                                $('row:first c', sheet).attr('s', '42');
                                // Celdas de datos con bordes (style 25)
                                $('row:not(:first) c', sheet).each(function () {
                                    if (!$(this).attr('s')) {
                                        $(this).attr('s', '25');
                                    }
                                });
                            }
                        },
                        {
                            extend: 'pdfHtml5',
                            text: '<i class="mdi mdi-collection-pdf"></i> PDF',
                            className: 'btn btn-danger btn-space',
                            exportOptions: { columns: ':not(:eq(0))' }
                        }
                    ],
                    "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
                    order: [[1, "asc"]], // Ordenar por la columna 1 (Item PLE) en lugar de Opciones
                    initComplete: function () {
                        var filtros = `
                            <div class="premium-toolbar">
                                <div class="filter-group">
                                    <label class="premium-filter-label" for="filtro_fecha_inicio">Desde:</label>
                                    <input type="date" id="filtro_fecha_inicio" class="premium-filter-input">
                                    <label class="premium-filter-label" for="filtro_fecha_fin" style="margin-left: 10px;">Hasta:</label>
                                    <input type="date" id="filtro_fecha_fin" class="premium-filter-input">
                                </div>
                                <div id="search_container"></div>
                            </div>
                        `;
                        // Insertar la barra de herramientas premium
                        $('#tabla-obras_wrapper').prepend(filtros);
                        
                        // Mover el buscador de datatables dentro de nuestra barra premium
                        $('.dataTables_filter').appendTo('#search_container');
                        
                        // Ocultar el selector de cantidad de registros para mantener el diseño limpio
                        $('.dataTables_length').hide();
                        
                        // Restaurar valores si existen
                        if(window.fecha_inicio_val) {
                            $('#filtro_fecha_inicio').val(window.fecha_inicio_val);
                            $('#filtro_fecha_fin').attr('min', window.fecha_inicio_val);
                        }
                        if(window.fecha_fin_val) {
                            $('#filtro_fecha_fin').val(window.fecha_fin_val);
                            $('#filtro_fecha_inicio').attr('max', window.fecha_fin_val);
                        }
                        
                        // Eventos automáticos onChange y validación
                        $('#filtro_fecha_inicio').on('change', function() {
                            $('#filtro_fecha_fin').attr('min', $(this).val());
                            window.fecha_inicio_val = $(this).val();
                            cargarLista();
                        });
                        
                        $('#filtro_fecha_fin').on('change', function() {
                            $('#filtro_fecha_inicio').attr('max', $(this).val());
                            window.fecha_fin_val = $(this).val();
                            cargarLista();
                        });
                    }
                });
            },
            error: function (data) {
                console.log(data);
            }
        });
    }

    cargarLista();

    $(".btn-agregar-activo").on('click', function(e) {
        e.preventDefault();
        $('#activo_id').val('');
        $('#activo_item_ple').val('');
        $('#activo_nombre').val('');
        $('#activo_tipo').val('Edificaciones');
        $('#activo_fecha_emision').val('');
        $('#activo_base_de_calculo').val('');
        $('#activo_depreciacion_acumulada').val('0');
        $('#activo_fecha_inicio_depreciacion').val('');
        $('#activo_ultima_fecha_depreciacion').val('');
        $('#modal-formulario-activo').niftyModal('show');
    });

    $(".listajax").on('click', '.btn-editar-activo', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var item_ple = $(this).attr('data-item_ple');
        var nombre = $(this).attr('data-nombre');
        var tipo = $(this).attr('data-tipo');
        var fecha_emision = $(this).attr('data-fecha_emision');
        var base_de_calculo = $(this).attr('data-base_de_calculo');
        var depreciacion_acumulada = $(this).attr('data-depreciacion_acumulada');
        var fecha_inicio_depreciacion = $(this).attr('data-fecha_inicio_depreciacion');
        var ultima_fecha_depreciacion = $(this).attr('data-ultima_fecha_depreciacion');

        $('#activo_id').val(id);
        $('#activo_item_ple').val(item_ple);
        $('#activo_nombre').val(nombre);
        if(tipo) $('#activo_tipo').val(tipo);
        
        $('#activo_fecha_emision').val(fecha_emision !== 'null' ? fecha_emision : '');
        $('#activo_base_de_calculo').val(base_de_calculo !== 'null' ? base_de_calculo : '');
        $('#activo_depreciacion_acumulada').val(depreciacion_acumulada !== 'null' ? depreciacion_acumulada : '0');
        $('#activo_fecha_inicio_depreciacion').val(fecha_inicio_depreciacion !== 'null' ? fecha_inicio_depreciacion : '');
        $('#activo_ultima_fecha_depreciacion').val(ultima_fecha_depreciacion !== 'null' ? ultima_fecha_depreciacion : '');

        $('#modal-formulario-activo').niftyModal('show');
    });

    $(".listajax").on('click', '.btn-eliminar-activo', function(e) {
        e.preventDefault();
        var id = $(this).attr('data-id');
        var _token = $('#token').val();

        $.confirm({
            title: '¿Confirma la Eliminación?',
            content: '¿Está seguro de eliminar esta obra?',
            theme: 'modern',
            onOpenBefore: function () {
                $('.jconfirm-bg').css({
                    'backdrop-filter': 'blur(5px)',
                    '-webkit-backdrop-filter': 'blur(5px)'
                });
            },
            buttons: {
                confirmar: {
                    text: 'Confirmar',
                    btnClass: 'btn-blue',
                    action: function () {
                        $.ajax({
                            type: "POST",
                            url: carpeta + "/eliminar-activo-fijo",
                            data: { _token: _token, id: id },
                            success: function (response) {
                                if (response.success) {
                                    alertajax(response.mensaje);
                                    cargarLista();
                                } else {
                                    alerterrorajax(response.error);
                                }
                            },
                            error: function (data) {
                                console.log(data);
                            }
                        });
                    }
                },
                cancelar: {
                    text: 'Cancelar',
                    action: function () {
                        // Acción al cancelar
                    }
                }
            }
        });
    });

    $(document).on('click', '.btn-guardar-activo', function(e) {
        e.preventDefault();
        
        var form = $('#form-activo');
        if (form.parsley().validate()) {
            var _token = $('#token').val();
            var data = form.serialize() + "&_token=" + _token;

            $.ajax({
                type: "POST",
                url: carpeta + "/agregar-modificar-activo-fijo",
                data: data,
                success: function (response) {
                    if (response.success) {
                        alertajax(response.mensaje);
                        $('#modal-formulario-activo').niftyModal('hide');
                        setTimeout(function() {
                            $('.md-overlay').removeClass('md-overlay-show');
                            $('.modal-overlay').removeClass('modal-overlay-show');
                            cargarLista();
                        }, 300);
                    } else {
                        alerterrorajax(response.error);
                    }
                },
                error: function (data) {
                    console.log(data);
                }
            });
        }
    });

    $(".modal-close").on('click', function(e) {
        e.preventDefault();
        $('#modal-formulario-activo').niftyModal('hide');
        setTimeout(function() {
            $('.md-overlay').removeClass('md-overlay-show');
            $('.modal-overlay').removeClass('modal-overlay-show');
        }, 300);
    });

});
