<table id="vale" class="table table-bordered td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%" style="font-style: italic;">
    <thead>
        <tr>
            <th class="col">ID</th>
            <th class="col">Autoriza</th>
            <th class="col">Motivo</th>
            <th class="col">Importe</th>
            <th class="col">Saldo</th>
            <th class="col">Glosa</th>  
            <th class="col">Estado Merge</th>  
            <th class="col">Ver Detalle</th>  
            <th class="col">Anular</th>  


        </tr>
    </thead>
    <tbody>
        <?php $__currentLoopData = $listarusuarios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
        <tr class="dobleclickpc" data_vale_rendir_reembolso="<?php echo e($item['ID']); ?>" style="cursor:pointer;">
            <td><?php echo e($item['ID']); ?></td>
            <td><?php echo e($item['USUARIO_AUTORIZA']); ?></td>
            <td><?php echo e($item['TIPO_MOTIVO']); ?></td>
            <td><?php echo e($item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$'); ?> <?php echo e($item['CAN_TOTAL_IMPORTE']); ?></td>
            <td><?php echo e($item['COD_MONEDA'] == 'MON0000000000001' ? 'S/.' : '$'); ?> <?php echo e($item['CAN_TOTAL_SALDO']); ?></td>

            <td class="custom-glosa"><?php echo e($item['TXT_GLOSA']); ?></td>
            <td>
                <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'GENERADO'): ?>
                    <span class="badge badge-warning">POR AUTORIZAR JEFATURA</span>
                <?php elseif($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO'): ?>
                    <span class="badge badge-primary">POR APROBAR ADMINISTRACION</span>
                <?php elseif($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO'): ?>
                    <span class="badge badge-success"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>    
                <?php elseif($item['TXT_CATEGORIA_ESTADO_VALE'] === 'RECHAZADO'): ?>
                    <span class="badge badge-danger"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>
                <?php else: ?>
                     <span class="badge badge-custom-danger"><?php echo e($item['TXT_CATEGORIA_ESTADO_VALE']); ?></span>                        
                <?php endif; ?>
            </td>

            <?php 
             $motivosPermitidos = [
            'GASTOS DE OPERACION',
            'GASTOS DE REPRESENTACION',
            'GASTOS DE MARKETING Y PUBLICIDAD',
            'GASTOS DE CAPACITACION Y FORMACION',
            'GASTOS DE INVESTIGACION Y DESARROLLO'
            ];
             ?>
           
            <td class="custom-glosa1">

                <div class="dropdown">

                         <button class="btn btn-sm btn-outline-dark dropdown-toggle text-left btn-primary" style="margin-top: 1px;"
                                type="button" id="dropdownAcciones<?php echo e($item['ID']); ?>"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                             <i class="mdi mdi-eye mr-4"></i> Ver Detalle
                        </button>
                       <div class="dropdown-menu d-dropdown-menu shadow-sm p-1" aria-labelledby="dropdownAcciones<?php echo e($item['ID']); ?>">
                            <?php if(!empty($item['TXT_GLOSA_RECHAZADO'])): ?>
                                <a class="dropdown-item show-glosa d-flex align-items-center" href="#"
                                   data-glosa="<?php echo e($item['TXT_GLOSA_RECHAZADO']); ?>"
                                   data-type="rechazo">
                                   <i class="mdi mdi-close-circle-outline text-danger mr-2"></i> Glosa de Rechazo
                                </a>
                            <?php endif; ?>

                            <?php if(!in_array($item['TIPO_MOTIVO'], $motivosPermitidos)): ?>
                          
                             <a class="dropdown-item verdetalleimporte-valerendir-vale-reembolso d-flex align-items-center" href="#">
                               <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Importe Gastos
                            </a>
                            <?php endif; ?>

                            <?php if(!empty($item['TXT_GLOSA_AUTORIZADO']) && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO'): ?>
                               <a class="dropdown-item show-glosa d-flex align-items-center" href="#"
                                       data-glosa="<?php echo e($item['TXT_GLOSA_AUTORIZADO']); ?>"
                                       data-type="autoriza">
                                       <i class="mdi mdi-close-circle-outline text-danger mr-2"></i> Glosa de Autorización
                                </a>
                            <?php endif; ?>

                             <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'APROBADO'): ?>
                                <a class="dropdown-item verdetalleaprobar-valerendir d-flex align-items-center" href="#">
                                    <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                                </a>
                            <?php endif; ?>
  
                    </div>
                     </div>
                </div>
             </td>
          
            <td style="text-align: center; vertical-align: middle;">
                 <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'ANULADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'AUTORIZADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO'): ?>
                    <button class="btn-rojo delete-valerendir">
                        <i class="icon mdi mdi-delete"></i>
                    </button>
                <?php endif; ?>
            </td>

        </tr>
         
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
</table>

<style>

    .d-dropdown-menu {
    width: auto !important;
    min-width: 150px; 
    max-width: 100px;
    white-space: normal;
    }

    .dropdown-menu a.dropdown-item {
    white-space: normal;
    display: flex;
    align-items: center;
    padding: 0.4rem 0.75rem;
    }   

    .dropdown-menu .dropdown-item + .dropdown-item {
    margin-top: 4px;
    }
    .badge-custom-danger {
        background-color: #8B0000; /* Rojo oscuro */
        color: white;
    }

    td.custom-glosa1 {
        display: flex;
        align-items: center;
        gap: 5px; /* Espacio entre botones */
        flex-wrap: wrap;
        }

    .btn-rojo {
    background-color: #d9534f;
    color: white;
    border: none;
    padding: 6px 10px;
    border-radius: 4px;
    }

    .btn-rojo i {
    color: white;
    }

    .btn-rojo:hover {
    background-color: #c9302c;
    }

    .col {
    background: #1d3a6d;; 
    color: white;              
    vertical-align: middle;
    }

    .selected {
    background-color: #7d9ac0 !important;
    color: #FFFFFF;
    vertical-align: middle;
    padding: 1.5em;
    }
</style>

