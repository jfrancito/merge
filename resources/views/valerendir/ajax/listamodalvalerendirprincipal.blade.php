<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
                <li class="active negrita"><a href="#generados" data-toggle="tab">Generados</a></li>
        </ul>
        <div class="tab-content">
                  <div id="generados" class="tab-pane cont active">
                   @include('valerendir.ajax.listamodalvalerendir')
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



