
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
  <form method="POST" id='formre' action="{{ url('/select-xml-estiba/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
        {{ csrf_field()}}
        <input type="hidden" name="jsondocumenos" id = 'jsondocumenos'>
        <input type="hidden" name="operacion_sel" id="operacion_sel" value = '{{$operacion_id}}'>

  </form>

  <div class="tools tooltiptop">
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones detalleestibs">
      <span class="tooltiptext">Detalle</span>
      <span class="icon mdi mdi-assignment"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones lotesestibas">
      <span class="tooltiptext">Lotes</span>
      <span class="icon mdi mdi-eye"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones migrarestibaadmin">
      <span class="tooltiptext">Registrar</span>
      <span class="icon mdi mdi-collection-image"></span>
    </a>
  </div>
</div>



<table id="estiba" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>DOCUMENTO</th>
      <th>EXTORNO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
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
      <tr data_requerimiento_id = "{{$item->COD_DOCUMENTO_CTBLE}}" data_lote = "{{$item->LOTE_DOC}}" data_total = "{{$item->CAN_TOTAL}}">
        <td><b>{{$index + 1}}</b></td>
        <td><b>{{$operacion_id}}</b></td>
        <td>{{$item->COD_DOCUMENTO_CTBLE}}</td>
        <td>{{$item->NRO_SERIE}} - {{$item->NRO_DOC}}</td>
        <td>{{$funcion->funciones->estorno_referencia($item->COD_DOCUMENTO_CTBLE)}}</td>
        <td>{{$item->FEC_EMISION}}</td>
        <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
        <td>{{$item->TXT_EMPR_EMISOR}}</td>
        <td>{{$item->CAN_TOTAL}}</td>
        <td>{{$item->COD_USUARIO_CREA_AUD}}</td>
        @include('comprobante.ajax.estados')
        <td>{{$item->LOTE_DOC}}</td>
        
        <td class="rigth">
          <div class="text-center be-checkbox be-checkbox-sm has-primary">
            <input  type="checkbox"
              class="{{$item->COD_DOCUMENTO_CTBLE}} input_asignar"
              data_total = "{{$item->CAN_TOTAL}}"   
              id="{{$item->COD_DOCUMENTO_CTBLE}}" >
            <label  for="{{$item->COD_DOCUMENTO_CTBLE}}"
                  data-atr = "ver"
                  class = "checkbox checkbox_asignar"
                  data_total = "{{$item->CAN_TOTAL}}"                
                  name="{{$item->COD_DOCUMENTO_CTBLE}}"
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