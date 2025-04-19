<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>LIQUIDACION COMPRA</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}">
        <td>{{$index + 1}}</td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>CODIGO : {{$item->ID_DOCUMENTO}} </b> </span>
          <span><b>FECHA  : {{$item->FECHA_EMI}}</b></span>
          <span><b>TRABAJADOR : </b>{{$item->TXT_EMPRESA_TRABAJADOR}} </span>
          <span><b>CUENTA : </b>{{$item->TXT_CUENTA}} </span>
          <span><b>SUB CUENTA : </b>{{$item->TXT_SUBCUENTA}} </span>
          <span><b>CENTRO : </b>{{$item->TXT_CENTRO}} </span>
          <span><b>PERIODO : </b>{{$item->TXT_PERIODO}} </span>
          <span><b>TOTAL : </b> {{$item->TOTAL}}</span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>JEFE : </b> {{date_format(date_create($item->FECHA_JEFE_APRUEBA), 'd-m-Y h:i:s')}}</span>
          <span><b>ADMINISTRACION : </b> {{date_format(date_create($item->FECHA_ADM_APRUEBA), 'd-m-Y h:i:s')}}</span>
        </td>
        @include('comprobante.ajax.estadosfe')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/detalle-comprobante-lg-validado/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
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