<table id="nso_check" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>PLANILLA</th>
      <th>PERIODO</th>

      <th>CODIGO</th>
      <th>FECHA EMISION</th>
      <th>TRABAJADOR</th>
      <th>PERIODO</th>
      <th>TOTAL</th>
      <th></th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr 
        data_requerimiento_id = "{{$item->ID_DOCUMENTO}}"
        class="toptable" 
        >
        <td>{{$index +1}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{$item->TXT_PERIODO}}</td>

        <td>{{$item->CODIGO}}</td>
        <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
        <td>{{$item->FECHA_EMI}}</td>
        <td>{{$item->TXT_TRABAJADOR}}</td>
        <td>{{$item->TOTAL}}</td>
        <td>
          <div class="text-center be-checkbox be-checkbox-sm has-primary">
            <input  type="checkbox"
              class="{{$item->ID_DOCUMENTO}} input_asignar selectfolio"
              id="{{$item->ID_DOCUMENTO}}"
              @if(isset($entregable_sel)  && $item->FOLIO_RESERVA==$entregable_sel->FOLIO) checked @endif>

            <label  for="{{$item->ID_DOCUMENTO}}"
                  data-atr = "ver"
                  class = "checkbox checkbox_asignar"                    
                  name="{{$item->ID_DOCUMENTO}}"
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


@if(isset($mensaje))
  <script type="text/javascript">
    alertajax("{{$mensaje}}");
  </script> 
@endif