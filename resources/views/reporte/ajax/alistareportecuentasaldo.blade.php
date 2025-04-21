<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            @if($todos === '' or $todos === 'C')
                <li class="active negrita"><a href="#ccobrar" data-toggle="tab">Cuentas por Cobrar Terceros</a></li>
                <li class="negrita"><a href="#ccobrarrel" data-toggle="tab">Cuentas por Cobrar Relacionadas</a></li>
            @endif
            @if($todos === '' or $todos === 'P')
                <li class="negrita"><a href="#cpagar" data-toggle="tab">Cuentas por Pagar Terceros</a></li>
                <li class="negrita"><a href="#cpagarrel" data-toggle="tab">Cuentas por Pagar Relacionadas</a></li>
            @endif
        </ul>

        <div class="tab-content">
            @if($todos === '' or $todos === 'C')
                <div id="ccobrar" class="tab-pane cont active">
                    @include('reporte.ajax.listacuentascobrarterceros')
                </div>
                <div id="ccobrarrel" class="tab-pane cont">
                    @include('reporte.ajax.listacuentascobrarrelacionadas')
                </div>
            @endif
            @if($todos === '' or $todos === 'P')
                <div id="cpagar" class="tab-pane cont">
                    @include('reporte.ajax.listacuentaspagarterceros')
                </div>
                <div id="cpagarrel" class="tab-pane cont">
                    @include('reporte.ajax.listacuentaspagarrelacionadas')
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
