<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
          
                <li class="active negrita"><a href="#pendientes" data-toggle="tab">PENDIENTES</a></li>
                <li class="negrita"><a href="#autorizados" data-toggle="tab">APROBADOS</a></li>
        
           
        </ul>
        <div class="tab-content">
           
                <div id="pendientes" class="tab-pane cont active">
                   @include('valerendir.ajax.listamodalvalerendirapruebapendiente')
                </div>
                <div id="autorizados" class="tab-pane cont">
                   @include('valerendir.ajax.listamodalvalerendiraprobado')
                </div>
           
        </div>

    </div>
</div>

@if(isset($ajax))
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
@endif



