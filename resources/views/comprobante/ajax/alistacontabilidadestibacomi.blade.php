
<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="@if($tab_id=='oc') active @endif"><a href="#oc" data-toggle="tab">{{$operacion_id}} <span class="badge badge-success" style="font-size:16px">{{count($listadatos)}}</span></a></li>
            <li class="@if($tab_id=='observado') active @endif"><a href="#observado" data-toggle="tab">OBSERVADOS <span class="badge badge-danger" style="font-size:16px">{{count($listadatos_obs)}}</span></a></li>
            <li class="@if($tab_id=='observadole') active @endif"><a href="#observadole" data-toggle="tab">OBSERVACIONES LEVANTADAS <span class="badge badge-primary" style="font-size:16px">{{count($listadatos_obs_le)}}</span></a></li>

          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane @if($tab_id=='oc') active @endif cont">

              @include('comprobante.lista.ajax.alistaestibacomcon', ['id' => 'nso' , 'listadatos' => $listadatos])

            </div>
            <div id="observado" class="tab-pane @if($tab_id=='observado') active @endif cont">

              @include('comprobante.lista.ajax.alistaestibacomcon', ['id' => 'nso_obs' , 'listadatos' => $listadatos_obs])

            </div>

            <div id="observadole" class="tab-pane @if($tab_id=='observadole') active @endif cont">

              @include('comprobante.lista.ajax.alistaestibacomcon', ['id' => 'nso_obs_le' , 'listadatos' => $listadatos_obs_le])

            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>



@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
@endif
