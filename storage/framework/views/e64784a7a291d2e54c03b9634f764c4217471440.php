
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
              <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                <?php  $color_virtual =  $funcion->funciones->ver_virtual_color($item->ID_DOCUMENTO,$item->TIPO_ARCHIVO)  ?>
                <tr class="<?php echo e($color_virtual); ?>">
                  <td><?php echo e($index + 1); ?></td>
                  <td><?php echo e($item->DESCRIPCION_ARCHIVO); ?></td>
                  <td><?php echo e($item->NOMBRE_ARCHIVO); ?></td>
                  <?php  
                    $es_pdf = str_contains(strtolower($item->NOMBRE_ARCHIVO), 'pdf');
                   ?>

                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">

                        <li>
                          <a href="<?php echo e(url('/descargar-archivo-requerimiento-contrato/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9)))); ?>">
                            Descargar
                          </a>  
                        </li>

                        <?php if($es_pdf): ?>
                            <li>
                                <a href="#" class="modificar-pdf" 
                                   data-tipo="<?php echo e($item->TIPO_ARCHIVO); ?>" 
                                   data-nombre="<?php echo e($item->DESCRIPCION_ARCHIVO); ?>">
                                  Modificar
                                </a>
                            </li>
                        <?php endif; ?>

                      </ul>
                    </div>
                  </td>
                </tr>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </tbody>
        </table>
      </div>
    </div>