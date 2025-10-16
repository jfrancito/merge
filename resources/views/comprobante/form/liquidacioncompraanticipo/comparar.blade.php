
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ORDEN DE PAGO
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Valor</th>
              <th>Orden Pago</th>                 
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><b>RUC</b></td>
                <td><p class='subtitulomerge'>{{$ordenpago->NRO_DOC}}</p></td>                
              </tr>
              
              <tr>
                <td><b>RAZON SOCIAL</b></td>
                <td><p class='subtitulomerge'>{{$ordenpago->TXT_EMPRESA}}</p></td>                
              </tr>


              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'>{{$ordenpago->TXT_CATEGORIA_MONEDA}}</p></td>                  
              </tr>

              <tr>
                <td><b>Total</b></td>
                <td><p class='subtitulomerge'>{{number_format($ordenpago->CAN_TOTAL, 4, '.', ',')}}</p></td>                
              </tr>
          </tbody>
        </table>
      </div>
    </div>
