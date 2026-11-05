<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE AGRUPADO
  </div>
  <div class="panel-body panel-body-contrast">

        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>CODIGO PRODUCTO</th>
              <th>PRODUCTO</th>      
              <th>CANTIDAD</th>       
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
            @php
                $sumaTotal = 0;
            @endphp

          @foreach($productosagru as $index => $item)
                @php
                    $sumaTotal += $item->TOTAL;
                @endphp

              <tr>
                <td>{{$item->COD_PRODUCTO}}</td>
                <td>{{$item->TXT_PRODUCTO}}</td>
                <td>{{$item->CANTIDAD}}</td>                    
                <td>{{$item->TOTAL}}</td>
              </tr>
          @endforeach

            <tr style="font-weight: bold; background-color: #f5f5f5;">
                <td></td>
                <td></td>
                <td></td>
                <td><b>{{ number_format($sumaTotal, 2) }}</b></td>
            </tr>

          </tbody>
        </table>
  </div>
</div>