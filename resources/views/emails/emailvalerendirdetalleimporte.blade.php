<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8"/>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, sans-serif;
            font-size: 14px;
            color: #333;
            background-color: #ffffff !important; /* Fondo blanco */
            margin: 0;
            padding: 25px 0;
        }

        p {
            margin: 0 0 20px 0;
            font-size: 15px;
        }

        .container {
            background-color: #ffffff;
            border: 1px solid #e3e3e3;
            border-radius: 10px;
            max-width: 1000px;
            margin: auto;
            box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            padding: 25px 30px;
        }

        h3 {
            color: #003b5c;
            font-weight: 700;
            margin-bottom: 15px;
            border-left: 4px solid #007bff;
            padding-left: 10px;
            font-size: 18px;
        }

        /* TABLA */
        .tabla-contenedor {
            width: 100%;
            display: flex;
            justify-content: center;
        }

        table {
            width: 90%;
            border-collapse: collapse;
            font-size: 13.5px;
            margin: 25px 0;
            background: #ffffff;
            border-radius: 12px;
            border: 1px solid #e1e1e1;
            overflow: hidden;
        }

        table th {
            background-color: #003b5c;
            color: #fff;
            font-weight: bold;
            padding: 10px;
            text-align: center;
            letter-spacing: 0.3px;
        }

        table td {
            padding: 10px;
            border-bottom: 1px solid #ededed;
            text-align: center;
        }

        table tr:nth-child(even) {
            background-color: #f8fafc;
        }

        table tr:hover {
            background-color: #eef5ff;
        }

    </style>
</head>
<body>

    <p>
        Sres.<br>
        Se adjunta el Vale a Rendir. El cual el importe fue modificado. 
    </p>

@if(isset($cambios) && count($cambios) > 0)
<div class="container" style="margin-top:20px;">

    <h3>CAMBIOS REALIZADOS</h3>

    @foreach($cambios as $key => $cambio)
        @if(count($cambio['diferencias']) > 0)

        <div class="tabla-contenedor">
            <table>
                <thead>
                    <tr>
                        <th>CÓDIGO VALE MERGE</th>
                        <th>DESTINO</th>
                        <th>DESCRIPCIÓN</th>
                        <th>MONTO ASIGNADO</th>
                        <th>MONTO MODIFICADO</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cambio['diferencias'] as $d)
                    <tr>
                        <td style="font-weight:bold;">{{ $d['id'] }}</td>
                        <td style="font-weight:bold;">{{ $d['nombredestino'] }}</td>
                        <td style="font-weight:bold;">{{ $d['nombre'] }}</td>
                        <td style="color:#c00; font-weight:bold;">{{ $d['antes'] }}</td>
                        <td style="color:#090; font-weight:bold;">{{ $d['despues'] }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @endif
    @endforeach

</div>
@endif

</body>
</html>
