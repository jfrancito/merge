<div class="form-group">
  <label class="col-sm-3 control-label">Cliente:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($ordencompra->TXT_EMPR_CLIENTE); ?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Codigo Orden:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($fedocumento->ID_DOCUMENTO); ?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Documento:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($fedocumento->SERIE); ?>-<?php echo e($fedocumento->NUMERO); ?>">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Usario Contacto:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($trabajador->TXT_APE_PATERNO); ?> <?php echo e($trabajador->TXT_APE_MATERNO); ?> <?php echo e($trabajador->TXT_NOMBRES); ?>">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Descripcion de Observacion<span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
        <textarea 
        name="descripcion"
        id = "descripcion"
        class="form-control input-sm validarmayusculas"
        rows="5" 
        cols="50"
        required = ""       
        data-aw="2"></textarea>
  </div>
</div>

