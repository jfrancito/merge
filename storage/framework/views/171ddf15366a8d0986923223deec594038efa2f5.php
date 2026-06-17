<?php 
    $estado_consolidado = $listadetalle->first()->COD_ESTADO ?? null;
 ?>

<?php if($estado_consolidado != 'ETM0000000000015'): ?>
<div class="row" style="margin-bottom: 15px;">
    <div class="col-xs-12 text-right">
      


        <button type="button" class="btn btn-danger btn-detalle-consolidado" id="btn-aprobar-consolidado">
            <i class="mdi mdi-content-check"></i> Cerrar Consolidado
        </button>

      

    </div>
</div>
<?php endif; ?>


<style>
    .btn-detalle-consolidado {
        padding: 6px 15px;
        margin-left: 5px;
        border-radius: 4px;
        font-weight: 600;
        min-width: 140px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    .btn-detalle-consolidado i {
        margin-right: 6px;
        font-size: 16px;
    }

    /* Combo Box Premium */
    .combo-compra-moderno {
        height: 28px !important;
        padding: 0 15px 1px 5px !important; /* Ajustamos padding para subir un poco el texto */
        border-radius: 14px !important;
        border: 2px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        font-weight: 600 !important;
        color: #334155 !important;
        transition: all 0.3s ease;
        cursor: pointer;
        width: 145px !important;
        appearance: none;
        text-align: center !important;
        text-align-last: center !important;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23475569'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'%3E%3C/path%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 10px center;
        background-size: 14px;
        line-height: normal !important;
    }
    .combo-compra-moderno:focus {
        border-color: #3b82f6 !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.15) !important;
        outline: none;
    }
    .combo-compra-moderno:hover {
        border-color: #94a3b8 !important;
        background-color: #f8fafc !important;
    }
    .combo-compra-moderno:disabled {
        background-color: #f1f5f9 !important;
        border-color: #e2e8f0 !important;
        cursor: not-allowed;
        opacity: 0.7;
    }
    /* Estilo para Cantidad Comprada Redondeado */
    .input-cantidad-moderno {
        height: 28px !important;
        border-radius: 14px !important;
        border: 2px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        text-align: center;
        width: 80px !important;
        margin: 0 auto;
        font-weight: 600 !important;
        color: #334155 !important;
        transition: all 0.3s ease;
    }
    .input-cantidad-moderno:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15) !important;
        outline: none;
    }

    /* Select2 Personalizado Redondeado */
    .select2-container--default .select2-selection--single {
        border-radius: 14px !important;
        height: 28px !important;
        border: 2px solid #cbd5e1 !important;
        background-color: #ffffff !important;
        transition: all 0.3s ease;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 24px !important;
        font-weight: normal !important;
        color: #334155;
        text-align: center;
        padding-left: 15px !important;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 26px !important;
    }
    .select2-container--open .select2-dropdown--below, 
    .select2-container--open .select2-dropdown--above {
        border-radius: 14px !important;
        border: 2px solid #cbd5e1 !important;
        overflow: hidden;
        box-shadow: 0 4px 12px rgba(0,0,0,0.1) !important;
        margin-top: 5px;
    }
    .select2-results__option {
        padding: 6px 12px !important;
        font-weight: 500;
        text-align: center;
    }
</style>

<table id="tabla-detalle-consolidado" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" cellspacing="0" width="100%">
    <thead class="background-th-azul">
        <tr>
            <th>#</th>
            <th>COD_PRODUCTO</th>
            <th>PRODUCTO</th>
            <th class="text-center">COMPRA(LOCAL/SEDE)</th>
            <th class="text-center">UNIDAD MEDIDA</th>
            <th class="text-center">CANTIDAD</th>
            <th class="text-center">STOCK</th>
            <th class="text-center">RESERVADO</th>
            <th class="text-center">DIFERENCIA</th>
            <th class="text-center">CANTIDAD COMPRADA</th>
            <th>FAMILIA</th>
        </tr>
    </thead>

    <tbody>
        <?php $__empty_1 = true; $__currentLoopData = $listadetalle; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <tr class="fila-detalle-consolidado-generado" 
                data-id="<?php echo e($item->COD_PRODUCTO); ?>" 
                data-nombre="<?php echo e($item->NOM_PRODUCTO); ?>"
                data-detalle="<?php echo e($item->DETALLE_POR_AREA); ?>"
                style="cursor: pointer;">
                <td class="text-center"><?php echo e($index + 1); ?></td>
                <td><?php echo e($item->COD_PRODUCTO); ?></td>
                <td><?php echo e($item->NOM_PRODUCTO); ?></td>
                <td class="text-center">
                    <?php 
                        $current_ind_compra = trim($item->IND_COMPRA ?? '');
                        $current_cod_empr   = trim($item->COD_EMPR ?? '');
                        $current_cod_centro = trim($item->COD_CENTRO ?? '');

                        $selected_compra = $current_ind_compra;
                        if($selected_compra == ''){
                            if($current_cod_empr == 'IACHEM0000007086'){
                                $selected_compra = 'CHICLAYO';
                            } elseif($current_cod_empr == 'IACHEM0000010394'){
                                if($current_cod_centro == 'CEN0000000000002'){
                                    $selected_compra = 'LIMA';
                                } elseif($current_cod_centro == 'CEN0000000000001'){
                                    $selected_compra = 'CHICLAYO';
                                }
                            }
                        }
                     ?>
                    <select class="form-control input-sm select2-compra combo-compra" 
                            <?php if($item->COD_ESTADO == 'ETM0000000000015'): ?> disabled <?php endif; ?>>
                        <?php if($cod_centro_usuario === 'CEN0000000000001'): ?>
                            <option value="CHICLAYO" data-codigo="CEN0000000000001" selected>CHICLAYO</option>
                        <?php else: ?>
                            <option value="">Seleccione...</option>
                            <option value="<?php echo e($nom_centro_usuario); ?>" data-codigo="<?php echo e($cod_centro_usuario); ?>" <?php echo e($selected_compra == $nom_centro_usuario ? 'selected' : ''); ?>><?php echo e($nom_centro_usuario); ?></option>
                            <option value="CHICLAYO" data-codigo="CEN0000000000001" <?php echo e($selected_compra == 'CHICLAYO' ? 'selected' : ''); ?>>CHICLAYO</option>

                            
                            <?php if($selected_compra == 'LIMA' && $nom_centro_usuario != 'LIMA'): ?>
                                <option value="LIMA" data-codigo="CEN0000000000002" selected>LIMA</option>
                            <?php endif; ?>
                        <?php endif; ?>
                    </select>
                </td>
                <td class="text-center"><?php echo e($item->NOM_CATEGORIA_MEDIDA); ?></td>
                <td class="text-center"><?php echo e(number_format($item->CANTIDAD, 2)); ?></td>
                <td class="text-center"><?php echo e(number_format($item->STOCK, 2)); ?></td>
                <td class="text-center"><?php echo e(number_format($item->RESERVADO, 2)); ?></td>
                <td class="text-center" style="font-weight: bold;"><?php echo e(number_format($item->DIFERENCIA, 2)); ?></td>
                <td class="text-center">
                    <input type="text" 
                           class="form-control input-sm input-descontar input-cantidad-moderno inputmask-mil" 
                           value="<?php echo e(!is_null($item->CAN_COMPRADA) ? intval($item->CAN_COMPRADA) : intval($item->DIFERENCIA < 0 ? 0 : $item->DIFERENCIA)); ?>" 
                           <?php if($item->COD_ESTADO == 'ETM0000000000015'): ?> readonly <?php endif; ?>>
                </td>

                <td><?php echo e($item->NOM_CATEGORIA_FAMILIA); ?></td>
            </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <tr>
                <td colspan="11" class="text-center">No se encontraron productos para este consolidado / familia.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#tabla-detalle-consolidado').DataTable({
            responsive: true,
            language: {
                search: "Buscar:",
                lengthMenu: "Mostrar _MENU_ registros",
                info: "Mostrando de _START_ a _END_ de _TOTAL_ registros",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior"
                }
            }
        });

        $('.select2-compra').select2({
            minimumResultsForSearch: Infinity,
            width: '145px'
        });

        $('.inputmask-mil').inputmask('decimal', {
            groupSeparator: ',',
            autoGroup: true,
            digits: 0,
            rightAlign: false,
            removeMaskOnSubmit: true
        });
    });
</script>

<!-- CONTENEDOR NUEVO: DETALLE DEL PRODUCTO CONSOLIDADO (EN TABLA INFERIOR) -->
<div id="contenedor-detalle-producto-consolidado" style="display: none; margin-top: 25px;">
    
    <div style="position: relative; margin-bottom: 15px;">
        <h4 class="text-center" style="font-weight: bold; margin: 0; text-transform: uppercase;">
            <i class="mdi mdi-receipt"></i> DETALLE: <span id="titulo-producto-detalle" class="text-primary"></span>
        </h4>
        <div style="position: absolute; right: 0; top: 0;">
            <button type="button" class="btn btn-xs btn-danger" onclick="$('#contenedor-detalle-producto-consolidado').slideUp();">
                <i class="mdi mdi-close"></i> Cerrar
            </button>
        </div>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap" id="tablaDetalleInferior" cellspacing="0" width="100%">
            <thead class="background-th-azul">
                <tr>
                    <th class="text-center">FECHA</th>
                    <th class="text-center">NRO PEDIDO</th>
                    <th class="text-center">AREA</th>
                    <th class="text-center">GLOSA</th>
                    <th class="text-center">CANTIDAD</th>
                    <th class="text-center">ARCHIVO</th>
                </tr>
            </thead>
            <tbody style="background: white;">
                <!-- Se llena dinámicamente -->
            </tbody>
        </table>
    </div>
</div>

