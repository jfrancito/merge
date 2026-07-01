<table  class="table table-bordered td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%" style="font-style: italic;">
    <thead>
        <tr>
            <th style="text-align: center;">Sede</th>
            <th style="text-align: center;">Área</th>
            <th style="text-align: center;">Cargo</th>
            <th style="text-align: center;">Aprueba</th>
            <th style="text-align: center;">Eliminar</th>  

        </tr>
    </thead>
    <tbody>

          <?php $__currentLoopData = $listarpersonalaprueba; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

        
         <tr class="dobleclickpc" data_personal_aprueba="<?php echo e($item['ID']); ?>">
            <td><?php echo e($item['NOM_CENTRO']); ?></td>
            <td><?php echo e($item['TXT_AREA']); ?></td>
            <td><?php echo e($item['TXT_CARGO']); ?></td>
            <td><?php echo e($item['TXT_APRUEBA']); ?></td>

            <td class="text-center align-middle">
          <button class="btn-rojo delete-registropersonalaprueba">
            <i class="icon mdi mdi-delete"></i>
          </button>
        </td>
         
        </tr>
         
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       
    </tbody>
</table>
<style>
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

  thead th {
    background: #1d3a6d;; 
    color: white;              
    text-align: center;
    vertical-align: middle;
  }
</style>
