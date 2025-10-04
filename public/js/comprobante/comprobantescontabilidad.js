$(document).ready(function () {
    let carpeta = $("#carpeta").val();

    $(".comprobantescontabilidad").on('click', '.buscarcomprobantes', function (e) {
        e.preventDefault();

        abrircargando();

        let cod_periodo = $('#periodo_asiento').val();

        let _token = $('#token').val();

        let link = '/listar-comprobantes-contabilidad';

        if (cod_periodo && cod_periodo === '') {
            alerterrorajax("Seleccione un periodo.");
            return false;
        }

        let data = {
            _token: _token,
            cod_periodo: cod_periodo
        };

        $('#tbl_respuesta').empty();

        $.ajax({
            type: "POST",
            dataType: 'json',
            url: carpeta + link,
            data: data,
            success: function (response) {
                cerrarcargando();
                console.log(response);
                // Suponiendo que 'response' es el array JSON que recibiste
                const datosAsientos = response.map(item => {
                    return {
                        COD_ASIENTO: item.COD_ASIENTO.trim(), // Usamos .trim() para limpiar espacios
                        TXT_EMPR_CLI: item.TXT_EMPR_CLI.trim(),
                        TXT_CATEGORIA_TIPO_DOCUMENTO: item.TXT_CATEGORIA_TIPO_DOCUMENTO.trim(),
                        // Concatenamos NRO_SERIE y NRO_DOC
                        NRO_DOCUMENTO: item.NRO_SERIE.trim() + '-' + item.NRO_DOC.trim(),
                        TXT_CATEGORIA_TIPO_ASIENTO: item.TXT_CATEGORIA_TIPO_ASIENTO.trim(),
                        TXT_CATEGORIA_MONEDA: item.TXT_CATEGORIA_MONEDA.trim(),
                        FEC_ASIENTO: item.FEC_ASIENTO,
                        // Usamos la función formatter para formatear estos números en Grid.js
                        CAN_TOTAL_DEBE: item.CAN_TOTAL_DEBE,
                        CAN_TOTAL_HABER: item.CAN_TOTAL_HABER
                    };
                });

                new gridjs.Grid({
                    columns: [
                        {name: 'Cód. Asiento', id: 'COD_ASIENTO'},
                        {name: 'Cliente/Tercero', id: 'TXT_EMPR_CLI'},
                        {name: 'Tipo Documento', id: 'TXT_CATEGORIA_TIPO_DOCUMENTO'},
                        {name: 'Nro. Documento', id: 'NRO_DOCUMENTO'},
                        {name: 'Tipo Asiento', id: 'TXT_CATEGORIA_TIPO_ASIENTO'},
                        {name: 'Moneda', id: 'TXT_CATEGORIA_MONEDA'},
                        {name: 'Fecha Asiento', id: 'FEC_ASIENTO'},
                        {
                            name: 'Total Debe',
                            id: 'CAN_TOTAL_DEBE',
                            width: '120px',
                            formatter: (cell) => new Intl.NumberFormat('es-ES', {
                                minimumFractionDigits: 4
                            }).format(parseFloat(cell)),
                            attributes: {style: 'text-align: right;'}
                        },
                        {
                            name: 'Total Haber',
                            id: 'CAN_TOTAL_HABER',
                            width: '120px',
                            formatter: (cell) => new Intl.NumberFormat('es-ES', {
                                minimumFractionDigits: 4
                            }).format(parseFloat(cell)),
                            attributes: {style: 'text-align: right;'}
                        }
                    ],
                    search: true,
                    sort: false,
                    pagination: true,
                    fixedHeader: true,
                    data: datosAsientos,
                    language: {
                        'search': {
                            'placeholder': '🔍 Buscar...', // Texto dentro del input
                        },
                        'sort': {
                            'ascending': 'Ordenar ascendente',
                            'descending': 'Ordenar descendente',
                            'clear': 'Limpiar orden',
                            'sorting': 'Ordenando...'
                        },
                        'pagination': {
                            'previous': 'Anterior',
                            'next': 'Siguiente',
                            'showing': 'Mostrando',
                            results: () => 'registros'
                        },
                        'loading': 'Cargando...',
                        'noRecordsFound': 'No se encontraron registros'
                    }
                }).render(document.getElementById("tbl_respuesta"));
            },
            error: function (response) {
                cerrarcargando();
                error500(response);
            }
        })

    });

    $("#anio_asiento").on('change', function () {

        event.preventDefault();
        let anio = $('#anio_asiento').val();
        let _token = $('#token').val();
        //validacioones
        if (anio == '') {
            alerterrorajax("Seleccione un anio.");
            return false;
        }
        data = {
            _token: _token,
            anio: anio
        };

        ajax_normal_combo(data, "/ajax-combo-periodo-xanio-xempresa", "ajax_anio_asiento")

    });

    function number_format(num, decimals = 0, decimal_separator = ".", thousands_separator = ",") {
        if (isNaN(num) || num === null) return "0";

        // Asegurar número flotante
        let n = parseFloat(num);

        // Redondear a la cantidad de decimales indicada
        let fixed = n.toFixed(decimals);

        // Separar parte entera y decimal
        let parts = fixed.split(".");

        // Insertar separador de miles en la parte entera
        parts[0] = parts[0].replace(/\B(?=(\d{3})+(?!\d))/g, thousands_separator);

        // Unir con el separador de decimales
        return parts.join(decimals > 0 ? decimal_separator : "");
    }

});
