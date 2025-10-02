
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<table table id="tablaValeRendir" class="table table-striped table-borderless" style="font-style: italic;">
  <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ID</th>
            <th>Solicita</th>
            <th>Autoriza</th>
            <th>Aprueba</th>
            <th>Motivo</th>
            <th>Importe</th>
            <th>Saldo</th>
            <th class="col-glosa">Glosa</th>
            <th>Estado y Ver Detalle</th> 
        </tr>
    </thead>
    <tbody>
    @foreach($listarusuarios as $index=>$item)
    @if(
            $item['COD_CATEGORIA_ESTADO_VALE'] == 'ETM0000000000007' && 
            (
                $perfil_administracion == '1CIX00000020' || 
                $perfil_administracion == '1CIX00000033' ||
                $perfil_administracion == '1CIX00000006' ||
                ($perfil_administracion == '1CIX00000043' && $trabajadorCentro) ||
                ($perfil_administracion == '1CIX00000003' && $trabajadorCentro)

            )
        )
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


                    {{-- Estado --}}
                    @if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO')
                        <span class="badge badge-primary mb-4">POR APROBAR ADMINISTRACION</span>
                    @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO')
                        <span class="badge badge-success mb-4">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>
                    @elseif ($item['TXT_CATEGORIA_ESTADO_VALE'] === 'RECHAZADO')
                        <span class="badge badge-danger mb-4">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>
                    @else
                        <span class="badge badge-custom-danger mb-4">{{$item['TXT_CATEGORIA_ESTADO_VALE']}}</span>
                    @endif


                    @if($item['ESTADO_OSIRIS'] === 'GENERADO')
                        <span class="badge bg-white text-dark">GENERADO</span>
                    @elseif($item['ESTADO_OSIRIS'] === 'COBRADO')
                        <span class="badge badge-success">COBRADO</span>
                    @elseif($item['ESTADO_OSIRIS'] === 'RECHAZADO')
                         <span class="badge badge-custom-danger">RECHAZADO</span>
                    @endif
           
                    {{-- Ver Detalle --}}
                    <div class="dropdown">
                        <button class="btn btn-sm btn-outline-dark dropdown-toggle btn-primary"
                            type="button" id="dropdownAcciones{{ $item['ID'] }}"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="mdi mdi-eye mr-1"></i> Ver Detalle
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
                                <a class="dropdown-item verdetalleimporte-valerendir d-flex align-items-center" href="#">
                                    <i class="mdi mdi-cash text-primary mr-2"></i> Detalle Importe Gasto
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
        </tr>
        @endif
    @endforeach
    </tbody>
</table>

<style>
  .custom-glosa {
    white-space: normal;
    overflow-wrap: break-word;
    max-width: 200px;
    }

  .col-glosa {
    max-width: 150px; 
    min-width: 150px;
    width: 35%; /* O cualquier porcentaje adecuado */
    }

    .badge-custom-danger {
        background-color: #8B0000;
        color: white;
    }

    .d-dropdown-menu {
        min-width: 160px;
        max-width: 250px;
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

    .d-flex {
        display: flex !important;
    }

    .align-items-center {
        align-items: center !important;
    }

    .justify-content-center {
        justify-content: center !important;
    }

    .gap-2 {
        gap: 0.5rem !important;
    }

    .flex-wrap {
        flex-wrap: wrap !important;
    }

    .table td, .table th {
        vertical-align: middle !important;
    }

   .badge {
    margin-bottom: 8px;
    }

</style>


<script>
       @if(isset($ajax))
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    
    @endif

     $('#tablaValeRendir').DataTable({
            pageLength: 10,
            order: [[0, 'desc']],
            language: {
                url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            }
        });
     });

</script>

