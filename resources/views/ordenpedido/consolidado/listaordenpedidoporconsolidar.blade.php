<!-- resources/views/ordenpedido/consolidado/listaordenconsolidado.blade.php -->

<div class="table-responsive">
    <table id="tablaconsolidadopedido"
           class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
           cellspacing="0" width="100%">
        <thead class="background-th-azul">
        <tr>
            <th><input type="checkbox" id="checkAll" /></th>
            <th>ID PEDIDO</th>
            <th>ESTADO</th>
            <th>FEC PEDIDO</th>
            <th>AREA</th>
            <th>GLOSA</th>
            <th>SOLICITA</th>
            <th>AUTORIZA</th>
            <th>APRUEBA ADM</th>
            <th class="text-center">ARCHIVOS</th>
        </tr>
        </thead>

        <tbody>
        @foreach($listaordenpedido as $pedido)
            @php $cabecera = $pedido->first(); @endphp
            <tr>
                <td>
                    <input type="checkbox" name="pedido_seleccionado[]" class="pedido_seleccionado"
                           value="{{ $cabecera->ID_PEDIDO }}">
                </td>
                <td>{{ $cabecera->ID_PEDIDO }}</td>
                <td>{{ $cabecera->TXT_ESTADO }}</td>
                <td>{{ $cabecera->FEC_PEDIDO }}</td>
                <td>{{ $cabecera->TXT_AREA }}</td>
                <td>{{ $cabecera->TXT_GLOSA }}</td>
                <td>{{ $cabecera->TXT_TRABAJADOR_SOLICITA }}</td>
                <td>{{ $cabecera->TXT_TRABAJADOR_AUTORIZA }}</td>
                <td>{{ $cabecera->TXT_TRABAJADOR_APRUEBA_ADM }}</td>
                <td class="text-center">
                    @if(isset($cabecera->MULTI_ARCHIVOS) && $cabecera->MULTI_ARCHIVOS != '')
                        @php
                            $archivos_raw = explode(' [SEP] ', $cabecera->MULTI_ARCHIVOS);
                            $archivos = [];
                            foreach($archivos_raw as $ar) {
                                $partes = explode(' [FLD] ', $ar);
                                if(count($partes) == 2) {
                                    $archivos[] = ['nombre' => $partes[0], 'url' => $partes[1]];
                                }
                            }
                        @endphp

                        @if(count($archivos) > 1)
                            <div class="btn-group">
                                <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown">
                                    <i class="fa fa-download"></i> Archivo <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                    @foreach($archivos as $index => $arch)
                                        <li>
                                            <a href="{{ url('descargar-archivo-informe/'.base64_encode($arch['url'])) }}" target="_blank">
                                                {{ ($index + 1) . '. ' . $arch['nombre'] }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        @elseif(count($archivos) == 1)
                            <a href="{{ url('descargar-archivo-informe/'.base64_encode($archivos[0]['url'])) }}"
                               class="btn btn-xs btn-success"
                               target="_blank"
                               title="Descargar: {{ $archivos[0]['nombre'] }}">
                                <i class="fa fa-download"></i> Archivo
                            </a>
                        @endif
                    @else
                        <span class="text-muted">—</span>
                    @endif
                </td>
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

<!-- Scripts -->
<script>
    // JSON seguro para JS (Se asigna a window para que ordenpedido.js lo vea)
    window.pedidosData = {!! json_encode($listaordenpedido->map(function($items) {
        return $items->toArray();
    }), JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) !!};
</script>

@if(isset($ajax))
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
@endif
