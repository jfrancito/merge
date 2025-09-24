<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Vale PDF</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            font-size: 12px;
            margin: 20px;
        }

        .pagina {
            display: block;
            width: 100%;
            min-height: 100%; 
        }

        .pagina.salto {
            page-break-after: always;
        }

        .empresa {
            text-align: left;
            font-weight: bold;
            margin-bottom: 5px;
        }
        h1 { 
            color: #1d3a6d; 
            text-align: center;
            margin: 0;
        }
        .voucher {
            text-align: center;
            margin-top: 2px; 
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 8px;
        }
        td {
            padding: 2px 5px;
            vertical-align: top;
        }
        .label {
            font-weight: bold;
            white-space: nowrap;
        }
        .value {
            width: 40%;
        }
        .glosa {
            white-space: normal;
            word-break: break-word;
            line-height: 1.2em;           
            max-height: calc(1.2em * 2); 
            overflow: hidden;
        }

        .linea-solida {
            border: none;
            border-top: 2px solid #000;
            margin: 10px 0;
        }
        .firma {
            text-align: center;
            margin-top: 75px;
        }
        .linea-firma {
            width: 300px;
            border-top: 1px solid #000;
            margin: 0 auto 5px auto;
        }
        .firma p {
            margin: 2px 0;
        }
    </style>
</head>
<body>

    <!-- PRIMERA PAGINA -->
    <div class="pagina salto">
        <p class="empresa">{{ $nom_empr }}</p>
        <hr class="linea-solida">
        <h1>{{ $txt_categoria_operacion_caja }} - CAJA</h1>
        <p class="voucher">Voucher N° {{ $cod_operacion_caja }}</p>

        <table>
            <tr>
                <td class="label">Caja/Bancos:</td>
                <td class="value">{{ $txt_categoria_moneda }} / {{ $txt_caja_banco }}</td>
                <td class="label">Fecha Operación:</td>
                <td>{{ $fec_operacion }}</td>
            </tr>
            <tr>
                <td class="label">Titular:</td>
                <td class="value">{{ $txt_empr_afecta }}</td>
                <td class="label">Fecha Registro:</td>
                <td>{{ $fec_operacion }}</td>
            </tr>
            <tr>
                <td class="label">Cuenta:</td>
                <td class="value">{{ $cod_cultivo_afecta }}</td>
                <td class="label">Medio Pago:</td>
                <td>{{ $txt_categoria_medio_pago }}</td>
            </tr>
            <tr>
                <td class="label">Cheque:</td>
                <td class="value">{{ $nro_cheque }}</td>
                <td class="label">Moneda:</td>
                <td>{{ $txt_categoria_moneda }}</td>
            </tr>
        </table>

        <table>
            <tr>
                <td class="label">Caja Banco:</td>
                <td>{{ $txt_caja_banco }}</td>
            </tr>
            <tr>
                <td class="label">Glosa:</td>
                <td class="glosa">{!! nl2br(e($txt_glosa)) !!}</td>
            </tr>
            <tr>
                <td class="label">Descripción:</td>
                <td>{{ $txt_descripcion }}</td>
            </tr>
            <tr>
                <td class="label">
                    @if($cod_categoria_moneda == "MON0000000000001")
                        @if($can_debe_mn != 0)
                            Importe:
                        @else
                            Pago:
                        @endif
                    @else
                        @if($can_debe_me != 0)
                            Importe:
                        @else
                            Pago:
                        @endif
                    @endif
                </td>
                <td>
                    @if($cod_categoria_moneda == "MON0000000000001")
                        @if($can_debe_mn != 0)
                            @php $importe = $can_debe_mn; @endphp
                            S/. {{ number_format($importe, 2) }}
                        @else
                            @php $importe = $can_haber_mn; @endphp
                            S/. {{ number_format($importe, 2) }}
                        @endif
                    @else
                        @if($can_debe_me != 0)
                            @php $importe = $can_debe_me; @endphp
                            $. {{ number_format($importe, 2) }}
                        @else
                            @php $importe = $can_haber_me; @endphp
                            $. {{ number_format($importe, 2) }}
                        @endif
                    @endif
                </td>
            </tr>
            <tr>
                <td class="label">Son:</td>
                <td>{{ $texto_importe }}</td>
            </tr>
        </table>

        <div class="firma">
            <div class="linea-firma"></div>
            <p>{{ $txt_empr_afecta }}</p>
            <p>DNI: {{ $nro_doc }}</p>
        </div>
    </div>

<!-- SEGUNDA PAGINA -->
    <div class="pagina">
        <div class="empresa">{{ $nom_empr }}</div>
        <hr class="linea-solida">

        <h1 style="text-align:center; color:#1d3a6d; text-decoration:underline;">ANEXO 1</h1>
        <h2 style="text-align:center; color:#1d3a6d; margin-top:5px;">
            AUTORIZACIÓN DE DESCUENTO POR PLANILLA
        </h2>

    <table style="width:100%; margin-top:15px; font-size:11px; border-collapse:collapse;">
        <style>
            table td {
                padding: 0;
            }
        </style>

        <!-- Primera fila -->
        <tr>
            <td style="text-align:left;  white-space:nowrap; vertical-align:top;">
                SEÑORES:
            </td>
            <td style="text-align:right; white-space:nowrap; font-size:12px;">
                {{ \Carbon\Carbon::now()->formatLocalized('%d de %B de %Y') }}
            </td>
        </tr>
        <!-- Segunda fila (empresa alineada debajo de SEÑORES) -->
        <tr>
            <td style="text-align:left; font-size:12px;">
                {{ $nom_empr }}
            </td>
            <td></td>
        </tr>
    </table>


        <hr class="linea-solida">

        <div style="margin-top:20px; font-size:12px;">
            YO,
             <span style="display:inline-block; border-bottom:1px dotted #000; width:90%; text-align:center;">
            <strong style="font-weight:bold;">{{ $txt_empr_afecta }}</strong>
        </span>
        </div>

        <!-- DNI -->
            <p style="margin-top:10px;">
            identificado(a) con DNI N°
            <span style="display:inline-block; border-bottom:1px dotted #000; width:40%; text-align:center;">
                <strong style="font-weight:bold; font-size:13px;" >{{ $nro_doc }}</strong>
            </span> ,
            mediante el presente documento <strong>AUTORIZO</strong> en forma irrevocable y expresa que se realice el descuento correspondiente de mi haber mensual,
            y en caso de cese, de mi liquidación de beneficios sociales, por lo siguiente:
        </p>

        <!-- Concepto -->
        <div style="margin-top:15px; font-size:13px; font-weight:bold;">
            CONCEPTO:
        </div>

        <!-- Vale a rendir -->
        <div style="margin-top:5px; font-size:13px;">
             <span style="display:inline-block; border-bottom:1px dotted #000; width:90%; text-align:center;">
            <strong style="font-weight:bold;">VALE A RENDIR</strong>
        </span>
        </div>

        <!-- Monto -->
        <div style="margin-top:10px; font-size:13px;">
            por el monto de 
            <span style="display:inline-block; border-bottom:1px dotted #000; width:50%; text-align:center;">
                 <strong style="font-weight:bold;">
                  @if($cod_categoria_moneda == "MON0000000000001")
                            @if($can_debe_mn != 0)
                                @php $importe = $can_debe_mn; @endphp
                                S/. {{ number_format($importe, 2) }}
                            @else
                                @php $importe = $can_haber_mn; @endphp
                                S/. {{ number_format($importe, 2) }}
                            @endif
                        @else
                            @if($can_debe_me != 0)
                                @php $importe = $can_debe_me; @endphp
                                $. {{ number_format($importe, 2) }}
                            @else
                                @php $importe = $can_haber_me; @endphp
                                $. {{ number_format($importe, 2) }}
                            @endif
                        @endif
                    {{ $txt_categoria_moneda }}
                    </strong>
            </span>.
        </div>

        <table style="width:100%; margin-top:30px; border-collapse:collapse;">
            <tr>
                <!-- Celda de la firma -->
                <td style="width:70%; text-align:center; vertical-align:bottom; padding-right:10px;">
                    <div style="border-top:1px solid #000; width:60%; margin:0 auto; margin-bottom:5px;"></div>
                    <p style="margin:0;">{{ $txt_empr_afecta }}</p>
                    <p style="margin:0;">DNI: {{ $nro_doc }}</p>
                </td>

                <!-- Celda del cuadro para huella -->
                <td style="width:30%; text-align:center; vertical-align:bottom;">
                    <div style="width:80px; height:80px; border:1px solid #000; margin:0 auto;"></div>
                    <p style="margin:5px 0 0 0; font-size:11px;">Huella Digital</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
