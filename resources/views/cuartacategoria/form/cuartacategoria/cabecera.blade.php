<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CUARTA CATEGORIA
  </div>
  <div class="panel-body panel-body-contrast">
    <table class="table table-condensed table-striped">
      <thead>
        <tr>
          <th>Atributo</th>
          <th>Valor</th>            
        </tr>
      </thead>
      <tbody>
          <tr>
            <td><b>DOCUMENTO</b></td>
            <td><p class='subtitulomerge'>{{$cuartacategoria->ID_DOCUMENTO}}</p></td>
          </tr>

          <tr>
            <td><b>PROVEEDOR</b></td>
            <td><p class='subtitulomerge'>{{$cuartacategoria->RAZON_SOCIAL}}</p></td>
          </tr>

          <tr>
            <td><b>FECHA CONSTANCIA</b></td>
            <td><p class='subtitulomerge'>{{$cuartacategoria->FECHA_CONSTANCIA}}</p></td>
          </tr>

          <tr>
            <td><b>FECHA CADUCIDAD</b></td>
            <td><p class='subtitulomerge'>{{$cuartacategoria->FECHA_CADUCIDAD}}</p></td>
          </tr>

          <tr>
            <td><b>NUMERO OPERACION</b></td>
            <td><p class='subtitulomerge'>{{$cuartacategoria->NUMERO_OPERACION}}</p></td>
          </tr>


      </tbody>
    </table>
  </div>
</div>