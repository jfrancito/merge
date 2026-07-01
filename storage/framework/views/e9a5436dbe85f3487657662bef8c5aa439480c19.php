<?php $__env->startSection('style'); ?>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>


<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>


<div class="be-content fusuario">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider" >USUARIO<span class="panel-subtitle">Crear un nuevo Usuario</span></div>
          <div class="panel-body">
            <form method="POST" action="<?php echo e(url('/agregar-usuario/'.$idopcion)); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>



              <div class="form-group">
                <label class="col-sm-3 control-label">Personal</label>
                <div class="col-sm-5">
                  <select class="select2 input-sm" id="personal" name='personal' required = "">
                    <optgroup label="Usuarios">
                      <option value="">Seleccione Personal</option>
                      <?php $__currentLoopData = $listapersonal; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($item->id); ?>"><?php echo e($item->nombres); ?></option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </optgroup>
                  </select>
                </div>
              </div>




              <div class="form-group">
                <label class="col-sm-3 control-label">Usuario</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="name" name='name' value="<?php echo e(old('name')); ?>" placeholder="Usuario"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4"/>

                    <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
                                                        'error' => $errors->first('name', ':message') , 
                                                        'data' => '4'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

                </div>
              </div>

  

              <div class="form-group">
                <label class="col-sm-3 control-label">Clave</label>
                <div class="col-sm-5">

                  <input  type="password"
                          id="password" name='password' value="" placeholder="Clave"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="6"/>

                </div>
              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Rol</label>
                <div class="col-sm-5">
                  <?php echo Form::select( 'rol_id', $comborol, array('1CIX00000024'),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'rol_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]); ?>

                </div>
              </div>

              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                  </p>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>


  </div>
</div>  



<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>



    <script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>" type="text/javascript"></script>        
    <script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();

        $('#cliente_select').select2({
            // Activamos la opcion "Tags" del plugin
            placeholder: 'Seleccione un proveedor',
            language: "es",
            tags: true,
            tokenSeparators: [','],
            ajax: {
                dataType: 'json',
                url: '<?php echo e(url("buscarcliente")); ?>',
                delay: 100,
                data: function(params) {

                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {

                  return {
                    results: data
                  };

                },
            }
        });
        $(".fusuario").on('change','#cliente_select', function() {

          var empresa   = $(this).val();
          var arrayempresa = empresa.split("-");
          var strempresa = arrayempresa[0].trim();
          $('#name').val(strempresa);
          debugger;

        });



      });
    </script> 

    <script src="<?php echo e(asset('public/js/user/user.js?v='.$version)); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>