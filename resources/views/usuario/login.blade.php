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
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/material-design-icons/css/material-design-iconic-font.min.css') }} "/>
    <link rel="stylesheet" type="text/css" href="{{ asset('public/css/font-awesome.min.css') }} "/>
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="{{ asset('public/css/style.css?v='.$version) }}" type="text/css"/>
    <link rel="stylesheet" href="{{ asset('public/css/login.css?v='.$version) }}" type="text/css"/>


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
            <div class="panel panel-default panel-border-color ">
              
              <div class="tab-container color-azul-indu" >
                <ul class="nav nav-tabs color-azul-indu">
                  <li class="active"><a href="#login" data-toggle="tab"><b>LOGIN</b></a></li>
                  <li><a href="#contactanos" data-toggle="tab"><b>CONTACTANOS</b></a></li>
                </ul>
                <div class="tab-content card color-azul-indu">
                  <div id="login" class="tab-pane active cont box">

                    <div class="panel-heading" style="margin-bottom: 0px;">
                    <img src="{{ asset('public/img/indulogo.png') }}" alt="logo" width="150" height="130" class="logo-img">
                    <span class="splash-description color-blanco"><b>PLATAFORMA PARA REGISTRO COMPROBANTE</b></span>
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

                          <button data-dismiss="modal" type="submit"  class="btn btn-primary btn-xl background-amarillo color-negro border-color-amarillo"><b>INICIO SESSION</b></button>
                          <a href="{{ url('/registrate') }}" type="button"  class="btn btn-success btn-xl background-rojo color-blanco border-color-rojo" style="margin-top: 15px;"><b>REGISTRATE</b></a>

                        </div>

                        <input type='hidden' id='carpeta' value="{{$capeta}}"/>
                        <input type="hidden" id="token"  class ="ocultar" name="_token"  value="{{ csrf_token() }}">

                      </form>
                
                    </div>

                    <span>
                        <ul>
                            <li><a href="https://www.facebook.com/induamericasl" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href="https://x.com/induamerica_sac?lang=es" target="_blank"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.linkedin.com/company/induamerica-servicios-logisticos/" target="_blank"><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href="https://www.instagram.com/induamerica.peru?igsh=bGg0YzdrbnJxdWM=" target="_blank"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        </ul>
                        <strong style="color: #FFCC00 !important;">MERGE</strong>
                    </span>

                    <div class="row">
                      <div class="col-md-6">
                        <!-- ¿Olvidates tu contraseña? -->
                      </div>
                      <div class="col-md-6">
                        <a href="{{ url('/descargar-manual/') }}" class="color-blanco" target="_blank">DESCARGAR MANUAL</a>
                      </div>
                    </div>


                  </div>
                  <div id="contactanos" class="tab-pane cont">
                      <div class="row profile">


                          <div class="col-md-12">
                            <p style="margin-top:10px;font-size: 15px;" class="color-blanco"><b>Email :</b> <a class="color-blanco" href= "mailto: helpdeskia@induamerica.com.pe">helpdeskia@induamerica.com.pe</a> </p>

                            <div class="profile-sidebar background-amarillo color-blanco">
                              <!-- SIDEBAR USERPIC -->
                              <div class="profile-userpic">
                                <img src="{{ asset('public/img/jl.jpg')}}" class="img-responsive" alt="">
                              </div>
                              <!-- END SIDEBAR USERPIC -->
                              <!-- SIDEBAR USER TITLE -->
                              <div class="profile-usertitle">
                                <div class="profile-usertitle-name color-negro">
                                  Jose Luis Neciosup Millones
                                </div>
                                <div class="profile-usertitle-job color-negro">
                                  Analista Programador (+51 988910599)
                                </div>
                              </div>
                              <!-- END SIDEBAR USER TITLE -->
                              <!-- SIDEBAR BUTTONS -->
                              <div class="profile-userbuttons">
                                <a href="https://api.whatsapp.com/send/?phone=51988910599" target="_blank" type="button" class="btn btn-success btn-sm">Whatsapp</a>

                              </div>
                            </div>
                            <div class="profile-sidebar background-rojo">
                              <!-- SIDEBAR USERPIC -->
                              <div class="profile-userpic">
                                <img src="{{ asset('public/img/jf.jpg')}}" class="img-responsive" alt="">
                              </div>
                              <!-- END SIDEBAR USERPIC -->
                              <!-- SIDEBAR USER TITLE -->
                              <div class="profile-usertitle">
                                <div class="profile-usertitle-name color-blanco">
                                  Jorge Francelli Saldaña Reyes
                                </div>
                                <div class="profile-usertitle-job color-blanco">
                                  Analista Programador (+51 979820173)
                                </div>
                              </div>
                              <!-- END SIDEBAR USER TITLE -->
                              <!-- SIDEBAR BUTTONS -->
                              <div class="profile-userbuttons">
                                <a href="https://api.whatsapp.com/send/?phone=51979820173" target="_blank" type="button" class="btn btn-success btn-sm">Whatsapp</a>
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