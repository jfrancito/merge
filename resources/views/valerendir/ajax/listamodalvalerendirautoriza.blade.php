<div class="panel panel-default">
    <div class="tab-container">
      <ul class="nav nav-tabs">
            <li class="active negrita">
                <a href="#pendientes" data-toggle="tab">
                    <span class="badge badge-warning" style="margin-right: 8px; font-size: 16px;">&nbsp;&nbsp;</span>
                    PENDIENTES
                </a>
            </li>
            <li class="negrita">
                <a href="#autorizados" data-toggle="tab">
                    <span class="badge badge-success" style="margin-right: 8px; font-size: 16px;">&nbsp;&nbsp;</span>
                    AUTORIZADOS
                </a>
            </li>
            <li class="negrita">
                <a href="#rechazados" data-toggle="tab">
                    <span class="badge badge-danger" style="margin-right: 8px; font-size: 16px;">&nbsp;&nbsp;</span>
                    RECHAZADOS
                </a>
            </li>
        </ul>

        <div class="tab-content">
           
                <div id="pendientes" class="tab-pane cont active">
                   @include('valerendir.ajax.listamodalvalerendirautorizapendiente')
                </div>
                <div id="autorizados" class="tab-pane cont">
                   @include('valerendir.ajax.listamodalvalerendirautorizado')
                </div>
                 <div id="rechazados" class="tab-pane cont">
                   @include('valerendir.ajax.listamodalvalerendirrechazadoautorizado')
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



