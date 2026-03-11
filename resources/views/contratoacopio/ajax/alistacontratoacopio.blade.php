<table id="table1" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>ID DOCUMENTO</th>
      <th>FECHA CONTRATO</th>

      <th>CENTRO</th>
      <th>NRO CONTRATO</th>
      <th>PROVEEDOR</th>

      <th>FECHA COSECHA</th>
      <th>VARIEDAD</th>
      <th>HECTAREAS</th>
      <th>TOTAL KG</th>
      <th>PRECIO REFERENCIA</th>
      <th>PROYECCION</th>
      <th>IMPORTE HABILITAR</th>

      <th>ESTADO</th>
      <th>OPCION</th>

    </tr>
  </thead>
  <tbody>

    @foreach($lcontratoacopio as $index => $item)
      <tr data_requerimiento_id = "{{$item->ID_DOCUMENTO}}"
        >
        <td>{{$index + 1}}</td>
        <td>{{$item->ID_DOCUMENTO}}</td>
        <td>{{date_format(date_create($item->FECHA_CONTRATO), 'd-m-Y')}}</td>

        <td>{{$item->TXT_CENTRO}}</td>
        <td>{{$item->NRO_CONTRATO}}</td>
        <td>{{$item->TXT_PROVEEDOR}}</td>
        <td>{{date_format(date_create($item->FECHA_COSECHA), 'd-m-Y')}}</td> 
        <td>{{$item->TXT_VARIEDAD}}</td>
        <td>{{$item->HECTAREAS}}</td>
        <td>{{$item->TOTAL_KG}}</td>
        <td>{{$item->PRECIO_REFERENCIA}}</td>
        <td>{{$item->PROYECCION}}</td>
        <td>{{$item->IMPORTE_HABILITAR}}</td>
        @include('cuartacategoria.ajax.estados')
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>
                <a href="{{ url('/descargar-documento-cuarta-categoria/'.$item->ID_DOCUMENTO) }}">
                  Descargar 4ta Categoria
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

