<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="{{ asset('public/img/icono/merge1.ico') }}">
    <title>Registrate - Inicio Sessión</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/styleregistrate.css?v='.$version) }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/datetimepicker/css/bootstrap-datetimepicker.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/bootstrap-slider/css/bootstrap-slider.css') }} "/>

    <link rel="stylesheet" href="{{ asset('public/css/registrate.css?v='.$version) }}" type="text/css"/>


  </head>
  <body class="form-v10 wrapper registroruc">
        @include('error.erroresurl', ['error' => Session::get('errorurl')])
        @include('error.erroresbd', ['error' => Session::get('errorbd')])

    <div class="page-content">
      <div class="form-v10-content">
        <form class="form-detail" action="{{ url('registrate') }}" method="POST" id="myform">
          {{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

          <div class="form-left">
            <h2>Datos Principales </h2> 
                <div class="row regla-modal">
                    <div class="col-md-12">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                              <div class="inputr">
                                <div class="control-label">
                                  <div class="tooltipfr">Ruc <span class='requerido'>*</span>
                                    <span class="tooltiptext">Ingrese el ruc y busque los datos correspondiente.</span>
                                  </div>  
                                </div>
                                <div class="abajocaja">
                                      <div class="input-group">
                                            <input  type="text"
                                                    id="ruc" name='ruc' value="{{ old('ruc') }}" placeholder="RUC"
                                                    required = ""
                                                    autocomplete="off" class="form-control input-sm" data-aw="4"/>
                                            <span class="input-group-btn">
                                              <button type="button" class="buscarruc btn btn-success input-sm" style="height: 37px;">
                                                Buscar
                                              </button>
                                          </span>       

                                      </div>
                                </div>
                              </div>
                              <div class='encontro_proveedor'>
                                @include('usuario.form.formproveedor')
                              </div>
                              <div class='inputr'>
                                <div class="control-label">Cuenta Detracción :</div>
                                <div class="abajocaja">

                                  <input  type="text"
                                          id="cuenta_detraccion" name='cuenta_detraccion' value="{{ old('cuenta_detraccion') }}" 
                                          placeholder="Cuenta Detracción"
                                          autocomplete="off" class="form-control input-sm" data-aw="4"/>

                                </div>
                              </div>


                              <div class='inputr'>
                                <div class="control-label">Contraseña : (entre 8 a 20 caracteres) <span class='requerido'>*</span>:</div>
                                <div class="abajocaja">

                                  <input  type="password"
                                          id="lblcontrasena" name='lblcontrasena' value="{{ old('lblcontrasena') }}" placeholder="Ingresa una contraseña"
                                          required = ""
                                          data-parsley-minlength="8"
                                          data-parsley-maxlength="20"
                                          autocomplete="off" 
                                          data-parsley-equalto="#lblcontrasenaconfirmar"
                                          class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                          data-aw="1"/>


                                </div>
                              </div>

                              <div class='inputr'>
                                <div class="control-label">Confirmar Contraseña <span class='requerido'>*</span>:</div>
                                <div class="abajocaja">

                                    <input  type="password"
                                            id="lblcontrasenaconfirmar" name='lblcontrasenaconfirmar' value="{{ old('lblcontrasenaconfirmar') }}" placeholder="Confirmar contraseña"
                                            required = ""
                                            autocomplete="off"
                                            data-parsley-equalto="#lblcontrasena"
                                            class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                            data-aw="1"/>


                                </div>
                              </div>
                              <span class='requerido'>* Datos obligatorios</span>
                              <br>

                        </div>
                    </div>
                </div>
          </div>
        <div class="form-right">

          <h2>Datos del Contacto</h2>

          <div class="row regla-modal">
              <div class="col-md-12">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">


                    <div class='inputr'>
                      <div class="control-label cblanco">Nombres <span class='requerido'>*</span>:</div>
                      <div class="abajocaja">

                        <input  type="text"
                                id="nombre" name='nombre' value="{{ old('nombre') }}" placeholder="Nombre"
                                required = ""
                                autocomplete="off" class="form-control input-sm" data-aw="4"/>

                      </div>
                    </div>

                    <div class='inputr'>
                      <div class="control-label cblanco">Celular <span class='requerido'>*</span>:</div>
                      <div class="abajocaja">

                        <input  type="text"
                                id="lblcelular" name='lblcelular' value="{{ old('lblcelular') }}" placeholder="Ingrese su celular"
                                required = ""
                                data-parsley-type="number"
                                autocomplete="off" 
                                class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                data-aw="1"/>

                      </div>
                    </div>

                    <div class='inputr'>
                      <div class="control-label cblanco">Correo electronico <span class='requerido'>*</span>:</div>
                      <div class="abajocaja">

                        <input  type="email"
                                id="lblemail" name='lblemail' value="{{ old('lblemail') }}" placeholder="Ingresa tu correo electronico"
                                required = ""
                                autocomplete="off" 
                                class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                data-aw="1"/>

                      </div>
                    </div>


                    <div class='inputr'>
                      <div class="control-label cblanco">Confirmar Correo electronico <span class='requerido'>*</span>:</div>
                      <div class="abajocaja">

                        <input  type="email"
                                id="lblconfirmaremail" name='lblconfirmaremail' value="{{ old('lblconfirmaremail') }}" placeholder="Ingresa confirmacion de correo electronico"
                                required = ""
                                autocomplete="off" 
                                data-parsley-equalto="#lblemail"
                                class="form-control textpucanegro fuente-recoleta-regular input-sm"
                                data-aw="1"/>

                      </div>
                    </div>
                    <input type='hidden' id='carpeta' value="{{$capeta}}"/>
                    <input type="hidden" id="token" name="_token"  value="{{csrf_token()}}"> 



                   </div>
                </div>
          </div>

          <div class="form-group login-submit">
            <button data-dismiss="modal" type="submit"  class="btn btn-success btn-xl btn-registrated"><b>REGISTRATE</b></button>
          </div>
        </div>
        </form>
      </div>
    </div>





    <script src="{{ asset('public/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>



    <script src="{{ asset('public/lib/jquery-ui/jquery-ui.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/jquery.nestable/jquery.nestable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/moment.js/min/moment.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/datetimepicker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>        
    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap-slider/js/bootstrap-slider.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/app-form-elements.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>

    <script src="{{ asset('public/js/general/general.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/gmeta.js?v='.$version) }}" type="text/javascript"></script>

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.formElements();
        $('form').parsley();

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


    <script src="{{ asset('public/js/user/registro.js') }}" type="text/javascript"></script>

  </body>
</html>