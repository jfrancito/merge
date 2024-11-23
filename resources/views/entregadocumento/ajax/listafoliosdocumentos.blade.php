<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>OPERACION</th>
      <th>FOLIO</th>
      <th>BANCO</th>
      
      <th>GLOSA</th>


      <th>CANTIDAD DOCUMENTOS</th>
      <th>USUARIO CREA</th>
      <th>FECHA CREA</th>
      <th>OPCION</th>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr data_requerimiento_id = "{{$item->FOLIO}}"
        class='dobleclickpc seleccionar'
        >
        <td>{{$index + 1}}</td>
        <td>{{$item->OPERACION}}</td>
        <td>{{$item->FOLIO}}</td>
        <td>{{$item->TXT_CATEGORIA_BANCO}}</td>

        <td>{{$item->TXT_GLOSA}}</td>
        <td>{{$item->CAN_FOLIO}}</td>
        <td>{{$item->nombre}}</td>
        <td>{{date_format(date_create($item->FECHA_CREA), 'd-m-Y h:i:s')}}</td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/descargar-folio-excel/'.$item->FOLIO) }}">
                  Descargar Resumen
                </a>  
              </li>
              @if($item->OPERACION=='CONTRATO')
                <li>
                  <a href="{{ url('/descargar-pago-proveedor-bcp-excel/'.$item->FOLIO) }}">
                    Detalle Informativo
                  </a>  
                </li>

                <li>
                  <a href="{{ url('/descargar-pago-proveedor-macro-excel/'.$item->FOLIO) }}">
                    Macro de BCP
                  </a>  
                </li>

                <li>
                  <a href="{{ url('/descargar-pago-proveedor-macro-bbva-excel/'.$item->FOLIO) }}">
                    Macro de BBVA
                  </a>  
                </li>
                <li>
                  <a href="{{ url('/descargar-pago-proveedor-macro-sbk-excel/'.$item->FOLIO) }}">
                    Macro de SBK
                  </a>  
                </li>
                <li>
                  <a href="{{ url('/descargar-pago-proveedor-macro-interbank-excel/'.$item->FOLIO) }}">
                    Macro de INTERBANK
                  </a>  
                </li>



              @endif
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