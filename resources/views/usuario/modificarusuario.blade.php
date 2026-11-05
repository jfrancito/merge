@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datatables/css/dataTables.bootstrap.min.css') }} "/>
@stop
@section('section')

<div class="be-content">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">USUARIO<span class="panel-subtitle">Modificar Usuario : {{$usuario->nombre}}</span></div>
          <div class="panel-body">


            <form method="POST" action="{{ url('/modificar-usuario/'.$idopcion.'/'.Hashids::encode(substr($usuario->id, -8))) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed"> 
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

              
                <div class="form-group">
                    <label class="col-sm-3 control-label">Personal</label>
                    <div class="col-sm-5">

                      <input  type="text"
                              id="nombre" name='nombre' value="{{old('nombre',$usuario->nombre)}}" placeholder="Nombre del Personal"
                              required = "" readonly="readonly"
                              autocomplete="off" class="form-control input-sm" data-aw="1"/>

                    </div>
                    <input  type="hidden"
                             id="trabajador_id" name='trabajador_id'/>
                </div>
            
            
              <div class="form-group">
                <label class="col-sm-3 control-label">Usuario</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="name" name='name' value="{{old('name',$usuario->name)}}" placeholder="Usuario"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="4"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
                                                        'error' => $errors->first('name', ':message') , 
                                                        'data' => '4'])

                </div>
              </div>

  

              <div class="form-group">
                <label class="col-sm-3 control-label">Clave ({{Crypt::decrypt($usuario->password)}})</label>
                <div class="col-sm-5">

                  <input  type="password"
                          id="password" name='password' value="" placeholder="Clave"
                          required = ""
                          autocomplete="off" class="form-control input-sm" data-aw="6"/>

                </div>
              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Rol</label>
                <div class="col-sm-5">
                  {!! Form::select( 'rol_id', $comborol, array(),
                                    [
                                      'class'       => 'form-control control input-sm' ,
                                      'id'          => 'rol_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>






              <div class="form-group">
                <label class="col-sm-3 control-label">Activo</label>
                <div class="col-sm-5">
                  <div class="be-radio has-success inline">
                    <input type="radio" value='1' @if($usuario->activo == 1) checked @endif name="activo" id="rad6">
                    <label for="rad6">Activado</label>
                  </div>
                  <div class="be-radio has-danger inline">
                    <input type="radio" value='0' @if($usuario->activo == 0) checked @endif name="activo" id="rad8">
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
                  </p>
                </div>
              </div>

            </form>


          </div>
        </div>
      </div>
    </div>


    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider">Perfiles<span class="panel-subtitle">Perfiles del usuario : {{$usuario->nombre}}</span></div>
          <div class="panel-body">


            <div class="row">
              <div class="col-sm-12">
                <div class="panel panel-default panel-table">
                  <div class="panel-body listadoperfiles">
                    <table id="tableperfiles" class="table table-striped table-hover table-fw-widget">
                      <thead>
                        <tr>
                          <th>Empresa</th>
                          <th>Acceso</th>
                        </tr>
                      </thead>
                      <tbody>

                        @foreach($empresas as $itemempresa)
                          @foreach($centros as $itemcentro)
                            @if($itemcentro->COD_CENTRO=='CEN0000000000001')
                              <tr>
                                <td>
                                  {{$itemempresa->NOM_EMPR}}
                                </td>
                                <td>
                                  <div class="text-center be-checkbox be-checkbox-sm">
                                    <input  type="checkbox"
                                            class="{{$itemempresa->COD_EMPR}}{{$itemcentro->COD_CENTRO}}"
                                            id="1{{$itemempresa->COD_EMPR}}{{$itemcentro->COD_CENTRO}}"
                                            @if ($funcion->funciones->tiene_perfil($itemempresa->COD_EMPR,$itemcentro->COD_CENTRO,$usuario->id)) checked @endif
                                    >
                                    <label  for="1{{$itemempresa->COD_EMPR}}{{$itemcentro->COD_CENTRO}}"
                                            data-idempresa = "{{$itemempresa->COD_EMPR}}"
                                            data-idcentro = "{{$itemcentro->COD_CENTRO}}"
                                            data_idusuario = "{{$usuario->id}}"
                                            class = "checkbox"                    
                                            name="{{$itemempresa->COD_EMPR}}{{$itemcentro->COD_CENTRO}}"
                                      ></label>
                                  </div>

                                </td>
                              </tr> 
                            @endif
                          @endforeach                   
                        @endforeach

                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>






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


    <script src="{{ asset('public/lib/datatables/js/jquery.dataTables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/js/dataTables.bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/dataTables.buttons.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.html5.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.flash.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.print.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.colVis.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datatables/plugins/buttons/js/buttons.bootstrap.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-tables-datatables.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
        App.formElements();
        $('form').parsley();
      });
    </script> 
    <script src="{{ asset('public/js/user/user.js?v='.$version) }}" type="text/javascript"></script> 
    
@stop