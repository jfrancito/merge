<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="active"><a href="#oc" data-toggle="tab">ORDEN COMPRA <span class="badge badge-success" style="font-size:16px">{{count($listadatos)}}</span></a></li>
            <li><a href="#observado" data-toggle="tab">OBSERVADOS <span class="badge badge-danger" style="font-size:16px">{{count($listadatos_obs)}}</span></a></li>
            <li><a href="#observadole" data-toggle="tab">OBSERVACIONES LEVANTADAS <span class="badge badge-primary" style="font-size:16px">{{count($listadatos_obs_le)}}</span></a></li>

          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane active cont">
              @include('comprobante.lista.ajax.alistaoccon', ['id' => 'nso' , 'listadatos' => $listadatos])
            </div>
            <div id="observado" class="tab-pane cont">
              @include('comprobante.lista.ajax.alistaoccon', ['id' => 'nso_obs' , 'listadatos' => $listadatos_obs])
            </div>
            <div id="observadole" class="tab-pane cont">
              @include('comprobante.lista.ajax.alistaoccon', ['id' => 'nso_obs_le' , 'listadatos' => $listadatos_obs_le])
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