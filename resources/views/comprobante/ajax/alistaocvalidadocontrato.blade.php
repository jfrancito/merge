<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>

      <th>CONTRATO</th>
      <th>FACTURA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index+1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : {{$item->COD_DOCUMENTO_CTBLE}} </b> </span>
          <span><b>FECHA  : {{$item->FEC_EMISION}}</b></span>
          <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_EMISOR}}</span>
          <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
          <span><b>DOCUMENTO : </b> {{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</span>
          <span><b>CENTRO : </b> {{$item->NOM_CENTRO}}</span>

          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>AREA : </b> {{$item->AREA}}</span>
          <span><b>FOLIO : </b> {{$item->FOLIO}}</span>
          <span><b>H. OBSERVACION : </b> {{$item->TXT_OBSERVADO}}</span>
          <span><b>H. REPARABLE : </b> {{$item->TXT_REPARABLE}}</span>


        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
          <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
          <span><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>
          <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
        </td>
        @include('comprobante.ajax.estadosgestion')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/detalle-comprobante-oc-validado-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">
                    Detalle de Registro
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

