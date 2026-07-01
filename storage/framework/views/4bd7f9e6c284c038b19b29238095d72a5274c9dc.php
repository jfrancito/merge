<div class="form-group">
    <label class="col-sm-3 control-label">TRABAJADOR:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm"
               value="<?php echo e($liquidaciongastos->TXT_EMPRESA_TRABAJADOR); ?>">
    </div>
</div>
<div class="form-group">
    <label class="col-sm-3 control-label">CENTRO:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm" value="<?php echo e($liquidaciongastos->TXT_CENTRO); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">PERIODO:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm" value="<?php echo e($liquidaciongastos->TXT_PERIODO); ?>">
    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">FECHA EMISION:</label>
    <div class="col-sm-6">
        <input type="text" disabled class="form-control control input-sm"
               value="<?php echo e(date_format(date_create($liquidaciongastos->FECHA_EMI), 'd/m/Y')); ?>">
    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Detalle Documento:</label>
    <div class="col-sm-6">

        <div>
            <table id="tblobservacionesreparable" class="table table-condensed table-striped tablaobservacion">
                <thead>
                <tr>
                    <th>FECHA EMISION</th>
                    <th>DOCUMENTO</th>
                    <th>TIPO DOCUMENTO</th>
                    <th>PROVEEDOR</th>
                    <th>TOTAL</th>
                    <th></th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $tdetliquidaciongastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data_id="<?php echo e($item->ID_DOCUMENTO); ?>" data_item='<?php echo e($item->ITEM); ?>'>
                        <td><?php echo e(date_format(date_create($item->FECHA_EMISION), 'd/m/Y')); ?></td>
                        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?> </td>
                        <td><?php echo e($item->TXT_TIPODOCUMENTO); ?></td>
                        <td><?php echo e($item->TXT_EMPRESA_PROVEEDOR); ?></td>
                        <td><?php echo e($item->TOTAL); ?></td>
                        <td>
                            <div class="text-center be-checkbox be-checkbox-sm has-primary">
                                <input type="checkbox"
                                       class="<?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?> input_asignar"
                                       id="<?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?>">

                                <label for="<?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?>"
                                       data-atr="ver"
                                       class="checkbox checkbox_asignar"
                                       name="<?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?>"
                                ></label>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>
</div>


<div class="form-group">
    <label class="col-sm-3 control-label">Documentos Observados:</label>
    <div class="col-sm-6">

        <div>
            <table class="table table-condensed table-striped tablaobservacion">
                <thead>
                <tr>
                    <th>FECHA EMISION</th>
                    <th>DOCUMENTO</th>
                    <th>TIPO DOCUMENTO</th>
                    <th>PROVEEDOR</th>
                    <th>TOTAL</th>
                </tr>
                </thead>
                <tbody>
                <?php $__currentLoopData = $tdetliquidaciongastosel; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td><?php echo e(date_format(date_create($item->FECHA_EMISION), 'd/m/Y')); ?></td>
                        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?> </td>
                        <td><?php echo e($item->TXT_TIPODOCUMENTO); ?></td>
                        <td><?php echo e($item->TXT_EMPRESA_PROVEEDOR); ?></td>
                        <td><?php echo e($item->TOTAL); ?></td>
                    </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<div class="form-group">
    <label class="col-sm-3 control-label">Descripcion de Observacion<span class="obligatorio">(*)</span> :</label>
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

<input type="hidden" id="tipo_operacion_reparable" name="tipo_operacion_reparable" value=""/>
<input type="hidden" id="operacion_reparable" name="operacion_reparable" value=""/>

