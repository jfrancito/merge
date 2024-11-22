    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETRACCION
      </div>
      <div class="panel-body panel-body-contrast">

              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Monto Factura : </b> : {{$fedocumento->TOTAL_VENTA_ORIG}}</p>
                  <p style="margin:0px;"><b>Cuenta Detracción : </b> : {{$fedocumento->CTA_DETRACCION}}</p>
                  <p style="margin:0px;"><b>Valor Detraccion</b> : {{$fedocumento->VALOR_DETRACCION}}</p>
                  <p style="margin:0px;"><b>Monto de Detracion</b> : {{$fedocumento->MONTO_DETRACCION_XML}}</p>
                  <p style="margin:0px;"><b>Pago Detraccion</b> : {{$fedocumento->TXT_PAGO_DETRACCION}}</p>
              </div>
      </div>
    </div>