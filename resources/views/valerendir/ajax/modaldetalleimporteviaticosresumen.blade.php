<div class="scroll_text scroll_text_heigth_aler">
<table class="table table-bordered" style="width:100%; background-color:#f8f9fa;">
    <thead>
        <tr>
            <th colspan="2" class="text-center fw-bold">REPORTE DE VIAJE DE GESTIÓN</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <th>FECHA DE INICIO DE VIAJE</th>
            <td>{{ \Carbon\Carbon::parse($fecha_inicio)->format('d/m/Y') ?? '' }}</td>
        </tr>
        <tr>
            <th>FECHA DE FIN DE VIAJE</th>
            <td>{{ \Carbon\Carbon::parse($fecha_fin)->format('d/m/Y') ?? '' }}</td>
        </tr>
        <tr>
            <th>CIUDAD DE PARTIDA</th>
          
              <td>
                 @if($cod_centro == 'CEN0000000000001')
                    CHICLAYO
                @elseif($cod_centro == 'CEN0000000000002')
                    LIMA
                @elseif($cod_centro == 'CEN0000000000004')
                    RIOJA
                @elseif($cod_centro == 'CEN0000000000006')
                    BELLAVISTA
                @else
                    {{ $cod_centro }}
                @endif
            </td>
        
        </tr>
        <tr>
            <th>CIUDAD DE DESTINO</th>
            <td>{{ $ultimo_destino ?? '' }}</td>
        </tr>
        <tr>
            <th>RUTA DE VIAJE</th>
            <td>{{ $ruta_viaje ?? '' }}</td>
        </tr>
        <tr>
            <th>ACCIONES DE TRABAJO A REALIZAR</th>
            <td>{{ $txt_glosa }} </td> 
        </tr>
         @if(isset($areacomercial) && strtoupper($areacomercial) == 'COMERCIAL')
            <tr>
                <th>MONTO APROX. DE VENTA</th>
                <td>{{ $txt_glosa_venta }}</td>
            </tr>
            <tr>
                <th>MONTO APROX. DE COBRANZA</th>
                <td>{{ $txt_glosa_cobranza }}</td>
            </tr>
        @endif
        <tr>
            <th>NUM. NOCHES DE ESTADÍA</th>
            <td>{{ $total_dias ?? 0 }} NOCHES</td>
        </tr>
    </tbody>
</table>
</div>

