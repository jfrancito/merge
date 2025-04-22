<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            @if($todos === '' or $todos === 'IACHEM0000010394')
                <li class="@if($todos === '' or $todos === 'IACHEM0000010394') active @endif negrita"><a
                            href="#cenvasesii" data-toggle="tab">Compras Internacional</a>
                </li>
            @endif
            @if($todos === '' or $todos === 'IACHEM0000007086')
                <li class="@if($todos === 'IACHEM0000007086') active @endif negrita"><a href="#cenvasesic"
                                                                                        data-toggle="tab">Compras
                        Comercial</a></li>
            @endif
        </ul>

        <div class="tab-content">
            @if($todos === '' or $todos === 'IACHEM0000010394')
                <div id="cenvasesii"
                     class="tab-pane cont @if($todos === '' or $todos === 'IACHEM0000010394') active @endif">
                    @include('reporte.logistica.ajax.listacomprasenvasesinternacional')
                </div>
            @endif
            @if($todos === '' or $todos === 'IACHEM0000007086')
                <div id="cenvasesic" class="tab-pane cont @if($todos === 'IACHEM0000007086') active @endif">
                    @include('reporte.logistica.ajax.listacomprasenvasescomercial')
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
