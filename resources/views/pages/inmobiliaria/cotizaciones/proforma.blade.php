<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cotización Proforma - {{ $cotizacion->codigo_cotizacion }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #1e293b; }
        .proforma-card { max-width: 850px; margin: 30px auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .header-logo { max-height: 60px; object-fit: contain; }
        .table-custom th { background-color: #f1f5f9; color: #475569; font-size: 12px; text-transform: uppercase; }
        @media print {
            body { background: #fff; }
            .proforma-card { box-shadow: none; margin: 0; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print max-w-850 mx-auto" style="max-width: 850px;">
            <a href="javascript:window.history.back();" class="btn btn-outline-secondary btn-sm">
                <i class="ri-arrow-left-line"></i> Regresar
            </a>
            <div class="d-flex gap-2">
                <button onclick="window.print();" class="btn btn-primary btn-sm">
                    <i class="ri-printer-line me-1"></i> Imprimir / Guardar PDF
                </button>
            </div>
        </div>

        <div class="proforma-card">
            <!-- CABECERA DE LA EMPRESA -->
            <div class="row align-items-center mb-4 pb-3 border-bottom">
                <div class="col-7">
                    @if($cotizacion->empresa && $cotizacion->empresa->logo)
                        <img src="{{ asset('storage/' . $cotizacion->empresa->logo) }}" alt="Logo" class="header-logo mb-2">
                    @else
                        <h4 class="fw-bold text-primary mb-1">{{ $cotizacion->empresa->nombre ?? 'LOTEAME' }}</h4>
                    @endif
                    <div class="small text-muted">
                        <strong>RUC:</strong> {{ $cotizacion->empresa->ruc ?? '' }}<br>
                        <strong>Dirección:</strong> {{ $cotizacion->empresa->direccion_fiscal ?? '' }}
                    </div>
                </div>
                <div class="col-5 text-end">
                    <span class="badge bg-primary bg-opacity-10 text-primary fs-14 px-3 py-2 rounded-pill fw-bold font-monospace">
                        PROFORMA N° {{ $cotizacion->codigo_cotizacion }}
                    </span>
                    <div class="small text-muted mt-2">
                        <strong>Fecha Emisión:</strong> {{ date('d/m/Y', strtotime($cotizacion->fecha_emision)) }}<br>
                        <strong>Válido Hasta:</strong> {{ date('d/m/Y', strtotime($cotizacion->fecha_vencimiento)) }}
                    </div>
                </div>
            </div>

            <!-- DATOS DEL CLIENTE Y ASESOR -->
            <div class="row mb-4">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="p-3 bg-light rounded-3 h-100">
                        <span class="text-secondary text-uppercase fs-11 fw-bold letter-spacing-1 d-block mb-1">CLIENTE / COMPRADOR</span>
                        <h6 class="fw-bold mb-1 text-dark">{{ $cotizacion->cliente->nombre_completo ?? '' }}</h6>
                        <div class="small text-muted">
                            <strong>{{ $cotizacion->cliente->tipo_documento ?? 'DNI' }}:</strong> {{ $cotizacion->cliente->numero_documento ?? '' }}<br>
                            <strong>Teléfono:</strong> {{ $cotizacion->cliente->telefono ?? 'No especificado' }}<br>
                            <strong>Email:</strong> {{ $cotizacion->cliente->email ?? 'No especificado' }}
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="p-3 bg-light rounded-3 h-100">
                        <span class="text-secondary text-uppercase fs-11 fw-bold letter-spacing-1 d-block mb-1">PROYECTO INMOBILIARIO</span>
                        <h6 class="fw-bold mb-1 text-primary">{{ $cotizacion->proyecto->nombre ?? '' }}</h6>
                        <div class="small text-muted">
                            <strong>Ubicación:</strong> {{ $cotizacion->proyecto->distrito ?? '' }} - {{ $cotizacion->proyecto->provincia ?? '' }}<br>
                            <strong>Asesor Asignado:</strong> {{ $cotizacion->vendedor->nombre_completo ?? 'Atención Directa' }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- DETALLES TÉCNICOS DEL LOTE -->
            <h5 class="fw-bold text-dark fs-15 mb-2">1. Especificaciones del Lote</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-custom align-middle">
                    <thead>
                        <tr>
                            <th>Manzana</th>
                            <th>N° Lote</th>
                            <th class="text-center">Área Total</th>
                            <th class="text-center">Frente x Fondo</th>
                            <th class="text-center">Tipo Ubicación</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="fw-bold">{{ $cotizacion->lote->manzana->nombre ?? '' }}</td>
                            <td class="fw-bold text-primary">Lote {{ $cotizacion->lote->numero_lote ?? '' }}</td>
                            <td class="text-center fw-bold">{{ number_format($cotizacion->lote->area_m2 ?? 0, 2) }} m²</td>
                            <td class="text-center">{{ $cotizacion->lote->medida_frente ?? 0 }}m x {{ $cotizacion->lote->medida_fondo ?? 0 }}m</td>
                            <td class="text-center text-capitalize">{{ $cotizacion->lote->tipo_lote ?? 'Estándar' }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- PLAN FINANCIERO Y FORMA DE PAGO -->
            <h5 class="fw-bold text-dark fs-15 mb-2">2. Condiciones Económicas y Plan de Pago</h5>
            <div class="table-responsive mb-4">
                <table class="table table-bordered table-custom align-middle">
                    <tbody>
                        <tr>
                            <td class="bg-light fw-bold" style="width: 50%;">Modalidad de Adquisición:</td>
                            <td class="fw-bold text-uppercase">{{ $cotizacion->tipo_pago === 'contado' ? 'Venta al Contado' : 'Crédito Directo Inmobiliario' }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Precio de Lista:</td>
                            <td>S/ {{ number_format($cotizacion->precio_lote, 2) }}</td>
                        </tr>
                        @if($cotizacion->descuento > 0)
                        <tr>
                            <td class="bg-light fw-bold text-danger">Descuento Promocional:</td>
                            <td class="text-danger fw-bold">- S/ {{ number_format($cotizacion->descuento, 2) }}</td>
                        </tr>
                        @endif
                        <tr class="table-active">
                            <td class="fw-bold fs-15">PRECIO FINAL ACORDADO:</td>
                            <td class="fw-bold fs-15 text-primary">S/ {{ number_format($cotizacion->precio_final, 2) }}</td>
                        </tr>
                        @if($cotizacion->tipo_pago === 'credito')
                        <tr>
                            <td class="bg-light fw-bold">Cuota Inicial:</td>
                            <td class="fw-bold">S/ {{ number_format($cotizacion->monto_inicial, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Saldo a Financiar:</td>
                            <td class="fw-bold">S/ {{ number_format($cotizacion->saldo_financiar, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Plazo de Financiamiento:</td>
                            <td class="fw-bold">{{ $cotizacion->numero_cuotas }} Cuotas Mensuales Fijas</td>
                        </tr>
                        <tr class="table-success">
                            <td class="fw-bold fs-15 text-success">CUOTA MENSUAL SUGERIDA:</td>
                            <td class="fw-bold fs-16 text-success">S/ {{ number_format($cotizacion->monto_cuota_mensual, 2) }} / mes</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            <!-- CUENTAS BANCARIAS RECAUDADORAS -->
            @php
                $configEmpresa = is_array($cotizacion->empresa->configuracion_simple ?? null) ? $cotizacion->empresa->configuracion_simple : json_decode($cotizacion->empresa->configuracion_simple ?? '{}', true);
                $ctaSoles = $configEmpresa['cuenta_bancaria_soles'] ?? null;
            @endphp
            @if($ctaSoles)
            <div class="alert alert-secondary border-0 p-3 mb-4 rounded-3">
                <span class="fw-bold d-block text-uppercase fs-12 mb-1"><i class="ri-bank-card-line align-middle"></i> Cuentas Bancarias de la Inmobiliaria para Separación y Pagos:</span>
                <span class="fs-13 font-monospace">{{ $ctaSoles }}</span>
            </div>
            @endif

            <!-- FIRMAS -->
            <div class="row mt-5 pt-4 text-center">
                <div class="col-6">
                    <div style="border-top: 1px solid #94a3b8; width: 80%; margin: 0 auto; padding-top: 5px;">
                        <span class="fw-bold d-block fs-13">{{ $cotizacion->vendedor->nombre_completo ?? 'Asesor Comercial' }}</span>
                        <span class="text-muted fs-11">Asesor Inmobiliario</span>
                    </div>
                </div>
                <div class="col-6">
                    <div style="border-top: 1px solid #94a3b8; width: 80%; margin: 0 auto; padding-top: 5px;">
                        <span class="fw-bold d-block fs-13">{{ $cotizacion->cliente->nombre_completo ?? 'Comprador' }}</span>
                        <span class="text-muted fs-11">Firma del Cliente / Aceptación</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
