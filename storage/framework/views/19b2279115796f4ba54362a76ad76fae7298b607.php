<div class="panel panel-default">
  <div class="tab-container">
    <ul class="nav nav-tabs">
      <li class="active negrita"><a href="#iconsolidado" data-toggle="tab">Inventarios Consolidados</a></li>
      <li class="negrita"><a href="#icasacara" data-toggle="tab">Arroz Cáscara por Sede</a></li>
      <li class="negrita"><a href="#ipilado" data-toggle="tab">Arroz Pilado por Sede</a></li>
      <li class="negrita"><a href="#ipacas" data-toggle="tab">Pacas</a></li>
      <li class="negrita"><a href="#ienvases" data-toggle="tab">Envases</a></li>
      <li class="negrita"><a href="#ibobinas" data-toggle="tab">Bobinas</a></li>
      <li class="negrita"><a href="#idemassumi" data-toggle="tab">Demás Suministros</a></li>
      <li class="negrita"><a href="#ienvasesprod" data-toggle="tab">Envases de Producción</a></li>
      <li class="negrita"><a href="#ienvasesdesp" data-toggle="tab">Envases de Despachos</a></li>
      <li class="negrita"><a href="#ienvasescose" data-toggle="tab">Envases Cosecheros</a></li>
      <li class="negrita"><a href="#ifertilizante" data-toggle="tab">Fertilizantes</a></li>
    </ul>

    <div class="tab-content">
      <div id="iconsolidado" class="tab-pane active cont">
        <?php echo $__env->make('inventario.ajax.aconsolidado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="icasacara" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.acascara', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ipilado" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.apilado', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ipacas" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.apacas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ienvases" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.aenvases', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ibobinas" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.abobinas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="idemassumi" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.ademassuministros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ienvasesprod" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.aenvasesprod', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ienvasesdesp" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.aenvasesdesp', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ienvasescose" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.aenvasescose', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
      </div>
      <div id="ifertilizante" class="tab-pane cont">
        <?php echo $__env->make('inventario.ajax.afertilizante', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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







