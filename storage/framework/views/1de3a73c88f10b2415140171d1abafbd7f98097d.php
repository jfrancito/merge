<input type="hidden" name="rutaorden" id='rutaorden' value = '<?php echo e($rutaorden); ?>'>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.sunat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    <?php echo $__env->make('comprobante.form.contrato.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>

<div class="row">
    <?php echo $__env->make('comprobante.form.contrato.pagobanco', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="row">
    <?php echo $__env->make('comprobante.form.contrato.detraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>



<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS QUE SUBIRAN AUTOMATICAMENTE
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                    <?php if($rutaorden == ''): ?>
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                <label class="col-sm-12 control-label" style="text-align: left; height: 50px;"><b>CONTRATO DE TRANS. CARGA (PDF)</b></label>
                              <div class="form-group sectioncargarimagen">
                                  <div class="col-sm-12">
                                      <div class="file-loading">
                                          <input 
                                          id="file-<?php echo e($ordencompra->COD_DOCUMENTO_CTBLE); ?>" 
                                          name="DCC0000000000026[]" 
                                          class="file-es"  
                                          type="file" 
                                          multiple data-max-file-count="1"
                                          required>
                                      </div>
                                  </div>
                              </div>
                            </div> 
                    <?php else: ?>
                      <?php $__currentLoopData = $tarchivos_g; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                        <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026'): ?>
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                <label class="col-sm-12 control-label" style="text-align: left; height: 50px;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)</b></label>
                              <div class="form-group sectioncargarimagen">
                                  <div class="col-sm-12">
                                      <div class="file-loading">
                                          <input 
                                          id="file-<?php echo e($item->COD_ORDEN); ?>" 
                                          name="<?php echo e($item['COD_CATEGORIA_DOCUMENTO']); ?>[]" 
                                          class="file-es"  
                                          type="file" 
                                          multiple data-max-file-count="1">
                                      </div>
                                  </div>
                              </div>
                            </div> 
                        <?php endif; ?>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <?php endif; ?>

                    <?php $__currentLoopData = $array_guias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                          <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>GUIA REMITENTE <?php echo e($item['NRO_SERIE']); ?> - <?php echo e($item['NRO_DOC']); ?> (PDF)</b></label>
                          <div class="form-group sectioncargarimagen">
                              <div class="col-sm-12">
                                  <div class="file-loading">
                                      <input 
                                      id="file-<?php echo e($item['COD_DOCUMENTO_CTBLE']); ?>" 
                                      name="<?php echo e($item['COD_DOCUMENTO_CTBLE']); ?>[]" 
                                      class="file-ver"  
                                      type="file" 
                                      multiple data-max-file-count="1">
                                  </div>
                              </div>
                          </div>
                        </div> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $array_guias_no; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                          <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>GUIA REMITENTE <?php echo e($item['NRO_SERIE']); ?> - <?php echo e($item['NRO_DOC']); ?> (PDF)</b></label>
                          <div class="form-group sectioncargarimagen">
                              <div class="col-sm-12">
                                  <div class="file-loading">
                                      <input 
                                      id="file-<?php echo e($item['COD_DOCUMENTO_CTBLE']); ?>" 
                                      name="<?php echo e($item['COD_DOCUMENTO_CTBLE']); ?>[]" 
                                      class="file-ver"  
                                      type="file" 
                                      multiple data-max-file-count="1"
                                      required>
                                  </div>
                              </div>
                          </div>
                        </div> 
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


              </div>
      </div>
    </div>
  </div>
</div>


<div class="row">



  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php echo $__env->make('comprobante.form.contrato.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>


  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group sectioncargarimagen">
                      <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA OBSERVACION</b> <br><br></label>
                      <div class="col-sm-12">
                          <textarea 
                          name="descripcion"
                          id = "descripcion"
                          class="form-control input-sm validarmayusculas"
                          rows="12" 
                          cols="200"    
                          data-aw="2"></textarea>
                      </div>
                  </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cajareporte <?php if((float)$monto_anticipo<=0): ?> ocultar <?php endif; ?>">
                    <div class="form-group">
                      <label class="col-sm-12 control-label labelleft" style="text-align: left;">
                        <div class="tooltipfr" style="text-align: left;"><b>Aplicar Anticipo </b>
                          <span class="tooltiptext">¿Se le aplicara el anticipo a esta factura?</span>
                        </div>
                      :</label>
                      <div class="col-sm-12 abajocaja" >
                        <?php echo Form::select( 'monto_anticipo', $comboant, array(),
                                          [
                                            'class'       => 'select2 form-control control input-sm' ,
                                            'id'          => 'monto_anticipo',
                                            'data-aw'     => '1',
                                          ]); ?>

                      </div>
                    </div>
                </div>


              </div>
      </div>
    </div>
  </div>
</div>


<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="<?php echo e(url('/gestion-de-comprobante-us/'.$idopcion)); ?>"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <?php if($fedocumento->COD_ESTADO != 'ETM0000000000007'): ?>
            <button type="submit" class="btn btn-space btn-primary btnaprobarcomporbatnte">Guardar</button>
      <?php endif; ?>
    </p>
  </div>
</div>