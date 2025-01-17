<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>

      <th>DOCUMENTO</th>
      <th>INFORMACION</th>
      <th>REGISTRO</th>
      
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->id}}">

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>LOTE : {{$item->ID_DOCUMENTO}} </b> </span>
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECHA : </b> {{$item->FEC_VENTA}}</span>

        </td>

        <td class="cell-detail sorting_1" style="position: relative;">

          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
          <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
          <span><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>
          <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
        </td>

        @include('comprobante.ajax.estados')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/observacion-comprobante-uc-estiba/'.$idopcion.'/'.$item->ID_DOCUMENTO) }}">Observacion</a>  
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