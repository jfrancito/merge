<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">PLANILLA MOVILIDAD CONSOLIDADA
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
            <td><p class='subtitulomerge'>{{$feplanillaentrega->SERIE}} - {{$feplanillaentrega->NUMERO}}</p></td>
          </tr>
          <tr>
            <td><b>FOLIO</b></td>
            <td><p class='subtitulomerge'>{{$feplanillaentrega->FOLIO}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($feplanillaentrega->FEC_EMISION), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>PERIODO</b></td>
            <td><p class='subtitulomerge'>{{$feplanillaentrega->TXT_PERIODO}}</p></td>
          </tr>
          <tr>
            <td><b>CENTRO</b></td>
            <td><p class='subtitulomerge'>{{$feplanillaentrega->TXT_CENTRO}}</p></td>
          </tr>
          <tr>
            <td><b>USUSARIO</b></td>
            <td><p class='subtitulomerge'>{{$feplanillaentrega->COD_USUARIO_EMITE}}</p></td>
          </tr>
      </tbody>
    </table>
  </div>
</div>