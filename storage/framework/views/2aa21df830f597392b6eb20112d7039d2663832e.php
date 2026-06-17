<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/responsive.dataTables.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>

<style>
    /* Premium Panel Container */
    .panel-premium-rutas {
        border: none !important;
        border-radius: 12px !important;
        background: #ffffff !important;
        box-shadow: 0 8px 30px rgba(0, 0, 0, 0.04) !important;
        overflow: hidden !important;
        margin-bottom: 30px !important;
    }
    
    /* Heading Style */
    .heading-rutas {
        font-family: 'Montserrat', 'Poppins', 'Segoe UI', sans-serif !important;
        background: #f8fafc !important;
        padding: 20px 24px !important;
        border-bottom: 1px solid #edf2f7 !important;
        display: flex !important;
        align-items: center !important;
        gap: 12px !important;
        margin: 0 !important;
    }
    .heading-rutas i {
        color: #2a5298 !important;
        font-size: 24px !important;
    }
    .heading-rutas h3 {
        margin: 0 !important;
        font-size: 18px !important;
        font-weight: 700 !important;
        color: #1e293b !important;
        letter-spacing: 0.5px !important;
    }

    /* Filters Section */
    .filters-section {
        padding: 24px !important;
        background: #ffffff !important;
        border-bottom: 2px dashed #e2e8f0 !important;
    }
    .filter-label {
        font-size: 12px !important;
        font-weight: 700 !important;
        color: #64748b !important;
        text-transform: uppercase !important;
        letter-spacing: 1px !important;
        margin-bottom: 8px !important;
        display: block !important;
    }
    .select-premium {
        border-radius: 8px !important;
        border: 1px solid #cbd5e1 !important;
        padding: 10px 14px !important;
        height: auto !important;
        font-size: 14px !important;
        color: #334155 !important;
        width: 100% !important;
        background-color: #f8fafc !important;
        transition: all 0.3s ease !important;
    }
    .select-premium:focus {
        border-color: #3b82f6 !important;
        background-color: #ffffff !important;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1) !important;
        outline: none !important;
    }

    /* Matrix Table Section */
    .matrix-section {
        padding: 30px 24px !important;
        background: #fdfdfd !important;
    }
    
    .table-matrix {
        width: 100% !important;
        border-collapse: separate !important;
        border-spacing: 0 !important;
        border: 1px solid #e2e8f0 !important;
        border-radius: 10px !important;
        overflow: hidden !important;
    }
    
    .table-matrix th {
        background: linear-gradient(135deg, #1d3a6d 0%, #2a5298 100%) !important;
        color: #ffffff !important;
        font-size: 13px !important;
        font-weight: 600 !important;
        text-transform: uppercase !important;
        letter-spacing: 0.8px !important;
        padding: 16px !important;
        text-align: center !important;
        border-right: 1px solid rgba(255,255,255,0.1) !important;
    }
    .table-matrix th:first-child {
        text-align: left !important;
        background: #1e293b !important; /* Diferente para la cabecera de la primera columna */
    }
    
    .table-matrix td {
        padding: 12px 16px !important;
        border-bottom: 1px solid #edf2f7 !important;
        border-right: 1px solid #edf2f7 !important;
        vertical-align: middle !important;
        background: #ffffff !important;
        transition: all 0.2s ease !important;
    }
    
    .table-matrix tr:last-child td {
        border-bottom: none !important;
    }
    
    .table-matrix td:first-child {
        font-weight: 600 !important;
        color: #334155 !important;
        font-size: 13px !important;
        background: #f8fafc !important;
    }
    
    .table-matrix td:first-child i {
        font-size: 18px !important;
        color: #2a5298 !important;
        vertical-align: middle !important;
        width: 24px !important;
        display: inline-block !important;
        text-align: center !important;
    }
    
    .table-matrix tr:hover td {
        background: #f1f5f9 !important;
    }
    
    /* Input Importe */
    .input-importe {
        width: 100% !important;
        border: 1px solid #cbd5e1 !important;
        border-radius: 6px !important;
        padding: 10px 12px !important;
        font-size: 14px !important;
        font-weight: 600 !important;
        color: #0f172a !important;
        text-align: right !important;
        transition: all 0.3s ease !important;
    }
    .input-importe:focus {
        border-color: #10b981 !important;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1) !important;
        outline: none !important;
    }
    
    /* Estructura Base de Botones de Acción */
    .btn-guardar-matriz, .btn-limpiar-premium {
        height: 46px !important;
        padding: 0 30px !important;
        font-size: 14px !important;
        font-weight: bold !important;
        letter-spacing: 0.5px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        justify-content: center !important;
        gap: 10px !important;
        vertical-align: middle !important;
    }

    /* Botón Guardar */
    .btn-guardar-matriz {
        background: linear-gradient(135deg, #0f766e 0%, #059669 100%) !important;
        color: #ffffff !important;
        border: 1px solid transparent !important;
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3) !important;
    }
    .btn-guardar-matriz:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4) !important;
    }
    .btn-guardar-matriz i {
        font-size: 18px !important;
    }

    /* Botón Limpiar */
    .btn-limpiar-premium {
        background: #f8fafc !important;
        color: #475569 !important;
        border: 1px solid #cbd5e1 !important;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.04) !important;
    }
    .btn-limpiar-premium:hover {
        background: #f1f5f9 !important;
        border-color: #94a3b8 !important;
        transform: translateY(-2px) !important;
    }
    .btn-limpiar-premium i {
        font-size: 18px !important;
    }
    
    /* Tabs Premium */
    .nav-tabs-premium {
        border-bottom: 2px solid #e2e8f0 !important;
        margin-bottom: 0px !important;
        padding: 0 24px !important;
        background: #fdfdfd !important;
    }
    .nav-tabs-premium .nav-item {
        margin-bottom: -2px !important;
        display: inline-block;
    }
    .nav-tabs-premium .nav-item > a {
        border: none !important;
        color: #64748b !important;
        font-weight: 600 !important;
        font-size: 14px !important;
        padding: 16px 20px !important;
        border-bottom: 2px solid transparent !important;
        transition: all 0.3s ease !important;
        background: transparent !important;
        display: block;
    }
    .nav-tabs-premium .nav-item > a:hover {
        color: #3b82f6 !important;
    }
    .nav-tabs-premium .nav-item.active > a,
    .nav-tabs-premium .nav-item.active > a:focus,
    .nav-tabs-premium .nav-item.active > a:hover {
        color: #2a5298 !important;
        border-bottom: 2px solid #2a5298 !important;
        background: transparent !important;
    }
    .tab-content-premium {
        padding: 0 !important;
    }
    /* Accordion Premium */
    /* Buscador Premium */
    .search-premium-container {
        position: relative;
        width: 100%;
        max-width: 320px;
        margin-bottom: 20px;
    }
    .search-premium-container .search-icon {
        position: absolute;
        left: 16px;
        top: 50%;
        transform: translateY(-50%);
        color: #94a3b8;
        font-size: 16px;
    }
    .search-premium-input {
        width: 100%;
        height: 42px;
        padding: 8px 20px 8px 45px;
        border-radius: 25px;
        border: 1px solid #cbd5e1;
        background-color: #f8fafc;
        color: #334155;
        font-size: 14px;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);
        outline: none !important;
    }
    .search-premium-input:focus {
        background-color: #ffffff;
        border-color: #3b82f6;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.15);
    }
    .search-premium-input::placeholder {
        color: #94a3b8;
        font-weight: 400;
    }

    /* Animaciones para el Modal Premium */
    @keyframes  popIn {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    @keyframes  shake {
        0%, 100% { transform: translateX(0); }
        10%, 30%, 50%, 70%, 90% { transform: translateX(-5px); }
        20%, 40%, 60%, 80% { transform: translateX(5px); }
    }

    .accordion-premium .panel {
        border: 1px solid #e2e8f0 !important;
        border-radius: 8px !important;
        margin-bottom: 15px !important;
        box-shadow: 0 2px 6px rgba(0,0,0,0.03) !important;
        overflow: hidden;
    }
    .accordion-premium .panel-heading {
        background: #f8fafc !important;
        padding: 0 !important;
        border-bottom: none !important;
    }
    .accordion-premium .panel-title {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        background: transparent !important;
    }
    .accordion-premium .panel-title a.btn-collapse {
        display: block !important;
        padding: 16px 24px !important;
        font-size: 15px !important;
        color: #334155 !important;
        text-decoration: none !important;
        transition: all 0.3s ease !important;
        flex-grow: 1;
    }
    .accordion-premium .panel-title a.btn-collapse:hover,
    .accordion-premium .panel-title a.btn-collapse:not(.collapsed) {
        background: #f1f5f9 !important;
    }
    .accordion-premium .action-buttons {
        padding-right: 15px;
        display: flex;
        gap: 8px;
    }
    .btn-action-ruta {
        border-radius: 8px !important;
        padding: 8px 14px !important;
        font-size: 18px !important;
        border: 1px solid transparent !important;
        transition: all 0.2s !important;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 4px rgba(0,0,0,0.02) !important;
    }
    .btn-action-ruta.btn-modificar {
        color: #4f46e5 !important;
        background: #e0e7ff !important;
    }
    .btn-action-ruta.btn-modificar:hover {
        background: #c7d2fe !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(79, 70, 229, 0.15) !important;
    }
    .btn-action-ruta.btn-eliminar {
        color: #e11d48 !important;
        background: #ffe4e6 !important;
    }
    .btn-action-ruta.btn-eliminar:hover {
        background: #fecdd3 !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(225, 29, 72, 0.15) !important;
    }
    .btn-action-ruta i {
        font-size: 20px !important;
        line-height: 1;
    }

    /* Diseño Corporate Premium para el Header de Ruta */
    .route-header-premium {
        display: flex;
        align-items: center;
        flex-grow: 1;
        padding: 4px 0;
    }
    .location-box {
        display: flex;
        flex-direction: column;
        justify-content: center;
    }
    .location-box.origin {
        align-items: flex-end;
        text-align: right;
        min-width: 180px;
    }
    .location-box.destination {
        align-items: flex-start;
        text-align: left;
        min-width: 180px;
    }
    .location-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #94a3b8;
        letter-spacing: 1.2px;
        margin-bottom: 3px;
    }
    .location-name {
        font-size: 17px;
        font-weight: 800;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .location-box.origin .location-name i {
        color: #f59e0b; /* Amber */
        font-size: 22px;
    }
    .location-box.destination .location-name i {
        color: #059669; /* Emerald Green */
        font-size: 22px;
    }
    .route-divider {
        display: flex;
        align-items: center;
        margin: 0 35px;
        flex-grow: 1;
        max-width: 120px;
        position: relative;
    }
    .route-line {
        height: 2px;
        width: 100%;
        background-image: linear-gradient(to right, #cbd5e1 50%, transparent 50%);
        background-size: 10px 2px;
        background-repeat: repeat-x;
    }
    .transport-icon {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        color: #64748b;
        font-size: 26px;
        background: #f8fafc;
        padding: 0 10px;
        transition: all 0.3s;
    }
    
    /* Efecto al pasar el mouse */
    .accordion-premium .panel-title a.btn-collapse:hover .transport-icon,
    .accordion-premium .panel-title a.btn-collapse:not(.collapsed) .transport-icon {
        background: #f1f5f9 !important; /* Igualar al fondo de hover */
        color: #ea580c; /* Color naranja industrial para camión */
        transform: translate(-50%, -50%) scale(1.15);
    }
    
    /* Badge de Número */
    .route-number-badge {
        width: 38px;
        height: 38px;
        border-radius: 50%;
        background: linear-gradient(135deg, #1e293b, #0f172a);
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 800;
        font-size: 15px;
        margin-right: 20px;
        box-shadow: 0 2px 5px rgba(15, 23, 42, 0.3);
        flex-shrink: 0;
    }
    
    .accordion-premium .d-flex {
        display: flex !important;
        align-items: center !important;
    }
    .accordion-premium .mr-2 { margin-right: 8px !important; }
    .accordion-premium .mx-3 { margin-left: 15px !important; margin-right: 15px !important; }
    
    .accordion-premium .origen-text, .accordion-premium .destino-text {
        font-weight: 700 !important;
        letter-spacing: 0.5px;
        color: #1e293b !important;
    }
    .accordion-premium .panel-body {
        padding: 0 !important;
        border-top: 1px solid #e2e8f0 !important;
    }
    
    /* Readonly Matrix */
    .table-readonly td.has-value {
        color: #059669 !important;
        font-weight: 700 !important;
        background-color: #ecfdf5 !important;
    }
    .table-readonly td.is-zero {
        color: #94a3b8 !important;
        font-weight: 500 !important;
        text-align: center !important;
    }
    
</style>

<div class="be-content rutasprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                
                <div class="panel-premium-rutas">
                    <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" id="token">
                    <input type="hidden" name="carpeta" value="<?php echo e($capeta); ?>" id="carpeta">
                    
                    <!-- Heading -->
                    <div class="heading-rutas">
                        <i class="mdi mdi-map-marker-radius"></i>
                        <h3>Gestión de Importes por Ruta</h3>
                    </div>

                    <!-- Tabs Navigation -->
                    <ul class="nav nav-tabs nav-tabs-premium" role="tablist">
                        <li class="nav-item active">
                            <a href="#tab-configurar" role="tab" data-toggle="tab">
                                <i class="mdi mdi-settings"></i> Configuración de Matriz
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="#tab-registros" role="tab" data-toggle="tab">
                                <i class="mdi mdi-format-list-bulleted"></i> Registro de Rutas Creadas
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content tab-content-premium">
                        <!-- TAB 1: Configurar Matriz -->
                        <div role="tabpanel" class="tab-pane fade in active" id="tab-configurar">
                            <!-- Filtros de Ubicación -->
                            <div class="filters-section">
                                <div class="row">
                                    <div class="col-md-6 col-sm-12 mb-3">
                                        <label class="filter-label">Origen <span class="text-danger">*</span></label>
                                        <?php echo Form::select('origen', $origenes, '', [
                                            'class' => 'form-control select-premium select2',
                                            'id' => 'origen'
                                        ]); ?>

                                    </div>
                                    <div class="col-md-6 col-sm-12 mb-3">
                                        <label class="filter-label">Distrito / Destino <span class="text-danger">*</span></label>
                                        <?php echo Form::select('distrito', $distritos, '', [
                                            'class' => 'form-control select-premium select2',
                                            'id' => 'distrito'
                                        ]); ?>

                                    </div>
                                </div>
                            </div>
                    
                    <!-- Matriz de Configuración -->
                    <div class="matrix-section">
                        <div class="table-responsive">
                            <table class="table-matrix">
                                <thead>
                                    <tr>
                                        <th>Tipos de Importe \ Línea</th>
                                        <?php $__currentLoopData = $tipos_linea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <th><?php echo e($linea->TXT_LINEA); ?></th>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $tipo_importe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cod_motivo => $txt_motivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if($cod_motivo == ''): ?> <?php continue; ?> <?php endif; ?>
                                        <?php 
                                            $icon = 'mdi mdi-check-circle';
                                            $txt_upper = strtoupper($txt_motivo);
                                            if (strpos($txt_upper, 'ALIMENTA') !== false) $icon = 'fa fa-cutlery';
                                            elseif (strpos($txt_upper, 'ALOJA') !== false) $icon = 'mdi mdi-hotel';
                                            elseif (strpos($txt_upper, 'LOCAL') !== false || strpos($txt_upper, 'MOVILIDAD LOCAL') !== false) $icon = 'mdi mdi-car';
                                            elseif (strpos($txt_upper, 'DEPARTAMENTAL') !== false) $icon = 'mdi mdi-bus';
                                            elseif (strpos($txt_upper, 'PROVINCIAL') !== false) $icon = 'mdi mdi-bus';
                                            elseif (strpos($txt_upper, 'COMBUSTIBLE') !== false) $icon = 'mdi mdi-gas-station';
                                            elseif (strpos($txt_upper, 'PEAJE') !== false) $icon = 'fa fa-ticket';
                                            elseif (strpos($txt_upper, 'MANTENIMIENTO') !== false) $icon = 'mdi mdi-wrench';
                                            elseif (strpos($txt_upper, 'AEROPUERTO') !== false) $icon = 'mdi mdi-airplane';
                                            elseif (strpos($txt_upper, 'ESTACIONAMIENTO') !== false) $icon = 'mdi mdi-parking';
                                         ?>
                                        <tr>
                                            <td data-cod-tipo="<?php echo e($cod_motivo); ?>" data-txt-tipo="<?php echo e($txt_motivo); ?>">
                                                <i class="<?php echo e($icon); ?> mr-2"></i> <?php echo e($txt_motivo); ?>

                                            </td>
                                            <?php $__currentLoopData = $tipos_linea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <td>
                                                <input type="text" class="input-importe dinero" placeholder="0.00" 
                                                       data-cod-linea="<?php echo e($linea->COD_LINEA); ?>" 
                                                       data-txt-linea="<?php echo e($linea->TXT_LINEA); ?>"
                                                       data-cod-tipo="<?php echo e($cod_motivo); ?>"
                                                       data-txt-tipo="<?php echo e($txt_motivo); ?>">
                                            </td>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-right d-flex justify-content-end" style="gap: 10px; margin-top: 20px; padding-bottom: 0px; align-items: center;">
                            <input type="hidden" id="ind_tipo_operacion" name="ind_tipo_operacion" value="I">
                            <button type="button" class="btn-limpiar-premium btn-limpiar-ruta" style="display: none;">
                                <i class="fa fa-refresh"></i> LIMPIAR / NUEVA RUTA
                            </button>
                            <button type="button" class="btn-guardar-matriz">
                                <i class="fa fa-save"></i> GUARDAR CONFIGURACIÓN
                            </button>
                        </div>
                    </div> <!-- Fin div matrix-section -->
                        
                </div> <!-- Fin div tab-configurar -->
                        
                        <!-- TAB 2: Registros Creados -->
                        <div role="tabpanel" class="tab-pane fade" id="tab-registros">
                            <div class="matrix-section" style="padding-top: 25px !important; background: #ffffff !important;">
                                
                                <?php if(count($rutas_agrupadas) > 0): ?>
                                    <div class="row">
                                        <div class="col-xs-12">
                                            <div class="search-premium-container pull-right">
                                                <i class="fa fa-search search-icon"></i>
                                                <input type="text" id="buscador-rutas" class="search-premium-input" placeholder="Buscar origen o destino...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                    
                                    <div class="panel-group accordion-premium" id="accordion-rutas" role="tablist" aria-multiselectable="true">
                                        <?php  $i = 0;  ?>
                                        <?php $__currentLoopData = $rutas_agrupadas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $ruta): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <div class="panel panel-default">
                                                <div class="panel-heading" role="tab" id="heading-<?php echo e($i); ?>">
                                                    <h4 class="panel-title">
                                                        <a role="button" data-toggle="collapse" data-parent="#accordion-rutas" href="#collapse-<?php echo e($i); ?>" aria-expanded="false" aria-controls="collapse-<?php echo e($i); ?>" class="collapsed btn-collapse">
                                                            <div class="route-header-premium">
                                                                <div class="route-number-badge">
                                                                    <?php echo e(str_pad($i + 1, 2, '0', STR_PAD_LEFT)); ?>

                                                                </div>
                                                                
                                                                <div class="location-box origin">
                                                                    <span class="location-label">Punto de Origen</span>
                                                                    <div class="location-name">
                                                                        <span><?php echo e($ruta['origen']); ?></span>
                                                                        <i class="mdi mdi-map-marker-outline"></i>
                                                                    </div>
                                                                </div>
                                                                
                                                                <div class="route-divider">
                                                                    <div class="route-line"></div>
                                                                    <i class="mdi mdi-truck-fast transport-icon"></i>
                                                                </div>
                                                                
                                                                <div class="location-box destination">
                                                                    <span class="location-label">Punto de Destino</span>
                                                                    <div class="location-name">
                                                                        <i class="mdi mdi-map-marker"></i>
                                                                        <span><?php echo e($ruta['destino']); ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </a>
                                                        <div class="action-buttons">
                                                            <button type="button" class="btn-action-ruta btn-modificar" data-origen="<?php echo e($ruta['cod_origen']); ?>" data-destino="<?php echo e($ruta['cod_destino']); ?>" title="Modificar Ruta">
                                                                <i class="fa fa-pencil"></i>
                                                            </button>
                                                            <button type="button" class="btn-action-ruta btn-eliminar" data-origen="<?php echo e($ruta['cod_origen']); ?>" data-destino="<?php echo e($ruta['cod_destino']); ?>" title="Eliminar Ruta">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </div>
                                                    </h4>
                                                </div>
                                                <div id="collapse-<?php echo e($i); ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading-<?php echo e($i); ?>">
                                                    <div class="panel-body">
                                                        <div class="table-responsive">
                                                            <table class="table-matrix table-readonly">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Tipos de Importe \ Línea</th>
                                                                        <?php $__currentLoopData = $tipos_linea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                            <th class="text-center"><?php echo e($linea->TXT_LINEA); ?></th>
                                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    <?php $__currentLoopData = $tipo_importe; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cod_motivo => $txt_motivo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                        <?php if($cod_motivo == ''): ?> <?php continue; ?> <?php endif; ?>
                                                                        <?php 
                                                                            $icon = 'mdi mdi-check-circle';
                                                                            $txt_upper = strtoupper($txt_motivo);
                                                                            if (strpos($txt_upper, 'ALIMENTA') !== false) $icon = 'fa fa-cutlery';
                                                                            elseif (strpos($txt_upper, 'ALOJA') !== false) $icon = 'mdi mdi-hotel';
                                                                            elseif (strpos($txt_upper, 'LOCAL') !== false || strpos($txt_upper, 'MOVILIDAD LOCAL') !== false) $icon = 'mdi mdi-car';
                                                                            elseif (strpos($txt_upper, 'DEPARTAMENTAL') !== false) $icon = 'mdi mdi-bus';
                                                                            elseif (strpos($txt_upper, 'PROVINCIAL') !== false) $icon = 'mdi mdi-bus';
                                                                            elseif (strpos($txt_upper, 'COMBUSTIBLE') !== false) $icon = 'mdi mdi-gas-station';
                                                                            elseif (strpos($txt_upper, 'PEAJE') !== false) $icon = 'fa fa-ticket';
                                                                            elseif (strpos($txt_upper, 'MANTENIMIENTO') !== false) $icon = 'mdi mdi-wrench';
                                                                            elseif (strpos($txt_upper, 'AEROPUERTO') !== false) $icon = 'mdi mdi-airplane';
                                                                            elseif (strpos($txt_upper, 'ESTACIONAMIENTO') !== false) $icon = 'mdi mdi-parking';
                                                                         ?>
                                                                        <tr>
                                                                            <td>
                                                                                <i class="<?php echo e($icon); ?> mr-2 text-primary" style="font-size:18px; vertical-align:middle;"></i> <?php echo e($txt_motivo); ?>

                                                                            </td>
                                                                            <?php $__currentLoopData = $tipos_linea; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $linea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                                <?php 
                                                                                    $importe = isset($ruta['matriz'][$txt_motivo][$linea->TXT_LINEA]) ? $ruta['matriz'][$txt_motivo][$linea->TXT_LINEA] : 0;
                                                                                 ?>
                                                                                <td class="text-center td-matriz-readonly <?php echo e($importe > 0 ? 'has-value' : 'is-zero'); ?>" data-cod-tipo="<?php echo e($cod_motivo); ?>" data-cod-linea="<?php echo e($linea->COD_LINEA); ?>" data-importe="<?php echo e($importe); ?>">
                                                                                    <?php echo e($importe > 0 ? 'S/ ' . number_format($importe, 2) : '-'); ?>

                                                                                </td>
                                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                        </tr>
                                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php  $i++;  ?>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                <?php else: ?>
                                    <div class="alert alert-info text-center" style="font-size: 16px; padding: 30px;">
                                        <i class="mdi mdi-information-outline" style="font-size: 32px; display: block; margin-bottom: 10px;"></i>
                                        Aún no hay rutas configuradas. Agregue una ruta desde la pestaña de Configuración de Matriz.
                                    </div>
                                <?php endif; ?>

                            </div>
                        </div> <!-- Fin div tab-registros -->
                    </div> <!-- Fin div tab-content -->

                </div>

            </div>
        </div>
    </div> 
</div> 

<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>



    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.extensions.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.numeric.extensions.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/inputmask.date.extensions.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/inputmask/jquery.inputmask.js')); ?>" type="text/javascript"></script>

    <script src="<?php echo e(asset('public/lib/datatables/js/jquery.dataTables.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/js/dataTables.bootstrap.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/js/dataTables.responsive.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datatables/js/responsive.bootstrap.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-tables-datatables.js?v='.$version)); ?>" type="text/javascript"></script>


    <script src="<?php echo e(asset('public/lib/jquery-ui/jquery-ui.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/jquery.nestable/jquery.nestable.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/moment.js/min/moment.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js')); ?>"
            type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/select2/js/select2.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap-slider/js/bootstrap-slider.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/app-form-elements.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/parsley/parsley.js')); ?>" type="text/javascript"></script>

    <script type="text/javascript">
    $(document).ready(function () {
     
        App.init();
        App.formElements();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();
        
        // Inicializar datatable de registros (ya no se usa, la tabla plana se removió, pero evitamos error en JS si queda caché)
        if($('#table-registros').length) {
            $('#table-registros').DataTable({
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json"
                },
                "pageLength": 10,
                "lengthMenu": [10, 25, 50, 100],
                "dom": '<"row"<"col-sm-6"l><"col-sm-6"f>>rt<"row"<"col-sm-6"i><"col-sm-6"p>>',
                "order": [] // Quitar orden por defecto para respetar el del servidor
            });
        }
        
        // Forzar funcionalidad de pestañas manualmente para evitar conflictos de Bootstrap
        $('.nav-tabs a').on('click', function (e) {
            e.preventDefault();
            
            // Desactivar todos los tabs
            $('.nav-tabs li').removeClass('active');
            $('.nav-tabs a').removeClass('active');
            $('.tab-pane').removeClass('active in show');
            
            // Activar tab clickeado
            $(this).parent('li').addClass('active');
            $(this).addClass('active');
            
            // Mostrar contenido objetivo
            var target = $(this).attr('href');
            $(target).addClass('active in show');
        });
    });
</script>

<!-- Modal Premium para Alertas -->
<div class="modal fade" id="modalAlertPremium" tabindex="-1" role="dialog" aria-labelledby="modalAlertTitle" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" style="margin-top: 15vh;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
            <div class="modal-body text-center" style="padding: 30px 20px;">
                <div id="modalAlertIcon" style="font-size: 60px; margin-bottom: 10px;"></div>
                <h4 id="modalAlertTitle" style="font-weight: 800; color: #1e293b; margin-bottom: 20px; font-size: 22px;">Atención</h4>
                
                <div style="background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 25px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                    <p id="modalAlertMessage" style="color: #475569; font-size: 15px; font-weight: 500; line-height: 1.6; margin: 0; word-wrap: break-word;"></p>
                </div>
                
                <button type="button" class="btn btn-primary" data-dismiss="modal" style="border-radius: 25px; padding: 10px 35px; font-size: 15px; font-weight: 700; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.15); outline: none; letter-spacing: 0.5px; transition: all 0.3s ease;">Entendido</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Premium para Confirmaciones -->
<div class="modal fade" id="modalConfirmPremium" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-sm" role="document" style="margin-top: 15vh;">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 10px 25px rgba(0,0,0,0.15);">
            <div class="modal-body text-center" style="padding: 30px 20px;">
                <div style="animation: shake 0.5s cubic-bezier(0.36, 0.07, 0.19, 0.97) both; margin-bottom: 10px;">
                    <i class="fa fa-trash" style="color: #ef4444; font-size: 75px; text-shadow: 0 8px 15px rgba(239, 68, 68, 0.3);"></i>
                </div>
                <h4 style="font-weight: 800; color: #1e293b; margin-bottom: 20px; font-size: 22px;">¿Estás Seguro?</h4>
                
                <div style="background-color: #fff1f2; border: 1px solid #ffe4e6; border-radius: 10px; padding: 16px; margin-bottom: 25px; box-shadow: inset 0 2px 4px rgba(0,0,0,0.02);">
                    <p id="modalConfirmMessage" style="color: #be123c; font-size: 15px; font-weight: 500; line-height: 1.6; margin: 0; word-wrap: break-word;"></p>
                </div>
                
                <div style="display: flex; gap: 10px; justify-content: center;">
                    <button type="button" class="btn btn-default" data-dismiss="modal" style="border-radius: 25px; padding: 10px 20px; font-size: 14px; font-weight: 600; background: #f1f5f9; color: #475569; border: none; outline: none; transition: all 0.3s ease;">Cancelar</button>
                    <button type="button" id="btnConfirmAction" class="btn btn-danger" style="border-radius: 25px; padding: 10px 20px; font-size: 14px; font-weight: 700; border: none; box-shadow: 0 4px 10px rgba(239, 68, 68, 0.3); outline: none; transition: all 0.3s ease; background: #ef4444;">Sí, Eliminar</button>
                </div>
            </div>
        </div>
    </div>
</div>

    <script src="<?php echo e(asset('public/js/vale/registrorutas.js?v='.$version)); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>