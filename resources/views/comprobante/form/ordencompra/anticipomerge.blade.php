    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ANTICIPO ASOCIADOS
      </div>
      <div class="panel-body panel-body-contrast">

        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Lote</th>
              <th>Detraccion</th>
              <th>Retencion</th>
              <th>Monto</th>      
              <th>Fecha</th>       
            </tr>
          </thead>
          <tbody>
             @foreach($lista_anticipo_merge as $index => $item)  
                <tr>
                  <td>{{$item->ID_DOCUMENTO}}</td>
                  <td>{{number_format($item->MONTO_DETRACCION_RED, 2, '.', ',')}}</td>
                  <td>{{number_format($item->MONTO_ANTICIPO_DESC, 2, '.', ',')}}</td>
                  <td>{{number_format($item->TOTAL_VENTA_ORIG, 2, '.', ',')}}</td>
                  <td>{{$item->fecha_uc}}</td>
                </tr>
              @endforeach
          </tbody>
        </table>

      </div>
    </div>