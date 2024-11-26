<table id="{{$id}}" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla"  style="width:100% !important">
  <thead>

    <tr>
      <th></th>
      <th colspan="4" style="background: #eee; text-align:center;">DATOS DE LA FACTURA</th>
      <th colspan="4" style="background: #efe; text-align:center;">CONTRATO</th>
      <th></th>
      <th></th>
      <th></th>
    </tr>

    <tr>
      <th>ITEM</th>
      <th>FECHA EMISION</th>
      <th>PROVEEDOR</th>
      <th>NRO CPE</th>
      <th>TOTAL</th>

      <th>FECHA EMISION</th>
      <th>CODIGO</th>
      <th>COND. PAGO</th>
      <th>USUARIO CONTACTO</th>

      <th>TIEMPO AT.</th>
      <th>CAJA CHICA.</th>

      <th>REVISION</th>
    </tr>

  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">

        <td>{{$index+1}}</td>

        <td>{{date_format(date_create($item->FEC_VENTA), 'd-m-Y')}}</td>
        <td>{{$item->RZ_PROVEEDOR}}</td>
        <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
        <td>{{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</td>

        <td>{{date_format(date_create($item->FEC_EMISION), 'd-m-Y')}}</td>
        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
        <td>{{$item->TXT_CATEGORIA_CONDICION_PAGO}}</td>
        <td>{{$item->TXT_CONTACTO_UC}}</td>


        <td>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</td>
        <td>              
          @if($item->TXT_A_TIEMPO == 'CAJA_SI') 
            <span class="badge badge-success" style="display: inline-block;">{{$item->TXT_A_TIEMPO}}</span>
          @else
            <span class="badge badge-default" style="display: inline-block;">{{$item->TXT_A_TIEMPO}}</span>
          @endif
        </td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/aprobar-comprobante-contabilidad-contrato/'.$idopcion.'/'.$item->DOCUMENTO_ITEM.'/'.substr($item->ID_DOCUMENTO, 0,7).'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -9))) }}">
                  Revision Comprobante
                </a>  
              </li>

            </ul>
          </div>
        </td>
      </tr>                    
    @endforeach
  </tbody>
</table>