<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO</th>
      <th>FOLIO</th>
      <th>PERIODO</th>
      <th>GLOSA</th>
      <th>CANTIDAD DOCUMENTOS</th>
      <th>ESTADO</th>
      <th>USUARIO CREA</th>
      <th>FECHA EMISION</th>
      <th>OPCION</th>
  </thead>
  <tbody>

    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}"
        class="@if($item->COD_CATEGORIA_ESTADO == 'ETM0000000000011') dobleclickpc seleccionar @endif "
        >
        <td>{{$index + 1}}</td>
        <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
        <td>{{$item->FOLIO}}</td>
        <td>{{$item->TXT_PERIODO}}</td>
        <td>{{$item->TXT_GLOSA}}</td>
        <td>{{$item->CAN_FOLIO}}</td>
        @include('entregadocumento.ajax.estados')
        <td>{{$item->nombre}}</td>
        <td>{{date_format(date_create($item->FEC_EMISION), 'd-m-Y')}}</td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/pdf-planilla-movilidad-consolidada/'.$item->ID_DOCUMENTO) }}" target="_blank">
                  Imprimir Consolidado
                </a>  
              </li>

              <li>
                <a  href="#" 
                    data_requerimiento_opcion_id = "{{$item->ID_DOCUMENTO}}"
                    class="@if($item->COD_CATEGORIA_ESTADO == 'ETM0000000000011') clickpc @endif "
                 >
                  SUBIR EL CONSOLIDADO
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


@if(isset($mensaje))
  <script type="text/javascript">
    alertajax("{{$mensaje}}");
  </script> 
@endif