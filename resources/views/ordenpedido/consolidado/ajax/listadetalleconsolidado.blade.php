@php
    $estado_consolidado = $listadetalle->first()->COD_ESTADO ?? null;
@endphp

@if($estado_consolidado != 'ETM0000000000015')
<div class="row" style="margin-bottom: 15px;">
    <div class="col-xs-12 text-right">
      


        <button type="button" class="btn btn-danger btn-detalle-consolidado" id="btn-aprobar-consolidado">
            <i class="mdi mdi-content-check"></i> Cerrar Consolidado
        </button>

      {{--  <button type="button" class="btn btn-danger btn-detalle-consolidado" 
                id="btn-eliminar-consolidado-sede"
                data-id="{{ $listadetalle->first()->ID_PEDIDO_CONSOLIDADO ?? '' }}">
            <i class="mdi mdi-delete"></i> Eliminar consolidado 
        </button> --}}

    </div>
</div>
@endif


<style>
    .btn-detalle-consolidado {
        padding: 6px 15px;
        margin-left: 5px;
        border-radius: 4px;
        font-weight: 600;
        min-width: 140px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-detalle-consolidado i {
        margin-right: 6px;
        font-size: 16px;
    }

    /* Combo Box Premium */
    .combo-compra-moderno {
        height: 28px !important;
        padding: 0 15px 1px 5px !important; /* Ajustamos padding para subir un poco el texto */
        border-radius: 14px !important;
        border: 2px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
        color: #334155 !important;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 145px !important;
        appearance: none;
        text-align: center !important;
        text-align-last: center !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
        line-height: normal !important;
    }
    .combo-compra-moderno:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none;
    }
    .combo-compra-moderno:hover {
        border-color: #94a3b8 !important;
        background-color: #f8fafc !important;
    }
    .combo-compra-moderno:disabled {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        cursor: not-allowed;
        opacity: 0.7;
    }
    /* Estilo para Cantidad Comprada Redondeado */
    .input-cantidad-moderno {
        height: 28px !important;
        border-radius: 14px !important;
        border: 2px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        text-align: center;
        width: 80px !important;
        margin: 0 auto;
        font-weight: 600 !important;
        color: #334155 !important;
        transition: all 0.3s ease;
    }
    .input-cantidad-moderno:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
        outline: none;
    }

    /* Select2 Personalizado Redondeado */
    .select2-container--default .select2-selection--single {
        border-radius: 14px !important;
        height: 28px !important;
        border: 2px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        transition: all 0.3s ease;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px !important;
        font-weight: normal !important;
        color: #334155;
        text-align: center;
        padding-left: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px !important;
    }
    .select2-container--open .select2-dropdown--below, 
    .select2-container--open .select2-dropdown--above {
        border-radius: 14px !important;
        border: 2px solid #cbd5e1 !important;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        margin-top: 5px;
    }
    .select2-results__option {
        padding: 6px 12px !important;
        font-weight: 500;
        text-align: center;
    }

    #tabla-detalle-consolidado_wrapper {
        width: 100% !important;
        overflow-x: auto !important;
        padding-bottom: 10px;
    }
</style>

<table id="tabla-detalle-consolidado" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" cellspacing="0" width="100%">
    <thead class="background-th-azul">
        <tr>
            <th>#</th>
            <th>COD_PRODUCTO</th>
            <th>PRODUCTO</th>
            <th class="text-center">COMPRA(LOCAL/SEDE)</th>
            <th class="text-center" style="min-width: 240px;">ALMACEN</th>
            <th class="text-center">UNIDAD MEDIDA</th>
            <th class="text-center">CANTIDAD</th>
            <th class="text-center">STOCK</th>
            <th class="text-center">RESERVADO</th>
            <th class="text-center">DIFERENCIA</th>
            <th class="text-center">CANTIDAD COMPRADA</th>
            <th>FAMILIA</th>
        </tr>
    </thead>

    <tbody>
        @forelse($listadetalle as $index => $item)
            <tr class="fila-detalle-consolidado-generado" 
                data-id="{{ $item->COD_PRODUCTO }}" 
                data-nombre="{{ $item->NOM_PRODUCTO }}"
                data-detalle="{{ $item->DETALLE_POR_AREA }}"
                style="cursor: pointer;">
                <td class="text-center">{{ $index + 1 }}</td>
                <td>{{ $item->COD_PRODUCTO }}</td>
                <td>{{ $item->NOM_PRODUCTO }}</td>
                <td class="text-center">
                    @php
                        $current_ind_compra = trim($item->IND_COMPRA ?? '');
                        $current_cod_empr   = trim($item->COD_EMPR ?? '');
                        $current_cod_centro = trim($item->COD_CENTRO ?? '');

                        $selected_compra = $current_ind_compra;
                        if($selected_compra == ''){
                            if($current_cod_empr == 'IACHEM0000007086'){
                                $selected_compra = 'CHICLAYO';
                            } elseif($current_cod_empr == 'IACHEM0000010394'){
                                if($current_cod_centro == 'CEN0000000000002'){
                                    $selected_compra = 'LIMA';
                                } elseif($current_cod_centro == 'CEN0000000000001'){
                                    $selected_compra = 'CHICLAYO';
                                }
                            }
                        }
                    @endphp
                    <select class="form-control input-sm select2-compra combo-compra" 
                            data-empresa="{{ trim($item->COD_EMPR ?? '') }}"
                            @if($item->COD_ESTADO == 'ETM0000000000015') disabled @endif>
                        @if($cod_centro_usuario === 'CEN0000000000001')
                            <option value="CHICLAYO" data-codigo="CEN0000000000001" selected>CHICLAYO</option>
                        @else
                            <option value="">Seleccione...</option>
                            <option value="{{ $nom_centro_usuario }}" data-codigo="{{ $cod_centro_usuario }}" {{ $selected_compra == $nom_centro_usuario ? 'selected' : '' }}>{{ $nom_centro_usuario }}</option>
                            <option value="CHICLAYO" data-codigo="CEN0000000000001" {{ $selected_compra == 'CHICLAYO' ? 'selected' : '' }}>CHICLAYO</option>

                            {{-- Caso especial: LIMA no es el centro del usuario pero debe estar como opción --}}
                            @if($selected_compra == 'LIMA' && $nom_centro_usuario != 'LIMA')
                                <option value="LIMA" data-codigo="CEN0000000000002" selected>LIMA</option>
                            @endif
                        @endif
                    </select>
                </td>
                <td class="text-center">
                    <select class="form-control input-sm select2-almacen combo-almacen" 
                            data-almacen-actual="{{ trim($item->COD_ALMACEN ?? '') }}"
                            @if($item->COD_ESTADO == 'ETM0000000000015') disabled @endif>
                        <option value="">Seleccione...</option>
                    </select>
                </td>
                <td class="text-center">{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                <td class="text-center">{{ number_format($item->CANTIDAD, 2) }}</td>
                <td class="text-center">{{ number_format($item->STOCK, 2) }}</td>
                <td class="text-center">{{ number_format($item->RESERVADO, 2) }}</td>
                <td class="text-center" style="font-weight: bold;">{{ number_format($item->DIFERENCIA, 2) }}</td>
                <td class="text-center">
                    <input type="text" 
                           class="form-control input-sm input-descontar input-cantidad-moderno inputmask-mil" 
                           value="{{ !is_null($item->CAN_COMPRADA) ? intval($item->CAN_COMPRADA) : intval($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA) }}" 
                           @if($item->COD_ESTADO == 'ETM0000000000015') readonly @endif>
                </td>

                <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="12" class="text-center">No se encontraron productos para este consolidado / familia.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla-detalle-consolidado').DataTable({
            scrollX: true,
            responsive: false,
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

        function initSelect2Consolidado() {
            $('.select2-compra').each(function() {
                if (!$(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2({
                        minimumResultsForSearch: Infinity,
                        width: '145px'
                    });
                }
            });

            $('.select2-almacen').each(function() {
                if (!$(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2({
                        minimumResultsForSearch: Infinity,
                        width: '240px'
                    });
                }
            });
        }

        initSelect2Consolidado();

        $('#tabla-detalle-consolidado').on('draw.dt', function() {
            initSelect2Consolidado();
        });

        // Función para cargar los almacenes de una fila
        function cargarAlmacenesFila($tr) {
            let cod_producto = $tr.data('id');
            let $selectCompra = $tr.find('.combo-compra');
            let $selectAlmacen = $tr.find('.combo-almacen');
            let cod_centro = $selectCompra.find('option:selected').data('codigo') || '';
            let cod_empr = $selectCompra.data('empresa') || '';
            let almacen_actual = $selectAlmacen.data('almacen-actual') || '';

            if (cod_centro === '') {
                $selectAlmacen.html('<option value="">Seleccione...</option>').trigger('change');
                return;
            }

            $.ajax({
                type: 'POST',
                url: carpeta + '/ajax-obtener-almacenes-producto-centro',
                data: {
                    _token: $('#token').val(),
                    cod_producto: cod_producto,
                    cod_centro: cod_centro,
                    cod_empr: cod_empr
                },
                success: function(res) {
                    let html = '<option value="">Seleccione...</option>';
                    
                    let valor_seleccionado = '';
                    if (almacen_actual.trim() !== '') {
                        let existeGuardado = res.some(function(alm) {
                            return alm.COD_ALMACEN.trim() === almacen_actual.trim();
                        });
                        if (existeGuardado) {
                            valor_seleccionado = almacen_actual.trim();
                        }
                    }
                    
                    if (valor_seleccionado === '' && res.length === 1) {
                        valor_seleccionado = res[0].COD_ALMACEN.trim();
                    }

                    res.forEach(function(alm) {
                        let cod_alm = alm.COD_ALMACEN.trim();
                        let selected = (cod_alm === valor_seleccionado) ? 'selected' : '';
                        html += '<option value="' + cod_alm + '" ' + selected + '>' + alm.NOM_ALMACEN + '</option>';
                    });
                    $selectAlmacen.html(html).trigger('change');
                },
                error: function(e) {
                    console.error('Error al obtener almacenes:', e);
                }
            });
        }

        // Cargar almacenes inicialmente para cada fila
        let table = $('#tabla-detalle-consolidado').DataTable();
        table.rows().nodes().to$().each(function() {
            cargarAlmacenesFila($(this));
        });

        // Escuchar cambios en el combo de compra
        $(document).on('change', '.combo-compra', function() {
            let $tr = $(this).closest('tr');
            $tr.find('.combo-almacen').data('almacen-actual', '');
            cargarAlmacenesFila($tr);
        });

        $('.inputmask-mil').inputmask('decimal', {
            groupSeparator: ',',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true
        });
    });
</script>

<!-- CONTENEDOR NUEVO: DETALLE DEL PRODUCTO CONSOLIDADO (EN TABLA INFERIOR) -->
<div id="contenedor-detalle-producto-consolidado" style="display: none; margin-top: 25px;">
    
    <div style="position: relative; margin-bottom: 15px;">
        <h4 class="text-center" style="font-weight: bold; margin: 0; text-transform: uppercase;">
            <i class="mdi mdi-receipt"></i> DETALLE: <span id="titulo-producto-detalle" class="text-primary"></span>
        </h4>
        <div style="position: absolute; right: 0; top: 0;">
            <button type="button" class="btn btn-xs btn-danger" onclick="$('#contenedor-detalle-producto-consolidado').slideUp();">
                <i class="mdi mdi-close"></i> Cerrar
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" id="tablaDetalleInferior" cellspacing="0" width="100%">
            <thead class="background-th-azul">
                <tr>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">NRO PEDIDO</th>
                    <th class="text-center">AREA</th>
                    <th class="text-center">GLOSA</th>
                    <th class="text-center">CANTIDAD</th>
                    <th class="text-center">ARCHIVO</th>
                </tr>
            </thead>
            <tbody style="background: white;">
                <!-- Se llena dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

