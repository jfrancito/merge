@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>

@stop
@section('section')

<div class="be-content">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">GRUPO OPCION<span class="panel-subtitle">Modificar GRUPO OPCION : {{$registro->nombre}} {{$registro->apellido}}</span></div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/modificar-grupo-opcion/'.$idopcion.'/'.Hashids::encode(substr($registro->id, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}

              <div class="form-group">
                <label class="col-sm-3 control-label">Nombres</label>
                <div class="col-sm-6">

                  <input  type="text"
                          id="nombre" name='nombre' value="{{ old('nombre', $registro->nombre)}}" placeholder="Nombres"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="1"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('nombre')  , 
                                                        'error' => $errors->first('nombre', ':message') , 
                                                        'data' => '1'])                          

                </div>
              </div>


             

            <div class="form-group">
                <label class="col-sm-3 control-label">Icono</label>
                <div class="col-sm-6">

                    <input  type="text"
                            id="icono" name='icono' value="{{ old('icono',$registro->icono) }}" placeholder="iconos"
                            required = ""
                            autocomplete="off" class="form-control input-sm" data-aw="2"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('icono')  , 
                                                        'error' => $errors->first('icono', ':message') , 
                                                        'data' => '2'])

                </div>
              </div>


              @include('gestionmenu.iconos')


              <div class="form-group">
                <label class="col-sm-3 control-label">Activo</label>
                <div class="col-sm-6">
                  <div class="be-radio has-success inline">
                    <input type="radio" value='1' @if($registro->activo == 1) checked @endif name="activo" id="rad6">
                    <label for="rad6">Activado</label>
                  </div>
                  <div class="be-radio has-danger inline">
                    <input type="radio" value='0' @if($registro->activo == 0) checked @endif name="activo" id="rad8">
                    <label for="rad8">Desactivado</label>
                  </div>
                </div>
              </div> 

              <div class="row xs-pt-15">
                <div class="col-xs-6">
                    <div class="be-checkbox">

                    </div>
                </div>
                <div class="col-xs-6">
                  <p class="text-right">
                    <a href="{{ url('/gestion-de-grupoopciones/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger">Cancelar</button></a>
                    <button type="submit" class="btn btn-space btn-primary">Guardar</button>
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
    <script src="{{ asset('public/js/app/usuarios.js?v='.$version) }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();
      });
    </script> 
@stop