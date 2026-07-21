<table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>OPERACION</th>
      <th>FOLIO</th>
      <th>BANCO</th>
      <th>GLOSA</th>
      <th>CANTIDAD DOCUMENTOS</th>
      <th>ESTADO</th>
      <th>USUARIO CREA</th>
      <th>FECHA PAGO</th>
      <th>MONTO TOTAL</th>

      <th>OPCION</th>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php  $monto_total  = $funcion->funciones->neto_pagar_documento_lotes($item->FOLIO);  ?>

      <tr data_requerimiento_id = "<?php echo e($item->FOLIO); ?>"
        class='dobleclickpc seleccionar'
        >
        <td><?php echo e($index + 1); ?></td>
        <td><?php echo e($item->OPERACION); ?></td>
        <td><?php echo e($item->FOLIO); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_BANCO); ?></td>
        <td><?php echo e($item->TXT_GLOSA); ?></td>
        <td><?php echo e($item->CAN_FOLIO); ?></td>
        <?php echo $__env->make('entregadocumento.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td><?php echo e($item->nombre); ?></td>
        <td><?php echo e(date_format(date_create($item->FEC_PAGO), 'd-m-Y')); ?></td>
        <td><?php echo e($monto_total); ?></td>
        <td class="rigth">
          <div class="btn-group btn-hspace">
            <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
            <ul role="menu" class="dropdown-menu pull-right">
              <?php if($item->OPERACION=='DOCUMENTO_INTERNO_COMPRA'): ?>
                <li>
                  <a href="<?php echo e(url('/descargar-folio-dic-excel/'.$item->FOLIO)); ?>">
                    Descargar Resumen
                  </a>  
                </li>

                <li>
                  <a href="<?php echo e(url('/descargar-folio-dic-consolidado-excel/'.$item->FOLIO)); ?>">
                    Descargar Consolidado
                  </a>  
                </li>

                <li>
                  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-excel-cheque/'.$item->FOLIO)); ?>">
                    Macro de Cheque
                  </a>  
                </li>


              <?php else: ?>
                <?php if($item->OPERACION=='LIQUIDACION_COMPRA_ANTICIPO'): ?>
                  <li>
                    <a href="<?php echo e(url('/descargar-folio-lca-excel/'.$item->FOLIO)); ?>">
                      Descargar Resumen
                    </a>  
                  </li>
                <?php else: ?>
                  <?php if($item->OPERACION=='CONTRATO_ANTICIPO' || $item->OPERACION =='ORDEN_COMPRA_ANTICIPO'): ?>
                    <li>
                      <a href="<?php echo e(url('/descargar-folio-anticipo-excel/'.$item->FOLIO)); ?>">
                        Descargar Resumen
                      </a>  
                    </li>
                  <?php else: ?>
                    <li>
                      <a href="<?php echo e(url('/descargar-folio-excel/'.$item->FOLIO)); ?>">
                        Descargar Resumen
                      </a>  
                    </li>
                  <?php endif; ?>

                <?php endif; ?>
              <?php endif; ?>
              <?php if($item->OPERACION=='CONTRATO'): ?>
                <?php echo $__env->make('entregadocumento.excel.opcionct', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php else: ?>
                <?php if($item->OPERACION=='ORDEN_COMPRA'): ?>
                  <?php echo $__env->make('entregadocumento.excel.opcionoc', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                <?php else: ?>
                  <?php if($item->OPERACION=='DOCUMENTO_SERVICIO_BALANZA'): ?>
                    <?php echo $__env->make('entregadocumento.excel.opcionbal', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php else: ?>
                    <?php if($item->OPERACION=='LIQUIDACION_COMPRA_ANTICIPO'): ?>
                      <?php echo $__env->make('entregadocumento.excel.opcionlca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php else: ?>
                      <?php if($item->OPERACION=='ORDEN_COMPRA_ANTICIPO'): ?>
                        <?php echo $__env->make('entregadocumento.excel.opcionoca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <?php else: ?>
                        <?php if($item->OPERACION=='CONTRATO_ANTICIPO'): ?>
                          <?php echo $__env->make('entregadocumento.excel.opcionoca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php else: ?>
                          <?php echo $__env->make('entregadocumento.excel.opcionoc', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endif; ?>
              <?php endif; ?>

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


<?php if(isset($mensaje)): ?>
  <script type="text/javascript">
    alertajax("<?php echo e($mensaje); ?>");
  </script> 
<?php endif; ?>