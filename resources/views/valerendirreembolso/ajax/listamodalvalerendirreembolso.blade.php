<table id="vale" class="table table-bordered td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%" style="font-style: italic;">
    <thead>
        <tr>
            <th class="col">ID</th>
            <th class="col">Autoriza</th>
            <th class="col">Motivo</th>
            <th class="col">Importe</th>
            <th class="col">Saldo</th>
            <th class="col">Glosa</th>  
            <th class="col">Estado Merge</th>  
            <th class="col">Ver Detalle</th>  
            <th class="col">Anular</th>  


        </tr>
    </thead>
    <tbody>
        @foreach($listarusuarios as $index=>$item)  
        <tr class="dobleclickpc" data_vale_rendir_reembolso="{{$item['ID']}}" style="cursor:pointer;">
            <td>{{$item['ID']}}</td>
            <td>{{$item['USUARIO_AUTORIZA']}}</td>
            <td>{{$item['TIPO_MOTIVO']}}</td>
            <td>{{$item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$' }} {{ $item['CAN_TOTAL_IMPORTE'] }}</td>
            <td>{{$item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$' }} {{ $item['CAN_TOTAL_SALDO'] }}</td>

            <td class="custom-glosa">{{$item['TXT_GLOSA']}}</td>
            <td>
                @if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'GENERADO')
                    <span class="badge badge-warning">POR AUTORIZAR JEFATURA</span>
                @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO')
                    <span class="badge badge-primary">POR APROBAR ADMINISTRACION</span>
                @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO')
                    <span class="badge badge-success">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>    
                @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'RECHAZADO')
                    <span class="badge badge-danger">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>
                @else
                     <span class="badge badge-custom-danger">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>                        
                @endif
            </td>

            @php
             $motivosPermitidos = [
            'GASTOS DE OPERACION',
            'GASTOS DE REPRESENTACION',
            'GASTOS DE MARKETING Y PUBLICIDAD',
            'GASTOS DE CAPACITACION Y FORMACION',
            'GASTOS DE INVESTIGACION Y DESARROLLO'
            ];
            @endphp
           
            <td class="custom-glosa1">

                <div class="dropdown">

                         <button class="btn btn-sm btn-outline-dark dropdown-toggle text-left btn-primary" style="margin-top: 1px;"
                                type="button" id="dropdownAcciones{{ $item['ID'] }}"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="mdi mdi-eye mr-4"></i> Ver Detalle
                        </button>
                       <div class="dropdown-menu d-dropdown-menu shadow-sm p-1" aria-labelledby="dropdownAcciones{{ $item['ID'] }}">
                            @if(!empty($item['TXT_GLOSA_RECHAZADO']))
                                <a class="dropdown-item show-glosa d-flex align-items-center" href="#"
                                   data-glosa="{{ $item['TXT_GLOSA_RECHAZADO'] }}"
                                   data-type="rechazo">
                                   <i class="mdi mdi-close-circle-outline text-danger mr-2"></i> Glosa de Rechazo
                                </a>
                            @endif

                            @if(!in_array($item['TIPO_MOTIVO'], $motivosPermitidos))
                          
                             <a class="dropdown-item verdetalleimporte-valerendir-vale d-flex align-items-center" href="#">
                               <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Importe Gastos
                            </a>
                            @endif

                            @if(!empty($item['TXT_GLOSA_AUTORIZADO']) && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO')
                               <a class="dropdown-item show-glosa d-flex align-items-center" href="#"
                                       data-glosa="{{ $item['TXT_GLOSA_AUTORIZADO'] }}"
                                       data-type="autoriza">
                                       <i class="mdi mdi-close-circle-outline text-danger mr-2"></i> Glosa de Autorización
                                </a>
                            @endif

                             @if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO')
                                <a class="dropdown-item verdetalleaprobar-valerendir d-flex align-items-center" href="#">
                                    <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                                </a>
                            @endif
  
                    </div>
                     </div>
                </div>
             </td>
          
            <td style="text-align: center; vertical-align: middle;">
                 @if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'ANULADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'AUTORIZADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO')
                    <button class="btn-rojo delete-valerendir">
                        <i class="icon mdi mdi-delete"></i>
                    </button>
                @endif
            </td>

        </tr>
         
        @endforeach
    </tbody>
</table>

<style>

    .d-dropdown-menu {
    width: auto !important;
    min-width: 150px; 
    max-width: 100px;
    white-space: normal;
    }

    .dropdown-menu a.dropdown-item {
    white-space: normal;
    display: flex;
    align-items: center;
    padding: 0.4rem 0.75rem;
    }   

    .dropdown-menu .dropdown-item + .dropdown-item {
    margin-top: 4px;
    }
    .badge-custom-danger {
        background-color: #8B0000; /* Rojo oscuro */
        color: white;
    }

    td.custom-glosa1 {
        display: flex;
        align-items: center;
        gap: 5px; /* Espacio entre botones */
        flex-wrap: wrap;
        }

    .btn-rojo {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    }

    .btn-rojo i {
    color: white;
    }

    .btn-rojo:hover {
    background-color: #c9302c;
    }

    .col {
    background: #1d3a6d;; 
    color: white;              
    vertical-align: middle;
    }

    .selected {
    background-color: #7d9ac0 !important;
    color: #FFFFFF;
    vertical-align: middle;
    padding: 1.5em;
    }
</style>

