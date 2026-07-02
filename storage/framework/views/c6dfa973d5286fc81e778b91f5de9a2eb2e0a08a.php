<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">VALE ARENDIR
  </div>
  <div class="panel-body panel-body-contrast">
    <table class="table table-condensed table-striped">
      <thead>
        <tr>
          <th>Atributo</th>
          <th>Valor</th>            
        </tr>
      </thead>
      <tbody>
          <tr>
            <td><b>ID (MERGE)</b></td>
            <td><p class='subtitulomerge'><?php echo e($liquidaciongastos->ARENDIR_ID); ?></p></td>
          </tr>
          <tr>
            <td><b>TIPO (MERGE)</b></td>
            <td><p class='subtitulomerge'><?php echo e($liquidaciongastos->ARENDIR); ?></p></td>
          </tr>

          <?php if(count($valearendir_info)>0): ?>
          <tr>
            <td><b>DOCUMENTO (OSIRIS)</b></td>
            <td><p class='subtitulomerge'><?php echo e($valearendir_info->TXT_SERIE); ?> - <?php echo e($valearendir_info->TXT_NUMERO); ?></p></td>
          </tr>
          <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>