
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.estiba.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      <?php echo $__env->make('comprobante.form.contrato.consultaapi', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.contrato.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.estiba.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    <?php echo $__env->make('comprobante.form.estiba.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>
<?php if($fedocumento->MODO_REPARABLE == 'ARCHIVO_FISICO'): ?> 
  <div class="row">
    <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
      <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS A ENTREGAR FISICAMENTE
        </div>
        <div class="panel-body panel-body-contrast">
                <div class="row">
                  <table class="table table-condensed table-striped">
                    <thead>
                      <tr>
                        <th>ARCHIVO</th>        
                      </tr>
                    </thead>
                    <tbody>
                        <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                          <tr>
                            <td><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)</b></td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
 
                </div>
        </div>
      </div>
    </div>
  </div>
  <?php if($rol->ind_uc != 1): ?>
  <div class="row xs-pt-15">
    <div class="col-xs-6">
        <div class="be-checkbox">

        </div>
    </div>
    <div class="col-xs-6">
      <p class="text-right">
        <a href="<?php echo e(url('/gestion-de-comprobantes-reparable/'.$idopcion)); ?>"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
        <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
      </p>
    </div>
  </div>
  <?php endif; ?>

<?php else: ?>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
        </div>
        <div class="panel-body panel-body-contrast">
                <div class="row">
                  <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                      <div class="form-group sectioncargarimagen">
                          <label class="col-sm-12 control-label" style="text-align: left;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)</b> 
                            <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?> <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) <?php else: ?> <br><br> <?php endif; ?>
                          </label>
                          <div class="col-sm-12">
                              <div class="file-loading">
                                  <input 
                                  id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>" 
                                  name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]" 
                                  class="file-es"  
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


  <?php if($rol->ind_uc == 1): ?>
    <div class="row xs-pt-15">
      <div class="col-xs-6">
          <div class="be-checkbox">
          </div>
      </div>
      <div class="col-xs-6">
        <p class="text-right">
          <a href="<?php echo e(url('/gestion-de-comprobantes-reparable/'.$idopcion)); ?>"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
          <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
        </p>
      </div>
    </div>
  <?php endif; ?>

<?php endif; ?>



