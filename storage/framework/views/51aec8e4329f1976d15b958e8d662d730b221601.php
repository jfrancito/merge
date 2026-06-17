<!doctype html>
<html lang="<?php echo e(app()->getLocale()); ?>">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="Sistemas de Ventas">
    <meta name="author" content="Jorge Francelli Saldaña Reyes">
    <link rel="icon" href="<?php echo e(asset('public/img/icono/merge1.ico')); ?>">



    <title>Merge - Acceso</title>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/perfect-scrollbar/css/perfect-scrollbar.min.css')); ?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css')); ?> "/>
    
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="<?php echo e(asset('public/css/style.css?v='.$version)); ?>" type="text/css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('public/css/meta.css?v='.$version)); ?> "/>


  </head>
  <body class="be-splash-screen acceso-top">

    <div class="be-wrapper be-login ">
      <div class="be-content ajaxpersonal">  
        <div class="main-content container-fluid">
          <div class="splash-acceso-container ">
            <div class="panel panel-default panel-border-color panel-border-color-primary color-azul-indu">
              <div class="panel-heading">
               
              <span class="splash-description color-blanco"><b>POR FAVOR SELECCIONE UN ACCESO</b></span>
              </div>
              <div class="panel-body">

                <div class="panel-body listaaccesos">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th class="center color-blanco">EMPRESA</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x table-hover">
                      <?php $__currentLoopData = $accesos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr class='empresa-centro <?php echo e($funcion->funciones->color_empresa($item->empresa_id)); ?>'
                            data-empresa='<?php echo e($item->empresa_id); ?>'>
                          <td><?php echo e($item->empresa->NOM_EMPR); ?></td>
                        </tr>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>
                </div>

             
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <input type='hidden' id='carpeta' value="<?php echo e($capeta); ?>"/>

    <script src="<?php echo e(asset('public/lib/jquery/jquery.min.js')); ?>" type="text/javascript"></script>
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