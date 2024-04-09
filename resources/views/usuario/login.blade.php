<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="{{ asset('public/img/icono/merge1.ico') }}">



    <title>Merge - Inicio Sessión</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('public/css/style.css?v='.$version) }}" type="text/css"/>
    <style type="text/css">
      .alertaw{
          width: 50%;
          z-index: 1;
          /* float: right; */
          margin-bottom: 0px;
          position: absolute;
          right: 22px;
          top: 0px;
      }
      .alertaw_error{
          width: 50%;
          z-index: 1;
          /* float: right; */
          margin-bottom: 0px;
          position: absolute;
          right: 22px;
          top: 0px;
      }

    </style>

  </head>
  <body class="be-splash-screen login-top">

    @include('success.ajax-alert')
    @include('success.bienhecho', ['bien' => Session::get('bienhecho')])
    @include('error.erroresurl', ['error' => Session::get('errorurl')])
    @include('error.erroresbd', ['id' => Session::get('errorbd')  , 'error' => Session::get('errorbd'), 'data' => '2'])

    <div class="be-wrapper be-login">
      <div class="be-content ajaxpersonal">  
        <div class="main-content container-fluid" style="padding: 0px;">
          <div class="splash-container" style="margin: 0px auto;">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading" style="margin-bottom: 0px;">
                
              <img src="{{ asset('public/img/merge1.png') }}" alt="logo" width="150" height="130" class="logo-img">
              <span class="splash-description"><b>PLATAFORMA PARA REGISTRO COMPROBANTE</b></span>
              </div>
              <div class="panel-body">

                <form method="POST" action="{{ url('login') }}">
                  {{ csrf_field() }}

                  <div class="form-group">

                    <input id="name" name='name' type="text" required = "" value="{{ old('name') }}"  placeholder="Usuario" autocomplete="off" class="form-control" data-aw="1"/>

                    @include('error.erroresvalidate', [ 'id' => $errors->has('name')  , 
                                                        'error' => $errors->first('name', ':message') , 
                                                        'data' => '1'])


                  </div>

                  <div class="form-group">
                    <input id="password" name='password' type="password" required = ""   placeholder="Clave" class="form-control" data-aw="2"/>
                    @include('error.erroresvalidate', ['id' => $errors->has('name')  , 'error' => $errors->first('name', ':message'), 'data' => '2'])


                  </div>

                  <div class="form-group login-submit">

                    <button data-dismiss="modal" type="submit"  class="btn btn-primary btn-xl">Inicia sesión</button>
                    <a href="{{ url('/registrate') }}" type="button"  class="btn btn-success btn-xl" style="margin-top: 15px;">Registrate</a>

                  </div>

                  <input type='hidden' id='carpeta' value="{{$capeta}}"/>
                  <input type="hidden" id="token"  class ="ocultar" name="_token"  value="{{ csrf_token() }}">

                </form>
                
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('public/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/parsley/parsley.js') }}" type="text/javascript"></script>


    <script type="text/javascript">
      $(document).ready(function(){
        App.init();
        $('form').parsley();
      });
    </script>

    <script src="{{ asset('public/js/user/user.js') }}" type="text/javascript"></script>

  </body>
</html>