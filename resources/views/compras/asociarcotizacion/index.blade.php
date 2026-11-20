@extends('template_lateral')

@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }}"/>
    <style>
        .card-custom {
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 10px 25px -5px rgba(15, 23, 42, 0.08), 0 8px 10px -6px rgba(15, 23, 42, 0.04);
            border: 1px solid #e2e8f0;
            overflow: hidden;
            margin-bottom: 25px;
        }
        .card-header-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 60%, #2563eb 100%);
            padding: 22px 28px;
            color: #ffffff;
            position: relative;
        }
        .card-header-gradient h2 {
            margin: 0;
            font-size: 19px;
            font-weight: 700;
            letter-spacing: -0.3px;
            color: #ffffff;
        }
        .card-header-gradient p {
            margin: 4px 0 0;
            font-size: 13px;
            color: #93c5fd;
        }
        .filter-container {
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            padding: 24px 28px 16px;
        }
        .label-filter {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #475569;
            margin-bottom: 7px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .form-control-modern {
            border-radius: 10px !important;
            border: 1px solid #cbd5e1;
            height: 40px;
            font-size: 13px;
            box-shadow: 0 1px 2px rgba(0,0,0,0.03);
            transition: all 0.2s ease;
        }
        .form-control-modern:focus {
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37,99,235,0.15);
            outline: none;
        }
        .btn-modern-search,
        button#btnBuscarCotizaciones.btn,
        button#btnBuscarCotizaciones {
            background-color: #2563eb !important;
            background-image: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%) !important;
            color: #ffffff !important;
            border: 1px solid #1d4ed8 !important;
            border-radius: 10px !important;
            height: 42px !important;
            padding: 0 24px !important;
            font-weight: 700 !important;
            font-size: 13px !important;
            letter-spacing: 0.5px !important;
            box-shadow: 0 4px 12px rgba(37,99,235,0.35) !important;
            transition: all 0.25s ease !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 8px !important;
            width: 100% !important;
            cursor: pointer !important;
            text-shadow: none !important;
        }
        .btn-modern-search:hover,
        button#btnBuscarCotizaciones:hover,
        .btn-modern-search:focus,
        button#btnBuscarCotizaciones:focus {
            background-color: #1d4ed8 !important;
            background-image: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%) !important;
            color: #ffffff !important;
            border-color: #1e40af !important;
            box-shadow: 0 6px 18px rgba(37,99,235,0.45) !important;
            transform: translateY(-1px);
        }
        .btn-modern-search:active,
        button#btnBuscarCotizaciones:active {
            transform: translateY(0) !important;
            box-shadow: inset 0 2px 4px rgba(0,0,0,0.2) !important;
        }
        .btn-modern-search i,
        button#btnBuscarCotizaciones i {
            color: #ffffff !important;
            margin-right: 6px;
        }
        .select2-container .select2-choice {
            border-radius: 10px !important;
            height: 40px !important;
            line-height: 38px !important;
            border: 1px solid #cbd5e1 !important;
            background: #ffffff !important;
        }
        .select2-container .select2-choice .select2-arrow {
            border-radius: 0 10px 10px 0 !important;
        }
        .content-body-results {
            padding: 24px 28px;
            min-height: 250px;
        }
    </style>
@stop

@section('section')
<div class="be-content">
    <div class="main-content container-fluid" style="padding-top: 15px;">
        <input type="hidden" id="token" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="carpeta" value="{{ $capeta }}" id="carpeta">
        <input type="hidden" name="idopcion" value="{{ $idopcion }}" id="idopcion">

        <div class="row">
            <div class="col-sm-12">
                
                <div class="card-custom">
                    <!-- HEADER -->
                    <div class="card-header-gradient">
                        <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 15px;">
                            <div>
                                <h2><i class="fa fa-link mr-2"></i> Asociar Cotización y Orden de Compra</h2>
                                <p>Consulta de cotizaciones aprobadas sin orden de compra emitida</p>
                            </div>
                            <div>
                                <span class="badge" style="background: rgba(255,255,255,0.18); color: #ffffff; padding: 7px 14px; border-radius: 20px; font-size: 12px; font-weight: 600; border: 1px solid rgba(255,255,255,0.25);">
                                    <i class="fa fa-building-o mr-1"></i> {{ $nom_empr }}
                                </span>
                            </div>
                        </div>
                    </div>

                    <!-- FILTROS -->
                    <div class="filter-container">
                        <div class="row">
                            <!-- Fecha Inicio -->
                            <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 15px;">
                                <label class="label-filter">
                                    <i class="fa fa-calendar text-primary"></i> Fecha Inicio:
                                </label>
                                <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker pickerfecha">
                                    <input size="16" type="text" 
                                           value="{{ $fecha_inicio }}" 
                                           placeholder="Fecha Inicio"
                                           id="fecha_inicio" 
                                           name="fecha_inicio" 
                                           required
                                           class="form-control form-control-modern"/>
                                    <span class="input-group-addon btn btn-primary" style="border-radius: 0 10px 10px 0; background: #2563eb; border-color: #2563eb;">
                                        <i class="icon-th mdi mdi-calendar"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Fecha Fin -->
                            <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 15px;">
                                <label class="label-filter">
                                    <i class="fa fa-calendar text-primary"></i> Fecha Fin:
                                </label>
                                <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker pickerfecha">
                                    <input size="16" type="text" 
                                           value="{{ $fecha_fin }}" 
                                           placeholder="Fecha Fin"
                                           id="fecha_fin" 
                                           name="fecha_fin" 
                                           required
                                           class="form-control form-control-modern"/>
                                    <span class="input-group-addon btn btn-primary" style="border-radius: 0 10px 10px 0; background: #2563eb; border-color: #2563eb;">
                                        <i class="icon-th mdi mdi-calendar"></i>
                                    </span>
                                </div>
                            </div>

                            <!-- Empresa (Logueada) -->
                            <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 15px;">
                                <label class="label-filter">
                                    <i class="fa fa-briefcase text-primary"></i> Empresa:
                                </label>
                                {!! Form::select('empresa_id', $combo_empresa, $cod_empr, [
                                    'class' => 'form-control form-control-modern',
                                    'id' => 'empresa_id',
                                    'disabled' => 'disabled',
                                    'style' => 'background-color: #f1f5f9; cursor: not-allowed; font-weight: 600;'
                                ]) !!}
                            </div>

                            <!-- Centro -->
                            <div class="col-xs-12 col-sm-6 col-md-3" style="margin-bottom: 15px;">
                                <label class="label-filter">
                                    <i class="fa fa-map-marker text-primary"></i> Centro / Sede:
                                </label>
                                {!! Form::select('cod_centro', $combo_centro, '', [
                                    'class' => 'form-control select2 form-control-modern',
                                    'id' => 'cod_centro'
                                ]) !!}
                            </div>
                        </div>

                        <!-- Botón Buscar -->
                        <div class="row" style="margin-top: 5px;">
                            <div class="col-xs-12 col-sm-4 col-sm-offset-8 col-md-3 col-md-offset-9">
                                <button type="button" id="btnBuscarCotizaciones" onclick="buscarCotizacionesSinOC();" class="btn btn-modern-search">
                                    <i class="fa fa-search"></i> BUSCAR COTIZACIONES
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- RESULTADOS -->
                    <div class="content-body-results">
                        <div id="contenedor-resultado-cotizaciones">
                            <div class="text-center" style="padding: 50px 20px; color: #94a3b8;">
                                <i class="fa fa-search fa-3x" style="color: #cbd5e1; margin-bottom: 15px;"></i>
                                <h4 style="color: #64748b; font-weight: 600;">Haga clic en <b>Buscar Cotizaciones</b> para listar los registros</h4>
                                <p style="font-size: 13px; color: #94a3b8;">Los resultados filtrarán las cotizaciones aprobadas sin orden de compra asociada.</p>
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</div>

<!-- MODAL ASOCIAR OC -->
<div class="modal fade" id="modalAsociarOC" tabindex="-1" role="dialog" aria-labelledby="modalAsociarOCLabel" aria-hidden="true" data-backdrop="static">
    <div class="modal-dialog modal-lg" role="document" style="width: 85%; max-width: 1050px; margin: 30px auto;">
        <div class="modal-content" id="modal-asociar-oc-contenido" style="border-radius: 12px; box-shadow: 0 15px 35px rgba(15,23,42,0.25); border: none; overflow: hidden;">
            <!-- Contenido cargado dinámicamente vía AJAX -->
        </div>
    </div>
</div>
@stop

@section('script')
    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            try { if (typeof App !== 'undefined' && typeof App.init === 'function') App.init(); } catch (e) { console.warn(e); }
            try { if (typeof App !== 'undefined' && typeof App.formElements === 'function') App.formElements(); } catch (e) { console.warn(e); }
            try { if (typeof App !== 'undefined' && typeof App.dataTables === 'function') App.dataTables(); } catch (e) { console.warn(e); }
            try { if (typeof $.fn.tooltip === 'function') $('[data-toggle="tooltip"]').tooltip(); } catch (e) { console.warn(e); }
        });
    </script>

    <script src="{{ asset('public/js/compras/asociarcotizacion.js?v='.$version) }}" type="text/javascript"></script>
@stop
