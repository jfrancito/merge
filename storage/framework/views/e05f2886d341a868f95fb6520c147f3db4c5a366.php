
	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 <b>Lista de la Cuenta Bancaria</b>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">
          
          <div class="tab-container">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#cuentaregistrada" data-toggle="tab">CUENTAS REGISTRADAS</a></li>
              <li><a href="#bancossincuenta" data-toggle="tab">BANCOS SIN CUENTA</a></li>
            </ul>
            <div class="tab-content">
              <div id="cuentaregistrada" class="tab-pane active cont">
                <table class="table table-striped table-borderless">
                  <thead>
                    <tr>
                      <th>INFORMACION</th>
                      <th>CUENTA BANCARIA</th>
                      <?php if(isset($idopcion)): ?>
                      <th>OPERACION</th> 
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody class="no-border-x">
                    <?php $__currentLoopData = $cuentabancarias; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="cell-detail sorting_1" style="position: relative;">
                            <span><b>BANCO :  </b> <?php echo e($item->TXT_EMPR_BANCO); ?></span>
                            <span><b>TIPO CUENTA  : </b> <?php echo e($item->TXT_REFERENCIA); ?></span>
                            <span><b>MONEDA : </b> <?php echo e($item->TXT_CATEGORIA_MONEDA); ?></span>
                          </td>
                          <td class="cell-detail sorting_1" style="position: relative;">
                            <span><b>NRO CUENTA BANCARIA :  </b> <?php echo e($item->TXT_NRO_CUENTA_BANCARIA); ?></span>
                            <span><b>CCI  : </b> <?php echo e($item->TXT_NRO_CCI); ?></span>
                            <span><b>CARNET EXTRANJERIA : </b> <?php echo e($item->CARNET_EXTRANJERIA); ?></span>
                          </td>
                          <?php if(isset($idopcion)): ?>
                            <td>
                              <a href="<?php echo e(url('/cambiar-cuenta-corriente/'.$item->COD_EMPR_TITULAR.'/'.$item->COD_EMPR_BANCO.'/'.$item->TXT_NRO_CUENTA_BANCARIA.'/'.$item->COD_CATEGORIA_MONEDA.'/'.$idoc.'/'.$idopcion)); ?>" class="tools select"> <span class="label label-success">CAMBIAR CUENTA</span></a>
                            </td>
                          <?php endif; ?>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </tbody>
                </table>
              </div>
              <div id="bancossincuenta" class="tab-pane cont">
                <table class="table table-striped table-borderless">
                  <thead>
                    <tr>
                      <th>BANCO</th>
                      <?php if(isset($idopcion)): ?>
                      <th>OPERACION</th> 
                      <?php endif; ?>
                    </tr>
                  </thead>
                  <tbody class="no-border-x">
                    <?php $__currentLoopData = $bancos_sin_cuenta; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                          <td class="cell-detail sorting_1" style="position: relative;">
                            <span><b>BANCO :  </b> <?php echo e($item->NOM_CATEGORIA); ?></span>
                          </td>
                          <?php if(isset($idopcion)): ?>
                            <td>
                              <a href="<?php echo e(url('/cambiar-banco-sin-cuenta/'.$item->COD_CATEGORIA.'/'.$idoc.'/'.$idopcion)); ?>" class="tools select"> <span class="label label-success">CAMBIAR BANCO</span></a>
                            </td>
                          <?php endif; ?>
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
	</div>

<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){


    });
  </script>
<?php endif; ?>




