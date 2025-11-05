<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">LIQUIDACION DE GASTOS
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
            <td><p class='subtitulomerge'>{{$firma->ID_DOCUMENTO}}</p></td>
          </tr>

          <tr>
            <td><b>TRABAJADOR</b></td>
            <td><p class='subtitulomerge'>{{$firma->TXT_NOMBRE}}</p></td>
          </tr>

          <tr>
            <td><b>DNI</b></td>
            <td><p class='subtitulomerge'>{{$firma->DNI}}</p></td>
          </tr>

          <tr>
            <td><b>NOMBRE ARCHIVO</b></td>
            <td><p class='subtitulomerge'>{{$firma->NOMBRE_ARCHIVO}}</p></td>
          </tr>


      </tbody>
    </table>
  </div>
</div>