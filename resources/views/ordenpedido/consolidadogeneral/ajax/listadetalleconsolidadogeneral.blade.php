@php
    $estado_consolidado = $listadetalle->first()->COD_ESTADO ?? null;
@endphp

@if($estado_consolidado != 'ETM0000000000005')
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-xs-12 text-right">

            <button type="button"
                    class="btn btn-primary btn-detalle-consolidado"
                    id="btn-guardar-detalle-consolidado-editado-general">
                <i class="mdi mdi-content-save"></i> Guardar
            </button>

            <button type="button"
                    class="btn btn-success btn-detalle-consolidado"
                    id="btn-aprobar-consolidado-general">
                <i class="mdi mdi-content-check"></i> Aprobar pedido
            </button>

        </div>
    </div>
@endif


{{-- SOLO CUANDO ESTÉ APROBADO --}}
@if($estado_consolidado == 'ETM0000000000005')
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-xs-12 text-right">

            <button type="button"
                    class="btn btn-primary btn-excel-consolidado-detalle"
                    id="btn-descargar-excel-area">
                <i class="mdi mdi-download"></i> Reporte Area
            </button>

            <button type="button"
                    class="btn btn-success btn-excel-consolidado-detalle"
                    id="btn-descargar-excel">
                <i class="mdi mdi-file-excel"></i> Descargar Excel
            </button>

             <button type="button"
                    class="btn btn-danger btn-excel-consolidado-detalle"
                    id="btn-elimnar-consolidado-general"
                    data-id="{{ $listadetalle->first()->ID_PEDIDO_CONSOLIDADO_GENERAL ?? '' }}">
                <i class="mdi mdi-delete"></i> Eliminar Consolidado
            </button>

        </div>
    </div>
@endif

<style>
    .glosa-cell {
        white-space: pre-wrap !important;
        word-wrap: break-word !important;
        max-width: 250px;
        min-width: 150px;
        line-height: 1.3;
    }

    /* Para mantener la funcionalidad de DataTables */
    .dataTable td.glosa-cell {
        white-space: pre-wrap !important;
        overflow: visible;
    }

    /* Opcional: si quieres un scroll interno */
    .glosa-cell-scroll {
        max-height: 80px;
        overflow-y: auto;
        display: block;
        white-space: pre-wrap;
        word-wrap: break-word;
        padding: 5px;
    }
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

    .btn-excel-consolidado-detalle {
        padding: 6px 15px;
        margin-left: 5px;
        border-radius: 4px;
        font-weight: 600;
        min-width: 140px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-excel-consolidado-detalle i {
        margin-right: 6px;
        font-size: 16px;
    }

    .input-cantidad-pequena {
        width: 80px;
        height: 28px;
        font-size: 12px;
        padding: 2px 6px;
        text-align: center;
    }
</style>

<table id="consolidado_general_detalle" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
    <tr>
        <th>COD PRODUCTO</th>
        <th>PRODUCTO</th>
        <th>UNIDAD MEDIDA</th>
        <th>GLOSA</th>
        <th>CANTIDAD</th>
        <th>STOCK</th>
        <th>RESERVADO</th>
        <th>DIFERENCIA</th>
        <th>CAN COMPRAR</th>
        <th>FAMILIA</th>
    </tr>
    </thead>

    <tbody>
    @forelse($listadetalle as $item)
        <tr class="fila-detalle-consolidado-general"
            data-id="{{ $item->COD_PRODUCTO }}"
            data-nombre="{{ $item->NOM_PRODUCTO }}"
            data-detalle="{{ $item->DETALLE_POR_AREA }}"
            style="cursor: pointer;">
            <td>{{ $item->COD_PRODUCTO }}</td>
            <td>{{ $item->NOM_PRODUCTO }}</td>
            <td>{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
            <td style="padding: 8px; max-width: 250px; min-width: 150px;">
                @php
                    $glosa = $item->DETALLE_POR_AREA_GLOSA;

                    // Dividir por saltos de línea
                    $lineas = preg_split('/\R/', $glosa);

                    // Limpiar cada línea
                    $lineas = array_map(function($l) {
                        $l = trim($l);
                        // Eliminar espacios múltiples
                        $l = preg_replace('/\s+/', ' ', $l);
                        return $l;
                    }, $lineas);

                    // Filtrar líneas vacías
                    $lineas = array_filter($lineas);
                @endphp

                @foreach($lineas as $linea)
                    <div style="white-space: normal; word-wrap: break-word; margin-bottom: 3px;">
                        {{ $linea }}
                    </div>
                @endforeach
            </td>
            <td>{{ number_format($item->CANTIDAD, 2) }}</td>
            <td>{{ number_format($item->STOCK, 2) }}</td>
            <td>{{ number_format($item->RESERVADO, 2) }}</td>
            <td>{{ number_format($item->DIFERENCIA, 2) }}</td>
            <td style="width:90px;">
                <input type="number"
                       class="form-control input-sm can_comprar_cant"
                       style="height:28px; font-size:12px; padding:2px 6px; text-align:center;"
                       value="{{ intval($item->CAN_COMPRADA !== null ? $item->CAN_COMPRADA:$item->CAN_COMPRADA_CALCULADA) }}"
                       min="0"
                       oninput="if(this.value<0)this.value=0"
                       step="1"
                       @if($estado_consolidado == 'ETM0000000000005') readonly @endif>
            </td>
            <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
        </tr>
    @empty
        <tr>
            <td colspan="8" class="text-center">No se encontraron productos para este consolidado general / familia.
            </td>
        </tr>
    @endforelse
    </tbody>
</table>

<!-- CONTENEDOR NUEVO: DETALLE DEL PRODUCTO CONSOLIDADO (EN TABLA INFERIOR) -->
<div id="contenedor-detalle-producto-consolidado-general" style="display: none; margin-top: 25px;">

    <div style="position: relative; margin-bottom: 15px;">
        <h4 class="text-center" style="font-weight: bold; margin: 0; text-transform: uppercase;">
            <i class="mdi mdi-receipt"></i> DETALLE: <span id="titulo-producto-detalle-general"
                                                           class="text-primary"></span>
        </h4>
        <div style="position: absolute; right: 0; top: 0;">
            <button type="button" class="btn btn-xs btn-danger"
                    onclick="$('#contenedor-detalle-producto-consolidado-general').slideUp();">
                <i class="mdi mdi-close"></i> Cerrar
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
               id="tablaDetalleInferiorGeneral" cellspacing="0" width="100%">
            <thead class="background-th-azul">
            <tr>
                <th class="text-center">FECHA</th>
                <th class="text-center">NRO PEDIDO</th>
                <th class="text-center">AREA</th>
                <th class="text-center">CENTRO</th>
                <th class="text-center">GLOSA</th>
                <th class="text-center">CANTIDAD</th>
            </tr>
            </thead>
            <tbody style="background: white;">
            <!-- Se llena dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function () {
        let table = $("#consolidado_general_detalle").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });
        let table_detalle = $("#tablaDetalleInferiorGeneral").dataTable({
            responsive: true,
            autoWidth: true,
            lengthMenu: [[5000, 7500, 10000], [5000, 7500, 10000]],
            scrollX: true,
            scrollY: "300px",
            ordering: false,
        });
    });
</script>
