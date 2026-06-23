<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<?php if(isset($listarDocumentoXML_CDR) && count($listarDocumentoXML_CDR) > 0): ?>
<?php 
   $usuario = $listarDocumentoXML_CDR[0]['USUARIO_CREA'] ?? '';
 ?>

<div class="alert mt-1 p-2" 
     style="background-color: #f8d7da; border: 1px solid #f5c2c7; color: #333; 
            margin-left: 15px; font-size: 13px; font-weight: 400; 
            box-shadow: 0px 2px 6px rgba(0,0,0,0.1); line-height: 1.4;">
    <span style="font-weight: bold; color: black; font-size:16px; text-transform: uppercase;">
        <?php echo e($usuario); ?>

    </span>  
    <span style="font-size:14px;">
        hasta la fecha el sistema no obtiene el XML y CDR de dichos comprobantes.  
        Por favor gestionar el envío de dicha documentación con el proveedor.
    </span>
</div>
<?php endif; ?>

<table table id="tablaDocumentoxml_cdr" class="table table-striped table-borderless">
  <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ITEM</th>
            <th>ID DOCUMENTO</th>
            <th>FECHA CREA</th>
            <th>SERIE</th>
            <th>NUMERO</th>
            <th>FECHA EMISION</th>
            <th>PROVEEDOR</th>
            <th>TOTAL</th>
            <th>IND_PDF</th>
            <th>IND_XML</th>
            <th>IND_CDR</th>
            <th>BUSQUEDAD</th>
        </tr>
  </thead>
      <tbody>
          <?php $__currentLoopData = $listarDocumentoXML_CDR; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <tr>
              <td><?php echo e($index + 1); ?></td>
              <td><?php echo e($item['ID_DOCUMENTO']); ?></td>
              <td><?php echo e($item['FEC_EMISION']); ?></td>
              <td><?php echo e($item['NRO_SERIE']); ?></td>
              <td><?php echo e($item['NUMERO']); ?></td>
              <td><?php echo e($item['FECHA_EMISIONDOC']); ?></td>
              <td style=" padding-right:200px;"><?php echo e($item['PROVEEDOR']); ?></td>
              <td><?php echo e($item['TOTAL']); ?></td>
              <td><?php echo e($item['IND_PDF']); ?></td>
              <td><?php echo e($item['IND_XML']); ?></td>
              <td><?php echo e($item['IND_CDR']); ?></td>
              <td><?php echo e($item['BUSQUEDAD']); ?></td>
            </tr>   
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>


      </tbody>
</table>

<script>
    
    <?php if(isset($ajax)): ?>
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablaDocumentoxml_cdr').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true
        });
    });
    <?php endif; ?>
</script>
