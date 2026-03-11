<table id="table1" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>DOCUMENTO / CONTRATO</th>
      <th>PROVEEDOR / SEDE</th>
      <th>PRODUCTO / COSECHA</th>
      <th>PRODUCCIÓN</th>
      <th>FINANZAS</th>
      <th>ESTADO</th>
      <th class="text-center">ACCIÓN</th>
    </tr>
  </thead>
  <tbody>
    @foreach($lcontratoacopio as $index => $item)
      <tr data_requerimiento_id="{{$item->ID_DOCUMENTO}}">
        <td class="text-center">{{$index + 1}}</td>
        <td class="cell-detail">
          <span><b>ID:</b> {{$item->ID_DOCUMENTO}}</span>
          <span class="cell-detail-description"><b>NRO:</b> {{$item->NRO_CONTRATO}}</span>
          <span class="cell-detail-description"><b>REGISTRO:</b> {{date_format(date_create($item->FECHA_CONTRATO), 'd-m-Y')}}</span>
        </td>
        <td class="cell-detail">
          <span><b>PROVEEDOR:</b> {{$item->TXT_PROVEEDOR}}</span>
          <span class="cell-detail-description"><b>SEDE:</b> {{$item->TXT_CENTRO}}</span>
        </td>
        <td class="cell-detail">
          <span><b>VARIEDAD:</b> {{$item->TXT_VARIEDAD}}</span>
          <span class="cell-detail-description"><b>COSECHA:</b> {{date_format(date_create($item->FECHA_COSECHA), 'd-m-Y')}}</span>
        </td>
        <td class="cell-detail">
          <span><b>HECTÁREAS:</b> {{number_format($item->HECTAREAS, 2, '.', ',')}}</span>
          <span class="cell-detail-description"><b>TOTAL KG:</b> {{number_format($item->TOTAL_KG, 2, '.', ',')}}</span>
          <span class="cell-detail-description"><b>P. REF:</b> {{number_format($item->PRECIO_REFERENCIA, 4, '.', ',')}}</span>
        </td>
        <td class="cell-detail">
          <span><b>PROYECCIÓN:</b> {{number_format($item->PROYECCION, 2, '.', ',')}}</span>
          <span class="cell-detail-description text-primary-dark text-bold"><b>HABILITAR:</b> {{number_format($item->IMPORTE_HABILITAR, 2, '.', ',')}}</span>
        </td>
        @include('cuartacategoria.ajax.estados')

        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/gestion-revisar-acopio-contrato/'.$idopcion.'/'.Hashids::encode(substr($item->ID_DOCUMENTO, -8))) }}">
                  Revisar Acopio Contrato
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


      $("#nso_f").dataTable({
          dom: 'Bfrtip',
          buttons: [
              'csv', 'excel', 'pdf'
          ],
          "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
          columnDefs:[{
              targets: "_all",
              sortable: false
          }]
      });



    });
  </script> 
@endif

