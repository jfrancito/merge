<div class="table-responsive mt-4">
    <table id="tabla_detalle_consolidado_general"
    class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
           cellspacing="0" width="100%">
        <thead class="background-th-azul">
            <tr>
                <th>COD PRODUCTO</th>
                <th>PRODUCTO</th>
                <th>CENTRO</th>
                <th>UNIDA MEDIDA</th>
                <th>CANTIDAD</th>
                <th>STOCK</th>
                <th>RESERVADO</th>
                <th>DIFERENCIA</th>
                <th>FAMILIA</th>
            </tr>
        </thead>
        <tbody  style="cursor: pointer;"></tbody>
    </table>
</div>

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

<style>
    .tabla-contenedor {
        border-radius: 10px;
        border: 1px solid #e0e6ed;
        box-shadow: 0 4px 10px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .tabla-elegante thead th {
        background: #1d3a6d;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
    }

    .tabla-elegante tbody td {
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .tabla-elegante tbody tr {
        cursor: pointer;
        transition: background .2s ease;
    }

    .tabla-elegante tbody tr:hover {
        background: #f1f6ff;
    }

    .tabla-elegante tbody tr.seleccionado {
        background: #dbeafe !important;
    }
</style>