@extends('template_lateral')
@section('style')
   
@stop
@section('section')
      <div class="be-content">
        <div class="main-content container-fluid">
          <div class="row">
            <div class="col-sm-12">
              <!--Dropdowns-->
              <div class="panel panel-default">
                <div class="panel-heading panel-heading-divider">Permisos<span class="panel-subtitle">Lista de roles para dar permisos (seleccione un rol)</span></div>
                <div class="panel-body">
                  <h4 class="xs-mb-20">Roles</h4>
                  <div class="row dropdown-showcase">
                    <!--Basic Dropdown-->
                    <div class="showcase col-xs-3">
                      <div class="dropdown">
                        <ul style="display: block; position: relative;" class="dropdown-menu menu-roles">
                          @foreach($listaroles as $item)
                             <li ><a href="#"  id="{{Hashids::encode(substr($item->id, -8))}}" class='selectrol'>{{$item->nombre}}</a></li>
                          @endforeach  
                        </ul> 
                      </div>
                    </div>


                    <div class="panel panel-default col-xs-8">
                      <div class="panel-body listadoopciones">

                      </div>
                    </div>

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
      });
    </script>

    <script src="{{ asset('public/js/user/user.js?v='.$version) }}" type="text/javascript"></script> 
@stop