<style>
    /* Combo Box Premium */
    .combo-compra-moderno {
        height: 28px !important;
        padding: 0 15px 1px 5px !important;
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

    #tabla-detalle-consolidado-ap_wrapper {
        width: 100% !important;
        overflow-x: auto !important;
        padding-bottom: 10px;
    }
</style>

<div class="panel panel-default" style="margin-top: 20px;">
    <div class="panel-heading" style="background-color: #f5f5f5; border-bottom: 2px solid #34aadc;">
        <h4 style="font-weight: bold; margin: 0;">
            <i class="mdi mdi-view-list"></i> PRODUCTOS DEL CONSOLIDADO:
            {{$listadetalle->first()->ID_PEDIDO_CONSOLIDADO ?? ''}}
        </h4>
    </div>
    <div class="panel-body">
        <div class="row" style="margin-bottom: 10px;">
            <div class="col-xs-12 text-right">
                @if(($listadetalle->first()->COD_ESTADO ?? '') != 'ETM0000000000005')
                    <button type="button" class="btn btn-success" id="btn-aprobar-consolidado-ap"
                        style="width: 200px; display: inline-flex; align-items: center; justify-content: center; height: 38px; font-weight: bold;">
                        <i class="mdi mdi-check" style="font-size: 18px; margin-right: 8px;"></i> Aprobar Consolidado
                    </button>
                @else
                    <span class="label label-success"
                        style="font-size: 14px; padding: 8px 15px; background-color: #27ae60; display: inline-block;">
                        <i class="mdi mdi-check-all"></i> ESTE CONSOLIDADO YA SE ENCUENTRA APROBADO
                    </span>
                @endif
            </div>
        </div>
        <div class="table-responsive">
            <table id="tabla-detalle-consolidado-ap"
                class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
                style="width: 100%;">
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
                        <tr class="fila-detalle-consolidado-ap" data-id="{{ $item->COD_PRODUCTO }}"
                            data-nombre="{{ $item->NOM_PRODUCTO }}" data-detalle="{{ $item->DETALLE_POR_AREA }}"
                            style="cursor: pointer;">
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td>{{ $item->COD_PRODUCTO }}</td>
                            <td>{{ $item->NOM_PRODUCTO }}</td>
                            <!-- DEBUG: COD_EMPR: {{ $item->COD_EMPR ?? 'NULL' }} | IND_COMPRA: {{ $item->IND_COMPRA ?? 'NULL' }} -->
                            <td class="text-center">
                                <select class="form-control input-sm combo-compra-moderno combo-compra-ap"
                                    data-empresa="{{ trim($item->COD_EMPR ?? '') }}"
                                    @if(($item->COD_ESTADO ?? '') == 'ETM0000000000005') disabled @endif>
                                    @php
                                        $current_ind_compra = trim($item->IND_COMPRA ?? '');
                                        $current_cod_empr   = trim($item->COD_EMPR ?? '');
                                        $current_cod_centro = trim($item->COD_CENTRO ?? '');
                                        $current_nom_centro = trim($item->NOM_CENTRO_CONSOLIDADO ?? '');

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

                                    <option value="">Seleccione...</option>
                                    {{-- 1. Centro origen del Consolidado (ej. RIOJA) --}}
                                    @if($current_nom_centro != '' && $current_nom_centro != 'CHICLAYO' && $current_nom_centro != 'LIMA')
                                        <option value="{{ $current_nom_centro }}" data-codigo="{{ $current_cod_centro }}" {{ $selected_compra == $current_nom_centro ? 'selected' : '' }}>
                                            {{ $current_nom_centro }}
                                        </option>
                                    @endif
                                    {{-- 2. Chiclayo --}}
                                    <option value="CHICLAYO" data-codigo="CEN0000000000001" {{ $selected_compra == 'CHICLAYO' ? 'selected' : '' }}>
                                        CHICLAYO
                                    </option>
                                    {{-- 3. Lima (Si aplica) --}}
                                    @if($selected_compra == 'LIMA' || $current_nom_centro == 'LIMA')
                                        <option value="LIMA" data-codigo="CEN0000000000002" {{ $selected_compra == 'LIMA' ? 'selected' : '' }}>
                                            LIMA
                                        </option>
                                    @endif
                                    {{-- 4. Caso especial: Valor guardado diferente a los anteriores --}}
                                    @if($current_ind_compra != '' && $current_ind_compra != 'CHICLAYO' && $current_ind_compra != 'LIMA' && $current_ind_compra != $current_nom_centro)
                                        <option value="{{ $current_ind_compra }}" data-codigo="" selected>
                                            {{ $current_ind_compra }}
                                        </option>
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">
                                <select class="form-control input-sm select2-almacen-ap combo-almacen-ap" 
                                    data-almacen-actual="{{ trim($item->COD_ALMACEN ?? '') }}"
                                    @if(($item->COD_ESTADO ?? '') == 'ETM0000000000005') disabled @endif>
                                    <option value="">Seleccione...</option>
                                    @if(trim($item->COD_ALMACEN ?? '') != '')
                                        <option value="{{ trim($item->COD_ALMACEN) }}" selected>{{ trim($item->NOM_ALMACEN ?? '') }}</option>
                                    @endif
                                </select>
                            </td>
                            <td class="text-center">{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                            <td class="text-center">{{ number_format($item->CANTIDAD, 2) }}</td>
                            <td class="text-center">{{ number_format($item->STOCK, 2) }}</td>
                            <td class="text-center">{{ number_format($item->RESERVADO, 2) }}</td>
                            <td class="text-center" style="font-weight: bold;">{{ number_format($item->DIFERENCIA, 2) }}
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control input-sm input-cantidad-moderno input-cantidad-ap inputmask-mil"
                                    value="{{ (int) (!is_null($item->CAN_COMPRADA) ? ($item->CAN_COMPRADA) : ($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA)) }}"
                                    @if(($item->COD_ESTADO ?? '') == 'ETM0000000000005') readonly @endif>
                            </td>
                            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="12" class="text-center text-muted">No se encontraron productos.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- CONTENEDOR PARA EL DETALLE POR ÁREA (DOBLE CLIC EN PRODUCTO) -->
        <div id="contenedor-detalle-area-producto"
            style="display: none; margin-top: 30px; border-top: 1px dashed #ccc; padding-top: 20px;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
                <h4 style="font-weight: bold; color: #34aadc;">
                    <i class="mdi mdi-map-marker"></i> DETALLE POR ÁREA: <span id="nombre-producto-area"
                        class="text-muted"></span>
                </h4>
                <button type="button" class="btn btn-xs btn-danger"
                    onclick="$('#contenedor-detalle-area-producto').slideUp();">
                    <i class="mdi mdi-close"></i> Cerrar detalle
                </button>
            </div>
            <table class="table table-bordered table-condensed table-hover" id="tabla-area-detalle">
                <thead style="background-color: #eee;">
                    <tr>
                        <th class="text-center">FECHA</th>
                        <th class="text-center">NRO PEDIDO</th>
                        <th class="text-center">ÁREA</th>
                        <th>GLOSA</th>
                        <th class="text-center">CANTIDAD</th>
                        <th class="text-center">ARCHIVO</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>

    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla-detalle-consolidado-ap').DataTable({
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

        function initSelect2AlmacenAp() {
            $('.select2-almacen-ap').each(function() {
                if (!$(this).hasClass("select2-hidden-accessible")) {
                    $(this).select2({
                        minimumResultsForSearch: Infinity,
                        width: '240px'
                    });
                }
            });
        }

        initSelect2AlmacenAp();

        $('#tabla-detalle-consolidado-ap').on('draw.dt', function() {
            initSelect2AlmacenAp();
        });

        function cargarAlmacenesFilaAp($tr, callback) {
            let cod_producto = $tr.data('id');
            let $selectCompra = $tr.find('.combo-compra-ap');
            let $selectAlmacen = $tr.find('.combo-almacen-ap');
            let cod_centro = $selectCompra.find('option:selected').data('codigo') || '';
            let cod_empr = $selectCompra.data('empresa') || '';
            let almacen_actual = $selectAlmacen.data('almacen-actual') || '';

            if (cod_centro === '') {
                $selectAlmacen.html('<option value="">Seleccione...</option>').trigger('change');
                $selectAlmacen.data('loaded', true);
                if (typeof callback === 'function') callback();
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
                    $selectAlmacen.data('loaded', true);
                    if (typeof callback === 'function') callback();
                },
                error: function(e) {
                    console.error('Error al obtener almacenes:', e);
                    if (typeof callback === 'function') callback();
                }
            });
        }

        // NO cargar almacenes inicialmente para cada fila para evitar demoras de múltiples peticiones AJAX
        /*
        let table = $('#tabla-detalle-consolidado-ap').DataTable();
        table.rows().nodes().to$().each(function() {
            cargarAlmacenesFilaAp($(this));
        });
        */

        // Escuchar cambios en el combo de compra
        $(document).on('change', '.combo-compra-ap', function() {
            let $tr = $(this).closest('tr');
            let $selectAlmacen = $tr.find('.combo-almacen-ap');
            $selectAlmacen.data('almacen-actual', '');
            $selectAlmacen.data('loaded', false);
            cargarAlmacenesFilaAp($tr);
        });

        // Cargar almacenes bajo demanda al abrir el select2 si no se han cargado previamente
        $(document).on('select2:opening', '.select2-almacen-ap', function(e) {
            let $select = $(this);
            let $tr = $select.closest('tr');
            if (!$select.data('loaded')) {
                e.preventDefault();
                cargarAlmacenesFilaAp($tr, function() {
                    $select.select2('open');
                });
            }
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