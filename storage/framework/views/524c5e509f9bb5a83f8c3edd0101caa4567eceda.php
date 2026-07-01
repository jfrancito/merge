<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> "/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>


	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de Terceros
                  <div class="tools">
                    <a href="<?php echo e(url('/agregar-tercero/'.$idopcion)); ?>" 
                     class="btn btn-success btn-sm d-flex align-items-center" 
                     data-toggle="tooltip" 
                     data-placement="top" 
                     title="Agregar Usuario">
                     <i class="mdi mdi-plus-circle-outline me-2"></i> Agregar Usuario
                     </a>
                  </div>
                </div>
                <div class="panel-body">
                  <table id="table1" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>Dni</th>
                        <th>Nombre</th>
                        <th>Area</th>
                        <th>Empresa</th>
                        <th>Centro</th>
                        <th>Activo</th>
                        <th>Opción</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $__currentLoopData = $listaterceros; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->DNI); ?></td>
                            <td><?php echo e($item->NOMBRE); ?></td>
                            <td><?php echo e($item->TXT_AREA); ?></td>
                            <td><?php echo e($item->TXT_EMPRESA); ?></td>
                            <td><?php echo e($item->TXT_CENTRO); ?></td>

                            <td> 
                              <?php if($item->ACTIVO == 1): ?>  
                                <span class="icon mdi mdi-check"></span> 
                              <?php else: ?> 
                                <span class="icon mdi mdi-close"></span> 
                              <?php endif; ?>
                            </td>
                            <td class="rigth">
                              <div class="btn-group btn-hspace">
                                <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">
                                  <li>
                                    <a href="<?php echo e(url('/modificar-tercero/'.$idopcion.'/'.Hashids::encode($item->DNI))); ?>">
                                      Modificar
                                    </a>
                                  </li>
                                </ul>
                              </div>
                            </td>
                        </tr>                    
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
		</div>
	</div>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>


	<script src="<?php echo e(asset('public/lib/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.print.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js')); ?>" type="text/javascript"></script>
	<script src="<?php echo e(asset('public/js/app-tables-datatables.js')); ?>" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip(); 
      });
    </script> 
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>