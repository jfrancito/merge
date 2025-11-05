<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
        <th>NOMBRE</th>
        <th>SEMANA</th>
        @for($i = 1; $i <= 7; $i++)
            <th>{{ ['', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'][$i] }}</th>
        @endfor
    </tr>
  </thead>
  <tbody>
        @foreach($datosAgrupados as $index => $fila)
        <tr>
            <td>{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}</td>
            <td>{{ $fila['FECHA_INICIO'] }} / {{ $fila['FECHA_FIN'] }}</td>
            {{-- Campos ocultos para información adicional --}}
            <input type="hidden" name="datos[{{ $index }}][id_documento]" value="{{ $fila['ID_DOCUMENTO'] }}">
            <input type="hidden" name="datos[{{ $index }}][txt_empresa_trabajador]" value="{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}">
            @for($dia = 1; $dia <= 7; $dia++)
                <td class="text-center">

                        @if(isset($fila['dias'][$dia]))
                            <input type="hidden" name="datos[{{ $index }}][dias][{{ $dia }}][fecha]" value="{{ $fila['dias'][$dia]['fecha'] }}">
                            <input type="hidden" name="datos[{{ $index }}][dias][{{ $dia }}][dia]" value="{{ $dia }}">
                            
                            {!! Form::select(
                                "datos[$index][dias][$dia][configuracion]", 
                                $comboconfiguracion, 
                                $fila['dias'][$dia]['data']->COD_CONFIGURACION ?? null,
                                [
                                    'class' => 'select2 form-control control input-sm',
                                    'id' => "configuracion_${index}_${dia}",
                                    'placeholder' => 'Seleccionar...'
                                ]
                            ) !!}
                            <br><small>{{ \Carbon\Carbon::parse($fila['dias'][$dia]['fecha'])->format('d/m') }}</small>
                        @else
                            -
                        @endif


                    
                </td>
            @endfor
        </tr>
        @endforeach


        @foreach($datosAgrupadosadicional as $index => $fila)
        <tr class="@if($sw_adicional==1) ocultar @endif">
            <td style="color:white;">XXXXXXXXXXXXXXA</td>
            <td >ADICIONALES</td>
            {{-- Campos ocultos para información adicional --}}
            <input type="hidden" name="datosadicional[{{ $index }}][id_documento]" value="{{ $fila['ID_DOCUMENTO'] }}">
            <input type="hidden" name="datosadicional[{{ $index }}][txt_empresa_trabajador]" value="{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}">
            
            @for($dia = 1; $dia <= 7; $dia++)
                <td class="text-center">
                    @if(isset($fila['dias'][$dia]))
                        <input type="hidden" name="datosadicional[{{ $index }}][dias][{{ $dia }}][fecha]" value="{{ $fila['dias'][$dia]['fecha'] }}">
                        <input type="hidden" name="datosadicional[{{ $index }}][dias][{{ $dia }}][dia]" value="{{ $dia }}">
                        <input type="text" 
                               name="datosadicional[{{ $index }}][dias][{{ $dia }}][configuracion]" 
                               value="{{ $fila['dias'][$dia]['data']->MONTO ?? '' }}"                         
                               placeholder="MONTO"
                               autocomplete="off" 
                               class="form-control input-sm importe" 
                               data-aw="2" 
                               style="width:100px !important;" />
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
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif
