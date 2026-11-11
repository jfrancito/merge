<div class="table-responsive" style="overflow-x: auto; max-width: 100%;">

    @if(count($datosParaVista)>0)
        <table id="nso_check" class="table table-striped table-borderless td-color-borde td-padding-7 listatabla" style="min-width: {{ ($totalDias * 120) + 300 }}px;">
            <thead>
                <tr>
                    <th>TRABAJADOR<small style="color:#ffffff;">xxxxxxxxxxxxxxxxxxxxxxxxxxxxxx</small></th>
                    <th>PERIODO<small style="color:#ffffff;">xxxxxxxxxxxxxxx</small></th>
                    <th style="width: 150px !important;">TIPO</th>
                    <th>BANCO<small style="color:#ffffff;">xxxxxxxxxxxxxxx</small></th>

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
                <tr class=" @if($fila['TIPO'] == 'ADICIONAL') ocultar @endif">
                    <td style="width: 300px !important;" >{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}</td>
                    <td>{{date_format(date_create($fila['FECHA_INICIO']), 'd-m-Y')}}  / {{date_format(date_create($fila['FECHA_FIN']), 'd-m-Y')}}</td>
                    <td style="width: 150px !important;">{{ $fila['TIPO'] }}</td>
                    <td class="user-avatar cell-detail user-info">
                        @if($fila['TIPO'] == 'ASIGNADO')
                            <span style="padding-left: 0px;">{{ $fila['TXT_EMPR_BANCO'] }}</span><span style="padding-left: 0px;" class="cell-detail-description">{{ $fila['TXT_NRO_CUENTA_BANCARIA'] }}</span>
                        @endif
                    </td>
                    
                    <input type="hidden" name="datos[{{ $index }}][id_documento]" value="{{ $fila['ID_DOCUMENTO'] }}">
                    <input type="hidden" name="datos[{{ $index }}][txt_empresa_trabajador]" value="{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}">
                    <input type="hidden" name="datos[{{ $index }}][tipo]" value="{{ $fila['TIPO'] }}">
                    <input type="hidden" name="TXT_EMPR_BANCO" value="{{ $fila['TXT_EMPR_BANCO'] }}">
                    
                    @for($diaNumero = 1; $diaNumero <= $totalDias; $diaNumero++)
                        <td class="text-center" style="min-width: 120px;" fecha_formateada="">
                            @if(isset($fila['dias'][$diaNumero]))
                                @php
                                    $diaData = $fila['dias'][$diaNumero];
                                @endphp
                                <input type="hidden" name="datos[{{ $index }}][dias][{{ $diaNumero }}][fecha]" value="{{ $diaData['fecha'] }}">
                                <input type="hidden" name="datos[{{ $index }}][dias][{{ $diaNumero }}][dia]" value="{{ $diaNumero }}">
                                <input type="hidden" name="fecha_formateada" value="{{ $diaData['fecha_formateada'] }}">
                                @if($fila['TIPO'] == 'ASIGNADO')
 
                                {{isset($diaData['data']->MONTODETALLE) ? $diaData['data']->MONTODETALLE : (isset($diaData['data']->COD_CONFIGURACION) ? $diaData['data']->COD_CONFIGURACION : '')}}
                                
                                @elseif($fila['TIPO'] == 'OTRO_TIPO' || $fila['TIPO'] == 'ADICIONAL')
                                    {{isset($diaData['data']->MONTODETALLE) ? $diaData['data']->MONTODETALLE : (isset($diaData['data']->COD_CONFIGURACION) ? $diaData['data']->COD_CONFIGURACION : '')}}
                                @else
                                    0
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
