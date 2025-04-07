<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
  </div>
  <div class="panel-body panel-body-contrast">

        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>FECHA EMISION</th>
              <th>DOCUMENTO</th>      
              <th>TIPO DOCUMENTO</th>       
              <th>PROVEEDOR</th>
              <th>TOTAL</th>
            </tr>
          </thead>
          <tbody>
          @foreach($tdetliquidaciongastos as $index => $item)
              <tr>
                <td>{{date_format(date_create($item->FECHA_EMISION), 'd/m/Y')}}</td>
                <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
                <td>{{$item->TXT_TIPODOCUMENTO}}</td>
                <td>{{$item->TXT_EMPRESA_PROVEEDOR}}</td>                    
                <td>{{$item->TOTAL}}</td>
              </tr>
          @endforeach
          </tbody>
        </table>
  </div>
</div>