<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
     <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 14px;
            color: #333;
            background-color: #f0f2f5;
            padding: 30px 0;
        }
        .container {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            max-width: 600px;
            margin: auto;
            box-shadow: 0 3px 8px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .header {
            background-color: #191970;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            font-family: 'Times New Roman', Times, serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-family: 'Times New Roman', Times, serif;
        }
        td {
            padding: 10px 12px;
            vertical-align: top;
        }
        td.label {
            background-color: #f8f9fb;
            font-weight: bold;
            color: #333;
            width: 40%;
            border-bottom: 1px solid #eee;
        }
        td.value {
            border-bottom: 1px solid #eee;
        }
        .footer {
            text-align: center;
            font-size: 11px;
            color: #aaa;
            padding: 15px;
            font-family: 'Times New Roman', Times, serif;
        }
    </style>
</head>
<body>
   <p style="font-family: 'Times New Roman', Times, serif;">
    Sres.<br>
    Se adjunta el Vale a Rendir GENERADO/RECHAZADO.
    </p>
<div class="container">
    <div class="header">
        VALE A RENDIR - RECHAZADO POR JEFATURA
    </div>
    <table>
        <tr>
            <td class="label">ID</td>
            <td class="value">{{ $vale->ID }}</td>
        </tr>
        <tr>
            <td class="label">Empresa</td>
            <td class="value">
                @if($vale->COD_EMPR === 'IACHEM0000010394')
                    INDUAMERICA INTERNACIONAL S.A.C
                @else
                    INDUAMERICA COMERCIAL SOCIEDAD ANÓNIMA CERRADA
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Solicitado por</td>
            <td class="value">{{ $vale->TXT_NOM_SOLICITA }}</td>
        </tr>
        <tr>
            <td class="label">Autorizado por</td>
            <td class="value">{{ $vale->TXT_NOM_AUTORIZA }}</td>
        </tr>
        <tr>
            <td class="label">Motivo</td>
            <td class="value">
                @if($vale->TIPO_MOTIVO === 'TIP0000000000001')
                    GASTOS DE REPRESENTACION
                @elseif($vale->TIPO_MOTIVO === 'TIP0000000000002')
                    GASTOS DE OPERACION
                @elseif($vale->TIPO_MOTIVO === 'TIP0000000000003')
                    GASTOS DE VIAJE O VIÁTICOS
                @elseif($vale->TIPO_MOTIVO === 'TIP0000000000004')
                    GASTOS DE MARKETING Y PUBLICIDAD
                @elseif($vale->TIPO_MOTIVO === 'TIP0000000000005')
                    GASTOS DE CAPACITACIÓN Y FORMACIÓN
                @elseif($vale->TIPO_MOTIVO === 'TIP0000000000006')
                    GASTOS DE INVESTIGACIÓN Y DESARROLLO
                @else
                    {{ $vale->TIPO_MOTIVO }}
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Moneda</td>
            <td class="value">
                @if($vale->COD_MONEDA === 'MON0000000000001')
                    SOLES
                @else
                    DÓLARES
                @endif
            </td>
        </tr>
        <tr>
            <td class="label">Importe Total</td>
            <td class="value">
                @if($vale->COD_MONEDA === 'MON0000000000001')
                    S/.
                @else
                    US$
                @endif
                {{ number_format($vale->CAN_TOTAL_IMPORTE, 2) }}
            </td>
        </tr>
        <tr>
            <td class="label">Glosa</td>
            <td class="value">{{ $vale->TXT_GLOSA }}</td>
        </tr>
        <tr>
            <td class="label">Estado</td>
            <td class="value">{{ $vale->TXT_CATEGORIA_ESTADO_VALE }}</td>
        </tr>
    </table>
</div>
</body>
</html>
