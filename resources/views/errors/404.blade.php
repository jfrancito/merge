<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas multiplataforma">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">

    <link rel="icon" href="{{ asset('public/img/icono/favicon.ico') }}">    
    <title>404</title>


    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/style.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/alfasweb.css') }} "/>
  </head>
  <body class="be-splash-screen">
    <div class="be-wrapper be-error be-error-404">
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="error-container">
            <div class="error-number">404</div>
            <div class="error-description">La página que está buscando podría haberse eliminado.</div>
            <div class="error-goback-text">¿Te gustaría ir al inicio?</div>
            <div class="error-goback-button"><a href="{{ url('/bienvenido') }}" class="btn btn-xl btn-primary">Vamos a inicio</a></div>

          </div>
        </div>
      </div>
    </div>
    <script src="{{ asset('public/lib/jquery/jquery-2.1.3.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
      $(document).ready(function(){
      	//initialize the javascript
      	App.init();
      });
      
    </script>
  </body>
</html>