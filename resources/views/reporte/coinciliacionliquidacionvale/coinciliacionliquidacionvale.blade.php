@extends('template_lateral')
@section('style')
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} " />
<link rel="stylesheet" type="text/css"
    href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} " />
<link rel="stylesheet" type="text/css" href="{{ asset('public/css/reporte/reportes.css?v=' . $version) }} " />

@stop

@section('section')
<div class="be-content contenido cfedocumento">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div
                    class="panel panel-default panel-border-color @if(Session::get('empresas')->COD_EMPR == 'IACHEM0000010394') panel-border-color-danger @else @if(Session::get('empresas')->COD_EMPR == 'IACHEM0000007086') panel-border-color-success @else panel-border-color-info @endif @endif">
                    <div class="panel-heading negrita">Conciliación de Liquidación de Gastos y Vales
                        <div class="tools tooltiptop">
                            <div class="dropdown">

                                <a href="#" class="tooltipcss opciones btn-exportar-excel" id="btnExportar">
                                    <span class="tooltiptext">Exportar a Excel</span>
                                    <span class="icon mdi mdi-file-excel"></span>
                                </a>
                            </div>
                        </div>
                        <span class="panel-subtitle negrita">{{Session::get('empresas')->NOM_EMPR}}</span>
                    </div>

                    <div class="panel-body">
                        <div class='filtrotabla row'>
                            <div class="col-xs-12">
                                <form method="POST" id="formFiltros" style="border-radius: 0px;">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="idopcion" id="idopcion" value="{{ $idopcion }}">

                                    <div class="row">
                                        <!-- Filtro de Trabajador -->
                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft">Trabajador(es):</label>
                                                <div class="col-sm-12 abajocaja">
                                                    <select name="trabajador" id="trabajador"
                                                        class="select2 form-control control input-xs" data-aw="1">
                                                        <option value="todos">-- Todos los trabajadores --</option>
                                                        @foreach($trabajadores as $item)
                                                            <option value="{{ $item->COD_EMPRESA_TRABAJADOR }}">
                                                                {{ $item->TXT_EMPRESA_TRABAJADOR }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
                                            <div class="form-group ">
                                                <label class="col-sm-12 control-label labelleft">Fecha Inicio:</label>
                                                <div class="col-sm-12 abajocaja">
                                                    <div data-min-view="2" data-date-format="dd-mm-yyyy"
                                                        class="input-group date datetimepicker pickerfecha">
                                                        <input size="16" type="text" value="{{date('d-m-Y')}}"
                                                            placeholder="Fecha Inicio" id='fecha_inicio'
                                                            name='fecha_inicio' required=""
                                                            class="form-control input-sm" />
                                                        <span class="input-group-addon btn btn-primary"><i
                                                                class="icon-th mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
                                            <div class="form-group ">
                                                <label class="col-sm-12 control-label labelleft">Fecha Fin:</label>
                                                <div class="col-sm-12 abajocaja">
                                                    <div data-min-view="2" data-date-format="dd-mm-yyyy"
                                                        class="input-group date datetimepicker pickerfecha">
                                                        <input size="16" type="text" value="{{date('d-m-Y')}}"
                                                            placeholder="Fecha Fin" id='fecha_fin' name='fecha_fin'
                                                            required="" class="form-control input-sm" />
                                                        <span class="input-group-addon btn btn-primary"><i
                                                                class="icon-th mdi mdi-calendar"></i></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>



                                        <!-- Botón Buscar -->
                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 cajareporte">
                                            <div class="form-group quitar-tb">
                                                <label class="col-sm-12 control-label hidden-xs">&nbsp;</label>
                                                <div class="col-sm-12">
                                                    <button type="button" id="btnBuscar"
                                                        class="btn btn-primary btn-block">
                                                        <i class="mdi mdi-search"></i> BUSCAR
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>

                        <!-- Área de resultados -->
                        <div class="row">
                            <div class="col-xs-12">
                                <div class="listajax" id="resultadosReporte">
                                    <div id="summaryHeader" style="display: none;">
                                        <!-- Se cargará por JS -->
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover table-bordered"
                                            id="tablaConciliacion">
                                            <thead id="theadConciliacion">
                                                <!-- Cargado dinámicamente por JS -->
                                            </thead>
                                            <tbody id="tbodyConciliacion">
                                                <tr>
                                                    <td class="text-center text-muted">
                                                        <i class="mdi mdi-information-outline"></i>
                                                        Seleccione los filtros y presione buscar para ver los resultados
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot id="tfootConciliacion">
                                                <!-- Totales dinámicos -->
                                            </tfoot>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Loading Overlay Estilo Gerencial -->
                        <div id="loadingOverlay" class="loading-overlay" style="display: none;">
                            <div class="spinner-gerencial"></div>
                            <p style="margin-top: 15px; font-weight: 600; color: #1e293b; letter-spacing: 0.05em;">
                                PROCESANDO REPORTE GERENCIAL...
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


@stop
@section('script')
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

<script type="text/javascript">
    // Definir variables globales ANTES de cargar el script externo
    var urlBase = "{{ url('/') }}";
    var csrfToken = "{{ csrf_token() }}";
</script>


<script type="text/javascript">
    $(document).ready(function () {
        App.init();
        App.formElements();
        $('[data-toggle="tooltip"]').tooltip();
        $('form').parsley();

    });
</script>
<script src="{{ asset('public/js/reporte/conciliacionliquidaciongastos.js?v=' . $version) }}"
    type="text/javascript"></script>

@stop