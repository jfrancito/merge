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
          <div class="panel-heading panel-heading-divider" >Empresa Proveedor<span class="panel-subtitle">Buscar en sunat</span></div>
          <div class="panel-body">

            <form method="POST" action="{{ url('/buscar-sunat-ruc/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed frmbuscar">
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

              <div class="form-group">
                <label class="col-sm-3 control-label" style="text-align:right;">RUC</label>
                <div class="col-sm-5">
                  <input  type="text"
                          id="ruc_buscar" name='ruc_buscar' value="{{ old('ruc') }}" placeholder="RUC"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-parsley-length="[11,11]" data-aw="4"/>

                </div>
              </div>
              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-success btn_cargando">Buscar</button>
                  </p>
                </div>
              </div>
            </form>

            <form method="POST" action="{{ url('/guardar-empresa-proveedor/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed frmbuscar">
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>


              <div class="form-group">
                <label class="col-sm-3 control-label">¿EXISTE EMPRESA?</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="texto_empresa" name='texto_empresa' value="{{$texto_empresa}}"
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">¿EXISTE CONTRATO?</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="texto_contrato" name='texto_contrato' value="{{$texto_contrato}}" 
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>

              <input type="hidden" name="ind_empresa" value='{{$ind_empresa}}'>
              <input type="hidden" name="ind_contrato" value='{{$ind_contrato}}'>



              <div class="form-group">
                <label class="col-sm-3 control-label">RUC</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="ruc" name='ruc' value="{{ $ruc }}" placeholder="RUC"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">RAZON SOCIAL</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="rz" name='rz' value="{{ $rz }}" placeholder="RAZON SOCIAL"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">DIRECCION</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="direccion" name='direccion' value="{{ $direccion }}" placeholder="DIRECCION"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>
              <div class="form-group">
                <label class="col-sm-3 control-label">DEPARTAMENTO</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="departamento" name='departamento' value="{{ $departamento }}" placeholder="DEPARTAMENTO"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>

              <div class="form-group">
                <label class="col-sm-3 control-label">PROVINCIA</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="provincia" name='provincia' value="{{ $provincia }}" placeholder="PROVINCIA"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label">DISTRITO</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="distrito" name='distrito' value="{{ $distrito }}" placeholder="DISTRITO"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4" readonly = "readonly"/>

                </div>
              </div>

              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <button type="submit" class="btn btn-space btn-primary btn_cargando">Guardar</button>
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