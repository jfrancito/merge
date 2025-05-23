
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">{{$fedocumento->OPERACION}}
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Valor</th>
              <th>Documento</th>      
              <th>XML</th>       
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'>
                  @if(count($documento_top)>0)
                    {{$documento_top->MONEDA}}
                  @endif
                  
                </p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_moneda == 1) msjexitoso @else msjerror @endif'> <b>
                      @if($fedocumento->MONEDA == 'PEN')
                          SOLES
                      @else
                          {{$fedocumento->MONEDA}}
                      @endif</b>
                  </div>
                </td>
              </tr>
              <tr>
                <td><b>Total</b></td>
                <td><p class='subtitulomerge'>{{number_format($documento_asociados->sum('MONTO'), 4, '.', ',')}}</p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                      <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')}}</b>
                  </div>
                </td>
              </tr>

            
          </tbody>
        </table>
      </div>
    </div>
