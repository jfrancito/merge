<div class="table-responsive">
    <table id="tablaconsolidadopedidogeneral"
           class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
           cellspacing="0" width="100%">
        <thead class="background-th-azul">
        <tr>
            <th><input type="checkbox" id="checkAll" /></th>
            <th>ID CONSOLIDADO</th>
            <th>EMPRESA</th>
            <th>FEC CONSOLIDADO</th>
            <th>MES</th>
            <th>FAMILIA</th>
            <th>ESTADO</th>
        </tr>
        </thead>

        <tbody>
        @foreach($listaordenpedidogeneral as $consolidado)
            @php $cabecera = $consolidado->first(); @endphp
            <tr>
                <td>
                    <input type="checkbox" name="consolidado_seleccionado[]" class="consolidado_seleccionado"
                           value="{{ $cabecera->ID_PEDIDO_CONSOLIDADO }}"
                           data-detalle='{{ json_encode($consolidado) }}'>
                </td>
                <td>{{ $cabecera->ID_PEDIDO_CONSOLIDADO }}</td>
                <td>{{ $cabecera->NOM_EMPR }}</td>
                <td>{{ $cabecera->FEC_PEDIDO }}</td>
                <td>{{ $cabecera->TXT_NOMBRE }}</td>
                <td>{{ $cabecera->NOM_CATEGORIA_FAMILIA }}</td>
                <td>{{ $cabecera->TXT_ESTADO }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>

<!-- Estilos -->
<style>
    .tabla-contenedor {
        border-radius: 10px;
        border: 1px solid #e0e6ed;
        box-shadow: 0 4px 10px rgba(0,0,0,.06);
        overflow: hidden;
    }

    .tabla-elegante thead th {
        background: #1d3a6d;
        color: #fff;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        border: none;
    }

    .tabla-elegante tbody td {
        font-size: 13px;
        vertical-align: middle;
        white-space: nowrap;
    }

    .tabla-elegante tbody tr {
        cursor: pointer;
        transition: background .2s ease;
    }

    .tabla-elegante tbody tr:hover {
        background: #f1f6ff;
    }

    .tabla-elegante tbody tr.seleccionado {
        background: #dbeafe !important;
    }
</style>

@if(isset($ajax))
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
@endif


