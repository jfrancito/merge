<?php if(count($productos) > 0): ?>
    <div class="row" style="margin-bottom: 15px; padding: 0 5px;">
        <div class="col-md-12">
            <p class="text-muted">
                Seleccione los productos del consolidado <b><?php echo e($id_consolidado); ?></b> que desea deshabilitar. Solo se muestran los productos que aún no han sido cotizados.
            </p>
        </div>
    </div>

    <div class="table-responsive" style="max-height: 350px; overflow-y: auto;">
        <table id="table-productos-deshabilitar" class="table table-striped table-hover table-fw-widget listatabla">
            <thead>
                <tr>
                    <th class="text-center" width="50">
                        <div class="xs-check-prod">
                            <input id="check-all-productos-desh" type="checkbox" checked>
                            <label for="check-all-productos-desh"></label>
                        </div>
                    </th>
                    <th>COD PRODUCTO</th>
                    <th>PRODUCTO</th>
                    <th>UNIDAD MEDIDA</th>
                    <th class="text-right">CANTIDAD</th>
                    <th>FAMILIA</th>
                </tr>
            </thead>
            <tbody>
                <?php $__currentLoopData = $productos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prod): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr class="fila-producto-deshabilitar" style="cursor: pointer;">
                    <td class="text-center">
                        <div class="xs-check-prod">
                            <input id="check-prod-<?php echo e(trim($prod->COD_PRODUCTO)); ?>" 
                                   type="checkbox" 
                                   name="cod_producto_desh[]" 
                                   class="check-producto-desh" 
                                   value="<?php echo e(trim($prod->COD_PRODUCTO)); ?>"
                                   checked>
                            <label for="check-prod-<?php echo e(trim($prod->COD_PRODUCTO)); ?>"></label>
                        </div>
                    </td>
                    <td class="font-bold"><?php echo e(trim($prod->COD_PRODUCTO)); ?></td>
                    <td><?php echo e($prod->NOM_PRODUCTO); ?></td>
                    <td><?php echo e($prod->NOM_CATEGORIA_MEDIDA); ?></td>
                    <td class="text-right font-bold"><?php echo e(number_format($prod->CANTIDAD, 2)); ?></td>
                    <td><?php echo e($prod->NOM_CATEGORIA_FAMILIA); ?></td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </tbody>
        </table>
    </div>
    
    <!-- ID Consolidado oculto para el confirmador -->
    <input type="hidden" id="id_consolidado_desh" value="<?php echo e($id_consolidado); ?>">

    <script>
        $(document).ready(function() {
            // Activar/desactivar todos los productos
            $('#check-all-productos-desh').on('change', function() {
                $('.check-producto-desh').prop('checked', $(this).prop('checked'));
            });

            // Al hacer clic en una fila, seleccionar el checkbox
            $('#table-productos-deshabilitar tbody tr').on('click', function(e) {
                if ($(e.target).is('input') || $(e.target).is('label')) return;
                var cb = $(this).find('.check-producto-desh');
                cb.prop('checked', !cb.prop('checked'));
            });
        });
    </script>
<?php else: ?>
    <div class="alert alert-warning text-center shadow-soft" style="margin: 20px 0; border-radius: 8px;">
        <div class="icon" style="font-size: 24px; margin-bottom: 10px;">⚠️</div>
        <h4>¡No hay productos pendientes!</h4>
        <p>Todos los productos de este consolidado (<b><?php echo e($id_consolidado); ?></b>) ya están asociados a una cotización activa.</p>
    </div>
    <script>
        $(document).ready(function() {
            // Ocultar o deshabilitar el botón de confirmar si no hay productos
            $('.btn-confirmar-deshabilitar-productos').prop('disabled', true).addClass('disabled');
        });
    </script>
<?php endif; ?>

<style>
    .xs-check-prod {
        position: relative;
        display: inline-block;
        vertical-align: middle;
        text-align: left;
    }
    .xs-check-prod input { opacity: 0; position: absolute; z-index: -1; }
    .xs-check-prod label { cursor: pointer; display: block; height: 18px; width: 18px; border: 2px solid #ddd; border-radius: 4px; position: relative; }
    .xs-check-prod input:checked + label { background: #a94442; border-color: #a94442; }
    .xs-check-prod input:checked + label:after {
        content: '\2714';
        position: absolute;
        top: -1px;
        left: 2px;
        color: white;
        font-size: 12px;
    }
</style>
