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
<style>
    .nav-tabs-primary {
        margin-bottom: 0px !important;
        background: #f5f8fb;
        border-radius: 12px 12px 0 0;
        padding: 5px 10px 0 10px;
    }

    .nav-tabs-primary>li>a {
        font-weight: 800;
        text-transform: uppercase;
        letter-spacing: 1px;
        font-size: 13px;
    }

    .main-tab-content {
        background: #fff;
        padding: 20px;
        border: 1px solid #eee;
        border-top: none;
        border-radius: 0 0 12px 12px;
    }

    .filter-section-title {
        font-size: 14px;
        font-weight: 800;
        color: #2c3e50;
        margin-bottom: 20px;
        padding-left: 10px;
        border-left: 5px solid #3498db;
        background: #f8f9fa;
        padding-top: 5px;
        padding-bottom: 5px;
    }

    .filter-grid-comparative {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
    }

    .scrollable-filter-content,
    .filter-buttons-container {
        max-height: 120px;
        overflow-y: auto;
        padding-right: 5px;
    }

    .filters-single-row {
        display: flex;
        flex-wrap: nowrap;
        overflow-x: auto;
        gap: 15px;
        padding-bottom: 10px;
        align-items: flex-start;
    }

    .filters-single-row>div {
        flex: 0 0 250px;
        /* Fixed width for each filter card in the row */
    }

    /* Custom Scrollbar */
    .scrollable-filter-content::-webkit-scrollbar {
        width: 5px;
    }

    .scrollable-filter-content::-webkit-scrollbar-track {
        background: #f1f1f1;
    }

    .scrollable-filter-content::-webkit-scrollbar-thumb {
        background: #cbd5e0;
        border-radius: 10px;
    }

    .filter-btn,
    .filter-btn-control {
        margin: 2px;
        padding: 5px 12px;
        font-size: 11px;
        border-radius: 6px;
        background: #fff;
        border: 1px solid #e2e8f0;
        color: #64748b;
        transition: all 0.2s;
        cursor: pointer;
        display: inline-block;
    }

    .filter-btn.active,
    .filter-btn-control.active {
        background: #3498db !important;
        color: white !important;
        border-color: #2980b9;
        box-shadow: 0 2px 4px rgba(52, 152, 219, 0.3);
    }

    .filter-btn-mode {
        background: #f1f5f9;
        font-weight: 700;
        border-color: #cbd5e0;
    }

    .kpi-row .card-kpi {
        border-radius: 10px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        transition: transform 0.2s;
    }

    .kpi-row .card-kpi:hover {
        transform: translateY(-5px);
    }
</style>
@stop

@section('section')
<div class="be-content contenido cfedocumento">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <!-- MAIN NAVIGATION (PHASE 1 VS PHASE 2) -->
                <ul class="nav nav-tabs nav-tabs-primary" id="main_dashboard_tabs">
                    <li class="active"><a href="#fase1_operativo" data-toggle="tab">Gestión y Análisis Operativo</a>
                    </li>
                    <li><a href="#fase2_comparativo" data-toggle="tab">KPIs y Análisis Comparativo</a></li>
                </ul>

                <div class="tab-content main-tab-content">
                    <input type="hidden" name="idopcion" id="idopcion" value="{{ $idopcion }}">
                    <input type="hidden" name="token" id="token" value="{{ csrf_token() }}">
                    <input type="hidden" name="ajax_url" id="ajax_url" value="{{ url('/actionAjaxDashboards') }}">

                    <!-- ================================================================
                         PHASE 1: OPERATIVO 
                         ================================================================ -->
                    <div id="fase1_operativo" class="tab-pane active">
                        <div class="filter-section-title">Filtros de Análisis Operativo</div>
                        <div class='filters-single-row'>
                            <!-- Hidden Selects F1 -->
                            <input type="hidden" name="f1_ano" id="f1_ano" value="">
                            <input type="hidden" name="f1_mes" id="f1_mes" value="">
                            <input type="hidden" name="f1_empresa_id" id="f1_empresa_id" value="">
                            <input type="hidden" name="f1_moneda_id" id="f1_moneda_id" value="">
                            <input type="hidden" name="f1_estado_id" id="f1_estado_id" value="">

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Año</span></div>
                                    <div class="filter-buttons-container" id="container_f1_ano" data-target="f1_ano"
                                        data-select="single">
                                        @foreach($anios as $val => $label)
                                            <div class="filter-btn {{ $loop->first ? 'active' : '' }}"
                                                data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Mes</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action f-select-all"
                                                data-target="f1_mes">TODOS</button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f1_mes" data-target="f1_mes">
                                        @foreach($meses as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">{{$val}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Empresa</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action f-select-all"
                                                data-target="f1_empresa_id">TODOS</button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f1_empresa_id"
                                        data-target="f1_empresa_id">
                                        @foreach($lista_empresas as $val => $label)
                                            <div class="filter-btn active" title="{{$label}}" data-value="{{$val}}">
                                                {{ strlen($label) > 15 ? substr($label, 0, 15) . '..' : $label }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Moneda</span></div>
                                    <div class="filter-buttons-container" id="container_f1_moneda_id"
                                        data-target="f1_moneda_id" data-select="single">
                                        @foreach($lista_monedas as $val => $label)
                                            <div class="filter-btn {{ strpos(strtoupper($label), 'SOL') !== false ? 'active' : '' }}"
                                                data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Estado</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action f-select-all"
                                                data-target="f1_estado_id">TODOS</button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f1_estado_id"
                                        data-target="f1_estado_id">
                                        @foreach($lista_estados as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Sub-tabs Operational -->
                        <div class="tab-container m-t-20">
                            <ul class="nav nav-tabs">
                                <li class="active"><a href="#dashboard1" data-toggle="tab">Ejecutivo</a></li>
                                <li><a href="#dashboard2" data-toggle="tab">Área y Centro</a></li>
                                <li><a href="#dashboard3" data-toggle="tab">Proveedores</a></li>
                                <li><a href="#dashboard4" data-toggle="tab">Responsables</a></li>
                                <li><a href="#dashboard6" data-toggle="tab">Productos</a></li>
                                <li><a href="#dashboard5" data-toggle="tab">Detalle / Auditoría</a></li>
                            </ul>
                            <div class="tab-action-bar">
                                <button class="btn btn-success btn-download-excel" id="btn_export_excel_f1">
                                    <i class="mdi mdi-file-excel"></i> Exportar Análisis Operativo
                                </button>
                            </div>
                            <div class="tab-content" style="border:none; padding:15px 0;">
                                <div class="dashboard-loader" id="loader_f1">
                                    <div class="loader-spinner"></div>
                                    <div class="loader-text">Procesando Análisis...</div>
                                </div>
                                <div id="dashboard1" class="tab-pane active cont">
                                    <!-- (EJECUTIVO CONTENT) -->
                                    <div class="row kpi-row">
                                        <div class="col-md-3">
                                            <div class="card card-kpi">
                                                <div class="card-body"><span class="title">Total Gasto</span>
                                                    <h3 id="kpi_total_general">S/ 0.00</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card card-kpi">
                                                <div class="card-body"><span class="title">Documentos</span>
                                                    <h3 id="kpi_total_documentos">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card card-kpi">
                                                <div class="card-body"><span class="title">Ticket Promedio</span>
                                                    <h3 id="kpi_ticket_promedio">S/ 0.00</h3>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="card card-kpi">
                                                <div class="card-body"><span class="title">Trabajadores</span>
                                                    <h3 id="kpi_total_trabajadores">0</h3>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row m-t-20">
                                        <div class="col-md-8">
                                            <div class="card">
                                                <div class="card-header">Evolución</div>
                                                <div class="card-body"><canvas id="chart_evolucion_mensual"
                                                        height="250"></canvas></div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="card">
                                                <div class="card-header">Moneda</div>
                                                <div class="card-body"><canvas id="chart_por_moneda"
                                                        height="250"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Tipo Doc.</div>
                                                <div class="card-body"><canvas id="chart_tipo_documento"
                                                        height="250"></canvas></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Áreas</div>
                                                <div class="card-body"><canvas id="chart_top_areas_exec"
                                                        height="250"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="dashboard2" class="tab-pane cont">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Gasto por Área</div>
                                                <div class="card-body"><canvas id="chart_por_area"
                                                        height="300"></canvas></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Gasto por Centro</div>
                                                <div class="card-body"><canvas id="chart_por_centro"
                                                        height="300"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="dashboard3" class="tab-pane cont">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-header">Top 10 Proveedores</div>
                                                <div class="card-body"><canvas id="chart_top_proveedores"
                                                        height="300"></canvas></div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card">
                                                <div class="card-header">Participación</div>
                                                <div class="card-body"><canvas id="chart_participacion_proveedor"
                                                        height="300"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="dashboard4" class="tab-pane cont">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Ranking Solicitantes</div>
                                                <div class="card-body"><canvas id="chart_por_trabajador"
                                                        height="350"></canvas></div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="card">
                                                <div class="card-header">Jefes Autorizadores</div>
                                                <div class="card-body"><canvas id="chart_por_jefe"
                                                        height="350"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="dashboard6" class="tab-pane cont">
                                    <div class="row">
                                        <div class="col-md-7">
                                            <div class="card">
                                                <div class="card-header">Top 10 Productos</div>
                                                <div class="card-body"><canvas id="chart_top_productos"
                                                        height="300"></canvas></div>
                                            </div>
                                        </div>
                                        <div class="col-md-5">
                                            <div class="card">
                                                <div class="card-header">Participación</div>
                                                <div class="card-body"><canvas id="chart_participacion_producto"
                                                        height="300"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="dashboard5" class="tab-pane cont">
                                    <div class="table-responsive listajax_detalle">
                                        <table id="tbl_detalle"
                                            class="table table-striped table-hover table-fw-widget text-sm">
                                            <thead>
                                                <tr>
                                                    <th>ID Liq.</th>
                                                    <th>Serie Reg.</th>
                                                    <th>Nro Reg.</th>
                                                    <th>Estado</th>
                                                    <th>Usuario</th>
                                                    <th>Fecha Reg.</th>
                                                    <th>Empresa</th>
                                                    <th>Centro</th>
                                                    <th>Área</th>
                                                    <th>Trabajador</th>
                                                    <th>Jefe</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Año</th>
                                                    <th>Mes</th>
                                                    <th>Tipo Doc.</th>
                                                    <th>Documento</th>
                                                    <th>Proveedor</th>
                                                    <th>Producto</th>
                                                    <th>Moneda</th>
                                                    <th class="text-right">Total</th>
                                                </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ================================================================
                         PHASE 2: COMPARATIVO 
                         ================================================================ -->
                    <div id="fase2_comparativo" class="tab-pane">
                        <!-- Hidden Selects F2 -->
                        <input type="hidden" name="f2_ano" id="f2_ano" value="">
                        <input type="hidden" name="f2_mes" id="f2_mes" value="">
                        <input type="hidden" name="f2_empresa_id" id="f2_empresa_id" value="">
                        <input type="hidden" name="f2_moneda_id" id="f2_moneda_id" value="">
                        <input type="hidden" name="f2_centro_id" id="f2_centro_id" value="">
                        <input type="hidden" name="f2_area_id" id="f2_area_id" value="">
                        <input type="hidden" name="f2_tipo_vista" id="f2_tipo_vista" value="mensual">
                        <input type="hidden" name="comparar_vs" id="comparar_vs" value="anterior">

                        <div class="filter-section-title">Análisis Comparativo Gerencial</div>

                        <div class='filters-single-row'>
                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Modo de Análisis</span></div>
                                    <div class="filter-buttons-container" id="container_f2_tipo_vista"
                                        data-target="f2_tipo_vista" data-select="single">
                                        <div class="filter-btn-control active filter-btn-mode" data-value="mensual">
                                            MENSUAL</div>
                                        <div class="filter-btn-control filter-btn-mode" data-value="trimestral">
                                            TRIMESTRAL</div>
                                        <div class="filter-btn-control filter-btn-mode" data-value="anual">ANUAL</div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Año</span></div>
                                    <div class="filter-buttons-container" id="container_f2_ano" data-target="f2_ano"
                                        data-select="single">
                                        @foreach($anios as $val => $label)
                                            <div class="filter-btn {{ $loop->first ? 'active' : '' }}"
                                                data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div id="col_f2_periodo">
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title" id="lbl_f2_periodo">Mes</span>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f2_mes" data-target="f2_mes"
                                        data-select="single">
                                        <!-- Monthly Buttons -->
                                        <div class="view-mes-btns">
                                            @foreach($meses as $val => $label)
                                                <div class="filter-btn {{ (int) $val == (int) date('n') ? 'active' : '' }}"
                                                    data-value="{{$val}}">{{$val}}</div>
                                            @endforeach
                                        </div>
                                        <!-- Quarterly Buttons (Hidden by default) -->
                                        <div class="view-trim-btns" style="display:none;">
                                            <div class="filter-btn" data-value="1,2,3">T1 (Ene-Mar)</div>
                                            <div class="filter-btn" data-value="4,5,6">T2 (Abr-Jun)</div>
                                            <div class="filter-btn" data-value="7,8,9">T3 (Jul-Sep)</div>
                                            <div class="filter-btn" data-value="10,11,12">T4 (Oct-Dic)</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Comparar contra...</span></div>
                                    <div class="filter-buttons-container" id="container_comparar_vs"
                                        data-target="comparar_vs" data-select="single">
                                        <div class="filter-btn active" data-value="anterior">PERIODO ANTERIOR</div>
                                        <div class="filter-btn" data-value="anio_pasado">MISMO MES (AÑO PASADO)</div>
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Empresas</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action f-select-all"
                                                data-target="f2_empresa_id">TODOS</button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f2_empresa_id"
                                        data-target="f2_empresa_id" data-select="multi">
                                        @foreach($lista_empresas as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">
                                                {{ strlen($label) > 15 ? substr($label, 0, 15) : $label }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Moneda</span></div>
                                    <div class="filter-buttons-container" id="container_f2_moneda_id"
                                        data-target="f2_moneda_id" data-select="single">
                                        @foreach($lista_monedas as $val => $label)
                                            <div class="filter-btn {{ strpos(strtoupper($label), 'SOL') !== false ? 'active' : '' }}"
                                                data-value="{{$val}}">{{$label}}</div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Centros</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action f-select-all"
                                                data-target="f2_centro_id">TODOS</button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f2_centro_id"
                                        data-target="f2_centro_id" data-select="multi">
                                        @foreach($lista_centros as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">
                                                {{ strlen($label) > 15 ? substr($label, 0, 15) : $label }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div>
                                <div class="filter-card">
                                    <div class="filter-card-header"><span class="title">Áreas</span>
                                        <div class="filter-actions">
                                            <button type="button" class="btn-filter-action f-select-all"
                                                data-target="f2_area_id">TODOS</button>
                                        </div>
                                    </div>
                                    <div class="filter-buttons-container" id="container_f2_area_id"
                                        data-target="f2_area_id" data-select="multi">
                                        @foreach($lista_areas as $val => $label)
                                            <div class="filter-btn active" data-value="{{$val}}">
                                                {{ strlen($label) > 15 ? substr($label, 0, 15) : $label }}
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="m-t-20">
                            <div class="tab-action-bar">
                                <button class="btn btn-primary btn-download-excel" id="btn_export_excel_f2">
                                    <i class="mdi mdi-file-excel"></i> Exportar KPIs Gerenciales
                                </button>
                            </div>
                            <div id="dashboard7_container" style="position:relative;">
                                <div class="dashboard-loader" id="loader_f2">
                                    <div class="loader-spinner"></div>
                                    <div class="loader-text">Calculando KPIs Comparativos...</div>
                                </div>
                                <!-- Content from Dashboard 7 -->
                                <div class="row kpi-row">
                                    <div class="col-md-3">
                                        <div class="card card-kpi" style="border-left-color: #3498db;">
                                            <div class="card-body"><span class="title" id="lbl_periodo_actual">Periodo
                                                    Actual</span>
                                                <h3 id="comp_gasto_actual">S/ 0.00</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-kpi" style="border-left-color: #95a5a6;">
                                            <div class="card-body"><span class="title" id="lbl_periodo_prev">Periodo
                                                    Anterior</span>
                                                <h3 id="comp_gasto_prev">S/ 0.00</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-kpi" id="card_variacion_abs">
                                            <div class="card-body"><span class="title">Var. Absoluta</span>
                                                <h3 id="comp_variacion_abs">S/ 0.00</h3>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card card-kpi" id="card_variacion_pct">
                                            <div class="card-body"><span class="title">Variación %</span>
                                                <h3 id="comp_variacion_pct">0.00%</h3>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row m-t-20">
                                    <div class="col-md-12">
                                        <div class="card">
                                            <div class="card-header">¿Por qué varió el gasto? - Top 5 Incrementos vs Top
                                                5 Ahorros por Producto</div>
                                            <div class="card-body">
                                                <div class="variation-legend"
                                                    style="display: flex; gap: 20px; margin-bottom: 5px; font-size: 12px; justify-content: center; flex-wrap: wrap;">
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <div
                                                            style="width: 12px; height: 12px; background: rgba(217, 83, 79, 0.7); border: 1px solid #d9534f;">
                                                        </div>
                                                        <span><strong>ALZA:</strong> Gastamos MÁS que el periodo
                                                            anterior</span>
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <div
                                                            style="width: 12px; height: 12px; background: rgba(92, 184, 92, 0.7); border: 1px solid #5cb85c;">
                                                        </div>
                                                        <span><strong>AHORRO:</strong> Gastamos MENOS (Performance
                                                            positiva)</span>
                                                    </div>
                                                </div>
                                                <p class="text-center"
                                                    style="font-weight: bold; color: #555; margin-bottom: 15px; font-size: 13px;">
                                                    Comparando: <span id="lbl_chart_impact_dates"
                                                        style="color: #3498db;">...</span>
                                                </p>
                                                <div style="height: 320px;">
                                                    <canvas id="chart_comp_producto"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">Gasto por Área: ¿Cómo varió el consumo por
                                                departamento?</div>
                                            <div class="card-body">
                                                <div class="comp-chart-legend"
                                                    style="display: flex; gap: 15px; margin-bottom: 10px; font-size: 11px; justify-content: center;">
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <div style="width: 10px; height: 10px; background: #3498db;">
                                                        </div>
                                                        <span>Periodo Actual</span>
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <div style="width: 10px; height: 10px; background: #95a5a6;">
                                                        </div>
                                                        <span>Periodo Anterior</span>
                                                    </div>
                                                </div>
                                                <div style="height: 300px;"><canvas id="chart_comp_area"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">Gasto por Centro de Trabajo: Análisis de Sedes
                                            </div>
                                            <div class="card-body">
                                                <div class="comp-chart-legend"
                                                    style="display: flex; gap: 15px; margin-bottom: 10px; font-size: 11px; justify-content: center;">
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <div style="width: 10px; height: 10px; background: #3498db;">
                                                        </div>
                                                        <span>Periodo Actual</span>
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <div style="width: 10px; height: 10px; background: #95a5a6;">
                                                        </div>
                                                        <span>Periodo Anterior</span>
                                                    </div>
                                                </div>
                                                <div style="height: 300px;"><canvas id="chart_comp_centro"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">¿Quién empujó el gasto? - Impacto Real por
                                                Proveedor (S/)</div>
                                            <div class="card-body">
                                                <div class="comp-chart-legend"
                                                    style="display: flex; gap: 20px; margin-bottom: 10px; font-size: 11px; justify-content: center;">
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <div
                                                            style="width: 12px; height: 12px; background: rgba(217, 83, 79, 0.7); border: 1px solid #d9534f;">
                                                        </div>
                                                        <span><strong>Incremento</strong></span>
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 5px;">
                                                        <div
                                                            style="width: 12px; height: 12px; background: rgba(92, 184, 92, 0.7); border: 1px solid #5cb85c;">
                                                        </div>
                                                        <span><strong>Ahorro</strong></span>
                                                    </div>
                                                </div>
                                                <p class="text-muted"
                                                    style="font-size: 10px; text-align: center; margin-bottom: 5px;">
                                                    Refleja la diferencia en soles contra el periodo anterior. Ayuda a
                                                    identificar fugas de dinero.
                                                </p>
                                                <p class="text-center"
                                                    style="font-weight: bold; color: #555; margin-bottom: 10px; font-size: 11px;">
                                                    Comparando: <span id="lbl_chart_impact_prov_dates"
                                                        style="color: #3498db;">...</span>
                                                </p>
                                                <div style="height: 300px;"><canvas id="chart_comp_proveedor"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="card">
                                            <div class="card-header">Eficiencia: Ticket Promedio por Sede (S/)</div>
                                            <div class="card-body">
                                                <div class="comp-chart-legend"
                                                    style="display: flex; gap: 15px; margin-bottom: 15px; font-size: 11px; justify-content: center;">
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <div style="width: 10px; height: 10px; background: #3498db;">
                                                        </div>
                                                        <span>Ticket Actual</span>
                                                    </div>
                                                    <div style="display: flex; align-items: center; gap: 4px;">
                                                        <div style="width: 10px; height: 10px; background: #95a5a6;">
                                                        </div>
                                                        <span>Ticket Anterior</span>
                                                    </div>
                                                </div>
                                                <p class="text-muted"
                                                    style="font-size: 10px; text-align: center; margin-bottom: 5px;">
                                                    Muestra el costo promedio por documento. Sirve para comparar si una
                                                    sede gasta más "caro" que otra.
                                                </p>
                                                <p class="text-center"
                                                    style="font-weight: bold; color: #555; margin-bottom: 10px; font-size: 11px;">
                                                    Comparando: <span id="lbl_chart_efficiency_dates"
                                                        style="color: #3498db;">...</span>
                                                </p>
                                                <div style="height: 300px;"><canvas
                                                        id="chart_comp_responsable"></canvas></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop
@section('script')
<script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}"
    type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
<script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="{{ asset('public/js/analisis/analisisliquidaciongasto.js?v=' . $version) }}"
    type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        App.init();

        // Logic for Phase 2 Analysis Modes
        $('.filter-btn-control').on('click', function () {
            const mode = $(this).data('value');
            const $parent = $(this).closest('.filter-buttons-container');
            const $mesContainer = $('#container_f2_mes');
            const $colPeriodo = $('#col_f2_periodo');
            const $colComparar = $('#container_comparar_vs').closest('div');

            // Manual active toggle for control buttons
            $parent.find('.filter-btn-control').removeClass('active');
            $(this).addClass('active');
            $('#f2_tipo_vista').val(mode);

            // Clean up periods
            $mesContainer.find('.filter-btn').removeClass('active');

            let $btnToTrigger = null;

            if (mode === 'trimestral') {
                $colPeriodo.show();
                $colComparar.show();
                $('.view-mes-btns').hide();
                $('.view-trim-btns').show();
                $('#lbl_f2_periodo').text('Trimestre');
                $btnToTrigger = $('.view-trim-btns .filter-btn').first();
            } else if (mode === 'anual') {
                $colPeriodo.hide();
                $colComparar.hide();
                // When annual, we use a hidden or dummy refresh. 
                // We'll set the value and trigger refresh via another filter.
                $('#f2_mes').val('1,2,3,4,5,6,7,8,9,10,11,12');
                $btnToTrigger = $('#container_f2_ano .filter-btn.active');
            } else { // mensual
                $colPeriodo.show();
                $colComparar.show();
                $('.view-trim-btns').hide();
                $('.view-mes-btns').show();
                $('#lbl_f2_periodo').text('Mes');
                const currentMonth = new Date().getMonth() + 1;
                $btnToTrigger = $(`.view-mes-btns .filter-btn[data-value="${currentMonth}"]`);
            }

            if ($btnToTrigger && $btnToTrigger.length) {
                $btnToTrigger.click(); // This will trigger the global 'reloadActivePhase'
            }
        });

        // Fixed listener for sub-period buttons
        $('#container_f2_mes').on('click', '.filter-btn', function () {
            // No need to manually trigger because analisisliquidaciongasto.js already has a listener for .filter-btn
            // We just ensure the hidden value is correct if the global one fails for some reason
            // but the global one is usually enough.
        });
    });
</script>
@stop