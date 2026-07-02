<table id="tabla-obras" class="table table-striped table-hover table-fw-widget">
  <thead>
    <tr>
      <th class="no-export">Opciones</th>
      <th>Item PLE</th>
      <th>Nombre</th>
      <th>Estado</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $lista; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <?php if(isset($permisos) && $permisos['modificar'] == 1): ?>
            <button type="button" class="btn btn-primary btn-xs btn-editar-activo"
               data-id="<?php echo e($item->id); ?>" 
               data-item_ple="<?php echo e($item->item_ple); ?>" 
               data-nombre="<?php echo e($item->nombre); ?>" 
               data-cantidad="<?php echo e($item->cantidad); ?>" 
               data-estado="<?php echo e($item->estado); ?>" 
               data-tipo="<?php echo e($item->tipo_activo); ?>"
               data-marca="<?php echo e($item->marca); ?>"
               data-modelo="<?php echo e($item->modelo); ?>"
               data-numero_serie="<?php echo e($item->numero_serie); ?>"
               data-factura="<?php echo e($item->factura); ?>"
               data-fecha_emision="<?php echo e($item->fecha_emision); ?>"
               data-base_de_calculo="<?php echo e($item->base_de_calculo); ?>"
               data-depreciacion_acumulada="<?php echo e($item->depreciacion_acumulada); ?>"
               data-fecha_inicio_depreciacion="<?php echo e($item->fecha_inicio_depreciacion); ?>"
               data-ultima_fecha_depreciacion="<?php echo e($item->ultima_fecha_depreciacion); ?>"
               data-cod_centro="<?php echo e($item->cod_centro); ?>"
               data-toggle="tooltip" data-placement="top" title="Editar">
              <i class="mdi mdi-edit"></i>
            </button>
            <?php endif; ?>

            <?php if(isset($permisos) && $permisos['eliminar'] == 1): ?>
            <button type="button" class="btn btn-danger btn-xs btn-eliminar-activo" 
               data-id="<?php echo e($item->id); ?>"
               data-toggle="tooltip" data-placement="top" title="Eliminar">
              <i class="mdi mdi-delete"></i>
            </button>
            <?php endif; ?>
          </div>
        </td>
        <td><?php echo e($item->item_ple); ?></td>
        <td><?php echo e($item->nombre); ?></td>
        <td><?php echo e($item->estado); ?></td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>
