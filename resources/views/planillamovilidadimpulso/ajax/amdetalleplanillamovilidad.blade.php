<div class="table-responsive" style="overflow-x: auto; max-width: 100%;">
    <table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla" style="min-width: {{ ($totalDias * 120) + 300 }}px;">
        <thead>
            <tr>
                <th style="width: 800px !important;">NOMBRE<span style="color:#fff;">xxxxxxxxxxxxxxxxxxxxxxxx</span></th>
                <th>PERIODO<span style="color:#fff;">xxxxxxxxxxxx</span></th>
                <th style="width: 150px !important;">TIPO</th>
                <th>BANCO<small style="color:#ffffff;">xxxxxxxxxx</small></th>
                @for($i = 1; $i <= $totalDias; $i++)
                    @php
                        $fechaColumna = \Carbon\Carbon::parse($datosAgrupados->first()['FECHA_INICIO'])->addDays($i-1);
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
            @foreach($datosAgrupados as $index => $fila)
            <tr>
                <td style="width: 800px !important;" class="user-avatar cell-detail user-info">{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}                             <span style="padding-left: 0px;">{{ $fila['TXT_EMPR_BANCO'] }}</span><span style="padding-left: 0px;" class="cell-detail-description">{{ $fila['TXT_NRO_CUENTA_BANCARIA'] }}</span></td>
                <td>{{date_format(date_create($fila['FECHA_INICIO']), 'd-m-Y')}}  / {{date_format(date_create($fila['FECHA_FIN']), 'd-m-Y')}}</td>
                <td style="width: 150px !important;">{{ $fila['TIPO'] }}</td>
                <td class="user-avatar cell-detail user-info">
                    @if($fila['TIPO'] == 'ASIGNADO')
                            <div class="btn-toolbar">
                              <div class="btn-group btn-space">
                                <button type="button" data_id="{{ $fila['ID_DOCUMENTO'] }}" class="btn btn-default agregar_cuenta_bancaria_oc "><i class="icon mdi mdi-settings"></i></button>
                                <button type="button" data_id="{{ $fila['ID_DOCUMENTO'] }}" class="btn btn-default ver_cuenta_bancaria"><i class="icon mdi mdi-eye"></i></button>
                              </div>
                            </div>
                    @endif
                </td>

                <input type="hidden" name="datos[{{ $index }}][id_documento]" value="{{ $fila['ID_DOCUMENTO'] }}">
                <input type="hidden" name="datos[{{ $index }}][txt_empresa_trabajador]" value="{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}">
                <input type="hidden" name="TXT_EMPR_BANCO" value="{{ $fila['TXT_EMPR_BANCO'] }}">
                <input type="hidden" name="datos[{{ $index }}][tipo]" value="{{ $fila['TIPO'] }}">
                @for($diaNumero = 1; $diaNumero <= $totalDias; $diaNumero++)
                    <td class="text-center" style="min-width: 120px;">
                        @if(isset($fila['dias'][$diaNumero]))
                            @php
                                $diaData = $fila['dias'][$diaNumero];
                            @endphp
                            <input type="hidden" name="datos[{{ $index }}][dias][{{ $diaNumero }}][fecha]" value="{{ $diaData['fecha'] }}">
                            <input type="hidden" name="datos[{{ $index }}][dias][{{ $diaNumero }}][dia]" value="{{ $diaNumero }}">
                            <input type="hidden" name="fecha_formateada" value="{{ $diaData['fecha_formateada'] }}">
                            {!! Form::select(
                                "datos[$index][dias][$diaNumero][configuracion]", 
                                $comboconfiguracion, 
                                isset($diaData['data']->COD_CONFIGURACION) ? $diaData['data']->COD_CONFIGURACION : null,
                                [
                                    'class' => 'select2 form-control control input-sm',
                                    'id' => "configuracion_{$index}_{$diaNumero}",
                                    'style' => 'min-width: 100px;'
                                ]
                            ) !!}
                            <br>
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
                <td >ADICIONALES {{ $fila['dias'][$diaNumero]['data']->MONTO ?? '' }}</td>
                <td style="width: 150px !important;">{{ $fila['TIPO'] }}</td>
                <td></td>
                <input type="hidden" name="datosadicional[{{ $index }}][id_documento]" value="{{ $fila['ID_DOCUMENTO'] }}">
                <input type="hidden" name="datosadicional[{{ $index }}][txt_empresa_trabajador]" value="{{ $fila['TXT_EMPRESA_TRABAJADOR'] }}">
                <input type="hidden" name="TXT_EMPR_BANCO" value="{{ $fila['TXT_EMPR_BANCO'] }}">
                <input type="hidden" name="datos[{{ $index }}][tipo]" value="{{ $fila['TIPO'] }}">

                @for($diaNumero = 1; $diaNumero <= $totalDias; $diaNumero++)
                    <td class="text-center" style="min-width: 120px;">
                        @if(isset($fila['dias'][$diaNumero]))
                            @php
                                $diaData = $fila['dias'][$diaNumero];
                            @endphp
                            <input type="hidden" name="datosadicional[{{ $index }}][dias][{{ $diaNumero }}][fecha]" value="{{ $diaData['fecha'] }}">
                            <input type="hidden" name="datosadicional[{{ $index }}][dias][{{ $diaNumero }}][dia]" value="{{ $diaNumero }}">
                            <input type="hidden" name="fecha_formateada" value="{{ $diaData['fecha_formateada'] }}">

                            <input type="text" 
                                   name="datosadicional[{{ $index }}][dias][{{ $diaNumero }}][configuracion]" 
                                   value="{{ $fila['dias'][$diaNumero]['data']->MONTODETALLE ?? '' }}"                         
                                   placeholder="MONTO"
                                   autocomplete="off" 
                                   class="form-control input-sm importe" 
                                   data-aw="2" 
                                   style="width:100px !important;" />

                            <br>

                        @else
                            -
                        @endif
                    </td>
                @endfor
            </tr>
            @endforeach


        <tr style="font-weight: bold;">
            <td style="color:white;">XXXXXXXXXXXXXXX</td>
            <td></td>
            <td></td>
            <td><b>TOTALES</b></td>
            @for($diaNumero = 1; $diaNumero <= $totalDias; $diaNumero++)
                @php
                    $totalDia = 0;
                    
                    // Sumar montos de datosAgrupados
                    foreach($datosAgrupados as $fila) {
                        if(isset($fila['dias'][$diaNumero])) {
                            $totalDia += $fila['dias'][$diaNumero]['data']->MONTODETALLE ?? 0;
                        }
                    }
                    
                    // Sumar montos de datosAgrupadosadicional
                    foreach($datosAgrupadosadicional as $fila) {
                        if(isset($fila['dias'][$diaNumero])) {
                            $totalDia += $fila['dias'][$diaNumero]['data']->MONTODETALLE ?? 0;
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


@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif
