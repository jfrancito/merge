@extends('template_lateral')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} " />
<link rel="stylesheet" type="text/css"
    href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} " />
<link rel="stylesheet" type="text/css"
    href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/analisis/analisis.css?v=' . $version) }} " />
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/exceljs/4.3.0/exceljs.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/FileSaver.js/2.0.5/FileSaver.min.js"></script>
@stop

@section('section')
<div class="be-content contenido cfedocumento">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-border-color panel-border-color-success">
                    <div class="panel-heading">Dashboard Analítico
                        <div class="tools tooltiptop">
                            <button class="btn btn-success" id="btn_actualizar" style="margin-top: -10px;">
                                <i class="zmdi zmdi-refresh"></i> Actualizar
                            </button>
                        </div>
                    </div>

                    <div class="panel-body">
                        <div class='filtrotabla row'>
                            <input type="hidden" name="idopcion" id="idopcion" value="{{ $idopcion }}">
                            <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                            <input type="hidden" name="ajax_url" id="ajax_url"
                                value="{{ url('/actionAjaxDashboards') }}">

                            <!-- Hidden Selects -->
                            <input type="hidden" name="ano" id="ano" value="">
                            <input type="hidden" name="mes" id="mes" value="">
                            <input type="hidden" name="empresa_id" id="empresa_id" value="">
                            <input type="hidden" name="moneda_id" id="moneda_id" value="">
                            <input type="hidden" name="estado_id" id="estado_id" value="">

                            <div class="col-md-3">
                                <div class="filter-card">
                                    <div class="filter-card-header">
                                        <span class="title">Año</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action select-all"
                                                data-target="ano">
                                                <i class="mdi mdi-check-all"></i> TODOS
                                            </button>
                                            <button type="button" class="btn-filter-action deselect-all"
                                                data-target="ano">
                                                <i class="mdi mdi-close-circle-o"></i> NINGUNO
                                            </button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_ano" data-target="ano">
                                        @foreach($anios as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="filter-card">
                                    <div class="filter-card-header">
                                        <span class="title">Moneda</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action select-all"
                                                data-target="moneda_id">
                                                <i class="mdi mdi-check-all"></i> TODOS
                                            </button>
                                            <button type="button" class="btn-filter-action deselect-all"
                                                data-target="moneda_id">
                                                <i class="mdi mdi-close-circle-o"></i> NINGUNO
                                            </button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_moneda_id"
                                        data-target="moneda_id">
                                        @foreach($lista_monedas as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-5">
                                <div class="filter-card">
                                    <div class="filter-card-header">
                                        <span class="title">Empresa</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action select-all"
                                                data-target="empresa_id">
                                                <i class="mdi mdi-check-all"></i> TODOS
                                            </button>
                                            <button type="button" class="btn-filter-action deselect-all"
                                                data-target="empresa_id">
                                                <i class="mdi mdi-close-circle-o"></i> NINGUNO
                                            </button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container overflow-auto" id="container_empresa_id"
                                        data-target="empresa_id">
                                        @foreach($lista_empresas as $val => $label)
                                            <div class="filter-btn active" title="{{$label}}" data-value="{{$val}}">
                                                {{ strlen($label) > 15 ? substr($label, 0, 15) . '..' : $label }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="filter-card">
                                    <div class="filter-card-header">
                                        <span class="title">Mes</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action select-all"
                                                data-target="mes">
                                                <i class="mdi mdi-check-all"></i> TODOS
                                            </button>
                                            <button type="button" class="btn-filter-action deselect-all"
                                                data-target="mes">
                                                <i class="mdi mdi-close-circle-o"></i> NINGUNO
                                            </button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_mes" data-target="mes">
                                        @foreach($meses as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">{{$val}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="filter-card">
                                    <div class="filter-card-header">
                                        <span class="title">Estado</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action select-all"
                                                data-target="estado_id">
                                                <i class="mdi mdi-check-all"></i> TODOS
                                            </button>
                                            <button type="button" class="btn-filter-action deselect-all"
                                                data-target="estado_id">
                                                <i class="mdi mdi-close-circle-o"></i> NINGUNO
                                            </button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_estado_id"
                                        data-target="estado_id">
                                        @foreach($lista_estados as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row m-t-20">
                        <div class="col-sm-12">
                            <div class="tab-container">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a href="#dashboard1" data-toggle="tab">Dashboard
                                            Ejecutivo</a></li>
                                    <li><a href="#dashboard2" data-toggle="tab">Área y Centro</a></li>
                                    <li><a href="#dashboard3" data-toggle="tab">Proveedores</a></li>
                                    <li><a href="#dashboard4" data-toggle="tab">Responsables</a></li>
                                    <li><a href="#dashboard5" data-toggle="tab">Detalle / Auditoría</a></li>
                                </ul>
                                <div class="tab-action-bar">
                                    <button class="btn btn-success btn-download-excel" id="btn_export_excel">
                                        <i class="mdi mdi-file-excel"></i> Descargar Excel del Tab
                                    </button>
                                </div>
                                <div class="tab-content">
                                    <!-- LOADING OVERLAY -->
                                    <div class="dashboard-loader" id="main-loader">
                                        <div class="loader-spinner"></div>
                                        <div class="loader-text">Actualizando reporte...</div>
                                    </div>
                                    <!-- TAB 1: EJECUTIVO -->
                                    <div id="dashboard1" class="tab-pane active cont">
                                        <div class="row kpi-row">
                                            <div class="col-md-3">
                                                <div class="card card-kpi">
                                                    <div class="card-body">
                                                        <span class="title">Total Gasto</span>
                                                        <h3 id="kpi_total_general">S/ 0.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-kpi">
                                                    <div class="card-body">
                                                        <span class="title">Cant. Documentos</span>
                                                        <h3 id="kpi_total_documentos">0</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-kpi">
                                                    <div class="card-body">
                                                        <span class="title">Ticket Promedio</span>
                                                        <h3 id="kpi_ticket_promedio">S/ 0.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="card card-kpi">
                                                    <div class="card-body">
                                                        <span class="title">Total Trabajadores</span>
                                                        <h3 id="kpi_total_trabajadores">0</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row kpi-row m-t-10">
                                            <div class="col-md-6">
                                                <div class="card card-kpi">
                                                    <div class="card-body">
                                                        <span class="title">Gastos del Mes Seleccionado</span>
                                                        <h3 id="kpi_gasto_mes">S/ 0.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card card-kpi">
                                                    <div class="card-body">
                                                        <span class="title">Gasto Máximo Individual</span>
                                                        <h3 id="kpi_max_gasto">S/ 0.00</h3>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row m-t-20">
                                            <div class="col-md-8">
                                                <div class="card">
                                                    <div class="card-header">Evolución de Gastos Mensuales</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_evolucion_mensual" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="card">
                                                    <div class="card-header">Gasto por Moneda</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_por_moneda" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Distribución por Tipo de Documento</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_tipo_documento" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Top 5 Áreas con Mayor Gasto</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_top_areas_exec" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="card">
                                                    <div class="card-header">Top 5 Proveedores Principales</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_top_proveedores_exec" height="250"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 2: AREA Y CENTRO -->
                                    <div id="dashboard2" class="tab-pane cont">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Gasto por Área de Trabajo</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_por_area" height="300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Gasto por Centro de Trabajo</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_por_centro" height="300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 3: PROVEEDORES -->
                                    <div id="dashboard3" class="tab-pane cont">
                                        <div class="row">
                                            <div class="col-md-7">
                                                <div class="card">
                                                    <div class="card-header">Top 10 Proveedores por Gasto</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_top_proveedores" height="300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="card">
                                                    <div class="card-header">Participación por Proveedor</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_participacion_proveedor"
                                                            height="300"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 4: RESPONSABLES -->
                                    <div id="dashboard4" class="tab-pane cont">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Top 10 Trabajadores Solicitantes</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_por_trabajador" height="350"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card">
                                                    <div class="card-header">Top 10 Jefes (Gasto Autorizado)</div>
                                                    <div class="card-body">
                                                        <canvas id="chart_por_jefe" height="350"></canvas>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- TAB 5: DETALLE -->
                                    <div id="dashboard5" class="tab-pane cont">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="table-responsive listajax_detalle">
                                                    <table id="tbl_detalle"
                                                        class="table table-striped table-hover table-fw-widget text-sm">
                                                        <thead>
                                                            <tr>
                                                                <th>ID Liq.</th>
                                                                <th>Serie Reg.</th>
                                                                <th>Nro Reg.</th>
                                                                <th>Estado</th>
                                                                <th>Usuario Reg.</th>
                                                                <th>Fecha Reg.</th>
                                                                <th>ID Emp.</th>
                                                                <th>Empresa</th>
                                                                <th>RUC Emp.</th>
                                                                <th>ID Centro</th>
                                                                <th>Centro</th>
                                                                <th>ID Área</th>
                                                                <th>Área</th>
                                                                <th>ID Trab.</th>
                                                                <th>Trabajador</th>
                                                                <th>ID Jefe</th>
                                                                <th>Jefe Autoriza</th>
                                                                <th>Fecha Emisión</th>
                                                                <th>Año</th>
                                                                <th>Mes</th>
                                                                <th>Nombre Mes</th>
                                                                <th>Semana</th>
                                                                <th>Trimestre</th>
                                                                <th>Tipo Doc.</th>
                                                                <th>Serie Doc.</th>
                                                                <th>Nro Doc.</th>
                                                                <th>Fecha Doc.</th>
                                                                <th>ID Prov.</th>
                                                                <th>Proveedor</th>
                                                                <th>RUC Prov.</th>
                                                                <th>ID Prod.</th>
                                                                <th>Producto</th>
                                                                <th>Moneda</th>
                                                                <th class="text-right">Cant.</th>
                                                                <th class="text-right">P. Unitario</th>
                                                                <th class="text-right">Subtotal</th>
                                                                <th class="text-right">Impuesto</th>
                                                                <th class="text-right">Total</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12">
                        <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@stop
@section('script')


<script src="{{ asset('public/js/general/inputmask/inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/js/general/inputmask/inputmask.extensions.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/js/general/inputmask/inputmask.numeric.extensions.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

<script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('public/js/app-tables-datatables.js?v=' . $version) }}" type="text/javascript"></script>


<script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script type="text/javascript">

    $.fn.niftyModal('setDefaults', {
        overlaySelector: '.modal-overlay',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
    });

    $(document).ready(function () {
        //initialize the javascript
        App.init();
        App.formElements();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();
        $('form').parsley();

    });
</script>
<script src="{{ asset('public/js/analisis/analisisliquidaciongasto.js?v=' . $version) }}"
    type="text/javascript"></script>

@stop