<div class="card shadow-sm mb-4">
   
  <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background:#1d3a6d;color:#fff;">
            LISTA ORDEN DE PEDIDO
        </div>
    </div>
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover table-striped mb-0">
                <thead class="thead-dark">
                    <tr>
                        <th>ID PEDIDO</th>
                        <th>FECHA</th>
                        <th>MES</th>
                        <th>AÑO</th>
                        <th>TIPO PEDIDO</th>
                        <th>SOLICITA</th>
                        <th>AREA</th>
                        <th>AUTORIZA</th>
                        <th>APRUEBA GER</th>
                        <th>APRUEBA ADM</th>
                        <th>GLOSA</th>
                        <th>ESTADO</th>
                        <th>VER DETALLE</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($listapedido as $index => $item)
                       @if ($item['COD_ESTADO'] === 'ETM0000000000004' ||$item['COD_ESTADO'] === 'ETM0000000000005'  && $item['COD_TRABAJADOR_APRUEBA_GER'] === $usuario_logueado_id)
                        <tr class="align-middle">
                            <td>{{ $item['ID_PEDIDO'] }}</td>
                            <td>{{ $item['FEC_PEDIDO'] }}</td>
                            <td>{{ $item['TXT_NOMBRE'] }}</td>
                            <td>{{ $item['COD_ANIO'] }}</td>
                            <td class="col-nombre">{{ $item['TXT_TIPO_PEDIDO'] }}</td>
                            <td class="col-nombre">{{ $item['TXT_TRABAJADOR_SOLICITA'] }}</td>
                            <td class="col-nombre">{{ $item['TXT_AREA'] }}</td>
                            <td class="col-nombre">{{ $item['TXT_TRABAJADOR_AUTORIZA'] }}</td>
                            <td class="col-nombre">{{ $item['TXT_TRABAJADOR_APRUEBA_GER'] }}</td>
                            <td class="col-nombre">{{ $item['TXT_TRABAJADOR_APRUEBA_ADM'] }}</td>
                            <td class="col-glosa">{{ $item['TXT_GLOSA'] }}</td>
                            <td>@include('comprobante.ajax.estadospedido')</td>
                           <td class="text-center">
                            <div class="grupo-acciones">
                                 <button 
                                    class="btn btn-sm btn-primary ver-detalle-pedido"
                                    data-id="{{ $item['ID_PEDIDO'] }}"
                                    title="Ver detalle del pedido">
                                    <i class="fa fa-eye me-1"></i>
                                    Detalle
                                </button>
                            </div>
                           </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



<style>
    .pedido-card {
        border-radius: 6px;
        border: none;
    }

    .pedido-header {
        background: linear-gradient(90deg, #1d3a6d, #2c4f91);
        color: #fff;
        font-weight: 600;
        padding: 14px 18px;
        font-size: 15px;
        border-radius: 6px 6px 0 0;
    }

    .table thead th {
        background: #f3f5f9;
        font-size: 13px;
        font-weight: 600;
        color: #333;
        text-transform: uppercase;
        border-bottom: 2px solid #dee2e6;
        white-space: nowrap;
    }

    /* GENERAL */
    .table tbody td {
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .table-hover tbody tr:hover {
        background-color: #f8f9fc;
    }

    /* ===============================
       COLUMNAS CON 2 LÍNEAS
       =============================== */

    .col-nombre {
        max-width: 140px;
        white-space: normal !important;
        word-break: break-word;
        line-height: 1.2;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .col-glosa {
        max-width: 180px;
        white-space: normal !important;
        word-break: break-word;
        line-height: 1.2;

        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    /* ===============================
       BOTONES (SE QUEDAN IGUAL)
       =============================== */

    .grupo-acciones {
        display: flex;
        gap: 8px;
        justify-content: center;
        flex-wrap: nowrap;
    }

    .grupo-acciones .btn {
        border-radius: 4px;
        padding: 4px 10px;
        font-size: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
</style>









