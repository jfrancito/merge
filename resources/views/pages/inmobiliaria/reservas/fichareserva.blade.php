<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha de Separación - {{ $reserva->codigo_reserva }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f8fafc; color: #1e293b; }
        .ficha-card { max-width: 800px; margin: 30px auto; background: #fff; padding: 40px; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .header-logo { max-height: 60px; object-fit: contain; }
        @media print {
            body { background: #fff; }
            .ficha-card { box-shadow: none; margin: 0; padding: 0; max-width: 100%; }
            .no-print { display: none !important; }
        }
    </style>
</head>
<body>

    <div class="container my-4">
        <div class="d-flex justify-content-between align-items-center mb-3 no-print max-w-800 mx-auto" style="max-width: 800px;">
            <a href="javascript:window.history.back();" class="btn btn-outline-secondary btn-sm">
                <i class="ri-arrow-left-line"></i> Regresar
            </a>
            <button onclick="window.print();" class="btn btn-primary btn-sm">
                <i class="ri-printer-line me-1"></i> Imprimir Constancia de Separación
            </button>
        </div>

        <div class="ficha-card">
            <!-- CABECERA -->
            <div class="row align-items-center mb-4 pb-3 border-bottom">
                <div class="col-7">
                    @if($reserva->empresa && $reserva->empresa->logo)
                        <img src="{{ asset('storage/' . $reserva->empresa->logo) }}" alt="Logo" class="header-logo mb-2">
                    @else
                        <h4 class="fw-bold text-primary mb-1">{{ $reserva->empresa->nombre ?? 'LOTEAME' }}</h4>
                    @endif
                    <div class="small text-muted">
                        <strong>RUC:</strong> {{ $reserva->empresa->ruc ?? '' }}<br>
                        <strong>Oficina:</strong> {{ $reserva->empresa->direccion_fiscal ?? '' }}
                    </div>
                </div>
                <div class="col-5 text-end">
                    <span class="badge bg-warning bg-opacity-20 text-dark border border-warning fs-14 px-3 py-2 rounded-pill fw-bold font-monospace">
                        CONSTANCIA DE SEPARACIÓN
                    </span>
                    <h6 class="mt-2 mb-0 fw-bold text-primary">{{ $reserva->codigo_reserva }}</h6>
                    <div class="small text-muted mt-1">
                        Fecha: {{ date('d/m/Y', strtotime($reserva->fecha_reserva)) }}
                    </div>
                </div>
            </div>

            <!-- CUERPO DE LA SEPARACIÓN -->
            <p class="fs-14 text-muted mb-4">
                Por medio del presente documento, la empresa inmobiliaria <strong>{{ $reserva->empresa->nombre ?? 'LOTEAME' }}</strong> deja constancia de la recepción del depósito por concepto de <strong>SEPARACIÓN Y BLOQUEO TEMPORAL DE LOTE</strong>, sujeto a las siguientes estipulaciones:
            </p>

            <div class="table-responsive mb-4">
                <table class="table table-bordered align-middle">
                    <tbody>
                        <tr>
                            <td class="bg-light fw-bold" style="width: 35%;">Titular / Comprador:</td>
                            <td class="fw-bold text-dark">{{ $reserva->cliente->nombre_completo ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Documento de Identidad:</td>
                            <td>{{ $reserva->cliente->tipo_documento ?? 'DNI' }}: {{ $reserva->cliente->numero_documento ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Teléfono de Contacto:</td>
                            <td>{{ $reserva->cliente->telefono ?? 'No registrado' }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Proyecto Inmobiliario:</td>
                            <td class="fw-bold text-primary">{{ $reserva->proyecto->nombre ?? '' }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Ubicación del Lote:</td>
                            <td class="fw-bold text-dark">
                                {{ $reserva->lote->manzana->nombre ?? 'Mz' }} - Lote {{ $reserva->lote->numero_lote ?? '' }}
                                (Área: {{ number_format($reserva->lote->area_m2 ?? 0, 2) }} m²)
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Precio Total del Lote:</td>
                            <td class="fw-bold">S/ {{ number_format($reserva->lote->precio_total ?? 0, 2) }}</td>
                        </tr>
                        <tr class="table-warning">
                            <td class="fw-bold fs-15 text-dark">MONTO DE SEPARACIÓN RECIBIDO:</td>
                            <td class="fw-bold fs-16 text-success">S/ {{ number_format($reserva->monto_reserva, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold">Forma de Pago del Depósito:</td>
                            <td class="text-capitalize">{{ $reserva->metodo_pago }} {{ $reserva->banco_origen ? '('.$reserva->banco_origen.')' : '' }} - N° Op: {{ $reserva->numero_operacion ?: 'Caja' }}</td>
                        </tr>
                        <tr>
                            <td class="bg-light fw-bold text-danger">FECHA LÍMITE DE FORMALIZACIÓN:</td>
                            <td class="fw-bold text-danger">{{ date('d/m/Y', strtotime($reserva->fecha_limite)) }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="alert alert-light border p-3 small text-muted mb-4">
                <strong>TÉRMINOS Y CONDICIONES:</strong> El presente monto de separación garantiza la reserva y no venta a terceros del lote descrito hasta la fecha límite indicada. Dicho importe será deducido íntegramente de la cuota inicial o precio total al momento de suscribir el contrato de compraventa definitivo.
            </div>

            <!-- FIRMAS -->
            <div class="row mt-5 pt-4 text-center">
                <div class="col-6">
                    <div style="border-top: 1px solid #94a3b8; width: 80%; margin: 0 auto; padding-top: 5px;">
                        <span class="fw-bold d-block fs-13">{{ $reserva->empresa->nombre ?? 'Inmobiliaria' }}</span>
                        <span class="text-muted fs-11">Por la Empresa Inmobiliaria</span>
                    </div>
                </div>
                <div class="col-6">
                    <div style="border-top: 1px solid #94a3b8; width: 80%; margin: 0 auto; padding-top: 5px;">
                        <span class="fw-bold d-block fs-13">{{ $reserva->cliente->nombre_completo ?? 'Comprador' }}</span>
                        <span class="text-muted fs-11">Firma del Cliente Comprador</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
