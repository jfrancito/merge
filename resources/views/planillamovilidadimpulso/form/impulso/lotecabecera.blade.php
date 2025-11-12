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
            <td><b>SEMANA</b></td>
            <td><p class='subtitulomerge'>{{$loteimpulso->FECHA_INICIO}} / {{$loteimpulso->FECHA_FIN}}</p></td>
          </tr>

          <tr>
            <td><b>MONTO</b></td>
            <td><p class='subtitulomerge'>{{$loteimpulso->MONTO}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA CREACION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($loteimpulso->FECHA_CREA), 'd/m/Y')}}</p></td>
          </tr>

          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($loteimpulso->FECHA_EMI), 'd/m/Y')}}</p></td>
          </tr>

      </tbody>
    </table>
  </div>
</div>