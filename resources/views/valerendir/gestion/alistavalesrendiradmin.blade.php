<table id="nsovales" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>VALE A RENDIR</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listavale as $index => $item)
      <tr data_vale_rendir="{{ $item->ID }}">

        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>ID :</b> {{ $item->ID }}</span>
          <span><b>FECHA  :</b> {{ $item->FEC_USUARIO_CREA_AUD }}</span>
          <span><b>TRABAJADOR : </b> {{ $item->TXT_NOM_SOLICITA }} </span>
          <span><b>CUENTA :</b> {{ substr($item->COD_CONTRATO, 0, 6) . '-' . substr($item->COD_CONTRATO, -6) }} -- S/ OTRAS CTAS X COBRAR</span>
          <span><b>SUB CUENTA : </b> {{ $item->SUB_CUENTA }}</span>
          <span><b>CENTRO :</b>
                  @if($item->COD_CENTRO == 'CEN0000000000001')
                      CHICLAYO
                  @elseif($item->COD_CENTRO == 'CEN0000000000002')
                      LIMA
                  @elseif($item->COD_CENTRO == 'CEN0000000000004')
                      RIOJA
                  @elseif($item->COD_CENTRO == 'CEN0000000000006')
                      BELLAVISTA
                  @else
                      {{ $item->COD_CENTRO }}
                  @endif
          </span>
          <span><b>DESTINO :</b> {{ $item->NOM_DESTINO }}</span>


          
          <span><b>OSIRIS DOCUMENTO : </b> {{ $item->TXT_SERIE }} - {{ $item->TXT_NUMERO }}</span>
          <span><b>OSIRIS ID : </b> {{ $item->ID_OSIRIS }} </span>



          <span><b>TOTAL : </b> {{ $item->CAN_TOTAL_IMPORTE }} </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>JEFE : </b> {{ $item->TXT_NOM_AUTORIZA }} </span>
          <span><b>ADMINISTRACION : </b> {{ $item->TXT_NOM_APRUEBA }} </span>
        </td>
         @include('valerendir.gestion.estados')

         <td class="rigth">
       <div class="btn-group btn-hspace"
            @if($item->TIPO_MOTIVO != 'TIP0000000000003') style="display:none;" @endif>
            <button type="button" id="dropdownAcciones{{ $item->ID }}" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
                <li>
                    <a class="dropdown-item verdetalleimporte-valegestion d-flex align-items-center" href="#">
                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                    </a>
                </li>

                <li>
                    <a class="dropdown-item verdetalle-valegestion d-flex align-items-center" href="#">
                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Aumentar Días Rendición 
                    </a>
                </li>

                <li>
                    <a class="dropdown-item aumdetalleimporte-valegestion d-flex align-items-center" href="#">
                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Aumentar Importe Viáticos 
                    </a>
                </li>
            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif


