<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            @if($empresa_defecto === '' or $empresa_defecto === 'IACHEM0000010394')
                <li class="@if($empresa_defecto === '' or $empresa_defecto === 'IACHEM0000010394') active @endif negrita"><a href="#cenvasesii" data-toggle="tab">Ingresos / Salidas Internacional</a>
                </li>
            @endif
            @if($empresa_defecto === '' or $empresa_defecto === 'IACHEM0000007086')
                <li class="@if($empresa_defecto === 'IACHEM0000007086') active @endif negrita"><a href="#cenvasesic" data-toggle="tab">Ingresos / Salidas Comercial</a></li>
            @endif
        </ul>

        <div class="tab-content">
            @if($empresa_defecto === '' or $empresa_defecto === 'IACHEM0000010394')
                <div id="cenvasesii" class="tab-pane cont @if($empresa_defecto === '' or $empresa_defecto === 'IACHEM0000010394') active @endif">
                    @include('reporte.logistica.ajax.listaingresossalidasinternacional')
                </div>
            @endif
            @if($empresa_defecto === '' or $empresa_defecto === 'IACHEM0000007086')
                <div id="cenvasesic" class="tab-pane cont @if($empresa_defecto === 'IACHEM0000007086') active @endif">
                    @include('reporte.logistica.ajax.listaingresossalidascomercial')
                </div>
            @endif
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
