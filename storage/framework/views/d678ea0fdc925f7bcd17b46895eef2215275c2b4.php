    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DE FACTURA
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Serie</b> : <?php echo e($fedocumento->SERIE); ?></p>
                  <p style="margin:0px;"><b>Numero</b> : <?php echo e($fedocumento->NUMERO); ?></p>
                  <p style="margin:0px;"><b>Fecha Factura</b> : <?php echo e($fedocumento->FEC_VENTA); ?></p>
                  <p style="margin:0px;"><b>Fecha Vencimiento</b> : <?php echo e($fedocumento->FEC_VENCI_PAGO); ?></p>
              </div>
      </div>
    </div>