<div class="panel panel-default panel-contrast ver-archivos">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">VER ARCHIVOS PDF  
  </div>
  <div class="panel-body panel-body-contrast">
        <?php $__currentLoopData = $archivospdf; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
            <div class="form-group sectioncargarimagen">
                <label class="col-sm-12 control-label" style="text-align: left;font-size: 1em;"><b><?php echo e($item->DESCRIPCION_ARCHIVO); ?></b></label>
                <div class="col-sm-12">
                    <div class="file-loading">
                        <input 
                        id="file-<?php echo e($index); ?>" 
                        name="file[]" 
                        class="file-ver"  
                        type="file" 
                        multiple data-max-file-count="1">
                    </div>
                </div>
            </div>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</div>