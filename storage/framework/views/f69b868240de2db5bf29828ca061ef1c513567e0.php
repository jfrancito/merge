<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">


<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>

<table table id="tablalistafirmavale" class="table table-striped table-borderless">
  <thead style="background-color: #1d3a6d; color: white;">
        <tr>
            <th>ITEM</th>
            <th>ID</th>
            <th>FECHA</th>
            <th>SERIE</th>
            <th>NUMERO</th>
            <th>SOLICITA</th>
            <th>CONTRATO</th>
            <th>CULTIVO</th>
            <th>AUTORIZA</th>
            <th>DOCUMENTO</th>
            <th>MONEDA</th>
            <th>TIPO CAMBIO</th>
            <th>TOTAL</th>
            <th>SALDO</th>
            <th>ESTADO</th>
            <th>FIRMA/PDF</th>
        </tr>
  </thead>

      <tbody>
              <?php $__currentLoopData = $pendientes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index=>$item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
           <tr>
              <td><?php echo e($index + 1); ?></td>
              <td><?php echo e($item['ID_AUTORIZACION']); ?></td> 
              <td><?php echo e($item['FECHA']); ?></td>    
              <td><?php echo e($item['SERIE']); ?></td>    
              <td><?php echo e($item['NUMERO']); ?></td>    
              <td><?php echo e($item['NOM_SOLICITA']); ?></td>    
              <td><?php echo e($item['CONTRATO']); ?></td>               
              <td><?php echo e($item['CULTIVO']); ?></td>    
              <td><?php echo e($item['TRA_AUTORIZA']); ?></td>    
              <td><?php echo e($item['DOCUMENTO']); ?></td>  
              <td><?php echo e($item['MONEDA']); ?></td>
              <td><?php echo e($item['TIPO_CAMBIO']); ?></td>    
              <td><?php echo e($item['TOTAL']); ?></td>   
              <td><?php echo e($item['SALDO']); ?></td>   
              <td>
                <span class="badge badge-white">
                    <?php echo e($item['ESTADO']); ?>

                </span>
              </td>
              <td>
                <a href="<?php echo e(route('exportar_pdf', $item['ID_AUTORIZACION'])); ?>" class="btn-pdf">
                    <svg xmlns="http://www.w3.org/2000/svg" 
                         width="16" height="16" viewBox="0 0 24 24" 
                         fill="white" class="icon">
                        <path d="M6 2a2 2 0 0 0-2 2v16c0 
                                 1.1.9 2 2 2h12a2 2 0 0 
                                 0 2-2V8l-6-6H6zm7 7V3.5L18.5 
                                 9H13z"/>
                        <text x="5" y="20" 
                              font-size="7" 
                              font-weight="bold" 
                              fill="white">PDF</text>
                    </svg>
                    <span>PDF</span>
                </a>
            </td>
            </tr>   
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
</table>

<style>
    .btn-pdf {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 4px 10px;
        font-size: 12px;
        font-weight: bold;
        color: white !important;        
        background-color: #e3342f;      
        border-radius: 20px;
        text-decoration: none !important; 
        transition: 0.2s ease-in-out;
    }

    .btn-pdf .icon {
        flex-shrink: 0;  
    }

    .btn-pdf:hover {
        background-color: #cc1f1a;   
        transform: scale(1.05);
        color: white !important;    
        text-decoration: none !important; 
    }
</style>

<script>
<?php if(isset($ajax)): ?>
        $(document).ready(function () {
        $('[data-toggle="tooltip"]').tooltip();

        $('#tablalistafirmavale').DataTable({
            pageLength: 10,
            language: {
                url: "https://cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
            },
            destroy: true,
            ordering: false
        });
    });
    <?php endif; ?>

</script>



