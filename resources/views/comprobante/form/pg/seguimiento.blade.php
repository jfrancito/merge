    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SEGUIMIENTO DE DOCUMENTO
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Fecha</th>
              <th>Usuario</th>      
              <th>Tipo</th>
              <th>Mensaje</th>

            </tr>
          </thead>
          <tbody>

              @foreach($documentohistorial as $index => $item)  
                <tr>
                  <td>{{date_format(date_create($item->FECHA), 'd-m-Y H:i:s')}}</td>
                  <td>{{$item->USUARIO_NOMBRE}}</td>
                  <td><b>{{$item->TIPO}}</</b></td>
                  <td>{{$item->MENSAJE}}</td>

                </tr>
              @endforeach

          </tbody>
        </table>

      </div>
    </div>