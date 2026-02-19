@php
    $estado_consolidado = $listadetalle->first()->COD_ESTADO ?? null;
@endphp

@if($estado_consolidado != 'ETM0000000000015')
<div class="row" style="margin-bottom: 15px;">
    <div class="col-xs-12 text-right">
      
        <button type="button" class="btn btn-primary btn-detalle-consolidado" id="btn-guardar-detalle-consolidado-editado">
            <i class="mdi mdi-content-save"></i> Guardar 
        </button>

        <button type="button" class="btn btn-danger btn-detalle-consolidado" id="btn-aprobar-consolidado">
            <i class="mdi mdi-content-check"></i> Cerrar pedido
        </button>

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
</style>

<table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" 
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
        <tr>
            <th>COD_PRODUCTO</th>
            <th>PRODUCTO</th>
            <th>UNIDAD MEDIDA</th>
            <th>CANTIDAD</th>
            <th>STOCK</th>
            <th>RESERVADO</th>
            <th>DIFERENCIA</th>
            <th>CANTIDAD COMPRADA</th>
            <th>FAMILIA</th>
        </tr>
    </thead>

    <tbody>
        @forelse($listadetalle as $item)
            <tr class="fila-detalle-consolidado-generado" 
                data-id="{{ $item->COD_PRODUCTO }}" 
                data-nombre="{{ $item->NOM_PRODUCTO }}"
                data-detalle="{{ $item->DETALLE_POR_AREA }}"
                style="cursor: pointer;">
                <td>{{ $item->COD_PRODUCTO }}</td>
                <td>{{ $item->NOM_PRODUCTO }}</td>
                <td>{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                <td>{{ number_format($item->CANTIDAD, 2) }}</td>
                <td>{{ number_format($item->STOCK, 2) }}</td>
                <td>{{ number_format($item->RESERVADO, 2) }}</td>
                <td>{{ number_format($item->DIFERENCIA, 2) }}</td>
                <td class="text-center" style="width: 100px;">
                    <input type="number" 
                           class="form-control input-sm input-descontar" 
                           value="{{ !is_null($item->CAN_COMPRADA) ? intval($item->CAN_COMPRADA) : intval($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA) }}" 
                           step="1"
                           min="0"
                        style="height: 25px; text-align: center;"
                         @if($item->COD_ESTADO == 'ETM0000000000015') readonly @endif>
                </td>

                <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="10" class="text-center">No se encontraron productos para este consolidado / familia.</td>
            </tr>
        @endforelse
    </tbody>
</table>

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
                </tr>
            </thead>
            <tbody style="background: white;">
                <!-- Se llena dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

