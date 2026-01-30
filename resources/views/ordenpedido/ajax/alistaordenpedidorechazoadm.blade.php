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
                        <th>FRECUENCIA</th>
                        <th>SOLICITA</th>
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
                                @if ($item['COD_ESTADO'] === 'ETM0000000000006'&& trim($item['COD_USUARIO_MODIF_AUD']) === trim($cod_usuario_modifica))
                        <tr class="align-middle">
                            <td>{{ $item['ID_PEDIDO'] }}</td>
                            <td>{{ $item['FEC_PEDIDO'] }}</td>
                            <td>{{ $item['TXT_NOMBRE'] }}</td>
                            <td>{{ $item['COD_ANIO'] }}</td>
                            <td>{{ $item['TXT_TIPO_PEDIDO'] }}</td>
                            <td>{{ $item['TXT_TIPO_FRECUENCIA'] }}</td>
                            <td>{{ $item['TXT_TRABAJADOR_SOLICITA'] }}</td>
                            <td>{{ $item['TXT_TRABAJADOR_AUTORIZA'] }}</td>
                            <td>{{ $item['TXT_TRABAJADOR_APRUEBA_GER'] }}</td>
                            <td>{{ $item['TXT_TRABAJADOR_APRUEBA_ADM'] }}</td>
                            <td>{{ $item['TXT_GLOSA'] }}</td>
                            <td>
                                 @include('comprobante.ajax.estadospedido')
                           <td class="text-center">

                            <div class="btn-group" role="group">

                                <!-- VER DETALLE -->
                                <button 
                                    class="btn btn-sm btn-primary ver-detalle-pedido"
                                    data-id="{{ $item['ID_PEDIDO'] }}"
                                    title="Ver detalle del pedido">
                                    <i class="fa fa-eye me-1"></i>
                                    Detalle
                                </button>
                        </td>
                        </tr>
                        @endif
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>













