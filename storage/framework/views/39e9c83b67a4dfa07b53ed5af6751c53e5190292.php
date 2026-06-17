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
         <?php if(
            $item['COD_CATEGORIA_ESTADO_VALE'] == 'ETM0000000000005' && 
            (
                ($perfil_administracion == '1CIX00000020' && $trabajadorCentro) || 
                ($perfil_administracion == '1CIX00000033' && $trabajadorCentro) ||
                ($perfil_administracion == '1CIX00000006' && $trabajadorCentro) ||
                ($perfil_administracion == '1CIX00000043' && $trabajadorCentro) ||
                ($perfil_administracion == '1CIX00000044' && $trabajadorCentro) ||
                ($perfil_administracion == '1CIX00000031' && $trabajadorCentro) ||
                ($perfil_administracion == '1CIX00000002' && $trabajadorCentro)

            )
        ): ?>
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
                <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] === 'AUTORIZADO'): ?>
                    <span class="badge badge-primary">POR APROBAR ADMINISTRACION</span> 
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

                       <?php if(!empty($item['TXT_GLOSA_AUTORIZADO']) || in_array($item['TIPO_MOTIVO'], $motivosPermitidos)): ?>
                            <a class="dropdown-item show-glosa d-flex align-items-center" href="#"
                                    data-glosa="<?php echo e($item['TXT_GLOSA_AUTORIZADO']); ?>"
                                    data-type="autoriza">
                                     <i class="mdi mdi-close-circle-outline text-danger mr-2"></i> Glosa de Autorización
                            </a>
                       <?php endif; ?>

                       <?php if(!in_array($item['TIPO_MOTIVO'], $motivosPermitidos)): ?>
                      
                         <a class="dropdown-item verdetalleimporte-valerendir d-flex align-items-center" href="#">
                           <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                        </a>
                        <?php endif; ?>
                    </div>
                </div>
           </td>

             <td>
                <div style="display: flex; flex-direction: column; gap: 5px;">
                    <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO'): ?>
                      <button class="btn btn-space btn-check btn-social registroaprobar-valerendir" 
                            data-toggle="tooltip" data-placement="top"> Aprobar
                    </button>
                    <?php endif; ?>
                    <?php if($item['TXT_CATEGORIA_ESTADO_VALE'] !== 'APROBADO' && $item['TXT_CATEGORIA_ESTADO_VALE'] !== 'RECHAZADO'): ?>
                        <button class="btn btn-space btn-close btn-social rechazar-valerendir" 
                                data-toggle="tooltip" data-placement="top" 
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

    .btn-check {
        background-color: #28a745; /* Color verde */
        border-color: #28a745;
        color: white;
    }

    .btn-check:hover {
        background-color: #218838;
        border-color: #1e7e34;
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

    td.custom-glosa1 {
    display: flex;
    align-items: center;
    gap: 5px; /* Espacio entre botones */
    flex-wrap: wrap;
    }

    td.custom-glosa {
    white-space: pre-line; 
    word-wrap: break-word; 
    max-width: 200px; 
    height: auto; 
    word-break: break-word;
    }
</style>

<script>
  
    <?php if(isset($ajax)): ?>
    $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();
    });
    <?php endif; ?>
</script>