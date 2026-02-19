@php
    $estado_consolidado = $listadetalle->first()->COD_ESTADO ?? null;
@endphp

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
</style>

<table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" 
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
        <tr>
            <th>COD PRODUCTO</th>
            <th>PRODUCTO</th>
            <th>CENTRO</th>
            <th>UNIDAD MEDIDA</th>
            <th>CANTIDAD</th>
            <th>STOCK</th>
            <th>RESERVADO</th>
            <th>DIFERENCIA</th>
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
                <td>{{ $item->NOM_CENTRO }}</td>
                <td>{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                <td>{{ number_format($item->CANTIDAD, 2) }}</td>
                <td>{{ number_format($item->STOCK, 2) }}</td>
                <td>{{ number_format($item->RESERVADO, 2) }}</td>
                <td>{{ number_format($item->DIFERENCIA, 2) }}</td>
                <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="9" class="text-center">No se encontraron productos para este consolidado general / familia.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<!-- CONTENEDOR NUEVO: DETALLE DEL PRODUCTO CONSOLIDADO (EN TABLA INFERIOR) -->
<div id="contenedor-detalle-producto-consolidado-general" style="display: none; margin-top: 25px;">
    
    <div style="position: relative; margin-bottom: 15px;">
        <h4 class="text-center" style="font-weight: bold; margin: 0; text-transform: uppercase;">
            <i class="mdi mdi-receipt"></i> DETALLE: <span id="titulo-producto-detalle-general" class="text-primary"></span>
        </h4>
        <div style="position: absolute; right: 0; top: 0;">
            <button type="button" class="btn btn-xs btn-danger" onclick="$('#contenedor-detalle-producto-consolidado-general').slideUp();">
                <i class="mdi mdi-close"></i> Cerrar
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" id="tablaDetalleInferiorGeneral" cellspacing="0" width="100%">
            <thead class="background-th-azul">
                <tr>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">NRO PEDIDO</th>
                    <th class="text-center">AREA</th>
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
