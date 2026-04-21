<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DAROS DE LA INTEGRACION
  </div>
  <div class="panel-body panel-body-contrast">
    <table class="table table-condensed table-striped">
      <thead>
        <tr>
          <th>Valor</th>
          <th>Orden de Compra</th>
        </tr>
      </thead>
      <tbody>
          <tr>
            <td><b>RUC</b></td>
            <td><p class='subtitulomerge'>{{$fedocumento->RUC_PROVEEDOR}}</p></td>
          </tr>
          <tr>
            <td><b>RAZON SOCIAL</b></td>
            <td><p class='subtitulomerge'>{{$fedocumento->RZ_PROVEEDOR}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($fedocumento->FEC_VENTA), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>TOTAL</b></td>
            <td><p class='subtitulomerge'>{{number_format($fedocumento->TOTAL_VENTA_SOLES, 4, '.', ',')}}</p></td>
          </tr>
          <tr>
            <td><b>FORMA PAGO</b></td>
            <td><p class='subtitulomerge'>{{$tp->NOM_CATEGORIA}}</p></td>
          </tr>
          <tr>
            <td><b>CANTIDAD ITEM</b></td>
            <td><p class='subtitulomerge'>{{count($detalleordencompra)}}</p></td>
          </tr>

          <tr>
            <td style="color: #4285f4;"><b>IMPORTE</b></td>
            <td><p class='subtitulomerge'>{{number_format($fedocumento->TOTAL_VENTA_SOLES, 4, '.', ',')}}</p></td>
          </tr>

          <tr>
            <td style="color: #4285f4;"><b>DETRACCION</b></td>
            <td  colspan="2" class=""><p class='subtitulomerge' style="font-weight: bold;">
              <b>{{$fedocumento->MONTO_DETRACCION_RED}}</b></p></td>
          </tr>

          <tr>
            <td style="color: #4285f4;"><b>RETENCION IGV</b></td>
            <td  colspan="2" class=""><p class='subtitulomerge' style="font-weight: bold;"><b>{{$fedocumento->MONTO_RETENCION}}</b></p></td>
          </tr>
      
          <tr>
            <td style="color: #4285f4;"><b>TOTAL A PAGAR</b></td>
            <td><p class='subtitulomerge' style="font-size:18px;font-weight: bold;color: #4285f4;">
              {{number_format($fedocumento->TOTAL_VENTA_SOLES - $fedocumento->MONTO_DETRACCION_RED-$fedocumento->MONTO_RETENCION, 4, '.', ',')}}
            </p></td>
          </tr>

          
          
      </tbody>
    </table>
  </div>
</div>