
<form method="POST" action="<?php echo e(url('/configurar-datos-proveedor/'.Hashids::encode(substr($usuario->id, -8)))); ?>">
      <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 <?php echo e($usuario->nombre); ?> <span>(<?php echo e($usuario->name); ?>)</span>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">


		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Dirección Fiscal :</label>
		                <div class="col-sm-12 abajocaja" >

									    <input  type="text"
									            id="direccion" name='direccion' 
									            value="<?php echo e($usuario->direccion_fiscal); ?>"
									             placeholder="Dirección Fiscal"
									            required = ""
									            autocomplete="off" class="form-control input-sm" data-aw="4"/>
		                </div>
		              </div>
		        </div>

		        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		              <div class="form-group">
		                <label class="col-sm-12 control-label labelleft negrita" >Cuenta Detracción :</label>
		                <div class="col-sm-12 abajocaja" >
                                  <input  type="text"
                                          id="cuenta_detraccion" name='cuenta_detraccion' value="<?php echo e($usuario->cuenta_detraccion); ?>" 
                                          placeholder="Cuenta Detracción"
                                          required = ""
                                          autocomplete="off" class="form-control input-sm" data-aw="4"/>
		                </div>
		              </div>
		        </div>
		        
				</div>
		    </div>
		    <div class="col-md-6">
		    </div>

		</div>
	</div>

	<div class="modal-footer">
	  <button type="submit" data-dismiss="modal" class="btn btn-success btn-guardar-configuracion">Guardar</button>
	</div>
</form>


<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){

      App.formElements();
      $('.importe').inputmask({ 'alias': 'numeric', 
      'groupSeparator': ',', 'autoGroup': true, 'digits': 0, 
      'digitsOptional': false, 
      'prefix': '', 
      'placeholder': '0'});

    });
  </script>
<?php endif; ?>




