<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>INFORMACION</th>
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
          <span><b>LOTE : {{$item->ID_DOCUMENTO}} </b> </span>
          <span><b>SERIE : {{$item->SERIE}} </b> </span>
          <span><b>NUMERO  : {{$item->NUMERO}}</b></span>
          <span><b>FECCHA : </b> {{$item->FEC_VENTA}}</span>
          <span><b>FORMA PAGO : </b> {{$item->FORMA_PAGO}}</span>
          <span><b>PROVEEDOR : </b>{{$item->RZ_PROVEEDOR}} </span>
          
          <span><b>TOTAL : </b> {{number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')}}</span>
        </td>


        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>USUARIO CONTACTO : </b> {{$item->TXT_CONTACTO}}</span>
          <span><b>FOLIO : </b> {{$item->FOLIO}}</span>
          <span><b>H. OBSERVACION : </b> {{$item->TXT_OBSERVADO}}</span>
          <span><b>H. REPARABLE : </b> {{$item->TXT_REPARABLE}}</span>
        </td>



        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>PROVEEDOR : </b>  {{date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')}}</span>
          <span><b>U. CONTACTO: </b>{{date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')}}</span>
          @IF($item->OPERACION != 'DOCUMENTO_INTERNO_COMPRA')
            <span><b>CONTABILIDAD : </b> {{date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')}}</span>
          @ENDIF
          <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')}}</span>
          <div class="tools ver_cuenta_bancaria_indi select" data_orden_id = "{{$item->ID_DOCUMENTO}}" data_numero_cuenta = "{{$item->TXT_NRO_CUENTA_BANCARIA}}" data_banco_codigo = "{{$item->COD_CATEGORIA_BANCO}}"
            style="cursor: pointer;width: 80px;"> <span class="label label-success">Ver Cuenta</span></div>
          
        </td>
        @include('comprobante.ajax.estadosgestion')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/detalle-comprobante-oc-validado-estiba-oca/'.$idopcion.'/'.$item->ID_DOCUMENTO) }}">
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

