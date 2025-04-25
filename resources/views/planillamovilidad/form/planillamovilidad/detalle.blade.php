<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE LA PLANILLA MOVILIDAD
  </div>
  <div class="panel-body panel-body-contrast">

            <table class="table table-condensed table-striped">
              <thead>
                <tr>
                  <th>FECHA GASTO</th>
                  <th>MOTIVO</th>      
                  <th>LUGAR PARTIDA</th>       
                  <th>LUGAR LLEGADA</th>
                  <th>TOTAL</th>
                </tr>
              </thead>
              <tbody>
              @foreach($tdetplanillamovilidad as $index => $item)
                  <tr>
                    <td>{{$item->FECHA_GASTO}}</td>
                    <td>{{$item->TXT_MOTIVO}}</td>
                    <td>{{$item->TXT_LUGARPARTIDA}}</td>
                    <td>{{$item->TXT_LUGARLLEGADA}}</td>                    
                    <td>{{$item->TOTAL}}</td>
                  </tr>
              @endforeach
              </tbody>
            </table>


  </div>
</div>