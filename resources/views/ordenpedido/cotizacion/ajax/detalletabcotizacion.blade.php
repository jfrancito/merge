@php
    $id_cotizacion = $cotizacion->ID_COTIZACION;
    $fecha = date('d-m-Y', strtotime($cotizacion->FEC_COTIZACION));
    $proveedor = $cotizacion->NOM_EMPR_PROVEEDOR;
    $ruc = $cotizacion->NRO_RUC;
    $moneda = $cotizacion->TXT_CATEGORIA_MONEDA;
    $total = number_format($cotizacion->CAN_TOTAL, 2);
    $estado = $cotizacion->TXT_ESTADO;
    $tipo_pago = $cotizacion->TXT_CATEGORIA_TIPO_PAGO;
@endphp

<div class="row">
    <div class="col-md-12">
        <!-- CONTENEDOR PRINCIPAL CON ESTÉTICA CORPORATIVA PREMIUM -->
        <div class="panel panel-default shadow-lg"
            style="border-radius: 15px; border: 1px solid #e3e6f0; background: #fff; overflow: hidden; margin-bottom: 30px;">

            <!-- ENCABEZADO CORPORATIVO CON FONDO AZUL PROFUNDO -->
            <div class="panel-heading"
                style="background: linear-gradient(135deg, #1d3a6d 0%, #122a52 100%); border-bottom: none; padding: 35px 25px; position: relative; color: white;">
                <div class="row align-items-center">
                    <div class="col-md-8">
                        <h2 class="fw-bold"
                            style="color: white; font-size: 26px; margin: 0 0 10px 0; letter-spacing: -0.5px; text-transform: uppercase;">
                            <i class="mdi mdi-file-document"></i> Detalle de Cotización
                        </h2>
                        <div style="display: flex; align-items: center; gap: 20px; flex-wrap: wrap;">
                            <span
                                style="font-size: 15px; color: rgba(255,255,255,0.9); font-weight: 500; background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2);">
                                <i class="fa fa-tag me-1"></i> ID: <b>{{ $id_cotizacion }}</b>
                            </span>
                            <span
                                style="font-size: 15px; color: rgba(255,255,255,0.9); font-weight: 500; background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2);">
                                <i class="fa fa-calendar me-1"></i> Fecha: <b>{{ $fecha }}</b>
                            </span>
                            <span
                                style="font-size: 15px; color: rgba(255,255,255,0.9); font-weight: 500; background: rgba(255,255,255,0.1); padding: 4px 12px; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2);">
                                <i class="fa fa-money me-1"></i> Moneda: <b>{{ $moneda }}</b>
                            </span>
                        </div>
                    </div>
                    <div class="col-md-4 text-right">
                        <button class="btn btn-default"
                            style="background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.3); color: white; padding: 8px 20px; border-radius: 10px; font-weight: 600; transition: all 0.3s;"
                            onclick="cerrarDetalleCotizacionTab();">
                            <i class="fa fa-arrow-left"></i> Volver al Listado
                        </button>
                    </div>
                </div>
            </div>

            <div class="panel-body" style="padding: 30px;">

                <!-- INFORMACIÓN DEL PROVEEDOR Y PAGOS -->
                <div class="row" style="margin-bottom: 30px;">
                    <div class="col-md-7">
                        <div
                            style="background: #f8f9fc; border-radius: 12px; padding: 20px; border: 1px solid #eaecf4; height: 100%;">
                            <h4
                                style="color: #1d3a6d; font-weight: 700; margin-top: 0; margin-bottom: 15px; border-bottom: 2px solid #1d3a6d; display: inline-block; padding-bottom: 5px;">
                                <i class="fa fa-truck"></i> DATOS DEL PROVEEDOR
                            </h4>
                            <div class="row">
                                <div class="col-sm-12">
                                    <label class="text-muted small fw-bold text-uppercase d-block"
                                        style="margin-bottom: 2px;">Razón Social</label>
                                    <p style="font-size: 16px; font-weight: 700; color: #333; margin-bottom: 15px;">
                                        {{ $proveedor }}
                                    </p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small fw-bold text-uppercase d-block"
                                        style="margin-bottom: 2px;">RUC</label>
                                    <p style="font-size: 15px; font-weight: 600; color: #555;">{{ $ruc }}</p>
                                </div>
                                <div class="col-sm-6">
                                    <label class="text-muted small fw-bold text-uppercase d-block"
                                        style="margin-bottom: 2px;">Tipo de Pago</label>
                                    <p style="font-size: 15px; font-weight: 600; color: #555;">{{ $tipo_pago }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div
                            style="background: #fff; border-radius: 12px; padding: 20px; border: 2px dashed #1d3a6d; height: auto; display: flex; flex-direction: column; justify-content: center; text-align: center;">
                            <label class="text-muted small fw-bold text-uppercase d-block"
                                style="margin-bottom: 5px;">Total de la Cotización</label>
                            <h3 style="font-size: 36px; font-weight: 800; color: #1d3a6d; margin: 0;">
                                <span
                                    style="font-size: 20px; vertical-align: middle; margin-right: 5px;">{{ $moneda == 'SOLES' ? 'S/' : '$' }}</span>{{ $total }}
                            </h3>
                            <div style="margin-top: 15px;">
                                <span class="label {{ $estado == 'GENERADO' ? 'label-primary' : 'label-success' }}"
                                    style="padding: 6px 15px; border-radius: 20px; font-size: 13px; font-weight: 700; letter-spacing: 0.5px;">
                                    {{ $estado }}
                                </span>
                            </div>
                        </div>

                        <!-- BOTONES DE ACCIÓN DEBAJO DEL TOTAL -->
                        @if($cotizacion->COD_ESTADO != 'ETM0000000000005')
                            <div style="margin-top: 20px; display: flex; gap: 10px; justify-content: center;">
                                <button class="btn btn-warning editar-cotizacion" data-id="{{ $id_cotizacion }}"
                                    style="flex: 1; border-radius: 8px; font-weight: 700; padding: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <i class="fa fa-edit"></i> EDITAR
                                </button>
                                <button class="btn btn-success aprobar-cotizacion" data-id="{{ $id_cotizacion }}"
                                    style="flex: 1; border-radius: 8px; font-weight: 700; padding: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                                    <i class="fa fa-check"></i> APROBAR
                                </button>
                                <button class="btn btn-danger eliminar-cotizacion" data-id="{{ $id_cotizacion }}"
                                    style="flex: 1; border-radius: 8px; font-weight: 700; padding: 10px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); background: #e3342f; border: none;">
                                    <i class="fa fa-trash"></i> ELIMINAR
                                </button>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- TABLA DE DETALLES -->
                <div class="panel panel-default"
                    style="border-radius: 12px; border: 1px solid #eaecf4; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
                    <div class="panel-heading"
                        style="background: #eef1f7; color: #1d3a6d; font-weight: 700; padding: 15px 20px; border-bottom: 1px solid #eaecf4;">
                        <i class="fa fa-list"></i> ITEMS DE LA COTIZACIÓN
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover table-striped mb-0">
                            <thead>
                                <tr style="background: #fff;">
                                    <th class="text-center" style="width: 60px;">#</th>
                                    <th>Producto / Servicio</th>
                                    <th>Familia</th>
                                    <th class="text-center">U.M.</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-center">Precio Unit.</th>
                                    <th class="text-center">Precio Unit. IGV</th>
                                    <th class="text-center" style="padding-right: 25px;">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody style="color: #444;">
                                @foreach($lista_detalle as $index => $det)
                                    <tr>
                                        <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                                        <td>
                                            <div style="font-weight: 700; color: #1d3a6d; font-size: 14px;">
                                                {{ $det->NOM_PRODUCTO }}
                                            </div>
                                            <span class="text-muted small">COD: {{ $det->COD_PRODUCTO }}</span>
                                        </td>
                                        <td>
                                            <span class="label label-outline"
                                                style="border: 1px solid #d1d3e2; color: #5a5c69; font-weight: 600; padding: 3px 10px;">
                                                {{ $det->NOM_CATEGORIA_FAMILIA }}
                                            </span>
                                        </td>
                                        <td class="text-center">{{ $det->NOM_CATEGORIA_MEDIDA }}</td>
                                        <td class="text-center">
                                            <b
                                                style="font-size: 15px; color: #333;">{{ number_format($det->CANTIDAD, 2) }}</b>
                                        </td>
                                        <td class="text-center">{{ number_format($det->CAN_PRECIO, 2) }}</td>
                                        <td class="text-center" style="color: #28a745; font-weight: 600;">
                                            {{ number_format($det->CAN_PRECIO_IGV, 2) }}
                                        </td>
                                        <td class="text-center fw-bold" style="padding-right: 25px; color: #1d3a6d;">
                                            {{ number_format($det->CANTIDAD * $det->CAN_PRECIO, 2) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- OBSERVACIONES Y ARCHIVOS -->
                <div class="row" style="margin-top: 30px;">
                    <!-- OBSERVACIÓN -->
                    <div class="col-md-7">
                        <div class="panel panel-default shadow-soft"
                            style="border-radius: 12px; height: 100%; border-left: 5px solid #1d3a6d;">
                            <div class="panel-heading" style="background: #fff; font-weight: 700; color: #1d3a6d;">
                                <i class="fa fa-comment"></i> OBSERVACIONES ADICIONALES
                            </div>
                            <div class="panel-body">
                                <div
                                    style="background: #fbfbfb; border: 1px solid #f0f0f0; border-radius: 8px; padding: 15px; min-height: 100px; color: #666; font-size: 14px; white-space: pre-line;">
                                    {!! $cotizacion->TXT_OBSERVACION ? nl2br(e($cotizacion->TXT_OBSERVACION)) : '<i>Sin observaciones registradas.</i>' !!}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- ARCHIVOS ADJUNTOS -->
                    <div class="col-md-5">
                        <div class="panel panel-default shadow-soft"
                            style="border-radius: 12px; height: 100%; border-left: 5px solid #28a745;">
                            <div class="panel-heading" style="background: #fff; font-weight: 700; color: #28a745;">
                                <i class="fa fa-paperclip"></i> DOCUMENTOS ADJUNTOS ({{ count($archivos) }})
                            </div>
                            <div class="panel-body">
                                @if(count($archivos) > 0)
                                    <div class="list-group" style="margin-bottom: 0;">
                                        @foreach($archivos as $arch)
                                            <a href="{{ url('/descargar-archivo-informe/' . base64_encode($arch->URL_ARCHIVO)) }}"
                                                target="_blank" class="list-group-item list-group-item-action"
                                                style="border: none; border-bottom: 1px solid #f0f0f0; padding: 12px 15px; transition: background 0.2s;">
                                                <div
                                                    style="display: flex; align-items: center; justify-content: space-between;">
                                                    <div style="display: flex; align-items: center;">
                                                        <i class="fa fa-file-pdf-o text-danger"
                                                            style="font-size: 20px; margin-right: 15px;"></i>
                                                        <span
                                                            style="font-weight: 600; color: #444; font-size: 13px;">{{ $arch->NOMBRE_ARCHIVO }}</span>
                                                    </div>
                                                    <i class="fa fa-download text-success"></i>
                                                </div>
                                            </a>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="text-center" style="padding: 20px; color: #999;">
                                        <i class="fa fa-folder-open-o fa-2x"></i>
                                        <p style="margin-top: 10px;">No hay archivos adjuntos.</p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <!-- BOTÓN DE ACCIÓN FINAL -->
                <div class="text-center" style="margin-top: 40px;">
                    <button class="btn btn-secondary btn-lg"
                        style="border-radius: 12px; padding: 12px 40px; font-weight: 700; background: #858796; color: #fff; border: none; box-shadow: 0 4px 10px rgba(0,0,0,0.15);"
                        onclick="cerrarDetalleCotizacionTab();">
                        <i class="fa fa-times"></i> CERRAR DETALLE
                    </button>
                </div>

            </div>
        </div>
    </div>
</div>

<style>
    .shadow-lg {
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1) !important;
    }

    .shadow-soft {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
    }

    .list-group-item-action:hover {
        background: #f8f9fc !important;
        text-decoration: none;
    }

    .panel-heading i {
        margin-right: 8px;
    }

    .label-outline {
        background: transparent;
    }
</style>