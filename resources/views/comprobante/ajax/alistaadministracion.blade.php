<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ORDEN COMPRA</th>
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
          <span><b>CODIGO : {{$item->COD_ORDEN}} </b> </span>
          <span><b>FECHA  : {{$item->FEC_ORDEN}}</b></span>
          <span><b>PROVEEDOR : </b> {{$item->TXT_EMPR_CLIENTE}}</span>
          <span><b>TOTAL : </b> {{$item->CAN_TOTAL}}</span>
          <span><b>ORSERVACION : </b>               
              @if($item->ind_observacion == 1) 
                  <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
              @else
                @if($item->ind_observacion == 0) 
                    <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                @else
                    <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                @endif
              @endif
          </span>


          <span><b>CAJA CHICA : </b>  
              @if($item->TXT_A_TIEMPO == 'CAJA_SI') 
                <span class="badge badge-success" style="display: inline-block;">{{$item->TXT_A_TIEMPO}}</span>
              @else
                <span class="badge badge-default" style="display: inline-block;">{{$item->TXT_A_TIEMPO}}</span>
              @endif
          </span>  

        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG+$item->PERCEPCION+$item->MONTO_RETENCION, 4, '.', ',')}}</span>
          <span><b>PERCEPCION : </b> {{$item->PERCEPCION}}</span>
          <span><b>RETENCION : </b> {{$item->MONTO_RETENCION}}</span>
        </td>

        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
          <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
          <span style="font-size: 18px;"><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>

          <!-- <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span> -->
        </td>

        @include('comprobante.ajax.estados')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
<!--               <li>
                <a href="{{ url('/detalle-comprobante-oc-validado/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">
                    Detalle de Registro
                </a>
              </li> -->
              <li>
                <a href="{{ url('/aprobar-comprobante-administracion/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">
                  Aprobar Comprobante
                </a>  
              </li>


              <li>
                <a href="{{ url('/agregar-observacion-administracion/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">
                  Agregar Observacion
                </a>  
              </li>
              

              <li>
                <a href="{{ url('/agregar-recomendacion-administracion/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">
                  Agregar Recomendacion
                </a>  
              </li>



<!--               <li>
                <a href="{{ url('/extornar-aprobar-comprobante-administrador/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,6).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -10))) }}">
                  Rechazar Comprobante
                </a>  
              </li> -->


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