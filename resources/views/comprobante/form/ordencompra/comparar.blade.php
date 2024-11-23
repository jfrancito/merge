<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - ORDEN COMPRA)
  </div>
  <div class="panel-body panel-body-contrast">
    <table class="table table-condensed table-striped">
      <thead>
        <tr>
          <th>Valor</th>
          <th>Orden de Compra</th>      
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
            <td><p class='subtitulomerge'>{{$ordencompra->TXT_EMPR_CLIENTE}}</p></td>
            <td>
              <div class='subtitulomerge @if($fedocumento->ind_rz == 1) msjexitoso @else msjerror @endif'><b>{{$fedocumento->RZ_PROVEEDOR}}</b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($ordencompra->FEC_ORDEN), 'd/m/Y')}}</p></td>
            <td>
              <div class='subtitulomerge @if($fedocumento->ind_fecha == 1) msjexitoso @else msjerror @endif'><b>{{date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y')}}</b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>MONEDA</b></td>
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
            <td><b>TOTAL</b></td>
            <td><p class='subtitulomerge'>{{number_format($ordencompra->CAN_TOTAL+$ordencompra_f->CAN_PERCEPCION, 4, '.', ',')}}</p></td>
            <td>
              <div class='subtitulomerge @if($fedocumento->ind_total == 1) msjexitoso @else msjerror @endif'>
                  <!-- <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG+$fedocumento->PERCEPCION+$fedocumento->MONTO_RETENCION, 4, '.', ',')}}</b> -->

                  <b>{{number_format($fedocumento->TOTAL_VENTA_ORIG+$fedocumento->PERCEPCION, 4, '.', ',')}}</b>
              </div>
            </td>
          </tr>

          <tr>
            <td><b>FORMA PAGO</b></td>
            <td><p class='subtitulomerge'>{{$tp->NOM_CATEGORIA}}</p></td>
            <td>
              <div class='subtitulomerge @if($fedocumento->ind_formapago == 1) msjexitoso @else msjerror @endif'>{{$fedocumento->FORMA_PAGO}} 
              </div>
            </td>
          </tr>

          <tr>
            <td><b>CANTIDAD ITEM</b></td>
            <td><p class='subtitulomerge'>{{count($detalleordencompra)}}</p></td>
            <td>
               <div class='subtitulomerge @if($fedocumento->ind_cantidaditem == 1) msjexitoso @else msjerror @endif'><b>{{count($detallefedocumento)}}</b>
               </div>
            </td>
          </tr>

          <tr>
            <td><b>PERCEPCION</b></td>
            <td  colspan="2" class=""><b>{{$fedocumento->PERCEPCION}}</b></td>
          </tr>

          <tr>
            <td><b>RETENCION</b></td>
            <td  colspan="2" class=""><b>{{$fedocumento->MONTO_RETENCION}}</b></td>
          </tr>

      </tbody>
    </table>
  </div>
</div>