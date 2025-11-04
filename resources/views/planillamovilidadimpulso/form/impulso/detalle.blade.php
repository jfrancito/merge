<div tabindex="0" class="panel panel-default panel-contrast pnldetallesdocumentos">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
    </div>
    <div class="panel-body panel-body-contrast">

    <table id="tblactivos" class="table table-condensed table-striped">
      <thead>
        <tr>
            <th>NOMBRE</th>
            <th>SEMANA</th>
            @for($i = 1; $i <= 7; $i++)
                <th class="text-center">{{ ['', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'][$i] }}</th>
            @endfor
        </tr>
      </thead>
      <tbody>
            @foreach($datosAgrupados as $index => $fila)
            <tr>
                <td>{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}</td>
                <td>{{ $fila['FECHA_INICIO'] }} / {{ $fila['FECHA_FIN'] }}</td>
                @for($dia = 1; $dia <= 7; $dia++)
                    <td class="text-center">
                            @if(isset($fila['dias'][$dia]))
                                <b>{{$fila['dias'][$dia]['data']->MONTO ?? null}}</b>
                                <br><small>{{ \Carbon\Carbon::parse($fila['dias'][$dia]['fecha'])->format('d/m') }}</small>
                            @else
                                -
                            @endif
            
                    </td>
                @endfor
            </tr>
            @endforeach


            @foreach($datosAgrupadosadicional as $index => $fila)
            <tr>
                <td style="color:white;">XXXXXXXXXXXXXXA</td>
                <td >ADICIONALES</td>

                @for($dia = 1; $dia <= 7; $dia++)
                    <td class="text-center">
                        @if(isset($fila['dias'][$dia]))
                            {{ $fila['dias'][$dia]['data']->MONTO ?? '' }}
                        @else
                            -
                        @endif
                    </td>
                @endfor
            </tr>
            @endforeach

            <tr style="font-weight: bold;">
                <td style="color:white;">XXXXXXXXXXXXXXX</td>
                <td><b>TOTALES</b></td>
                @for($dia = 1; $dia <= 7; $dia++)
                    @php
                        $totalDia = 0;
                        
                        // Sumar montos de datosAgrupados
                        foreach($datosAgrupados as $fila) {
                            if(isset($fila['dias'][$dia])) {
                                $totalDia += $fila['dias'][$dia]['data']->MONTO ?? 0;
                            }
                        }
                        
                        // Sumar montos de datosAgrupadosadicional
                        foreach($datosAgrupadosadicional as $fila) {
                            if(isset($fila['dias'][$dia])) {
                                $totalDia += $fila['dias'][$dia]['data']->MONTO ?? 0;
                            }
                        }
                    @endphp
                    <td class="text-center" style="font-size: 16px; color: #000; font-weight: bold;">
                        S/ {{ number_format($totalDia, 2) }}
                    </td>
                @endfor
            </tr>


      </tbody>
    </table>

    </div>
    <input type="hidden" id="total_xml" name="total_xml"
           value=""/>
</div>
