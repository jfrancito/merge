@extends('template_lateral')
@section('style')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>


@stop
@section('section')


<div class="be-content containercpe">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider" >CPE<span class="panel-subtitle">Buscar en sunat</span></div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/gestion-de-cpe/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed frmbuscar">
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

              <div class="form-group">
                <label class="col-sm-3 control-label">RUC</label>
                <div class="col-sm-5">
                  <input  type="text"
                          id="ruc" name='ruc' value="{{ old('ruc') }}" placeholder="RUC"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4"/>

                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">TIPO DOCUMENTO</label>
                <div class="col-sm-5">
                  {!! Form::select( 'td', $combotd, array('01'),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'td',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label">SERIE</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="serie" name='serie' value="{{ old('serie') }}" placeholder="SERIE"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4"/>



                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">NRO. DOCUMENTO</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="correlativo" name='correlativo' value="{{ old('correlativo') }}" placeholder="NRO. DOCUMENTO"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
                                                        'error' => $errors->first('name', ':message') , 
                                                        'data' => '4'])

                </div>
              </div>

              <div class="form-group" style="text-align: center;">
                <div class="col-sm-12">

                @if(Session::has('respuetacdr'))
                    @if(Session::get('respuetacdr')['cod_error'] == 1)
                      <span class="label label-danger">{{Session::get('respuetacdr')['mensaje']}}</span>
                    @else
                      <a class="btn btn-space btn-success" href="{{ url('descargar-archivo/'.Session::get('respuetacdr')['nombre_archivo']) }}">Descargar CDR</a>

                    @endif
                @endif

                @if(Session::has('respuetaxml'))
                    @if(Session::get('respuetaxml')['cod_error'] == 1)
                      <span class="label label-danger">{{Session::get('respuetaxml')['mensaje']}}</span>
                    @else
                      <a class="btn btn-space btn-success" href="{{ url('descargar-archivo/'.Session::get('respuetaxml')['nombre_archivo']) }}">Descargar XML Y CDR</a>

                    @endif
                @endif
                @if(Session::has('respuetapdf'))
                    @if(Session::get('respuetapdf')['cod_error'] == 1)
                      <span class="label label-danger">{{Session::get('respuetaxml')['mensaje']}}</span>
                    @else
                      <a class="btn btn-space btn-success" href="{{ url('descargar-archivo/'.Session::get('respuetapdf')['nombre_archivo']) }}">Descargar PDF</a>

                    @endif
                @endif
                </div>
              </div>

              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary btn_cargando">Buscar</button>
                  </p>
                </div>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>

  </div>
</div>  

@stop

@section('script')



    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 


    <script src="{{ asset('public/js/cpe/cpe.js?v='.$version) }}" type="text/javascript"></script>
@stop