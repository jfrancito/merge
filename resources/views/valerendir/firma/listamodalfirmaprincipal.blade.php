<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            <li class="active negrita">
                <a href="#pendientes" data-toggle="tab">
                    <span class="badge badge-primary" style="margin-right: 8px; font-size: 16px;">&nbsp;&nbsp;</span>
                    PENDIENTES
                </a>
            </li>
            <li class="negrita">
                <a href="#aprobados" data-toggle="tab">
                    <span class="badge badge-success" style="margin-right: 8px; font-size: 16px;">&nbsp;&nbsp;</span>
                    FIRMADOS
                </a>
            </li>
        </ul>
        
        <div class="tab-content">
           
                <div id="pendientes" class="tab-pane cont active">
                @include('valerendir.firma.listamodalfirmavalerendir', ['pendientes' => $pendientes])
                </div>
                <div id="aprobados" class="tab-pane cont">
                 @include('valerendir.firma.listamodalfirmavalerendiraprobados', ['aprobados' => $aprobados])
                </div>
        </div>

    </div>
</div>
