
<div class="panel-heading">

  <div class="tools tooltiptop">
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones">
      <span class="tooltiptext">Total Seleccionado</span>
      <b class='totalseleccion' style="font-size:16px;">0.0000</b>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones">
      <span class="tooltiptext">Cantidad Seleccionado</span>
      <b class='cantidaseleccion' style="font-size:16px;">0</b>
    </a>

  </div>


</div>
<br>

<div class="panel-heading">
  <form method="POST" id='formre' action="{{ url('/select-xml-comision/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
        {{ csrf_field()}}
        <input type="hidden" name="jsondocumenos" id = 'jsondocumenos'>

  </form>
  <div class="tools tooltiptop">
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones lotescomision">
      <span class="tooltiptext">Lotes</span>
      <span class="icon mdi mdi-eye"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones migrarcomisionadmin">
      <span class="tooltiptext">Registrar</span>
      <span class="icon mdi mdi-collection-image"></span>
    </a>
  </div>
</div>



<table id="estiba" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID</th>
      <th>MOVIMIENTO</th>
      <th>BANCO</th>
      <th>CUENTA</th>
      <th>FECHA REGISTRO</th>
      <th>FECHA MOVIMIENTO</th>
      <th>NRO CUENTA</th>    
      <th>NRO VOUCHER</th>
      <th>MONEDA</th>
      <th>TOTAL</th>
      <th>ESTADO</th>
      <th>LOTE</th>
      <th>
        <div class="text-center be-checkbox be-checkbox-sm has-primary">
          <input  type="checkbox"
                  class="todo_asignar input_asignar"
                  id="todo_asignar"
          >
          <label  for="todo_asignar"
                  data-atr = "todas_asignar"
                  class = "checkbox_asignar"
                  name="todo_asignar"
            ></label>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_OPERACION_CAJA}}" 
          data_lote = "{{$item->LOTE_DOC}}" 
          data_total = "@if($item->MONEDA=='SOLES') {{$item->MONTO_SOLES}} @else {{$item->MONTO_DOLARES}} @endif">
        <td><b>{{$index + 1}}</b></td>
        <td>{{$item->COD_OPERACION_CAJA}}</td>
        <td>{{$item->TXT_ITEM_MOVIMIENTO}}</td>
        <td>{{$item->NOMBRE_BANCO_CAJA}}</td>
        <td>{{$item->CUENTA}}</td>
        <td>{{$item->FEC_REGISTRO}}</td>
        <td>{{$item->FEC_MOVIMIENTO}}</td>
        <td>{{$item->NRO_CUENTA_BANCARIA}}</td>
        <td>{{$item->NRO_VOUCHER}}</td>
        <td>{{$item->MONEDA}}</td>
        <td>@if($item->MONEDA=='SOLES') {{$item->MONTO_SOLES}} @else {{$item->MONTO_DOLARES}} @endif</td>
        <td>{{$item->ESTADO}}</td>
        <td>{{$item->LOTE_DOC}}</td>
        <td class="rigth">
          <div class="text-center be-checkbox be-checkbox-sm has-primary">
            <input  type="checkbox"
              class="{{$item->COD_OPERACION_CAJA}} input_asignar"
              data_total = "@if($item->MONEDA=='SOLES') {{$item->MONTO_SOLES}} @else {{$item->MONTO_DOLARES}} @endif"   
              id="{{$item->COD_OPERACION_CAJA}}" >
            <label  for="{{$item->COD_OPERACION_CAJA}}"
                  data-atr = "ver"
                  class = "checkbox checkbox_asignar"
                  data_total = "@if($item->MONEDA=='SOLES') {{$item->MONTO_SOLES}} @else {{$item->MONTO_DOLARES}} @endif"                
                  name="{{$item->COD_OPERACION_CAJA}}"
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