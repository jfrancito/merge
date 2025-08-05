<table class="table table-striped table-borderless" style="font-style: italic;">
    <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ID</th>
            <th>Solicita</th>
            <th>Autoriza</th>
            <th>Aprueba</th>
            <th>Motivo</th>
            <th>Importe</th>
            <th>Saldo</th>
            <th>Glosa</th>  
            <th>Estado y Ver detalle</th>  
            <th>Acción</th>  
        </tr>
    </thead>
    <tbody>
    @foreach($listarusuarios as $index=>$item)
     @if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO'  && $item['USUARIO_APRUEBA_ID'] === $usuario_logueado_id)
      
        <tr data_vale_rendir="{{$item['ID']}}">
            <td>{{$item['ID']}}</td>
            <td>{{$item['USUARIO']}}</td>
            <td>{{$item['USUARIO_AUTORIZA']}}</td>
            <td>{{$item['USUARIO_APRUEBA']}}</td>
            <td>{{$item['TIPO_MOTIVO']}}</td>
            <td>{{$item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$' }} {{ $item['CAN_TOTAL_IMPORTE'] }}</td>
            <td>{{$item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$' }} {{ $item['CAN_TOTAL_SALDO'] }}</td>
            <td class="custom-glosa">{{$item['TXT_GLOSA']}}</td>

            @php
             $motivosPermitidos = [
            'GASTOS DE OPERACION',
            'GASTOS DE REPRESENTACION',
            'GASTOS DE MARKETING Y PUBLICIDAD',
            'GASTOS DE CAPACITACION Y FORMACION',
            'GASTOS DE INVESTIGACION Y DESARROLLO'
            ];
            @endphp

            <td class="align-middle text-center">
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                @if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO')
                    <span class="badge badge-primary">POR APROBAR ADMINISTRACION</span> 
                @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO')
                    <span class="badge badge-warning">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>
                @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO')
                    <span class="badge badge-success">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>    
                @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'RECHAZADO')
                    <span class="badge badge-danger">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>
                @else
                     <span class="badge badge-custom-danger">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>                        
                @endif

         

                <div class="dropdown">

                         <button class="btn btn-sm btn-outline-dark dropdown-toggle text-left btn-primary" style="margin-top: 7px;"
                                type="button" id="dropdownAcciones{{ $item['ID'] }}"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="mdi mdi-eye mr-1"></i> Ver Detalle
                        </button>

                  
                 <div class="dropdown-menu d-dropdown-menu shadow-sm p-1" aria-labelledby="dropdownAcciones{{ $item['ID'] }}">

                       @if (!empty($item['TXT_GLOSA_AUTORIZADO']) || in_array($item['TIPO_MOTIVO'], $motivosPermitidos))
                            <a class="dropdown-item show-glosa d-flex align-items-center" href="#"
                                    data-glosa="{{ $item['TXT_GLOSA_AUTORIZADO'] }}"
                                    data-type="autoriza">
                                     <i class="mdi mdi-close-circle-outline text-danger mr-2"></i> Glosa de Autorización
                            </a>
                       @endif

                       @if(!in_array($item['TIPO_MOTIVO'], $motivosPermitidos))
                      
                         <a class="dropdown-item verdetalleimporte-valerendir d-flex align-items-center" href="#">
                           <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                        </a>
                        @endif
                    </div>
                </div>
           </td>

             <td>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    @if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO')
                      <button class="btn btn-space btn-check btn-social registroaprobar-valerendir" 
                            data-toggle="tooltip" data-placement="top"> Aprobar
                    </button>
                    @endif
                    @if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO')
                        <button class="btn btn-space btn-close btn-social rechazar-valerendir" 
                                data-toggle="tooltip" data-placement="top" 
                                data-valerendir-id="{{ $item['ID'] }}" data-toggle="modal" data-target="#rechazoModal">
                                Rechazar
                        </button>
                    @endif
                </div>
            </td>
        </tr>
        @endif
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

    .btn-check {
        background-color: #28a745; /* Color verde */
        border-color: #28a745;
        color: white;
    }

    .btn-check:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .btn-close {
        background-color: #dc3545; /* Color rojo */
        border-color: #dc3545;
        color: white;
    }

    .btn-close:hover {
        background-color: #c82333;
        border-color: #bd2130;
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

    td.custom-glosa {
    white-space: pre-line; 
    word-wrap: break-word; 
    max-width: 200px; 
    height: auto; 
    word-break: break-word;
    }
</style>

<script>
  
    @if(isset($ajax))
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    @endif
</script>