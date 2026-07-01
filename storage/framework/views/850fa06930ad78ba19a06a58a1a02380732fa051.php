<div class="row">
<div class="col-xs-12 col-md-6">  
  <div class="panel panel-border-color panel-border-color-success">
    <div class="panel-heading panel-heading-divider xs-pb-15">Datos del Proveedor
    	<div class="tools editar_datos_proveedor"> <span class="label label-primary">Editar</span> </div>
    </div>
    <div class="panel-body xs-pt-25">

      <div class="row user-progress user-progress-small">
        <div class="col-md-5"><span class="title"><b>Razón Social :</b></span></div>
        <div class="col-md-7">
        	<?php echo e($usuario->nombre); ?>

        </div>
      </div>

      <div class="row user-progress user-progress-small">
        <div class="col-md-5"><span class="title"><b>Ruc :</b></span></div>
        <div class="col-md-7">
        	<?php echo e($usuario->name); ?>

        </div>
      </div>

      <div class="row user-progress user-progress-small">
        <div class="col-md-5"><span class="title"><b>Dirección Fiscal :</b></span></div>
        <div class="col-md-7">
        	<?php echo e($usuario->direccion_fiscal); ?>

        </div>
      </div>

      <div class="row user-progress user-progress-small">
        <div class="col-md-5"><span class="title"><b>Cuenta Detracción :</b></span></div>
        <div class="col-md-7">
        	<?php echo e($usuario->cuenta_detraccion); ?>

        </div>
      </div>


    </div>
  </div>
    </div>
    <div class="col-xs-12 col-md-6">
      <div class="panel panel-border-color panel-border-color-primary">
        <div class="panel-heading panel-heading-divider xs-pb-15">Datos del Contacto
        	<div class="tools editar_datos_contacto"> <span class="label label-primary">Editar</span> </div>
        </div>
        <div class="panel-body xs-pt-25">

          <div class="row user-progress user-progress-small">
            <div class="col-md-5"><span class="title"><b>Nombres :</b></span></div>
            <div class="col-md-7">
            	<?php echo e($usuario->nombre_contacto); ?>

            </div>
          </div>

          <div class="row user-progress user-progress-small">
            <div class="col-md-5"><span class="title"><b>Celular :</b></span></div>
            <div class="col-md-7">
            	<?php echo e($usuario->celular_contacto); ?>

            </div>
          </div>

          <div class="row user-progress user-progress-small">
            <div class="col-md-5"><span class="title"><b>Correo electronico :</b></span></div>
            <div class="col-md-7">
            	<?php echo e($usuario->email); ?>

            </div>
          </div>

          <div class="row user-progress user-progress-small">
            <div class="col-md-5"><span class="title"><b>Confirmacion de email :</b></span></div>
            <div class="col-md-7">
            	<span class="label label-success">Aceptado</span>
            	
            </div>
          </div>



        </div>
      </div>
    </div>
</div>

<div class="row">
<div class="col-sm-12">
  <div class="panel panel-default panel-table">
    <div class="panel-heading">Mis Cuentas Bancarias
        	<div class="tools agregar_cuenta_bancaria" style="cursor: pointer;"> <span class="label label-primary">Agregar</span> </div>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-borderless">
        <thead>
          <tr>
            <th>Banco</th>
            <th>Tipo Cuenta</th>
            <th>Moneda</th>
            <th>Nro. Cuenta</th>
            <th>Nro. CCI</th>
            <!-- <th></th> -->
          </tr>
        </thead>
        <tbody class="no-border-x">

          <?php $__currentLoopData = $cuentabancarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <tr>
                <td><?php echo e($item->TXT_EMPR_BANCO); ?></td>
                <td><?php echo e($item->TXT_REFERENCIA); ?></td>
                <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
                <td><?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></td>
                <td><?php echo e($item->TXT_NRO_CCI); ?></td>
<!--                 <td>
                	<span style="cursor:pointer;" 
                		data_COD_EMPR_TITULAR = '<?php echo e($item->COD_EMPR_TITULAR); ?>'
                		data_COD_EMPR_BANCO = '<?php echo e($item->COD_EMPR_BANCO); ?>'
                		data_COD_CATEGORIA_MONEDA = '<?php echo e($item->COD_CATEGORIA_MONEDA); ?>'
                		data_TXT_TIPO_REFERENCIA = '<?php echo e($item->TXT_TIPO_REFERENCIA); ?>'
                		data_TXT_NRO_CUENTA_BANCARIA = '<?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?>'

                		class="badge badge-danger btn-eliminar-cb">
                		<a href="#" class="icon"><i class="mdi mdi-close" style="color: #fff;"></i></a>
                	</span>
                </td> -->
              </tr>

          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



        </tbody>
      </table>
    </div>
  </div>
</div>
</div>