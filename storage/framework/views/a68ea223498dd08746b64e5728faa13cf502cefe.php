<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> "/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>


	<div class="be-content">
		<div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <div class="panel panel-default panel-table">
                <div class="panel-heading">Lista de Usuarios
                  <div class="tools">
                    <a href="<?php echo e(url('/agregar-usuario/'.$idopcion)); ?>" data-toggle="tooltip" data-placement="top" title="Crear Usuario">
                      <span class="icon mdi mdi-plus-circle-o"></span>
                    </a>


                  </div>
                </div>
                <div class="panel-body">
                  <table id="table1" class="table table-striped table-hover table-fw-widget">
                    <thead>
                      <tr>
                        <th>Institucion</th>
                        <th>Perfil</th>
                        <th>Activo</th>
                        <th>Opción</th>
                      </tr>
                    </thead>
                    <tbody>

                      <?php $__currentLoopData = $listausuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <td><?php echo e($item->nombre); ?> </td>
                            <td><?php echo e($item->rol->nombre); ?></td>
                            <td> 
                              <?php if($item->activo == 1): ?>  
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
                                    <a href="<?php echo e(url('/modificar-usuario/'.$idopcion.'/'.Hashids::encode(substr($item->id, -8)))); ?>">
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