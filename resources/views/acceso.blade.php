<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="{{ asset('public/img/icono/metayy.ico') }}">

    <title>Acceso - Inicio Sessión</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('public/css/style.css') }}" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/meta.css?v='.$version) }} "/>


  </head>
  <body class="be-splash-screen">

    <div class="be-wrapper be-login">
      <div class="be-content ajaxpersonal">  
        <div class="main-content container-fluid">
          <div class="splash-acceso-container">
            <div class="panel panel-default panel-border-color panel-border-color-primary">
              <div class="panel-heading">
               
              <span class="splash-description">Por favor seleccione un acceso.</span>
              </div>
              <div class="panel-body">

                <div class="panel-body listaaccesos">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th>Empresa</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x table-hover">
                      @foreach($accesos as $item)
                        <tr class='empresa-centro {{$funcion->funciones->color_empresa($item->empresa_id)}}'
                            data-empresa='{{$item->empresa_id}}'>
                          <td>{{$item->empresa->NOM_EMPR}}</td>
                        </tr>
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
    <input type='hidden' id='carpeta' value="{{$capeta}}"/>

    <script src="{{ asset('public/lib/jquery/jquery.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">


      $(document).ready(function(){
        var carpeta = $("#carpeta").val();

      $(".listaaccesos").on('click','.empresa-centro', function(e) {

          var empresa_id      =   $(this).attr('data-empresa');
          var centro_id       =   $(this).attr('data-centro');
          window.location     =   carpeta+"/accesobienvenido/" + empresa_id;

      });

      });
    </script>


  </body>
</html>