
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - CONTRATO)
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
                <td><b>RUC</b></td>
                <td><p class='subtitulomerge'>{{$ordencompra->NRO_DOCUMENTO_CLIENTE}}</p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_ruc == 1) msjexitoso @else msjerror @endif'><b>{{$fedocumento->RUC_PROVEEDOR}}</b>
                  </div>
                </td>
              </tr>
              
              <tr>
                <td><b>RAZON SOCIAL</b></td>
                <td><p class='subtitulomerge'>{{$ordencompra->TXT_EMPR_EMISOR}}</p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_rz == 1) msjexitoso @else msjerror @endif'><b>{{$fedocumento->RZ_PROVEEDOR}}</b>
                  </div>
                </td>
              </tr>


              <tr>
                <td><b>Moneda</b></td>
                <td><p class='subtitulomerge'>{{$ordencompra->TXT_CATEGORIA_MONEDA}}</p></td>
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
                <td><p class='subtitulomerge'>{{number_format($ordencompra->CAN_TOTAL, 4, '.', ',')}}</p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                      <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG, 4, '.', ',')}}</b>
                  </div>
                </td>
              </tr>

              <tr>
                <td><b>Forma Pago</b></td>
                <td><p class='subtitulomerge'>{{$tp->NOM_CATEGORIA}}</p></td>
                <td>
                  <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'>{{$fedocumento->FORMA_PAGO}} 
                  </div>
                </td>
              </tr>

              <tr>
                <td><b>Cantidad item</b></td>
                <td><p class='subtitulomerge'>{{count($detalleordencompra)}}</p></td>
                <td>
                   <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'><b>{{count($detallefedocumento)}}</b>
                   </div>
                </td>
              </tr>

              <tr>
                <td><b>Anticipo</b></td>
                <td><p class='subtitulomerge'>{{$fedocumento->MONTO_ANTICIPO_DESC}}</p></td>
              </tr>

          </tbody>
        </table>
      </div>
    </div>
