<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="<?php echo e(asset('public/img/icono/merge1.ico')); ?>">
    <title><?php echo e($titulo); ?></title>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/font-awesome.min.css')); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/scroll/css/scroll.css')); ?> "/>

    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->


    <?php echo $__env->yieldContent('style'); ?>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/jquery-confirm.min.css')); ?> "/>

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/style.css?v='.$version)); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/meta.css?v='.$version)); ?> "/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/ugel.css?v='.$version)); ?> " />

    <style type="text/css">
        
        .libre-baskerville-regular { font-family: "Libre Baskerville", serif; peso de fuente: 400; estilo de fuente: normal; } 
        .libre-baskerville-bold { font-family: "Libre Baskerville", serif; peso de fuente: 700; estilo de fuente: normal; } 
        .libre-baskerville-regular-italic { font-family: "Libre Baskerville", serif; peso de fuente: 400; estilo de fuente: cursiva; }

        .btn-detalle-moderno {
            background: linear-gradient(135deg, #1d3a6d 0%, #3b82f6 100%) !important;
            border: none !important;
            border-radius: 15px !important;
            padding: 5px 14px !important;
            font-weight: 600 !important;
            color: white !important;
            box-shadow: 0 3px 8px rgba(29, 58, 109, 0.3) !important;
            transition: all 0.2s ease-in-out !important;
            display: inline-flex !important;
            align-items: center !important;
            justify-content: center !important;
            gap: 5px !important;
            text-decoration: none !important;
        }
        .btn-detalle-moderno:hover {
            transform: translateY(-1.5px) !important;
            box-shadow: 0 5px 12px rgba(29, 58, 109, 0.4) !important;
            filter: brightness(1.08) !important;
            color: white !important;
        }
        .btn-detalle-moderno:active {
            transform: translateY(0) !important;
        }
    </style>


  </head>
  <body class='fuente-muktabold libre-baskerville-regular'>


    <div class="be-wrapper  be-fixed-sidebar libre-baskerville-regular">

        <?php echo $__env->make('success.ajax-alert', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('success.bienhecho', ['bien' => Session::get('bienhecho')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('error.erroresurl', ['error' => Session::get('errorurl')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('error.erroresbd', ['error' => Session::get('errorbd')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('menu.nav-top', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('menu.nav-left', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->make('success.xml', ['xml' => Session::get('xmlmsj')], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>

        <?php echo $__env->yieldContent('section'); ?>

         <input type='hidden' id='carpeta' value="<?php echo e($capeta); ?>"/>
         <input type="hidden" id="token" name="_token"  value="<?php echo e(csrf_token()); ?>"> 
    </div>


    <script src="<?php echo e(asset('public/lib/jquery/jquery-2.1.3.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/perfect-scrollbar/js/perfect-scrollbar.jquery.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/main.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/bootstrap/dist/js/bootstrap.min.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/scroll/js/jquery.mousewheel.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/scroll/js/jquery-scrollpanel-0.7.0.js')); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/lib/scroll/js/scroll.js')); ?>" type="text/javascript"></script>   
    <script src="<?php echo e(asset('public/js/general/general.js?v='.$version)); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/gmeta.js?v='.$version)); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/general/jquery-confirm.min.js?v='.$version)); ?>" type="text/javascript"></script>
    <script src="<?php echo e(asset('public/js/comprobante/datospc.js?v='.$version)); ?>" type="text/javascript"></script>

    <?php echo $__env->yieldContent('script'); ?>
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