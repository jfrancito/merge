@extends('template_lateral')
@section('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('public/lib/select2/css/select2.min.css') }} "/>
@stop
@section('section')
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-3">
              <div class="panel panel-default" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                <div class="panel-heading" style="background-color: #4285f4; color: white; padding: 15px; border: none;">
                    <h3 class="panel-title" style="margin: 0; font-weight: bold; font-size: 1.1em;">
                        <i class="mdi mdi-account-box" style="margin-right: 5px;"></i> ROLES DISPONIBLES
                    </h3>
                </div>
                <div class="panel-body" style="padding: 15px; background-color: #f8f9fa;">
                    <div class="form-group" style="margin-bottom: 15px;">
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" style="background: white;"><i class="mdi mdi-search"></i></span>
                            <input type="text" id="filterRoles" class="form-control" placeholder="Filtrar rol..." style="border-left: none;">
                        </div>
                    </div>
                    <div class="list-group menu-roles" style="margin-bottom: 0; max-height: 600px; overflow-y: auto; border: none;">
                        @foreach($listaroles as $item)
                        <a href="#" id="{{Hashids::encode(substr($item->id, -8))}}" 
                           class="list-group-item selectrol role-item" 
                           style="border-radius: 6px; margin-bottom: 4px; border: none; padding: 12px 15px; transition: all 0.3s;">
                            <i class="mdi mdi-account-circle" style="margin-right: 10px; font-size: 1.2em; color: #4285f4;"></i>
                            <b>{{$item->nombre}}</b>
                            <i class="mdi mdi-chevron-right pull-right" style="margin-top: 2px;"></i>
                        </a>
                        @endforeach
                    </div>
                </div>
              </div>
            </div>

            <style>
                .role-item:hover { background-color: #e8f0fe !important; color: #1967d2 !important; transform: translateX(5px); }
                .role-item.active { background-color: #4285f4 !important; color: white !important; box-shadow: 0 4px 10px rgba(66,133,244,0.3); }
                .role-item.active i { color: white !important; }
                .list-group-item.active:hover { color: white !important; transform: none !important; }
            </style>

            <div class="col-sm-9">
              <div class="panel panel-default">
                <div class="panel-heading panel-heading-divider">
                    <i class="mdi mdi-settings" style="margin-right: 5px;"></i> Configuración de Permisos
                    <span class="panel-subtitle">Gestione el acceso por cada opción del sistema</span>
                </div>
                <div class="panel-body listadoopciones">
                    <div class="text-center" style="padding: 50px; color: #aaa;">
                        <i class="mdi mdi-account-key" style="font-size: 5em; display: block;"></i>
                        <p style="font-size: 1.2em; margin-top: 15px;">Seleccione un rol de la izquierda para ver sus permisos</p>
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
@stop

@section('script')

    <script type="text/javascript">
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        $('[data-toggle="tooltip"]').tooltip(); 

        // Filtro de roles
        $("#filterRoles").on("keyup", function() {
            var value = $(this).val().toLowerCase();
            $(".menu-roles a").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
            });
        });

      });
    </script>

    <script src="{{ asset('public/lib/select2/js/select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('public/js/user/user.js?v='.$version) }}" type="text/javascript"></script> 
@stop