<!doctype html>
<html lang="{{ app()->getLocale() }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="{{ asset('public/img/icono/merge1.ico') }}">
    <title>{{$titulo}}</title>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/font-awesome.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/scroll/css/scroll.css') }} "/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    @yield('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/jquery-confirm.min.css') }} "/>

    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/style.css?v='.$version) }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/meta.css?v='.$version) }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/ugel.css?v='.$version) }} " />

    <style type="text/css">
        
        .libre-baskerville-regular { font-family: "Libre Baskerville", serif; peso de fuente: 400; estilo de fuente: normal; } 
        .libre-baskerville-bold { font-family: "Libre Baskerville", serif; peso de fuente: 700; estilo de fuente: normal; } 
        .libre-baskerville-regular-italic { font-family: "Libre Baskerville", serif; peso de fuente: 400; estilo de fuente: cursiva; }

    </style>


  </head>
  <body class='fuente-muktabold libre-baskerville-regular'>


    <div class="be-wrapper  be-fixed-sidebar libre-baskerville-regular">

        @include('success.ajax-alert')
        @include('success.bienhecho', ['bien' => Session::get('bienhecho')])
        @include('error.erroresurl', ['error' => Session::get('errorurl')])
        @include('error.erroresbd', ['error' => Session::get('errorbd')])

        @include('menu.nav-top')
        @include('menu.nav-left')

        @include('success.xml', ['xml' => Session::get('xmlmsj')])

        @yield('section')

         <input type='hidden' id='carpeta' value="{{$capeta}}"/>
         <input type="hidden" id="token" name="_token"  value="{{ csrf_token() }}"> 
    </div>


    <script src="{{ asset('public/lib/jquery/jquery-2.1.3.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/main.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/bootstrap/dist/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/scroll/js/jquery.mousewheel.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/scroll/js/jquery-scrollpanel-0.7.0.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/lib/scroll/js/scroll.js') }}" type="text/javascript"></script>   
    <script src="{{ asset('public/js/general/general.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/gmeta.js?v='.$version) }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/general/jquery-confirm.min.js?v='.$version) }}" type="text/javascript"></script>
    @yield('script')
    <link href="https://cdn.jsdelivr.net/npm/@n8n/chat/dist/style.css" rel="stylesheet" />
<!--     <script type="module">
      import { createChat } from 'https://cdn.jsdelivr.net/npm/@n8n/chat/dist/chat.bundle.es.js';

      createChat({
        webhookUrl: 'http://localhost:5678/webhook/b716d80a-c305-4b4b-98c1-e61e5f2c77c7/chat'
      });

      // Esperar a que el chat se cargue y modificar textos
      setTimeout(() => {
        document.querySelector('.chat-heading h1').innerText = "¡Hola! 👋";
        document.querySelector('.chat-header p').innerText = "Inicia una conversación. Estamos aquí para ayudarte 24/7.";
        
        const botMessages = document.querySelectorAll('.chat-message-from-bot .chat-message-markdown p');
        if (botMessages.length > 0) {
          botMessages[0].innerText = "¡Hola! 👋";
          if (botMessages.length > 1) {
            botMessages[1].innerText = "Me llamo Chalancito. ¿En qué puedo ayudarte hoy?";
          }
        }

        document.querySelector('.chat-input textarea').setAttribute('placeholder', "Escribe tu pregunta...");
      }, 3000); // Asegura que el chat esté completamente cargado
    </script>
 -->

  </body>
</html>