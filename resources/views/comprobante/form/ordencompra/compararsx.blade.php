<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - ORDEN COMPRA)
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
            <td><p class='subtitulomerge'>{{$ordencompra->NRO_DOCUMENTO_CLIENTE}}</p></td>
          </tr>
          <tr>
            <td><b>RAZON SOCIAL</b></td>
            <td><p class='subtitulomerge'>{{$ordencompra->TXT_EMPR_CLIENTE}}</p></td>
          </tr>
          <tr>
            <td><b>FECHA EMISION</b></td>
            <td><p class='subtitulomerge'>{{date_format(date_create($ordencompra->FEC_ORDEN), 'd/m/Y')}}</p></td>
          </tr>
          <tr>
            <td><b>MONEDA</b></td>
            <td><p class='subtitulomerge'>{{$ordencompra->TXT_CATEGORIA_MONEDA}}</p></td>
          </tr>
          <tr>
            <td><b>TOTAL</b></td>
            <td><p class='subtitulomerge'>{{number_format($ordencompra->CAN_TOTAL+$ordencompra_f->CAN_PERCEPCION, 4, '.', ',')}}</p></td>
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
            <td><b>Anticipo</b></td>
            <td><p class='subtitulomerge'>{{$fedocumento->SERIE_ANTICIPO}}-{{$fedocumento->NRO_ANTICIPO}}//{{$fedocumento->MONTO_ANTICIPO_DESC}}</p></td>
          </tr>
          
      </tbody>
    </table>
  </div>
</div>