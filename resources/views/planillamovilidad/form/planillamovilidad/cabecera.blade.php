<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">PLANILLA MOVILIDAD
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
            <td><p class='subtitulomerge'>{{$planillamovilidad->SERIE}} - {{$planillamovilidad->NUMERO}}</p></td>
          </tr>
          <tr>
            <td><b>TOTAL</b></td>
            <td><p class='subtitulomerge'>{{$planillamovilidad->TOTAL}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($planillamovilidad->FECHA_EMI), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA CREACION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($planillamovilidad->FECHA_CREA), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>PERIODO</b></td>
            <td><p class='subtitulomerge'>{{$planillamovilidad->TXT_PERIODO}}</p></td>
          </tr>

          <tr>
            <td><b>TRABAJADOR</b></td>
            <td><p class='subtitulomerge'>{{$planillamovilidad->TXT_TRABAJADOR}}</p></td>
          </tr>
          <tr>
            <td><b>CENTRO</b></td>
            <td><p class='subtitulomerge'>{{$planillamovilidad->TXT_CENTRO}}</p></td>
          </tr>
          <tr>
            <td><b>AUTORIZA</b></td>
            <td><p class='subtitulomerge'>{{$planillamovilidad->TXT_USUARIO_AUTORIZA}}</p></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>