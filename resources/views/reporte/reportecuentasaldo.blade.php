@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css"
          href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <style>
        .mdi--file-excel {
            display: inline-block;
            width: 1em;
            height: 1em;
            --svg: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24'%3E%3Cpath fill='%23000' d='M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8zm1.8 18H14l-2-3.4l-2 3.4H8.2l2.9-4.5L8.2 11H10l2 3.4l2-3.4h1.8l-2.9 4.5zM13 9V3.5L18.5 9z'/%3E%3C/svg%3E");
            background-color: currentColor;
            -webkit-mask-image: var(--svg);
            mask-image: var(--svg);
            -webkit-mask-repeat: no-repeat;
            mask-repeat: no-repeat;
            -webkit-mask-size: 100% 100%;
            mask-size: 100% 100%;
        }
    </style>
@stop
@section('section')

    <div class="be-content contenido reportecuentasaldo">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-border-color @if(Session::get('empresas')->COD_EMPR == 'IACHEM0000010394') panel-border-color-danger @else @if(Session::get('empresas')->COD_EMPR == 'IACHEM0000007086') panel-border-color-success @else panel-border-color-info @endif @endif">
                        <div class="panel-heading">CUENTAS POR COBRAR / PAGAR - SALDOS
                            <div class="tools tooltiptop">

                                <div class="dropdown">
                                    <a href="#" class="tooltipcss opciones buscarccp">
                                        <span class="tooltiptext">BUSCAR CUENTAS POR COBRAR O PAGAR</span>
                                        <span class="icon mdi mdi-search"></span>
                                    </a>
                                    <a href="#" class="tooltipcss opciones descargararchivo">
                                        <span class="tooltiptext">DESCARGAR ARCHIVO EXCEL</span>
                                        <span class="icon mdi mdi--file-excel"></span>
                                    </a>
                                </div>

                            </div>
                            <span class="panel-subtitle">{{Session::get('empresas')->NOM_EMPR}} </span>

                        </div>

                        <div class="panel-body">
                            <div class='filtrotabla row'>
                                <div class="col-xs-12">

                                    <form method="POST"
                                          id="formdescargar"
                                          target="_blank"
                                          action="{{ url('/obtener-reporte-cuentas-saldo-excel') }}"
                                          style="border-radius: 0px;"
                                    >
                                        {{ csrf_field() }}

                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">CENTRO :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    {!! Form::select( 'centro', $combo_centro, array(),
                                                                      [
                                                                        'class'       => 'select2 form-control control input-xs' ,
                                                                        'id'          => 'centro',
                                                                        'data-aw'     => '1',
                                                                      ]) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">COBRAR/PAGAR :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    {!! Form::select( 'tipocontrato', $combo_tipo_contrato, array(),
                                                                      [
                                                                        'class'       => 'select2 form-control control input-xs' ,
                                                                        'id'          => 'tipocontrato',
                                                                        'data-aw'     => '2',
                                                                      ]) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">FECHA AL :</label>
                                                <input required id="endDate" name="endDate"
                                                       class="form-control control input-sm" type="date"
                                                       value="{{$fecha_fin}}">
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">TC VENTA
                                                    :</label>
                                                <div class="col-sm-12">
                                                    <input type="number"
                                                           step=0.0001
                                                           id="tc_venta" name='tc_venta'
                                                           placeholder="TC Venta"
                                                           autocomplete="off"
                                                           class="form-control input-sm"
                                                           data-aw="1"
                                                           value="{{$tipo_cambio->CAN_VENTA}}"/>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 cajareporte">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">TC COMPRA
                                                    :</label>
                                                <div class="col-sm-12">
                                                    <input type="number"
                                                           step=0.0001
                                                           id="tc_compra" name='tc_compra'
                                                           placeholder="TC Venta"
                                                           autocomplete="off"
                                                           class="form-control input-sm"
                                                           data-aw="1"
                                                           value="{{$tipo_cambio->CAN_COMPRA}}"/>
                                                </div>
                                            </div>
                                        </div>

                                        <input type="hidden" name="idopcion" id='idopcion' value='{{$idopcion}}'>

                                    </form>

                                </div>

                            </div>

                            <div class='listajax'>
                                @include('reporte.ajax.alistareportecuentasaldo')
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
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/jszipoo.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/pdfmake.min.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/vfs_fonts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}"
            type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}"
            type="text/javascript"></script>
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
    <script src="{{ asset('public/lib/jquery.niftymodals/dist/jquery.niftymodals.js') }}"
            type="text/javascript"></script>

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

        $(".select3").select2({
            width: '100%'
        });
    </script>
    <script src="{{ asset('public/js/reporte/reportecuentasaldo.js?v='.$version) }}" type="text/javascript"></script>

@stop
