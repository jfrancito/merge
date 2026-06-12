@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')

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
    
    /* Botón Guardar */
    .btn-guardar-matriz {
        background: linear-gradient(135deg, #0f766e 0%, #059669 100%) !important;
        color: #ffffff !important;
        border: none !important;
        padding: 12px 30px !important;
        font-size: 14px !important;
        font-weight: bold !important;
        letter-spacing: 0.5px !important;
        border-radius: 8px !important;
        cursor: pointer !important;
        box-shadow: 0 6px 20px rgba(5, 150, 105, 0.3) !important;
        transition: all 0.3s ease !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 10px !important;
        margin-top: 25px !important;
    }
    .btn-guardar-matriz:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 25px rgba(5, 150, 105, 0.4) !important;
    }
    .btn-guardar-matriz i {
        font-size: 18px !important;
    }
</style>

<div class="be-content rutasprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                
                <div class="panel-premium-rutas">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}" id="token">
                    <input type="hidden" name="carpeta" value="{{$capeta}}" id="carpeta">
                    
                    <!-- Heading -->
                    <div class="heading-rutas">
                        <i class="mdi mdi-map-marker-radius"></i>
                        <h3>Gestión de Importes por Ruta</h3>
                    </div>
                    
                    <!-- Filtros de Ubicación -->
                    <div class="filters-section">
                        <div class="row">
                            <div class="col-md-2 col-sm-12 mb-3">
                                <label class="filter-label">Origen <span class="text-danger">*</span></label>
                                {!! Form::select('origen', $origenes, '', [
                                    'class' => 'form-control select-premium select2',
                                    'id' => 'origen'
                                ]) !!}
                            </div>
                            <div class="col-md-2 col-sm-12 mb-3">
                                <label class="filter-label">Departamento <span class="text-danger">*</span></label>
                                {!! Form::select('departamento', $departamentos, '', [
                                    'class' => 'form-control select-premium select2',
                                    'id' => 'departamento'
                                ]) !!}
                            </div>
                            <div class="col-md-2 col-sm-12 mb-3">
                                <label class="filter-label">Provincia <span class="text-danger">*</span></label>
                                {!! Form::select('provincia', $provincias, '', [
                                    'class' => 'form-control select-premium select2',
                                    'id' => 'provincia'
                                ]) !!}
                            </div>
                            <div class="col-md-3 col-sm-12 mb-3">
                                <label class="filter-label">Distrito <span class="text-danger">*</span></label>
                                {!! Form::select('distrito', $distritos, '', [
                                    'class' => 'form-control select-premium select2',
                                    'id' => 'distrito'
                                ]) !!}
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
                                        @foreach($tipos_linea as $linea)
                                            <th>{{ $linea->TXT_LINEA }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($tipo_importe as $cod_motivo => $txt_motivo)
                                        @if($cod_motivo == '') @continue @endif
                                        @php
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
                                        @endphp
                                        <tr>
                                            <td data-cod-tipo="{{ $cod_motivo }}" data-txt-tipo="{{ $txt_motivo }}">
                                                <i class="{{ $icon }} mr-2"></i> {{ $txt_motivo }}
                                            </td>
                                            @foreach($tipos_linea as $linea)
                                            <td>
                                                <input type="text" class="input-importe dinero" placeholder="0.00" 
                                                       data-cod-linea="{{ $linea->COD_LINEA }}" 
                                                       data-txt-linea="{{ $linea->TXT_LINEA }}"
                                                       data-cod-tipo="{{ $cod_motivo }}"
                                                       data-txt-tipo="{{ $txt_motivo }}">
                                            </td>
                                            @endforeach
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        
                        <div class="text-right">
                            <button type="button" class="btn-guardar-matriz">
                                <i class="mdi mdi-content-save"></i> GUARDAR CONFIGURACIÓN
                            </button>
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
    <script src="{{ asset('public/js/general/inputmask/inputmask.date.extensions.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/js/general/inputmask/jquery.inputmask.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.responsive.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/responsive.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js?v='.$version) }}" type="text/javascript"></script>


    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
    $(document).ready(function () {
     
        App.init();
        App.formElements();
        App.dataTables();
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>

    <script src="{{ asset('public/js/vale/registrorutas.js?v='.$version) }}" type="text/javascript"></script>
@stop