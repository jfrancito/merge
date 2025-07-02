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
            <td><p class='subtitulomerge'>{{$liquidaciongastos->CODIGO}}</p></td>
          </tr>

          <tr>
            <td><b>MONEDA</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_CATEGORIA_MONEDA}}</p></td>
          </tr>

          <tr>
            <td><b>CUENTA</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_CUENTA}}</p></td>
          </tr>


          <tr>
            <td><b>TOTAL</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TOTAL}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($liquidaciongastos->FECHA_EMI), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA CREACION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($liquidaciongastos->FECHA_CREA), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>PERIODO</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_PERIODO}}</p></td>
          </tr>

          <tr>
            <td><b>TRABAJADOR</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_EMPRESA_TRABAJADOR}}</p></td>
          </tr>
          <tr>
            <td><b>CENTRO</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_CENTRO}}</p></td>
          </tr>
          <tr>
            <td><b>AUTORIZA</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_USUARIO_AUTORIZA}}</p></td>
          </tr>
          <tr>
            <td><b>GLOSA</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->TXT_GLOSA}}</p></td>
          </tr>

      </tbody>
    </table>
  </div>
</div>