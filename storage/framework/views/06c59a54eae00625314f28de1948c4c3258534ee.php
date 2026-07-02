<h5 class='mensaje'><?php echo e($mensaje); ?></h5>
<input type="hidden" name="idactivo" id='idactivo' value = '<?php echo e($idactivo); ?>'>
<div class='inputr'>
  <div class="control-label">Razón Social <span class='requerido'>*</span>:</div>
  <div class="abajocaja">
    <input  type="text"
            id="razonsocial" name='razonsocial' 
            value="<?php if(isset($empresa)): ?><?php echo e(old('razonsocial' ,$empresa->NOM_EMPR)); ?><?php else: ?><?php echo e(old('razonsocial')); ?><?php endif; ?>"
            placeholder="Razón Social"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="4" readonly/>

  </div>
</div>
<div class='inputr'>
  <div class="control-label">Local de Establecimiento <span class='requerido'>*</span>:</div>
  <div class="abajocaja">

    <input  type="text"
            id="direccion" name='direccion' 
            value="<?php if(isset($empresa)): ?><?php echo e(old('direccion' ,$direccion)); ?><?php else: ?><?php echo e(old('direccion')); ?><?php endif; ?>"
            placeholder="Dirección Fiscal"
            required = ""
            autocomplete="off" class="form-control input-sm" data-aw="4"/>

  </div>
</div>



<input type="hidden" name="cod_empresa"  value="<?php if(isset($empresa)): ?><?php echo e(old('cod_empresa' ,$empresa->COD_EMPR)); ?><?php else: ?><?php echo e(old('cod_empresa')); ?><?php endif; ?>">