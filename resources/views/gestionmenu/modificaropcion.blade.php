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

          <div class="panel-heading panel-heading-divider">OPCION<span class="panel-subtitle">Modificar Opcion : {{$registro->nombre}} {{$registro->pagina}}</span></div>

          <div class="panel-body">

            <form method="POST" action="{{ url('/modificar-opcion/'.$idopcion.'/'.Hashids::encode(substr($registro->id,-8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">

                  {{ csrf_field() }}



 

          <div class="form-group">

                <label class="col-sm-3 control-label">Nombre</label>

                <div class="col-sm-6">



                  <input  type="text"

                          id='nombre' name='nombre' value="{{ old( 'nombre', $registro->nombre) }}" placeholder="nombre"

                          required = ""

                          autocomplete="off" class="form-control" data-aw="1"/>



                    @include('error.erroresvalidate', [ 'id' => $errors->has('nombre')  , 

                                                        'error' => $errors->first('nombre', ':message') , 

                                                        'data' => '1'])



                </div>

              </div>


              <div class="form-group">

                <label class="col-sm-3 control-label">Descripcion</label>

                <div class="col-sm-6">



                  <input  type="text"

                          id="descripcion" name='descripcion' value="{{ old( 'descripcion', $registro->descripcion) }}" placeholder="DESCRIPCION"

                          required = "" 

                          autocomplete="off" class="form-control" data-aw="2"/>



                    @include('error.erroresvalidate', [ 'id' => $errors->has('descripcion')  , 

                                                        'error' => $errors->first('descripcion', ':message') , 

                                                        'data' => '2'])



                </div>

              </div>



              <div class="form-group">

                <label class="col-sm-3 control-label">Pagina</label>

                <div class="col-sm-6">



                  <input  type="text"

                          id="pagina" name='pagina' value="{{ old( 'pagina', $registro->pagina) }}" placeholder="pagina-web"

                          required = "" sololectura readonly 

                          autocomplete="off" class="form-control" data-aw="3"/>


                </div>

              </div>








              <div class="form-group">



                <label class="col-sm-3 control-label">Grupo Opcion</label>

                <div class="col-sm-6">

                  {!! Form::select( 'grupoopcion_id', $combogrupoopcion, array(),

                                    [

                                      'class'       => 'form-control control' ,

                                      'id'          => 'grupoopcion_id',

                                      'required'    => '',

                                      'data-aw'     => '4'

                                    ]) !!}

                </div>

              </div>



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

                    <button type="submit" class="btn btn-space btn-primary">Guardar</button>
                    <a href="{{ url('/gestion-opciones/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger">Cancelar</button></a>

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

@stop