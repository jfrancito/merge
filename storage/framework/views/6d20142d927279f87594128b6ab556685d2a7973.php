<table class="table table-striped table-borderless" style="font-style: italic;">
    <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ID</th>
            <th>Solicita</th>
            <th>Autoriza</th>
            <th>Motivo</th>
            <th>Importe</th>
            <th>Saldo</th>
            <th>Glosa</th>
            <th>Estado y Ver detalle</th> 
            <th>Acción</th>  
        </tr>
    </thead>
    <tbody>
    <?php $__currentLoopData = $listarusuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
     <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'GENERADO'  && $item['USUARIO_AUTORIZA_ID'] === $usuario_logueado_id): ?>
      
        <tr data_vale_rendir="<?php echo e($item['ID']); ?>">
            <td><?php echo e($item['ID']); ?></td>
            <td><?php echo e($item['USUARIO']); ?></td>
            <td><?php echo e($item['USUARIO_AUTORIZA']); ?></td>
            <td><?php echo e($item['TIPO_MOTIVO']); ?></td>
            <td><?php echo e($item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$'); ?> <?php echo e($item['CAN_TOTAL_IMPORTE']); ?></td>
            <td><?php echo e($item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$'); ?> <?php echo e($item['CAN_TOTAL_SALDO']); ?></td>
            <td class="custom-glosa"><?php echo e($item['TXT_GLOSA']); ?></td>

            <?php 
             $motivosPermitidos = [
            'GASTOS DE OPERACION',
            'GASTOS DE REPRESENTACION',
            'GASTOS DE MARKETING Y PUBLICIDAD',
            'GASTOS DE CAPACITACION Y FORMACION',
            'GASTOS DE INVESTIGACION Y DESARROLLO'
            ];
             ?>

            <td class="align-middle text-center">
                <div style="display: flex; flex-direction: column; align-items: center; justify-content: center;">
                <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'GENERADO'): ?>
                    <span class="badge badge-warning">POR AUTORIZAR</span> 
                <?php elseif($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO'): ?>
                    <span class="badge badge-warning"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>
                <?php elseif($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO'): ?>
                    <span class="badge badge-success"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>    
                <?php elseif($item['TXT_CATEGORIA_ESTADO_VALE'] === 'RECHAZADO'): ?>
                    <span class="badge badge-danger"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>
                <?php else: ?>
                     <span class="badge badge-custom-danger"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>                        
                <?php endif; ?>

                    <div class="dropdown">

                             <button class="btn btn-sm btn-outline-dark dropdown-toggle text-left btn-primary" style="margin-top: 7px;"
                                    type="button" id="dropdownAcciones<?php echo e($item['ID']); ?>"
                                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                 <i class="mdi mdi-eye mr-1"></i> Ver Detalle
                            </button>

                      
                         <div class="dropdown-menu d-dropdown-menu shadow-sm p-1" aria-labelledby="dropdownAcciones<?php echo e($item['ID']); ?>">

                               <?php if(!in_array($item['TIPO_MOTIVO'], $motivosPermitidos)): ?>
                              
                                 <a class="dropdown-item verdetalleimporte-valerendir-autoriza d-flex align-items-center" href="#">
                                   <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                                </a>
                                <?php endif; ?>
                        </div>
                    </div>
                </div>
           </td>

           <td>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'AUTORIZADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO'): ?>
                        <button class="btn btn-space btn-check btn-social autorizar-valerendir"
                                data-toggle="tooltip" data-placement="top" title="Aprueba"
                                data-valerendir-id="<?php echo e($item['ID']); ?>" data-toggle="modal" data-target="#autorizaModal">
                            Autorizar
                        </button>
                    <?php endif; ?>

                    <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'AUTORIZADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO'): ?>
                        <button class="btn btn-space btn-close btn-social rechazar-valerendir"
                                data-toggle="tooltip" data-placement="top" title="Rechaza"
                                data-valerendir-id="<?php echo e($item['ID']); ?>" data-toggle="modal" data-target="#rechazoModal">
                            Rechazar
                        </button>
                    <?php endif; ?>
                </div>
            </td>
        </tr>
        <?php endif; ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</tbody>

</table>

<?php echo $__env->make('valerendir.ajax.modalverdetalleimportegastosvalerendir', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>


<style>
    .btn-check {
        background-color: #28a745; /* Color verde */
        border-color: #28a745;
        color: white;
    }

    .btn-check:hover {
        background-color: #218838;
        border-color: #1e7e34;
    }

    .col-glosa {
    max-width: 200x; 
    min-width: 200|px;
    width: 35%; /* O cualquier porcentaje adecuado */
    }


    .btn-close {
        background-color: #dc3545; /* Color rojo */
        border-color: #dc3545;
        color: white;
    }

    .btn-close:hover {
        background-color: #c82333;
        border-color: #bd2130;
    }

     .badge-custom-danger {
    background-color: #8B0000; /* Rojo oscuro */
    color: white;
    }



</style>




