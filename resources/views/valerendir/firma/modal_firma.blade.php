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
        ..glosa {
            white-space: pre-line;   /* respeta saltos de línea */
            word-wrap: break-word;   /* permite cortar palabras largas */
            word-break: break-word;  /* rompe si no hay espacios */
        }
        .linea-solida {
            border: none;            /* quita borde por defecto */
            border-top: 2px solid #000; /* grosor 2px, color negro */
            margin: 10px 0;          /* espacio arriba y abajo */
        }

        .firma {
            text-align: center;
            margin-top: 50px; /* espacio desde arriba */
        }

        .linea-firma {
            width: 300px;             /* largo de la línea */
            border-top: 1px solid #000;
            margin: 0 auto 5px auto;  /* centrada con espacio abajo */
        }
        .firma p {
            margin: 2px 0; /* muy poco espacio arriba y abajo */
        }

    </style>
</head>
<body>
    <!-- Empresa arriba a la izquierda -->
    <p class="empresa">{{ $nom_empr }}</p>
    <hr class="linea-solida">
    <!-- Título y Voucher centrados -->
    <h1>{{ $txt_categoria_operacion_caja }} - CAJA</h1>
    <p class="voucher">Voucher N° {{ $cod_operacion_caja }}</p>

    <!-- Tabla de datos principales -->
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

    <!-- Filas completas -->
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
            {{-- Moneda en Soles --}}
            @if($can_debe_mn != 0)
                Importe:
            @else
                Pago:
            @endif
        @else
            {{-- Moneda en Dólares --}}
            @if($can_debe_me != 0)
                Importe:
            @else
                Pago:
            @endif
        @endif
    </td>
    <td>
        @if($cod_categoria_moneda == "MON0000000000001")
            {{-- Moneda en Soles --}}
            @if($can_debe_mn != 0)
                @php $importe = $can_debe_mn; @endphp
                S/. {{ number_format($importe, 2) }}
            @else
                @php $importe = $can_haber_mn; @endphp
                S/. {{ number_format($importe, 2) }}
            @endif
        @else
            {{-- Moneda en Dólares --}}
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
    
</tr>

</tr>

    </table>

   <div class="firma">
    <div class="linea-firma"></div>
    <p>{{ $txt_empr_afecta }}</p>
    <p>DNI: {{ $nro_doc }}</p>
</div>

</body>
</html>
