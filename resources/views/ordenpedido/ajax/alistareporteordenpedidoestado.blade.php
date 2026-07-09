<style>
    #reporteordenpedidoestado th {
        white-space: normal !important;
        line-height: 1.2 !important;
        font-size: 11px !important;
        max-width: 120px !important;
        text-align: center !important;
        vertical-align: middle !important;
    }
</style>
<table id="reporteordenpedidoestado"
       class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap "
       cellspacing="0" width="100%">
    <thead class="background-th-azul">
    <tr>
        <th class="text-center">ID<br>PEDIDO</th>
        <th class="text-center">AREA</th>
        <th class="text-center">FECHA<br>PEDIDO</th>
        <th class="text-center">AÑO</th>
        <th class="text-center">PERIODO</th>
        <th class="text-center">TIPO<br>PEDIDO</th>
        <th class="text-center">CENTRO</th>
        <th class="text-center">ESTADO</th>
        <th class="text-center">USUARIO<br>SOLICITA</th>
        <th class="text-center">JEFE<br>AUTORIZA</th>
        <th class="text-center">APRUEBA GERENCIA<br>DE AREA</th>
        <th class="text-center">APRUEBA GERENCIA ADM<br>O JEFE DE COMPRAS</th>
        <th class="text-center">GLOSA</th>
        <th class="text-center">CONSOLIDADO<br>SEDE</th>
        <th class="text-center">CONSOLIDADO<br>GENERAL</th>
        <th class="text-center">ARCHIVO</th>
    </tr>
    </thead>
    <tbody>
    @foreach($resultado as $index => $item)
        <tr class="fila-pedido" 
            data-id="{{$item->ID_PEDIDO}}" 
            style="cursor: pointer;"
            title="Doble clic para ver detalle">
            <td>{{$item->ID_PEDIDO}}</td>
            <td>{{$item->NOM_AREA}}</td>
            <td class="align-center-tb">{{$item->FEC_PEDIDO}}</td>
            <td>{{$item->COD_ANIO}}</td>
            <td>{{$item->NOM_PERIODO}}</td>
            <td>{{$item->TXT_TIPO_PEDIDO}}</td>
            <td>{{$item->NOM_CENTRO}}</td>
            <td>
                @if(isset($item->COD_ESTADO) && $item->COD_ESTADO == 'ETM0000000000015' && isset($item->COD_TRABAJADOR_APRUEBA_ADM) && $item->COD_TRABAJADOR_APRUEBA_ADM == 'IITR000000000391')
                    POR APROBAR GERENCIA ADM
                @else
                    {{$item->TXT_ESTADO}}
                @endif
            </td>
            <td>{{$item->TXT_TRABAJADOR_SOLICITA}}</td>
            <td>{{$item->TXT_TRABAJADOR_AUTORIZA ?: '—'}}</td>
            <td>{{$item->TXT_TRABAJADOR_APRUEBA_GER ?: '—'}}</td>
            <td>{{$item->TXT_TRABAJADOR_APRUEBA_ADM ?: '—'}}</td>
            <td>{{$item->TXT_GLOSA}}</td>
            <td>{{$item->ID_PEDIDO_CONSOLIDADO}}</td>
            <td>{{$item->ID_PEDIDO_CONSOLIDADO_GENERAL}}</td>
            <td class="align-center-tb">
                @if(isset($item->MULTI_ARCHIVOS) && $item->MULTI_ARCHIVOS != '')
                    @php
                        $archivos_raw = explode(' [SEP] ', $item->MULTI_ARCHIVOS);
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
                            <button type="button" class="btn btn-xs btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
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
@if(isset($ajax))
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
@endif
