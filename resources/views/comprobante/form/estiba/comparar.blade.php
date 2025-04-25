
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">{{$fedocumento->OPERACION}}
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Valor</th>
              <th>Contrato</th>      
              <th>XML</th>       
            </tr>
          </thead>
          <tbody>
              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'>
                  @if(count($documento_top)>0)
                    {{$documento_top->TXT_CATEGORIA_MONEDA}}
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
                <td><p class='subtitulomerge'>{{number_format($documento_asociados->sum('CAN_TOTAL'), 4, '.', ',')}}</p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                      <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')}}</b>
                  </div>
                </td>
              </tr>
              <tr>
                <td><b>Anticipo</b></td>
                <td><p class='subtitulomerge'>{{$fedocumento->SERIE_ANTICIPO}}-{{$fedocumento->NRO_ANTICIPO}}//{{$fedocumento->MONTO_ANTICIPO_DESC}}</p></td>
              </tr>
              <tr>
                <td><b>Otro anticipo</b></td>
                <td><p class='subtitulomerge'>{{$fedocumento->MONTO_ANTICIPO_DESC_OTROS}}</p></td>
              </tr>
              

          </tbody>
        </table>
      </div>
    </div>
