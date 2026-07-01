<td>
  <?php if($item->COD_ESTADO == 'ETM0000000000001'): ?> 
      <span class="badge badge-default"><?php echo e($item->TXT_ESTADO); ?></span> 
  <?php else: ?>
    <?php if(is_null($item->COD_ESTADO)): ?> 
        <span class="badge badge-default">GENERADO</span>
    <?php else: ?>
      <?php if($item->COD_ESTADO == 'ETM0000000000002'): ?> 
          <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
      <?php else: ?>
        <?php if($item->COD_ESTADO == 'ETM0000000000003'): ?> 
            <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
        <?php else: ?>
          <?php if($item->COD_ESTADO == 'ETM0000000000004'): ?> 
              <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
          <?php else: ?>
            <?php if($item->COD_ESTADO == 'ETM0000000000005'): ?> 
                <span class="badge badge-primary"><?php echo e($item->TXT_ESTADO); ?></span>
            <?php else: ?>
              <?php if($item->COD_ESTADO == 'ETM0000000000006'): ?> 
                  <span class="badge badge-danger"><?php echo e($item->TXT_ESTADO); ?></span>
              <?php else: ?>
                <?php if($item->COD_ESTADO == 'ETM0000000000007'): ?> 
                    <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
                <?php else: ?>
                  <?php if($item->COD_ESTADO == 'ETM0000000000008'): ?> 
                      <span class="badge badge-success"><?php echo e($item->TXT_ESTADO); ?></span>
                  <?php else: ?>
                    <?php if($item->COD_ESTADO == 'ETM0000000000009'): ?> 
                        <span class="badge badge-warning"><?php echo e($item->TXT_ESTADO); ?></span>
                    <?php else: ?>
                      <?php if($item->COD_ESTADO == 'ETM0000000000011'): ?> 
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
  <?php endif; ?>

</td>