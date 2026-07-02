<table id="nsovales" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>VALE A RENDIR</th>
      <th>REGISTRO</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listavale; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_vale_rendir="<?php echo e($item->ID); ?>">

        <td><?php echo e($index + 1); ?></td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>ID :</b> <?php echo e($item->ID); ?></span>
          <span><b>FECHA  :</b> <?php echo e($item->FEC_USUARIO_CREA_AUD); ?></span>
          <span><b>TRABAJADOR : </b> <?php echo e($item->TXT_NOM_SOLICITA); ?> </span>
          <span><b>CUENTA :</b> <?php echo e(substr($item->COD_CONTRATO, 0, 6) . '-' . substr($item->COD_CONTRATO, -6)); ?> -- S/ OTRAS CTAS X COBRAR</span>
          <span><b>SUB CUENTA : </b> <?php echo e($item->SUB_CUENTA); ?></span>
          <span><b>CENTRO :</b>
                  <?php if($item->COD_CENTRO == 'CEN0000000000001'): ?>
                      CHICLAYO
                  <?php elseif($item->COD_CENTRO == 'CEN0000000000002'): ?>
                      LIMA
                  <?php elseif($item->COD_CENTRO == 'CEN0000000000004'): ?>
                      RIOJA
                  <?php elseif($item->COD_CENTRO == 'CEN0000000000006'): ?>
                      BELLAVISTA
                  <?php else: ?>
                      <?php echo e($item->COD_CENTRO); ?>

                  <?php endif; ?>
          </span>
          <span><b>DESTINO :</b> <?php echo e($item->NOM_DESTINO); ?></span>


          
          <span><b>OSIRIS DOCUMENTO : </b> <?php echo e($item->TXT_SERIE); ?> - <?php echo e($item->TXT_NUMERO); ?></span>
          <span><b>OSIRIS ID : </b> <?php echo e($item->ID_OSIRIS); ?> </span>



          <span><b>TOTAL : </b> <?php echo e($item->CAN_TOTAL_IMPORTE); ?> </span>
        </td>
        <td class="cell-detail sorting_1" style="position: relative;">
          <span><b>JEFE : </b> <?php echo e($item->TXT_NOM_AUTORIZA); ?> </span>
          <span><b>ADMINISTRACION : </b> <?php echo e($item->TXT_NOM_APRUEBA); ?> </span>
        </td>
         <?php echo $__env->make('valerendir.gestion.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

         <td class="rigth">
       <div class="btn-group btn-hspace"
            <?php if($item->TIPO_MOTIVO != 'TIP0000000000003'): ?> style="display:none;" <?php endif; ?>>
            <button type="button" id="dropdownAcciones<?php echo e($item->ID); ?>" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
                <li>
                    <a class="dropdown-item verdetalleimporte-valegestion d-flex align-items-center" href="#">
                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Detalle Vale a Rendir
                    </a>
                </li>

                <li>
                    <a class="dropdown-item verdetalle-valegestion d-flex align-items-center" href="#">
                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Aumentar Días Rendición 
                    </a>
                </li>

                <li>
                    <a class="dropdown-item aumdetalleimporte-valegestion d-flex align-items-center" href="#">
                        <i class="mdi mdi-check-circle-outline text-success mr-2"></i> Aumentar Importe Viáticos 
                    </a>
                </li>
            </ul>
          </div>
        </td>
      </tr>                    
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>
</table>

<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
<?php endif; ?>


