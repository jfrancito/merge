@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')

<div class="be-content apruebaprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Registro Personal Aprueba</div>   

                    <div class="panel-body selectfiltro">
                        <div class='filtrotabla row'>
                            <div class="col-xs-12">

                                   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">

                                            <label class="col-sm-12 control-label labelleft">Sede
                                                :</label>
                                            <div class="col-sm-12 abajocaja">
                                                 {!! Form::select('sede_select', $listasede, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'sede_select',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                               
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft">Persona Aprueba :</label>
                                            <div class="col-sm-12">
                                                 <div class="input-group">
                                                    {!! Form::select('usuario_select', $listausuario, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'usuario_select',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                                        <span class="input-group-btn">
                                                                 <input type="hidden" id="personal_aprueba_id" value="" />
                                                                  <input type="hidden" id="area_hidden" name="area" />
                                                                  <input type="hidden" id="cargo_hidden" name="cargo" />
                                                                 <button id="asignarpersonalaprueba" type="button" class="btn btn-primary">Asignar</button>
                                                        </span>
                                                     </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                             <div class="listadetalleajax"></div>
                                      <div class='ajaxvacio text-center'>
                                            Seleccione personal aprobar vale a rendir por sede. 
                                      </div>
                                <div class="col-xs-12">
                                    <div class='listacontratomasiva listajax reporteajax'>    
                                    </div>
                                </div>
                                @include('valerendir.ajax.listamodalpersonalaprueba')
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


    <script src="{{ asset('public/js/vale/registropersonalaprueba.js?v='.$version) }}" type="text/javascript"></script>
@stop