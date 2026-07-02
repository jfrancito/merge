<div class="form-group">
  <label class="col-sm-3 control-label">Cliente:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="<?php echo e($ordencompra->TXT_EMPR_EMISOR); ?>">
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
  <label class="col-sm-3 control-label">Descripcion de Extorno Comprobante<span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
        <textarea 
        name="descripcionextorno"
        id = "descripcionextorno"
        class="form-control input-sm validarmayusculas"
        rows="5" 
        cols="50"
        required = ""       
        data-aw="2"></textarea>
  </div>
</div>

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">
      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="<?php echo e(url('/gestion-de-contabilidad-aprobar/'.$idopcion)); ?>"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="button"  class="btn btn-space btn-primary btnrechazocomporbatnte">Guardar</button>
    </p>
  </div>
</div>