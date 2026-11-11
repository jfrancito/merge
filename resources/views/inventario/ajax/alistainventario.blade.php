<div class="panel panel-default">
  <div class="tab-container">
    <ul class="nav nav-tabs">
      <li class="active negrita"><a href="#iconsolidado" data-toggle="tab">Inventarios Consolidados</a></li>
      <li class="negrita"><a href="#icasacara" data-toggle="tab">Arroz Cáscara por Sede</a></li>
      <li class="negrita"><a href="#ipilado" data-toggle="tab">Arroz Pilado por Sede</a></li>
      <li class="negrita"><a href="#ipacas" data-toggle="tab">Pacas</a></li>
      <li class="negrita"><a href="#ienvases" data-toggle="tab">Envases</a></li>
      <li class="negrita"><a href="#ibobinas" data-toggle="tab">Bobinas</a></li>
      <li class="negrita"><a href="#idemassumi" data-toggle="tab">Demás Suministros</a></li>
      <li class="negrita"><a href="#ienvasesprod" data-toggle="tab">Envases de Producción</a></li>
      <li class="negrita"><a href="#ienvasesdesp" data-toggle="tab">Envases de Despachos</a></li>
      <li class="negrita"><a href="#ienvasescose" data-toggle="tab">Envases Cosecheros</a></li>
      <li class="negrita"><a href="#ifertilizante" data-toggle="tab">Fertilizantes</a></li>
    </ul>

    <div class="tab-content">
      <div id="iconsolidado" class="tab-pane active cont">
        @include('inventario.ajax.aconsolidado')
      </div>
      <div id="icasacara" class="tab-pane cont">
        @include('inventario.ajax.acascara')
      </div>
      <div id="ipilado" class="tab-pane cont">
        @include('inventario.ajax.apilado')
      </div>
      <div id="ipacas" class="tab-pane cont">
        @include('inventario.ajax.apacas')
      </div>
      <div id="ienvases" class="tab-pane cont">
        @include('inventario.ajax.aenvases')
      </div>
      <div id="ibobinas" class="tab-pane cont">
        @include('inventario.ajax.abobinas')
      </div>
      <div id="idemassumi" class="tab-pane cont">
        @include('inventario.ajax.ademassuministros')
      </div>
      <div id="ienvasesprod" class="tab-pane cont">
        @include('inventario.ajax.aenvasesprod')
      </div>
      <div id="ienvasesdesp" class="tab-pane cont">
        @include('inventario.ajax.aenvasesdesp')
      </div>
      <div id="ienvasescose" class="tab-pane cont">
        @include('inventario.ajax.aenvasescose')
      </div>
      <div id="ifertilizante" class="tab-pane cont">
        @include('inventario.ajax.afertilizante')
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







