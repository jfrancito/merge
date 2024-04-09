<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="{{ asset('public/img/icono/merge1.ico') }}">
    <title>Activar - Registro</title>
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
    <link rel="stylesheet" href="{{ asset('public/css/activar.css?v='.$version) }}" type="text/css"/>
  </head>
  <body class="form-v10 wrapper registroruc">
    <div class="page-content">

<aside class="profile-card">

  <header>
    <a href="{{ url('/login') }}">
      <img src="{{ asset('public/img/logoindexs.png') }}" />
    </a>
    @if(count($usuario)>0)
      <!-- the username -->
      <h1>{{$usuario->nombre}}</h1>
      <!-- and role or location -->
      <h2>{{$usuario->name}}</h2>
    @endif
  </header>

  <!-- bit of a bio; who are you? -->
  <div class="profile-bio">

    <h4>{{$mensaje}}</h4>

  </div>

  <div style="text-align:center;">
    
    <a href="{{ url('/login') }}" class="btn btn-rounded btn-space btn-primary">Ir a la pagina de inicio de session</a>

  </div>



</aside>





    </div>
  </body>
</html>