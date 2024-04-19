<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th></th>
      <th>CODIGO ORDEN</th>
      <th>FECHA ORDEN</th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_ORDEN}}">
        <td>  
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="{{$item->COD_ORDEN}} input_check_pe_ln check{{$item->COD_ORDEN}}" 
                    id="{{$item->COD_ORDEN}}">
            <label  for="{{$item->COD_ORDEN}}"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="{{$item->COD_ORDEN}}"
            ></label>
          </div>
        </td>

        <td>{{$item->COD_ORDEN}}</td>
        <td>{{$item->FEC_ORDEN}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>{{$item->TXT_EMPR_CLIENTE}}</td>
        <td>{{$item->CAN_TOTAL}}</td>

        @include('comprobante.ajax.estados')

        
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/detalle-comprobante-oc-validado/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                    Detalle de Registro
                </a>
              </li>
              <li>
                <a href="{{ url('/extornar-aprobar-comprobante/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10))) }}">
                  Extornar Comprobante
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