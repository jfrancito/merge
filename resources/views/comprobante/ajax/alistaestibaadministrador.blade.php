<div class="panel-heading">{{ $titulo }}

  <form method="POST" id='formre' action="{{ url('/select-xml-estiba/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
        {{ csrf_field()}}
        <input type="hidden" name="jsondocumenos" id = 'jsondocumenos'>
  </form>
  <div class="tools tooltiptop">
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones detalleestibs">
      <span class="tooltiptext">Detalle de Estibas</span>
      <span class="icon mdi mdi-assignment"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones lotesestibas">
      <span class="tooltiptext">Lotes Estiba</span>
      <span class="icon mdi mdi-eye"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones migrarestibaadmin">
      <span class="tooltiptext">Registrar Estiba</span>
      <span class="icon mdi mdi-collection-image"></span>
    </a>
  </div>
</div>



<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
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

      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->COD_DOCUMENTO_CTBLE}}" data_lote = "{{$item->LOTE_DOC}}">
        <td><b>{{$index + 1}}</b></td>
        <td><b>ESTIBA</b></td>
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
              id="{{$item->COD_DOCUMENTO_CTBLE}}" >
            <label  for="{{$item->COD_DOCUMENTO_CTBLE}}"
                  data-atr = "ver"
                  class = "checkbox checkbox_asignar"                    
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