<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Compraventa - {{ $venta->codigo_contrato }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/remixicon@3.5.0/fonts/remixicon.css" rel="stylesheet">
    <style>
        body { font-family: 'Times New Roman', Times, serif; background-color: #f8fafc; color: #000; line-height: 1.6; }
        .contrato-card { max-width: 850px; margin: 30px auto; background: #fff; padding: 50px; border-radius: 8px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        h4, h5, h6 { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        .clausula-titulo { font-weight: bold; text-decoration: underline; margin-top: 15px; margin-bottom: 5px; }
        p { text-align: justify; font-size: 13.5px; }
        @media print {
            body { background: #fff; }
            .contrato-card { box-shadow: none; margin: 0; padding: 20px; max-width: 100%; }
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
            <button onclick="window.print();" class="btn btn-primary btn-sm">
                <i class="ri-printer-line me-1"></i> Imprimir Contrato de Compraventa
            </button>
        </div>

        <div class="contrato-card">
            <div class="text-center mb-4 pb-3 border-bottom">
                <h4 class="fw-bold mb-1">CONTRATO PRIVADO DE COMPRAVENTA DE LOTE DE TERRENO</h4>
                <div class="text-muted font-monospace small">CÓDIGO DE CONTRATO: {{ $venta->codigo_contrato }}</div>
            </div>

            <p>
                Conste por el presente documento privado de <strong>CONTRATO DE COMPRAVENTA DE LOTE DE TERRENO</strong>, que celebran de una parte:
            </p>

            <p>
                <strong>LA PARTE VENDEDORA:</strong> <strong>{{ $venta->empresa->nombre ?? 'LA INMOBILIARIA' }}</strong>, con RUC N° <strong>{{ $venta->empresa->ruc ?? '' }}</strong>, con domicilio legal en {{ $venta->empresa->direccion_fiscal ?? 'su oficina principal' }}, debidamente representada por su Representante Legal.
            </p>

            <p>
                Y de la otra parte, <strong>LA PARTE COMPRADORA:</strong> Don(ña) <strong>{{ $venta->cliente->nombre_completo ?? '' }}</strong>, identificado(a) con {{ $venta->cliente->tipo_documento ?? 'DNI' }} N° <strong>{{ $venta->cliente->numero_documento ?? '' }}</strong>, de estado civil {{ $venta->cliente->estado_civil ?? 'Soltero(a)' }}, con domicilio en {{ $venta->cliente->direccion ?? 'la ciudad' }}
                @if($venta->cliente && $venta->cliente->conyuge_nombre)
                    y su cónyuge / co-propietario(a) Don(ña) <strong>{{ $venta->cliente->conyuge_nombre }}</strong>, con DNI N° <strong>{{ $venta->cliente->conyuge_dni }}</strong>
                @endif
                ; en los términos y condiciones siguientes:
            </p>

            <div class="clausula-titulo">CLÁUSULA PRIMERA: DEL INMUEBLE Y PROYECTO</div>
            <p>
                <strong>LA VENDEDORA</strong> es titular y desarrolladora del proyecto inmobiliario denominado <strong>"{{ $venta->proyecto->nombre ?? 'PROYECTO' }}"</strong>, ubicado en el distrito de {{ $venta->proyecto->distrito ?? '' }}, provincia de {{ $venta->proyecto->provincia ?? '' }}, departamento de {{ $venta->proyecto->departamento ?? '' }}.
            </p>

            <div class="clausula-titulo">CLÁUSULA SEGUNDA: OBJETO DEL CONTRATO</div>
            <p>
                Por el presente contrato, <strong>LA VENDEDORA</strong> da en venta real y enajenación perpetua a favor de <strong>EL COMPRADOR</strong>, el lote de terreno identificado como:
                <br>
                <strong>• MANZANA:</strong> {{ $venta->lote->manzana->nombre ?? 'Mz' }}
                <br>
                <strong>• N° DE LOTE:</strong> Lote {{ $venta->lote->numero_lote ?? '' }}
                <br>
                <strong>• ÁREA TOTAL:</strong> {{ number_format($venta->lote->area_m2 ?? 0, 2) }} m²
                <br>
                <strong>• MEDIDAS PERIMÉTRICAS:</strong> Frente: {{ $venta->lote->medida_frente ?? 0 }} ml, Fondo: {{ $venta->lote->medida_fondo ?? 0 }} ml, Derecha: {{ $venta->lote->medida_derecha ?? 0 }} ml, Izquierda: {{ $venta->lote->medida_izquierda ?? 0 }} ml.
            </p>

            <div class="clausula-titulo">CLÁUSULA TERCERA: PRECIO Y FORMA DE PAGO</div>
            <p>
                El precio total y definitivo pactado por la compraventa del lote de terreno es de <strong>S/ {{ number_format($venta->precio_final, 2) }} (SOLES)</strong>, el cual <strong>EL COMPRADOR</strong> cancela de la siguiente manera:
                <br>
                @if($venta->tipo_venta === 'contado')
                    - <strong>MODALIDAD AL CONTADO:</strong> Cancelado en su totalidad a la firma del presente contrato mediante pago bancarizado/efectivo.
                @else
                    - <strong>MODALIDAD CRÉDITO DIRECTO INMOBILIARIO:</strong>
                    <br>
                    a) Cuota Inicial de <strong>S/ {{ number_format($venta->monto_inicial, 2) }}</strong> cancelada a la suscripción de este documento.
                    <br>
                    b) Saldo financiado de <strong>S/ {{ number_format($venta->saldo_financiar, 2) }}</strong>, pagadero en <strong>{{ $venta->numero_cuotas }} cuotas mensuales consecutivas</strong> de <strong>S/ {{ number_format($venta->monto_cuota_mensual, 2) }}</strong> cada una, con vencimiento los días {{ $venta->dia_pago_mensual }} de cada mes, conforme al cronograma de cuotas anexo que forma parte integrante del presente contrato.
                @endif
            </p>

            @if($venta->clausulas_adicionales)
            <div class="clausula-titulo">CLÁUSULA CUARTA: ACUERDOS ESPECIALES</div>
            <p>{{ $venta->clausulas_adicionales }}</p>
            @endif

            <div class="clausula-titulo">CLÁUSULA QUINTA: ENTREGA Y MINUTA DEFINITIVA</div>
            <p>
                La posesión del lote se otorgará conforme a los plazos del proyecto. Al cancelarse el 100% del precio total convenido, <strong>LA VENDEDORA</strong> se obliga a suscribir la Minuta y Escritura Pública definitiva de Compraventa ante la Notaría correspondiente para su posterior inscripción registral.
            </p>

            <p class="mt-4">
                Ambas partes declaran su total conformidad con las cláusulas precedentes, firmando el presente contrato por duplicado en la ciudad correspondiente al día <strong>{{ date('d', strtotime($venta->fecha_venta)) }}</strong> del mes de <strong>{{ date('m', strtotime($venta->fecha_venta)) }}</strong> del año <strong>{{ date('Y', strtotime($venta->fecha_venta)) }}</strong>.
            </p>

            <!-- SECCIÓN DE FIRMAS -->
            <div class="row mt-5 pt-5 text-center">
                <div class="col-6">
                    <div style="border-top: 1px solid #000; width: 85%; margin: 0 auto; padding-top: 5px;">
                        <strong>{{ $venta->empresa->nombre ?? 'LA INMOBILIARIA' }}</strong><br>
                        <span class="small text-muted">LA PARTE VENDEDORA</span>
                    </div>
                </div>
                <div class="col-6">
                    <div style="border-top: 1px solid #000; width: 85%; margin: 0 auto; padding-top: 5px;">
                        <strong>{{ $venta->cliente->nombre_completo ?? 'EL COMPRADOR' }}</strong><br>
                        <span class="small text-muted">{{ $venta->cliente->tipo_documento ?? 'DNI' }}: {{ $venta->cliente->numero_documento ?? '' }}</span><br>
                        <span class="small text-muted">LA PARTE COMPRADORA</span>
                    </div>
                </div>
            </div>

            @if($venta->cliente && $venta->cliente->conyuge_nombre)
            <div class="row mt-5 pt-3 text-center">
                <div class="col-12">
                    <div style="border-top: 1px solid #000; width: 45%; margin: 0 auto; padding-top: 5px;">
                        <strong>{{ $venta->cliente->conyuge_nombre }}</strong><br>
                        <span class="small text-muted">DNI: {{ $venta->cliente->conyuge_dni }}</span><br>
                        <span class="small text-muted">CÓNYUGE / CO-PROPIETARIO(A)</span>
                    </div>
                </div>
            </div>
            @endif
        </div>
    </div>

</body>
</html>
