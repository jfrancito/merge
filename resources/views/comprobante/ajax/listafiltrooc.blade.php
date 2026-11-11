<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
      <th>IND ITEMS</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_ORDEN}}">
        <td><b>ORDER DE COMPRA</b></td>
        <td>{{$item->COD_ORDEN}}</td>
        <td>{{$item->FEC_ORDEN}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>{{$item->TXT_EMPR_CLIENTE}}</td>
        <td>{{$item->CAN_TOTAL}}</td>
        <td>{{$item->COD_USUARIO_CREA_AUD}}</td>
        <td >  
          <div class="text-center be-checkbox be-checkbox-sm" >
            <input  type="checkbox"
                    class="{{$item->COD_ORDEN}} input_check_pe_ln check{{$item->COD_ORDEN}}" 
                    id="check{{$item->COD_ORDEN}}" 
                    data_producto = "{{$item->COD_ORDEN}}" 
                    @if($item->TXT_CONFORMIDAD != '') checked = 'checked' @endif>

            <label  for="check{{$item->COD_ORDEN}}"
                  data-atr = "ver"
                  class = "checkbox"                    
                  name="check{{$item->COD_ORDEN}}"
            ></label>
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