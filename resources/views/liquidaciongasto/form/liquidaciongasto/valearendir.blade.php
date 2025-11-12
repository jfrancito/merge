<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">VALE ARENDIR
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
            <td><b>ID (MERGE)</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->ARENDIR_ID}}</p></td>
          </tr>
          <tr>
            <td><b>TIPO (MERGE)</b></td>
            <td><p class='subtitulomerge'>{{$liquidaciongastos->ARENDIR}}</p></td>
          </tr>

          @if(count($valearendir_info)>0)
          <tr>
            <td><b>DOCUMENTO (OSIRIS)</b></td>
            <td><p class='subtitulomerge'>{{$valearendir_info->TXT_SERIE}} - {{$valearendir_info->TXT_NUMERO}}</p></td>
          </tr>
          @endif
      </tbody>
    </table>
  </div>
</div>