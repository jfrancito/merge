<div class="form-group">
    <label class="col-sm-3 control-label">Cliente:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm" value="<?php echo e($fedocumento->RZ_PROVEEDOR); ?>">
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
        <input type="text" disabled class="form-control control input-sm"
               value="<?php echo e($fedocumento->SERIE); ?>-<?php echo e($fedocumento->NUMERO); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Usuario Contacto:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm"
               value="<?php echo e($trabajador->TXT_APE_PATERNO); ?> <?php echo e($trabajador->TXT_APE_MATERNO); ?> <?php echo e($trabajador->TXT_NOMBRES); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label labelleft negrita">Reparable :</label>
    <div class="col-sm-6 abajocaja">
        <?php echo Form::select( 'reparable', $comboreparable, array(),
                          [
                            'class'       => 'select2 form-control control input-xs combo' ,
                            'id'          => 'reparable',
                            'data-aw'     => '1',
                            'required'    => '',
                          ]); ?>

    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Archivos Reparable:</label>
    <div class="col-sm-6">
        <?php $__currentLoopData = $documentoscomprarepable; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="be-checkbox">
                <input id="<?php echo e($item->COD_CATEGORIA); ?>R" value="<?php echo e($item->COD_CATEGORIA); ?>" type="checkbox"
                       name="archivore[]">
                <label for="<?php echo e($item->COD_CATEGORIA); ?>R"><?php echo e($item->NOM_CATEGORIA); ?> (<?php echo e($item->COD_CTBLE); ?>)</label>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Descripcion de Reparar Comprobante<span class="obligatorio">(*)</span>
        :</label>
    <div class="col-sm-6">
        <textarea
                name="descripcion"
                id="descripcion"
                class="form-control input-sm validarmayusculas"
                rows="5"
                cols="50"
                required=""
                data-aw="2"></textarea>
    </div>
</div>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <?php echo $__env->make('comprobante.asiento.contenedorasientoreparable', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

<div class="row xs-pt-15">
    <div class="col-xs-6">
        <div class="be-checkbox">

        </div>
    </div>
    <div class="col-xs-6">
        <p class="text-right">
            <a href="<?php echo e(url('/gestion-de-contabilidad-aprobar/'.$idopcion)); ?>">
                <button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button>
            </a>
            <button type="button" class="btn btn-space btn-primary btnaprobarcomporbatntereparable">Guardar</button>
        </p>
    </div>
</div>

