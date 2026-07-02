<div class="panel panel-default panel-contrast">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DETALLE DE DOCUMENTOS
    </div>
    <div class="panel-body panel-body-contrast">

        <?php $__currentLoopData = $tdetliquidaciongastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="dtlg <?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?> <?php if($index!=0): ?> ocultar <?php endif; ?>">
                <table class="table table-condensed table-striped">
                    <thead>
                    <tr>
                        <th>RESPUESTA SUNAT</th>
                        <th>ESTADO COMPROBANTE</th>
                        <th>ESTADO RUC</th>
                        <th>ESTADO DOMICILIO</th>
                        <th>RESPUESTA CDR</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?php echo e($item->MESSAGE); ?></td>
                        <td><?php echo e($item->NESTADOCP); ?></td>
                        <td><?php echo e($item->NESTADORUC); ?></td>
                        <td><?php echo e($item->NCONDDOMIRUC); ?></td>
                        <td><?php echo e($item->RESPUESTA_CDR); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


        <?php $__currentLoopData = $tdetliquidaciongastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="dtlg <?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?> <?php if($index!=0): ?> ocultar <?php endif; ?>">
                <table class="table table-condensed table-striped">
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
                    <tr>
                        <td><?php echo e(date_format(date_create($item->FECHA_EMISION), 'd/m/Y')); ?></td>
                        <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?> </td>
                        <td><?php echo e($item->TXT_TIPODOCUMENTO); ?></td>
                        <td><?php echo e($item->TXT_EMPRESA_PROVEEDOR); ?></td>
                        <td><?php echo e($item->TOTAL); ?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        <table class="table table-condensed table-striped">
            <thead>
            <tr>
                <th>PRODUCTO</th>
                <th>PRODUCTO XML</th>
                <th>CANTIDAD</th>
                <th>PRECIO</th>
                <th>IGV</th>
                <th>SUB TOTAL</th>
                <th>TOTAL</th>
            </tr>
            </thead>
            <tbody>
            <?php $__currentLoopData = $detdocumentolg; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="dtlg <?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?>  <?php if($item->ITEM!=1): ?> ocultar <?php endif; ?>">
                    <td><?php echo e($item->TXT_PRODUCTO); ?></td>
                    <td><?php echo e($item->TXT_PRODUCTO_XML); ?></td>
                    <td><?php echo e($item->CANTIDAD); ?></td>
                    <td><?php echo e($item->PRECIO); ?></td>
                    <td><?php echo e($item->IGV); ?></td>
                    <td><?php echo e($item->SUBTOTAL); ?></td>
                    <td><?php echo e($item->TOTAL); ?></td>
                </tr>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>

        <?php echo $__env->make('liquidaciongasto.form.liquidaciongasto.verpdfmultiple', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

            <?php echo $__env->make('comprobante.asiento.contenedorasientolg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php $__currentLoopData = $tdetliquidaciongastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="dtlg <?php echo e($item->ID_DOCUMENTO); ?><?php echo e($item->ITEM); ?> <?php if($index!=0): ?> ocultar <?php endif; ?>">
                <div class="col-lg-12">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-4">
                        <div class="panel panel-default panel-contrast">
                            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS
                            </div>
                            <div class="panel-body panel-body-contrast">
                                <table class="table table-condensed table-striped">
                                    <thead>
                                    <tr>
                                        <th>Nro</th>
                                        <th>Nombre</th>
                                        <th>Archivo</th>
                                        <th>Opciones</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $indexa => $itema): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($itema->DOCUMENTO_ITEM == $item->ITEM): ?>
                                            <tr>
                                                <td><?php echo e($indexa + 1); ?></td>
                                                <td><?php echo e($itema->DESCRIPCION_ARCHIVO); ?></td>
                                                <td><?php echo e($itema->NOMBRE_ARCHIVO); ?></td>
                                                <td class="rigth">
                                                    <div class="btn-group btn-hspace">
                                                        <button type="button" data-toggle="dropdown"
                                                                class="btn btn-default dropdown-toggle">Acción <span
                                                                    class="icon-dropdown mdi mdi-chevron-down"></span>
                                                        </button>
                                                        <ul role="menu" class="dropdown-menu pull-right">
                                                            <li>
                                                                <a href="<?php echo e(url('/descargar-archivo-requerimiento-lg/'.$itema->TIPO_ARCHIVO.'/'.$idopcion.'/'.$itema->DOCUMENTO_ITEM.'/'.$itema->ID_DOCUMENTO)); ?>">
                                                                    Descargar
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


    </div>
</div>
