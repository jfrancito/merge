@extends('template_lateral')
@section('style')

    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>


@stop
@section('section')


<div class="be-content fusuario">
  <div class="main-content container-fluid">

    <!--Basic forms-->
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default panel-border-color panel-border-color-primary">
          <div class="panel-heading panel-heading-divider" >TERCERO <span class="panel-subtitle">Crear un nuevo Tercero</span></div>
          <div class="panel-body">
            <form method="POST" action="{{ url('/agregar-tercero/'.$idopcion) }}" style="border-radius: 0px;" class="form-horizontal group-border-dashed">
                  {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>



              <div class="form-group">
                <label class="col-sm-3 control-label">Personal</label>
                <div class="col-sm-5">
                  <select class="select2 input-sm" id="personal" name='personal' required = "">
                    <optgroup label="Usuarios">
                      <option value="">Seleccione Personal</option>
                      @foreach($listapersonal as $item)
                        <option value="{{$item->id}}" data_usuario='{{$item->COD_USUARIO}}'>{{$item->nombres}}</option>
                      @endforeach
                    </optgroup>
                  </select>
                </div>
              </div>




              <div class="form-group">
                <label class="col-sm-3 control-label">Usuario</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="name" name='name' value="{{ old('name') }}" placeholder="Usuario"
                          required = "" readonly="readonly"
                          autocomplete="off" class="form-control input-sm" data-aw="4"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
                                                        'error' => $errors->first('name', ':message') , 
                                                        'data' => '4'])

                </div>
              </div>

  

              <div class="form-group">
                <label class="col-sm-3 control-label">Clave</label>
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
                  {!! Form::select( 'rol_id', $comborol, array('1CIX00000048'),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'rol_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Empresa</label>
                <div class="col-sm-5">
                  {!! Form::select( 'empresa_id', $combo_empresa, array($empresa_id),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'empresa_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>


              <div class="form-group">

                <label class="col-sm-3 control-label">Centro</label>
                <div class="col-sm-5">
                  {!! Form::select( 'centro_id', $combo_centro, array($centro_id),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'centro_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>


              <div class="form-group">

                <label class="col-sm-3 control-label">Area</label>
                <div class="col-sm-5">
                  {!! Form::select( 'area_id', $combo_area, array($area_id),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'area_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>

              <div class="form-group">

                <label class="col-sm-3 control-label">Banco</label>
                <div class="col-sm-5">
                  {!! Form::select( 'banco_id', $combobancos, array($banco_id),
                                    [
                                      'class'       => 'form-control control input-sm select2' ,
                                      'id'          => 'banco_id',
                                      'required'    => '',
                                      'data-aw'     => '7'
                                    ]) !!}
                </div>
              </div>


              <div class="form-group">
                <label class="col-sm-3 control-label">Cuenta Bancaria</label>
                <div class="col-sm-5">

                  <input  type="text"
                          id="cuenta_bancaria" name='cuenta_bancaria' value="{{ old('cuenta_bancaria') }}" placeholder="Cuenta Bancaria"
                          required = ""
                          autocomplete="off" class="form-control input-sm"/>

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

        $('#cliente_select').select2({
            // Activamos la opcion "Tags" del plugin
            placeholder: 'Seleccione un proveedor',
            language: "es",
            tags: true,
            tokenSeparators: [','],
            ajax: {
                dataType: 'json',
                url: '{{ url("buscarcliente") }}',
                delay: 100,
                data: function(params) {

                    return {
                        term: params.term
                    }
                },
                processResults: function (data, page) {

                  return {
                    results: data
                  };

                },
            }
        });
        $(".fusuario").on('change','#cliente_select', function() {

          var empresa   = $(this).val();
          var arrayempresa = empresa.split("-");
          var strempresa = arrayempresa[0].trim();
          $('#name').val(strempresa);
          debugger;

        });



      });
    </script> 

    <script src="{{ asset('public/js/user/user.js?v='.$version) }}" type="text/javascript"></script>
@stop