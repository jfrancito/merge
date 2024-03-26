
<nav class="navbar navbar-default navbar-fixed-top be-top-header {{Session::get('color_meta')}}">
  <div class="container-fluid">
    <div class="navbar-header"> 
      <div class="color_amarillo"><b>MERGE</b></div>
    </div>

    <div class="be-right-navbar {{Session::get('color_meta')}}">
      <ul class="nav navbar-nav navbar-right be-user-nav">
        <li><div class="page-title"><span>{{Session::get('usuario')->nombre}}</span></div></li>

        <li class="dropdown">
          <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
            <img src="{{ asset('public/img/institucion1.jpg') }}" alt="Avatar">
            <span class="user-name">{{Session::get('usuario')->nombre}}</span></a>
          <ul role="menu" class="dropdown-menu">
            <li>
              <div class="user-info color_azul" >
                <div class="user-name">{{Session::get('usuario')->nombre}}</div>
                <div class="user-position online">disponible</div>
              </div>
            </li>
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