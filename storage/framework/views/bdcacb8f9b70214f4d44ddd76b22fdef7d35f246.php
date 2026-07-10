<div class="panel-heading">

    <div class="tools tooltiptop">
        <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones">
            <span class="tooltiptext">Total Seleccionado</span>
            <b class='totalseleccion' style="font-size:16px;">0.0000</b>
        </a>
        <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones">
            <span class="tooltiptext">Cantidad Seleccionado</span>
            <b class='cantidaseleccion' style="font-size:16px;">0</b>
        </a>

    </div>


</div>
<br>

<div class="panel-heading">
    <form method="POST" id='formre' action="<?php echo e(url('/select-xml-comision/'.$idopcion)); ?>" style="border-radius: 0px;"
          class="form-horizontal group-border-dashed" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="jsondocumenos" id='jsondocumenos'>
        

    </form>
    <div class="tools tooltiptop">
        <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones lotescomision">
            <span class="tooltiptext">Lotes</span>
            <span class="icon mdi mdi-eye"></span>
        </a>
        <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones migrarcomisionadmin">
            <span class="tooltiptext">Registrar</span>
            <span class="icon mdi mdi-collection-image"></span>
        </a>
        <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones registromasivocomision">
            <span class="tooltiptext">Registro masivo</span>
            <span class="icon mdi mdi-plus-circle-o"></span>
        </a>
    </div>
</div>


<table id="estiba" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
    <thead>
    <tr>
        <th>ITEM</th>
        <th>OPERACION</th>
        <th>FECHA</th>
        <th>TOTAL</th>
        <th>INTEGRADO</th>
        <th>INTEGRAR</th>
        <th>ESTADO</th>
        <th>LOTE</th>
        <th>
            <div class="text-center be-checkbox be-checkbox-sm has-primary">
                <input type="checkbox"
                       class="todo_asignar input_asignar"
                       id="todo_asignar"
                >
                <label for="todo_asignar"
                       data-atr="todas_asignar"
                       class="checkbox_asignar"
                       name="todo_asignar"
                ></label>
            </div>
        </th>
    </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr data_requerimiento_id="<?php echo e($item->COD_OPERACION_CAJA); ?>"
            data_lote="<?php echo e($item->LOTE_DOC); ?>"
            data_total="<?php echo e($item->MONTO); ?>"
            data_total_atendido="<?php echo e($item->MONTOATENDIDO); ?>"
            class="itemcomision"
        >
            <td><b><?php echo e($index + 1); ?></b></td>
            <td class="cell-detail sorting_1" style="position: relative;width: 550px;">
                <span><b>ID :</b>  <?php echo e($item->COD_OPERACION_CAJA); ?>  </span>
                <span><b>MOVIMIENTO </b>  : <?php echo e($item->TXT_ITEM_MOVIMIENTO); ?></span>
                <span><b>BANCO : </b> <?php echo e($item->NOMBRE_BANCO_CAJA); ?></span>
                <span><b>CUENTA : </b> <?php echo e($item->CUENTA); ?></span>
                <span><b>GLOSA : </b> <?php echo e($item->TXT_GLOSA); ?></span>
            </td>
            <td class="cell-detail sorting_1" style="position: relative;">
                <span><b>FECHA REGISTRO : </b> <?php echo e($item->FEC_REGISTRO); ?> </span>
                <span><b>FECHA MOVIMIENTO  :</b>  <?php echo e($item->FEC_MOVIMIENTO); ?></span>
                <span><b>NRO VOUCHER  :</b>  <?php echo e($item->NRO_VOUCHER); ?></span>
                <span><b>MONEDA  :</b>  <?php echo e($item->MONEDA); ?></span>
                <span><b>USUARIO  :</b>  <?php echo e($item->NOM_TRABAJADOR); ?></span>
            </td>

            <td><?php echo e($item->MONTO); ?></td>
            <td><?php echo e($item->MONTOATENDIDO); ?></td>
            <td>
                <input type="text"
                       id="integrar"
                       name="integrar"
                       value="<?php echo e($item->MONTO - $item->MONTOATENDIDO); ?>"
                       class="form-control input-sm importecomision"
                >
            </td>
            <td><?php echo e($item->ESTADO); ?></td>
            <td><?php echo e($item->LOTE_DOC); ?></td>
            <td class="rigth">
                <div class="text-center be-checkbox be-checkbox-sm has-primary">
                    <input type="checkbox"
                           class="<?php echo e($item->COD_OPERACION_CAJA); ?> input_asignar"
                           data_total="<?php if($item->MONEDA=='SOLES'): ?> <?php echo e($item->MONTO_SOLES); ?> <?php else: ?> <?php echo e($item->MONTO_DOLARES); ?> <?php endif; ?>"
                           id="<?php echo e($item->COD_OPERACION_CAJA); ?>_<?php echo e($index); ?>">
                    <label for="<?php echo e($item->COD_OPERACION_CAJA); ?>_<?php echo e($index); ?>"
                           data-atr="ver"
                           class="checkbox checkbox_asignar"
                           data_total="<?php if($item->MONEDA=='SOLES'): ?> <?php echo e($item->MONTO_SOLES); ?> <?php else: ?> <?php echo e($item->MONTO_DOLARES); ?> <?php endif; ?>"
                           name="<?php echo e($item->COD_OPERACION_CAJA); ?>"
                    ></label>
                </div>
            </td>
        </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<?php if(isset($ajax)): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
            $('.importecomision').inputmask({
                'alias': 'numeric',
                'groupSeparator': '', 'autoGroup': true, 'digits': 2,
                'digitsOptional': false,
                'prefix': '',
                'placeholder': '0'
            });

        });
    </script>
<?php endif; ?>
