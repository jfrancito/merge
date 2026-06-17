<table id="importegastos" class="table table-bordered td-color-borde td-padding-7 display nowrap"
       cellspacing="0" width="100%" style="font-style: italic;">
  <thead>
    <tr>
      <th rowspan="2" style="text-align: center;">ID</th>
      <th rowspan="2" style="text-align: center;">Centro</th>
      <th rowspan="2" style="text-align: center;">Departamento</th>
      <th rowspan="2" style="text-align: center;">Provincia</th>
      <th rowspan="2" style="text-align: center;">Distrito</th>
      <th colspan="3" style="text-align: center;">Importe - Línea</th> <!-- encabezado agrupado -->
      <th rowspan="2" style="text-align: center;">Tipo</th>
      <th rowspan="2" style="text-align: center;">Indicador<br>(Ruta corta)</th>
      <th rowspan="2" style="text-align: center;">Eliminar</th>
    </tr>
    <tr>
      <th style="text-align: center;">Gerente</th>
      <th style="text-align: center;">Jefe</th>
      <th style="text-align: center;">Demás Lineas</th>
    </tr>
  </thead>

  <tbody>
    <?php $__currentLoopData = $listarimportegastos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr style="cursor:pointer;"
          data_importe_gastos="<?php echo e($item['ID']); ?>"
          data-id-gerente="<?php echo e($item['ID_GERENTE'] ?? ''); ?>"
          data-id-jefe="<?php echo e($item['ID_JEFE'] ?? ''); ?>"
          data-id-demas="<?php echo e($item['ID_DEMAS'] ?? ''); ?>">
          
        <td><?php echo e($item['ID']); ?></td>
        <td><?php echo e($item['NOM_CENTRO']); ?></td>
        <td><?php echo e($item['NOM_DEPARTAMENTO']); ?></td>
        <td><?php echo e($item['NOM_PROVINCIA']); ?></td>
        <td><?php echo e($item['NOM_DISTRITO']); ?></td>

        <td class="text-center">
          <?php if(isset($item['IMP_GERENTE'])): ?>
            S/. <?php echo e(number_format($item['IMP_GERENTE'], 2)); ?>

          <?php endif; ?>
        </td>
        <td class="text-center">
          <?php if(isset($item['IMP_JEFE'])): ?>
            S/. <?php echo e(number_format($item['IMP_JEFE'], 2)); ?>

          <?php endif; ?>
        </td>
        <td class="text-center">
          <?php if(isset($item['IMP_DEMAS'])): ?>
            S/. <?php echo e(number_format($item['IMP_DEMAS'], 2)); ?>

          <?php endif; ?>
        </td>

        <td><?php echo e($item['TIPO']); ?></td>
        <td><?php echo e($item['IND_DESTINO'] == 1 ? 'Sí' : 'No'); ?></td>
        <td class="text-center align-middle">
          <button class="btn-rojo delete-registroimportegastos">
            <i class="icon mdi mdi-delete"></i>
          </button>
        </td>
      </tr>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </tbody>

</table>


<style>
thead th {
  background: #1d3a6d;
  color: white;
  text-align: center;
  vertical-align: middle;
}

.btn-rojo {
  background-color: #d9534f;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 4px;
}

.btn-rojo:hover {
  background-color: #c9302c;
}

.selected {
  background-color: #7d9ac0 !important;
  color: #FFFFFF;
}

thead th:last-child,
thead th[colspan] + th {
  border-right: 1px solid #dee2e6 !important;
}
thead tr:first-child th[colspan] {
  border-bottom: none !important;
}
</style>

<script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
</script>