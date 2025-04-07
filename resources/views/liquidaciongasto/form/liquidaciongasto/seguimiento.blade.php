    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SEGUIMIENTO DE DOCUMENTO
      </div>
      <div class="panel-body panel-body-contrast">
        <div class='long-text' id="longText">
          <table class="table table-condensed table-striped">
            <thead>
              <tr>
                <th>SEGUIMIENTO</th>
              </tr>
            </thead>
            <tbody>
              @foreach($documentohistorial as $index => $item)  
                <tr>
                  <td>
                    <span class="cell-detail-description"><b>FECHA : </b> {{date_format(date_create($item->FECHA), 'd-m-Y H:i:s')}}</span><br>
                    <span class="cell-detail-description"><b>USUARIO : </b> {{$item->USUARIO_NOMBRE}}</span><br>
                    <span class="cell-detail-description"><b>TIPO : </b> {{$item->TIPO}}</span><br>
                    <span class="cell-detail-description"><b>MENSAJE : </b> {{$item->MENSAJE}}</span>
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      <p style="margin-top: 20px;">
        <a id="toggleButton" onclick="toggleContent()" class="read-more" style="cursor: pointer; font-size: 1.2em;">+ Ver Más</a>
      </p>
      </div>
    </div>