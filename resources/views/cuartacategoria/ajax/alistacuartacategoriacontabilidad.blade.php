<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="@if($tab_id=='oc') active @endif"><a href="#oc" data-toggle="tab">CUARTA CATEGORIA <span class="badge badge-success" style="font-size:16px">{{count($lrentacuartacategoria)}}</span></a></li>
          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane @if($tab_id=='oc') active @endif cont">
              @include('cuartacategoria.lista.ajax.alistacccont', ['id' => 'nso' , 'lrentacuartacategoria' => $lrentacuartacategoria])
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