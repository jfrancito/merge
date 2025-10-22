@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/responsive.dataTables.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
@stop
@section('section')

<div class="be-content autorizaprincipal">
    <div class="main-content container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                    <div class="panel-heading">Registro Personal Autoriza</div>   

                    <div class="panel-body selectfiltro">
                        <div class='filtrotabla row'>
                            <div class="col-xs-12">

                                   <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">

                                             <label class="col-sm-12 control-label labelleft negrita"> SEDE <span class="obligatorio">(*)</span> :</label>
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
                                            <label class="col-sm-12 control-label labelleft negrita"> GERENCIA <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12 abajocaja">
                                                {!! Form::select('gerencia_select', $listagerencia, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'gerencia_select',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                            </div>
                                        </div>
                                    </div>


                                      <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                        <div class="form-group">
                                             <label class="col-sm-12 control-label labelleft negrita"> ÁREA <span class="obligatorio">(*)</span> :</label>
                                            <div class="col-sm-12">
                                                 <div class="input-group">
                                                {!! Form::select('area_select', $listaarea, '',
                                                   [
                                                     'class'       => 'form-control control select2' ,
                                                     'id'          => 'area_select',
                                                     'data-aw'     => '1',
                                                   ])
                                                !!}
                                                        <span class="input-group-btn">
                                                                 <input type="hidden" id="personal_autoriza_id" value="" />
                                                                 
                                                                 <button id="filtrarpersonal" type="button" class="btn btn-primary">Filtrar</button>
                                                        </span>
                                                     </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                             <div class="listadetalleajax"></div>
                                      <div class='ajaxvacio text-center'>
                                            Seleccione los campos para poder filtrar ...
                                      </div>
                                <div class="col-xs-12">
                                    <div class='listacontratomasiva listajax reporteajax'>    
                                    </div>
                                </div>
                                @include('valerendir.ajax.listamodalpersonalautoriza')
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
<script src="{{ asset('public/js/vale/registropersonalautoriza.js?v='.$version) }}" type="text/javascript"></script>
@stop