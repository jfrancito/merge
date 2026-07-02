<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>EXTORNO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>
      <th>USUARIO CREACION</th>
      <th>ESTADO</th>
      <th>OPCION</th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->id); ?>">
        <td><b>ORDER DE COMPRA</b></td>
        <td><?php echo e($item->COD_ORDEN); ?></td>
        <td><?php echo e($funcion->funciones->estorno_referencia($item->COD_ORDEN)); ?></td>
        <td><?php echo e($item->FEC_ORDEN); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
        <td><?php echo e($item->TXT_EMPR_CLIENTE); ?></td>
        <td><?php echo e($item->CAN_TOTAL); ?></td>
        <td><?php echo e($item->COD_USUARIO_CREA_AUD); ?></td>
        <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <li>


                  <?php if(ltrim(rtrim($item->COD_ESTADO)) == ''): ?> 
                      <a href="<?php echo e(url('/detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                        Registro XML
                      </a>
                  <?php else: ?>

                    <?php if(is_null($item->COD_ESTADO)): ?> 
                        <a href="<?php echo e(url('/detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                          Registro XML
                        </a>
                    <?php else: ?>
                      <?php if($item->COD_ESTADO != 'ETM0000000000001'): ?>
                        <?php if($item->COD_ESTADO != 'ETM0000000000006'): ?>
                          <a href="<?php echo e(url('/detalle-comprobante-oc-validado/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                            Detalle de Registro
                          </a>
                        <?php else: ?>
                          <a href="<?php echo e(url('/detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                            Registro XML
                          </a>
                        <?php endif; ?>
                      <?php else: ?>
                          <a href="<?php echo e(url('/detalle-comprobante-oc-administrator/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                            Registro XML
                          </a>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endif; ?>



              </li>
<!--               <li>
                <a href="<?php echo e(url('/agregar-archivo-uc/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                  Agregar Archivos
                </a>  
              </li> -->
<!--               <?php if(Session::get('usuario')->id == '1CIX00000001' || Session::get('usuario')->rol_id == '1CIX00000020'): ?>
              <li>
                <a href="<?php echo e(url('/quitar-archivo-uc/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                  Quitar Archivos
                </a>  
              </li>
              <?php endif; ?> -->

              <li>
                <a href="<?php echo e(url('/cambiar-orden-compra-anticipo/'.$procedencia.'/'.$idopcion.'/'.substr($item->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($item->COD_ORDEN, -10)))); ?>">
                  Cambiar OC Anticipo
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