
<div class="panel-heading">

  <div class="tools tooltiptop">
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones">
      <span class="tooltiptext">Total Seleccionado</span>
      <b class='totalseleccion' style="font-size:16px;">0.0000</b>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones">
      <span class="tooltiptext">Cantidad Seleccionado</span>
      <b class='cantidaseleccion' style="font-size:16px;">0</b>
    </a>

  </div>


</div>
<br>

<div class="panel-heading">
  <form method="POST" id='formre' action="<?php echo e(url('/select-xml-estiba/'.$idopcion)); ?>" style="border-radius: 0px;" class="form-horizontal group-border-dashed" enctype="multipart/form-data">
        <?php echo e(csrf_field()); ?>

        <input type="hidden" name="jsondocumenos" id = 'jsondocumenos'>
        <input type="hidden" name="operacion_sel" id="operacion_sel" value = '<?php echo e($operacion_id); ?>'>

  </form>

  <div class="tools tooltiptop">
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones detalleestibs">
      <span class="tooltiptext">Detalle</span>
      <span class="icon mdi mdi-assignment"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones lotesestibas">
      <span class="tooltiptext">Lotes</span>
      <span class="icon mdi mdi-eye"></span>
    </a>
    <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones migrarestibaadmin">
      <span class="tooltiptext">Registrar</span>
      <span class="icon mdi mdi-collection-image"></span>
    </a>
  </div>
</div>



<table id="estiba" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>
    <tr>
      <th>ITEM</th>
      <th>OPERACION</th>
      <th>CODIGO</th>
      <th>DOCUMENTO</th>
      <th>EXTORNO</th>
      <th>FECHA </th>
      <th>MONEDA</th>
      <th>PROVEEDOR</th>
      <th>TOTAL</th>      
      <th>USUARIO CREACION</th>
      <th>ESTADO</th>
      <th>LOTE</th>

      <th>
        <div class="text-center be-checkbox be-checkbox-sm has-primary">
          <input  type="checkbox"
                  class="todo_asignar input_asignar"
                  id="todo_asignar"                  
          >
          <label  for="todo_asignar"
                  data-atr = "todas_asignar"
                  class = "checkbox_asignar"
                  name="todo_asignar"
            ></label>
        </div>
      </th>
    </tr>
  </thead>
  <tbody>
    <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr data_requerimiento_id = "<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>" data_lote = "<?php echo e($item->LOTE_DOC); ?>" data_total = "<?php echo e($item->CAN_TOTAL); ?>">
        <td><b><?php echo e($index + 1); ?></b></td>
        <td><b><?php echo e($operacion_id); ?></b></td>
        <td><?php echo e($item->COD_DOCUMENTO_CTBLE); ?></td>
        <td><?php echo e($item->NRO_SERIE); ?> - <?php echo e($item->NRO_DOC); ?></td>
        <td><?php echo e($funcion->funciones->estorno_referencia($item->COD_DOCUMENTO_CTBLE)); ?></td>
        <td><?php echo e($item->FEC_EMISION); ?></td>
        <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
        <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
        <td><?php echo e($item->CAN_TOTAL); ?></td>        
        <td><?php echo e($item->COD_USUARIO_CREA_AUD); ?></td>
        <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <td><?php echo e($item->LOTE_DOC); ?></td>
        
        <td class="rigth">
          <div class="text-center be-checkbox be-checkbox-sm has-primary">
            <input  type="checkbox"
              class="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?> input_asignar"
              data_total = "<?php echo e($item->CAN_TOTAL); ?>"   
              id="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>" >
            <label  for="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>"
                  data-atr = "ver"
                  class = "checkbox checkbox_asignar"
                  data_total = "<?php echo e($item->CAN_TOTAL); ?>"                
                  name="<?php echo e($item->COD_DOCUMENTO_CTBLE); ?>"
            ></label>
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