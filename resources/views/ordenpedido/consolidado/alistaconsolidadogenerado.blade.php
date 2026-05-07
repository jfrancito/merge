<div class="panel panel-default" style="margin-bottom: 15px; border-radius: 8px; border: 1px solid #e1e6ef; box-shadow: 0 2px 4px rgba(0,0,0,0.05);">
    <div class="panel-body" style="padding: 12px 20px; background: #f9fbfd;">
        <div class="row">
            <div class="col-sm-5 col-md-4">
                <label style="font-weight: 700; color: #34495e; font-size: 12px; display: block; margin-bottom: 5px;">
                    <i class="mdi mdi-filter-variant" style="font-size: 16px; vertical-align: middle;"></i> FILTRAR LISTA POR ESTADO:
                </label>
                <select id="filtro-estado-consolidado" class="form-control input-sm select2">
                    <option value="TODO">MOSTRAR TODOS LOS REGISTROS</option>
                    <option value="GENERADO" selected>SÓLO EN ESTADO "GENERADO"</option>
                    <option value="CERRADO">SÓLO CERRADOS / APROBADOS</option>
                </select>
                <p class="text-muted" style="font-size: 11px; margin-top: 5px; margin-bottom: 0;">
                    * Por defecto solo se muestran los consolidados activos (GENERADO).
                </p>
            </div>
            <div class="col-sm-7 col-md-8 text-right" style="padding-top: 15px;">
                 <h4 style="margin: 0; font-weight: 700; color: #2c3e50;"> 
                    <small style="font-weight: 600;">Total listado:</small> 
                    <span id="contador-consolidados" class="text-primary">0</span>
                 </h4>
            </div>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table 
        class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
        id="tabla-consolidados-sede"
        cellspacing="0" width="100%">
        
        <thead class="background-th-azul">
            <tr>
                <th>ID CONSOLIDADO</th>
                <th>EMPRESA</th>
                <th>FEC PEDIDO</th>
                <th>MES</th>
                <th>FAMILIA</th>
                <th>ESTADO</th>
                <th>ACCIONES</th>
            </tr>
        </thead>

        <tbody>
        @foreach($listaordenconsolidado as $consolidado)

            @php 
                $cabecera = $consolidado->first(); 
                $estado_clase = '';
                if(str_contains(strtoupper($cabecera->TXT_ESTADO), 'GENERADO')) $estado_clase = 'GENERADO';
                if(str_contains(strtoupper($cabecera->TXT_ESTADO), 'CERRADO') || str_contains(strtoupper($cabecera->TXT_ESTADO), 'APROBADO')) $estado_clase = 'CERRADO';

                // Obtener familias únicas para este consolidado
                $familias_unicas = $consolidado->unique('COD_CATEGORIA_FAMILIA')->map(function($item) {
                    return [
                        'id' => $item->COD_CATEGORIA_FAMILIA,
                        'nombre' => $item->NOM_CATEGORIA_FAMILIA
                    ];
                })->values();
            @endphp

            <tr class="fila-consolidado-generado"
                data-consolidado="{{ $cabecera->ID_PEDIDO_CONSOLIDADO }}"
                data-familias="{{ json_encode($familias_unicas) }}"
                data-estado="{{ $cabecera->COD_ESTADO }}"
                style="cursor: pointer;">
                <td>{{ $cabecera->ID_PEDIDO_CONSOLIDADO }}</td>
                <td>{{ $cabecera->NOM_EMPR }}</td>
                <td>{{ $cabecera->FEC_PEDIDO }}</td>
                <td>{{ $cabecera->TXT_NOMBRE }}</td>
                <td>{{ $cabecera->NOM_CATEGORIA_FAMILIA }}</td>
                <td>{{ $cabecera->TXT_ESTADO }}</td>
                <td class="text-center">
                    @if($cabecera->COD_ESTADO == 'ETM0000000000015' || $cabecera->COD_ESTADO == 'ETM0000000000005')
                        <a href="{{ url('/exportar-excel-consolidado/'.$cabecera->ID_PEDIDO_CONSOLIDADO) }}" 
                           class="btn btn-sm btn-success" 
                           title="Exportar Excel"
                           style="border-radius: 4px; padding: 4px 8px;">
                            <i class="mdi mdi-file-excel"></i> Excel
                        </a>
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>

    </table>



    <div id="lista-detalle-consolidado-container">
        <!-- AQUÍ SE CARGARÁ EL DETALLE POR AJAX -->
    </div>
</div>
