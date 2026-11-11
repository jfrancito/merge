@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')

    <div class="be-content importegastosprincipal">
        <div class="main-content container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default panel-table">
                           <div class="panel panel-default panel-border-color panel-border-color-success">
                                <div class="panel-heading">Registro Importe Gastos</div>
                            </div>
                        <div class="panel-body selectfiltro">

                            <div class='filtrotabla row'>
                                <div class="col-xs-12">


                                     <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"> ORIGEN <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12 abajocaja">
                                                {!! Form::select('cliente_select', $listacentro, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cliente_select',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"> DEPARTAMENTO <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12 abajocaja">
                                                {!! Form::select('cliente_select1', $listadepartamento, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cliente_select1',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"> PROVINCIA <span class="obligatorio">(*)</span> :</label>
                                             <div class="col-sm-12 abajocaja">
                                                {!! Form::select('cliente_select2', $listaprovincia, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cliente_select2',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>


                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"> DISTRITO <span class="obligatorio">(*)</span> :</label>
                                             <div class="col-sm-12 abajocaja">
                                                {!! Form::select('cliente_select3', $listadistrito, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cliente_select3',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div> 

                                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                        <div class="form-group">
                                           <label class="col-sm-12 control-label labelleft negrita" style="margin-top:10px;"> TIPO DE LÍNEA <span class="obligatorio">(*)</span> :</label>
                                             <div class="col-sm-12 abajocaja">
                                                {!! Form::select('cliente_select4', $listatipolinea, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cliente_select4',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div> 

                                   

                                  {{--}}   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Importe Combustible (OPCIONAL) :</label>
                                            <div class="col-sm-12 input-group xs-mb-15">

                                                <input type="text"
                                                       id="can_combustible" name='' value="" placeholder="Combustible"
                                                       required=""
                                                       autocomplete="off" class="form-control input-md dinero_masivo"
                                                       data-aw="4"/>
                                            </div>
                                        </div>
                                    </div> --}}
                                    
                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                        <label class="col-sm-12 control-label labelleft negrita"style="margin-top:10px;"> TIPO DE IMPORTE <span class="obligatorio">(*)</span> :</label>
                                           <div class="col-sm-12 abajocaja">
                                                   
                                                 {!! Form::select('cod_tipo', $listatipoimporte, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'cod_tipo',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                                   
                                                </div>
                                            </div>
                                        </div>

                                     <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">

                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"style="margin-top:10px;"> IMPORTE <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12 input-group xs-mb-15">

                                                <input type="text"
                                                       id="can_total_importe" name='' value="" placeholder="Importe"
                                                       required=""
                                                       autocomplete="off" class="form-control input-md dinero_masivo"
                                                       data-aw="4"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft negrita"style="margin-top:10px;"> IND DESTINO - RUTA CORTA <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12">
                                                 <div class="input-group">
                                                 {!! Form::select('ind_destino', ['' => 'Selecciona indicador', '1' => 'Sí', '0' => 'No'], null, [
                                                    'class'   => 'form-control control select2',
                                                    'id'      => 'ind_destino',
                                                    'data-aw' => '1'
                                                ]) !!}
                                                        <span class="input-group-btn">
                                                                <input type="hidden" id="importe_gastos_id" value="" />
                                                                 <button id="asignarimportegastos" type="button" class="btn btn-primary">Asignar</button>
                                                        </span>
                                                     </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="listadetalleajax"></div>
                                      <div class='ajaxvacio text-center'>
                                            COMPLETE LOS CAMPOS CORRECTAMENTE ...
                                      </div>
                               

                            <div class="panel panel-default panel-border-color panel-border-color-primary">
                                <div class="panel-heading">
                                    <div class="tools tooltiptop">
                                        <div class="dropdown">
                                            <a href="#" class="btn btn-secondary botoncabecera tooltipcss opciones buscardocumento">
                                                <span class="tooltiptext">Buscar</span>
                                                <span class="icon mdi mdi-search"></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">PARTIDA <span class="obligatorio">(*)</span> :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    {!! Form::select('cod_centro', $listalugarpartida, '', [
                                                        'class' => 'form-control control select2',
                                                        'id' => 'cod_centro',
                                                        'data-aw' => '1',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                            <div class="form-group">
                                                <label class="col-sm-12 control-label labelleft negrita">DESTINO <span class="obligatorio">(*)</span> :</label>
                                                <div class="col-sm-12 abajocaja">
                                                    {!! Form::select('cod_distrito', $listalugardestino, '', [
                                                        'class' => 'form-control control select2',
                                                        'id' => 'cod_distrito',
                                                        'data-aw' => '1',
                                                    ]) !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                                <div class="col-xs-12">
                                    <div class='listacontratomasiva listajax reporteajax'></div>
                                </div>
                                <div class='listaajaxaux'>    
                                @include('valerendir.ajax.listamodalregistroimportegastos')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>




    <style>
        .custom-glosa-height {
            height: 100px;
        }
        .row-deleted {
         background-color: #f8d7da !important; 
         color: #721c24 !important; 
        }
    </style>

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


    <script src="{{ asset('public/js/vale/registroimportegastos.js?v='.$version) }}" type="text/javascript"></script>
@stop