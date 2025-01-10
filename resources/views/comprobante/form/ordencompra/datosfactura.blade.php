    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DE FACTURA
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Serie</b> : {{$fedocumento->SERIE}}</p>
                  <p style="margin:0px;"><b>Numero</b> : {{$fedocumento->NUMERO}}</p>
                  <p style="margin:0px;"><b>Fecha Factura</b> : {{$fedocumento->FEC_VENTA}}</p>
                  <p style="margin:0px;"><b>Fecha Vencimiento</b> : {{$fedocumento->FEC_VENCI_PAGO}}</p>
              </div>
      </div>
    </div>