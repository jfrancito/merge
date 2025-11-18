<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="@if($tab_id=='oc') active @endif"><a href="#oc" data-toggle="tab">MOVILIDAD IMPULSO <span class="badge badge-success" style="font-size:16px">{{count($listadatos)}}</span></a></li>
          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane @if($tab_id=='oc') active @endif cont">
              @include('planillamovilidad.lista.ajax.alistamvfirma', ['id' => 'nso' , 'listadatos' => $listadatos])
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