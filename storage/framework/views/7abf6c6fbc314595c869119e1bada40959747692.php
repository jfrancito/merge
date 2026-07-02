<?php $__env->startSection('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/dataTables.bootstrap.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datatables/css/responsive.dataTables.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/select2/css/select2.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/bootstrap-slider/css/bootstrap-slider.css')); ?> "/>
    <style>
        .btn-filtrar-premium {
            background: linear-gradient(135deg, #1d3a6d 0%, #2a5298 100%) !important;
            color: #ffffff !important;
            border: none !important;
            padding: 9px 20px !important;
            font-size: 13px !important;
            font-weight: 700 !important;
            letter-spacing: 0.5px !important;
            border-radius: 0 6px 6px 0 !important;
            cursor: pointer !important;
            box-shadow: 0 4px 15px rgba(42, 82, 152, 0.2) !important;
            transition: all 0.3s ease !important;
            height: 38px !important;
            display: inline-flex !important;
            align-items: center !important;
            gap: 6px !important;
            vertical-align: middle !important;
        }

        .btn-filtrar-premium i {
            font-size: 14px !important;
            transition: transform 0.3s ease !important;
        }

        .btn-filtrar-premium:hover {
            box-shadow: 0 6px 20px rgba(42, 82, 152, 0.3) !important;
            filter: brightness(1.1) !important;
        }

        .btn-filtrar-premium:hover i {
            transform: rotate(15deg) scale(1.15) !important;
        }

        .btn-filtrar-premium:active {
            box-shadow: 0 4px 10px rgba(42, 82, 152, 0.1) !important;
        }

        /* Ajuste de select2 del input-group */
        .input-group .select2-container--default .select2-selection--single {
            border-top-right-radius: 0 !important;
            border-bottom-right-radius: 0 !important;
        }

        /* Contenedor Ajax Vacio Premium Minimalista */
        .ajaxvacio-premium {
            padding: 14px 22px !important;
            background: #ffffff !important;
            border: 1px dashed #cbd5e0 !important;
            border-radius: 8px !important;
            text-align: center !important;
            max-width: 440px !important;
            margin: 25px auto !important;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01) !important;
            transition: all 0.3s ease !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 12px !important;
        }

        .ajaxvacio-premium:hover {
            border-color: #2a5298 !important;
            background: #f7fafc !important;
        }

        .ajaxvacio-premium .icon-vacio {
            font-size: 22px !important;
            background: linear-gradient(135deg, #1d3a6d 0%, #2a5298 100%) !important;
            -webkit-background-clip: text !important;
            -webkit-text-fill-color: transparent !important;
            margin-bottom: 0 !important;
            display: inline-flex !important;
            animation: bounce-slow 3s infinite ease-in-out !important;
            flex-shrink: 0 !important;
        }

        .ajaxvacio-premium h4 {
            display: none !important;
        }

        .ajaxvacio-premium p {
            font-size: 12.5px !important;
            color: #4a5568 !important;
            line-height: 1.4 !important;
            margin: 0 !important;
            font-weight: 600 !important;
            text-align: left !important;
        }

        @keyframes  bounce-slow {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-4px); }
        }
        /* Modal Premium Alertas */
        .modal-premium-content {
            border: none !important;
            border-radius: 16px !important;
            box-shadow: 0 10px 30px rgba(0,0,0,0.15) !important;
            overflow: hidden !important;
        }
        .modal-premium-content .modal-body {
            padding: 30px 20px !important;
            background: #ffffff !important;
        }
        .icon-box-premium {
            width: 70px;
            height: 70px;
            margin: 0 auto 15px auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .icon-box-premium.success {
            background: linear-gradient(135deg, #d4fc79 0%, #96e6a1 100%);
            color: #2b7a0b;
        }
        .icon-box-premium.error {
            background: linear-gradient(135deg, #f85032 0%, #e73827 100%);
            color: #ffffff;
        }
        .modal-title-premium {
            font-weight: 700;
            font-size: 20px;
            color: #2d3748;
            margin-bottom: 8px;
        }
        .modal-message-premium {
            font-size: 14px;
            color: #4a5568;
            margin-bottom: 20px;
        }
        .btn-premium-close {
            background: linear-gradient(135deg, #1d3a6d 0%, #2a5298 100%) !important;
            color: #ffffff !important;
            border: none;
            border-radius: 8px;
            padding: 10px 30px;
            font-weight: 600;
            letter-spacing: 0.5px;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(42, 82, 152, 0.2);
        }
        .btn-premium-close:hover {
            box-shadow: 0 6px 20px rgba(42, 82, 152, 0.3);
            filter: brightness(1.1);
            color: #ffffff !important;
        }

        /* Centrado Vertical para Modales */
        .modal-vertical-center {
            text-align: center;
            padding: 0 !important;
        }
        .modal-vertical-center:before {
            content: '';
            display: inline-block;
            height: 100%;
            vertical-align: middle;
            margin-right: -4px; /* Adjusts for spacing */
        }
        .modal-vertical-center .modal-dialog {
            display: inline-block;
            text-align: left;
            vertical-align: middle;
            vertical-align: middle;
            margin: 0 auto;
        }

        /* Título Premium */
        .premium-heading {
            font-family: 'Montserrat', 'Poppins', 'Segoe UI', sans-serif !important;
            font-size: 15px !important;
            font-weight: bold !important;
            color: #334155 !important;
            padding-bottom: 16px !important;
            margin-bottom: 24px !important;
            border-bottom: 2px solid #edf2f7 !important;
            text-transform: uppercase !important;
            letter-spacing: 0.8px !important;
            display: flex !important;
            align-items: center !important;
            gap: 10px !important;
        }
        .premium-heading i {
            color: #2a5298 !important;
            font-size: 17px !important;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('section'); ?>

<div class="be-content autorizaprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading premium-heading">
                        <i class="mdi mdi-account-multiple"></i> Registro Personal Autoriza
                    </div>   

                    <div class="panel-body selectfiltro">
                        <div class='filtrotabla row'>
                            <div class="col-xs-12">

                                   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">

                                             <label class="col-sm-12 control-label labelleft negrita"> SEDE <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12 abajocaja">
                                                <?php echo Form::select('sede_select', $listasede, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'sede_select',
                                                     'data-aw'     => '1',
                                                   ]); ?>

                                            </div>
                                        </div>
                                    </div>


                                       <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"> GERENCIA <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12 abajocaja">
                                                <?php echo Form::select('gerencia_select', $listagerencia, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'gerencia_select',
                                                     'data-aw'     => '1',
                                                   ]); ?>

                                            </div>
                                        </div>
                                    </div>


                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                             <label class="col-sm-12 control-label labelleft negrita"> ÁREA <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12">
                                                 <div class="input-group">
                                                <?php echo Form::select('area_select', $listaarea, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'area_select',
                                                     'data-aw'     => '1',
                                                   ]); ?>

                                                        <span class="input-group-btn">
                                                                 <input type="hidden" id="personal_autoriza_id" value="" />
                                                                 
                                                                 <button id="filtrarpersonal" type="button" class="btn-filtrar-premium">
                                                                     <i class="fa fa-filter"></i> FILTRAR
                                                                 </button>
                                                        </span>
                                                     </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                              <div class="listadetalleajax"></div>
                                       <div class='ajaxvacio ajaxvacio-premium'>
                                            <div class="icon-vacio">
                                                <i class="fa fa-info-circle"></i>
                                            </div>
                                            <p>Por favor, selecciona los filtros en la parte superior y haz clic en FILTRAR para gestionar al personal.</p>
                                       </div>
                                <div class="col-xs-12">
                                    <div class='listacontratomasiva listajax reporteajax'>    
                                    </div>
                                </div>
                                <?php echo $__env->make('valerendir.ajax.listamodalpersonalautoriza', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                        </div>
                    </div>
                </div>
             </div>
        </div> 
    </div>
</div> 


<!-- Modal Premium para Alertas -->
<div class="modal fade modal-vertical-center" id="modalPremiumAlerta" tabindex="-1" role="dialog" aria-labelledby="modalPremiumAlertaLabel" aria-hidden="true" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content modal-premium-content text-center">
            <div class="modal-body p-4">
                <div class="icon-box-premium mb-3" id="iconoPremiumAlerta">
                    <!-- Icono dinámico -->
                </div>
                <h4 class="modal-title-premium mb-2" id="tituloPremiumAlerta"></h4>
                <p class="modal-message-premium mb-4" id="mensajePremiumAlerta"></p>
                <button type="button" class="btn btn-premium-close" data-dismiss="modal">Aceptar</button>
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

        $('.dinero').inputmask({
            'alias': 'numeric',
            'groupSeparator': ',',
            'autoGroup': true,
            'digits': 2,
            'digitsOptional': false,
            'prefix': '',
            'placeholder': '0'
        });

        $('.dinero_masivo').inputmask({
            alias: 'numeric',
            groupSeparator: '',
            autoGroup: true,
            digits: 2,
            digitsOptional: false,
            prefix: '',
            placeholder: '0',
            allowMinus: false  
        });

    });
</script>
<script src="<?php echo e(asset('public/js/vale/registropersonalautoriza.js?v='.$version)); ?>" type="text/javascript"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('template_lateral', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>