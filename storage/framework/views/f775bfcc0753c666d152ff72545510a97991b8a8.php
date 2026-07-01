<span><b>REPARABLE : </b>               
    <?php if($item->IND_REPARABLE == 1): ?> 
        <span class="badge badge-primary" style="display: inline-block;">EN PROCESO</span>
    <?php else: ?>
      <?php if($item->IND_REPARABLE == 2): ?> 
          <span class="badge badge-warning" style="display: inline-block;">EN REVISION</span>
      <?php else: ?>
        <?php if($item->IND_REPARABLE == 0): ?> 
            <span class="badge badge-default" style="display: inline-block;">-</span>
        <?php else: ?>
            <span class="badge badge-default" style="display: inline-block;">-</span>
        <?php endif; ?>
      <?php endif; ?>
    <?php endif; ?>
</span>

<span><b>OBSERVADO REPARABLE : </b>               
    <?php if($item->IND_OBSERVACION_REPARABLE == 1): ?> 
        <span class="badge badge-danger" style="display: inline-block;">OBSERVADO</span>
    <?php endif; ?>
</span>
