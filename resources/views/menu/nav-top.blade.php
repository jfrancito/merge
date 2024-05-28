
<nav class="navbar navbar-default navbar-fixed-top be-top-header {{Session::get('color_meta')}}">
  <div class="container-fluid">
    <div class="navbar-header" style="padding-top: 14px;"> 
      <div class="color-blanco"><img width="160px" style="margin-bottom: 12px" src="{{ asset('public/img/indulogo_menu.png') }}" alt="Avatar"> <span> | ({{strtoupper(Session::get('usuario')->name)}})</span></div>
    </div>

    <div class="be-right-navbar {{Session::get('color_meta')}}">
      <ul class="nav navbar-nav navbar-right be-user-nav">
        <li><div class="page-title"><span>{{Session::get('usuario')->nombre}}</span></div></li>

        <li class="dropdown">
          <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
            <img src="{{ asset('public/img/iconos_7.png') }}" alt="Avatar">
            <span class="user-name">{{Session::get('usuario')->nombre}}</span></a>
          <ul role="menu" class="dropdown-menu">
            <li>
              <div class="user-info color_azul" >
                <div class="user-name">{{Session::get('usuario')->nombre}}</div>
                <div class="user-position online">disponible</div>
              </div>
            </li>
            <li><a href="{{ url('/cambiarperfil/') }}"><span class="icon mdi mdi-settings"></span> Cambiar de perfil</a></li>
            
            <li><a href="{{ url('/cerrarsession') }}"><span class="icon mdi mdi-power"></span>Cerrar sesión</a></li>


          </ul>
        </li>
      </ul>
    </div>
      <a href="#" data-toggle="collapse" data-target="#be-navbar-collapse" class="be-toggle-top-header-menu collapsed">Opciones</a>
      <div id="be-navbar-collapse" class="navbar-collapse collapse">
      </div>
  </div>
</nav>