<div class="table-responsive" style="overflow-x: auto; max-width: 100%;">

    @if(count($datosParaVista)>0)
        <table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="min-width: {{ ($totalDias * 120) + 300 }}px;">
            <thead>
                <tr>
                    <th>TRABAJADOR<small style="color:#ffffff;">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</small></th>
                    <th>PERIODO<small style="color:#ffffff;">xxxxxxxxxxxxxxx</small></th>
                    <th style="width: 150px !important;">TIPO</th>
                    @for($i = 1; $i <= $totalDias; $i++)
                        @php
                            $fechaColumna = \Carbon\Carbon::parse($datosParaVista[0]['FECHA_INICIO'])->addDays($i-1);
                            $diasSemana = [
                                'Monday' => 'Lunes',
                                'Tuesday' => 'Martes', 
                                'Wednesday' => 'Miércoles',
                                'Thursday' => 'Jueves',
                                'Friday' => 'Viernes',
                                'Saturday' => 'Sábado',
                                'Sunday' => 'Domingo'
                            ];
                            $nombreDia = $diasSemana[$fechaColumna->format('l')] ?? $fechaColumna->format('D');
                        @endphp
                        <th style="min-width: 120px;text-align: center;" title="{{ $nombreDia }}">
                            {{ $nombreDia }} ({{ $fechaColumna->format('d/m') }})
                        </th>
                    @endfor
                </tr>
            </thead>
            <tbody>
                @foreach($datosParaVista as $index => $fila)
                <tr>
                    <td style="width: 300px !important;">{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}</td>
                    <td>{{ $fila['FECHA_INICIO'] }} / {{ $fila['FECHA_FIN'] }}</td>
                    <td style="width: 150px !important;">{{ $fila['TIPO'] }}</td>
                    
                    <input type="hidden" name="datos[{{ $index }}][id_documento]" value="{{ $fila['ID_DOCUMENTO'] }}">
                    <input type="hidden" name="datos[{{ $index }}][txt_empresa_trabajador]" value="{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}">
                    <input type="hidden" name="datos[{{ $index }}][tipo]" value="{{ $fila['TIPO'] }}">
                    
                    @for($diaNumero = 1; $diaNumero <= $totalDias; $diaNumero++)
                        <td class="text-center" style="min-width: 120px;">
                            @if(isset($fila['dias'][$diaNumero]))
                                @php
                                    $diaData = $fila['dias'][$diaNumero];
                                @endphp
                                <input type="hidden" name="datos[{{ $index }}][dias][{{ $diaNumero }}][fecha]" value="{{ $diaData['fecha'] }}">
                                <input type="hidden" name="datos[{{ $index }}][dias][{{ $diaNumero }}][dia]" value="{{ $diaNumero }}">
                                
                                @if($fila['TIPO'] == 'ASIGNADO')
                                <!-- Para ASIGNADO: Solo SELECT -->
                                {!! Form::select(
                                    "datos[$index][dias][$diaNumero][configuracion]", 
                                    $fila['combo_configuracion'], 
                                    isset($diaData['data']->COD_CONFIGURACION) ? $diaData['data']->COD_CONFIGURACION : null,
                                    [
                                        'class' => 'select2 form-control control input-sm',
                                        'id' => "configuracion_{$index}_{$diaNumero}",
                                        'style' => 'min-width: 100px;'
                                    ]
                                ) !!}
                                
                                @elseif($fila['TIPO'] == 'OTRO_TIPO' || $fila['TIPO'] == 'ADICIONAL')
                                <!-- Para OTRO_TIPO/ADICIONAL: Solo INPUT TEXT -->
                                {!! Form::text(
                                    "datos[$index][dias][$diaNumero][valor_texto]", 
                                    isset($diaData['data']->MONTODETALLE) ? $diaData['data']->MONTODETALLE : (isset($diaData['data']->COD_CONFIGURACION) ? $diaData['data']->COD_CONFIGURACION : ''),
                                    [
                                        'class' => 'form-control control input-sm importe',
                                        'id' => "texto_{$index}_{$diaNumero}",
                                        'style' => 'min-width: 100px;',
                                        'placeholder' => 'Ingrese valor'
                                    ]
                                ) !!}
                                @else
                                <!-- Para otros tipos no especificados: SELECT por defecto -->
                                {!! Form::select(
                                    "datos[$index][dias][$diaNumero][configuracion]", 
                                    $fila['combo_configuracion'], 
                                    isset($diaData['data']->COD_CONFIGURACION) ? $diaData['data']->COD_CONFIGURACION : null,
                                    [
                                        'class' => 'select2 form-control control input-sm',
                                        'id' => "configuracion_{$index}_{$diaNumero}",
                                        'style' => 'min-width: 100px;'
                                    ]
                                ) !!}
                                @endif
                                
                            @else
                                -
                            @endif
                        </td>
                    @endfor
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>


@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif
