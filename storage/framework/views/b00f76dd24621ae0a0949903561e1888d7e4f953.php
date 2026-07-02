<td>
  <?php if($item->COD_ESTADO_FE == 'ETM0000000000001'): ?> 
      <span class="badge badge-default"><?php echo e($item->TXT_ESTADO); ?></span> 
  <?php else: ?>
    <?php if(is_null($item->COD_ESTADO_FE)): ?> 
        <span class="badge badge-default">GENERADO</span>
    <?php else: ?>
      <?php if($item->COD_ESTADO_FE == 'ETM0000000000002'): ?> 
          <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
      <?php else: ?>
        <?php if($item->COD_ESTADO_FE == 'ETM0000000000003'): ?> 
            <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
        <?php else: ?>
          <?php if($item->COD_ESTADO_FE == 'ETM0000000000004'): ?> 
              <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
          <?php else: ?>
            <?php if($item->COD_ESTADO_FE == 'ETM0000000000005'): ?> 
                <span class="badge badge-primary"><?php echo e($item->TXT_ESTADO); ?></span>
            <?php else: ?>
              <?php if($item->COD_ESTADO_FE == 'ETM0000000000006'): ?> 
                  <span class="badge badge-danger"><?php echo e($item->TXT_ESTADO); ?></span>
              <?php else: ?>
                <?php if($item->COD_ESTADO_FE == 'ETM0000000000007'): ?> 
                    <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
                <?php else: ?>
                  <?php if($item->COD_ESTADO_FE == 'ETM0000000000008'): ?> 
                      <span class="badge badge-success"><?php echo e($item->TXT_ESTADO); ?></span>
                  <?php else: ?>
                    <?php if($item->COD_ESTADO_FE == 'ETM0000000000009'): ?> 
                        <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
                    <?php else: ?>
                        <span class="badge badge-default"><?php echo e($item->TXT_ESTADO); ?></span>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif; ?>
            <?php endif; ?>
          <?php endif; ?>
        <?php endif; ?>
      <?php endif; ?>
    <?php endif; ?>
  <?php endif; ?>
  <br>
  <span><b>ORSERVACION : </b>               
      <?php if($item->ind_observacion == 1): ?> 
          <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
      <?php else: ?>
        <?php if($item->ind_observacion == 0): ?> 
            <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
        <?php else: ?>
            <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
        <?php endif; ?>
      <?php endif; ?>
  </span>
  <br>
  <?php echo $__env->make('comprobante.ajax.areparable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</td>