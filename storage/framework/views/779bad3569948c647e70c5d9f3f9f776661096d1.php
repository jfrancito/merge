
<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="<?php if($tab_id=='oc'): ?> active <?php endif; ?>"><a href="#oc" data-toggle="tab">PROVISION DE GASTOS <span class="badge badge-success" style="font-size:16px"><?php echo e(count($listadatos)); ?></span></a></li>
            <li class="<?php if($tab_id=='observado'): ?> active <?php endif; ?>"><a href="#observado" data-toggle="tab">OBSERVADOS <span class="badge badge-danger" style="font-size:16px"><?php echo e(count($listadatos_obs)); ?></span></a></li>
            <li class="<?php if($tab_id=='observadole'): ?> active <?php endif; ?>"><a href="#observadole" data-toggle="tab">OBSERVACIONES LEVANTADAS <span class="badge badge-primary" style="font-size:16px"><?php echo e(count($listadatos_obs_le)); ?></span></a></li>

          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane <?php if($tab_id=='oc'): ?> active <?php endif; ?> cont">

              <?php echo $__env->make('comprobante.lista.ajax.alistaprovisiongastoscon', ['id' => 'nso' , 'listadatos' => $listadatos], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            </div>
            <div id="observado" class="tab-pane <?php if($tab_id=='observado'): ?> active <?php endif; ?> cont">

              <?php echo $__env->make('comprobante.lista.ajax.alistaprovisiongastoscon', ['id' => 'nso_obs' , 'listadatos' => $listadatos_obs], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            </div>

            <div id="observadole" class="tab-pane <?php if($tab_id=='observadole'): ?> active <?php endif; ?> cont">

              <?php echo $__env->make('comprobante.lista.ajax.alistaprovisiongastoscon', ['id' => 'nso_obs_le' , 'listadatos' => $listadatos_obs_le], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
<?php endif; ?>