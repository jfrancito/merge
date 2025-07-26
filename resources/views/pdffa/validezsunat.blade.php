<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Consulta Individual de Comprobantes de Pago</title>
    <style>
        @page {
            margin: 20px;
            size: A4;
        }
        
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 0;
            line-height: 1.4;
        }
        
        .container {
            width: 100%;
            max-width: 100%;
        }
        
        /* Header azul */
        .header {
            background-color: #4a90c2;
            color: white;
            padding: 12px 15px;
            text-align: center;
            font-weight: bold;
            font-size: 14px;
            margin-bottom: 15px;
        }
        
        /* Texto de descripción */
        .description {
            margin-bottom: 15px;
            padding: 0 10px;
            color: #333;
        }
        
        .bullet-points {
            margin: 10px 0;
            padding-left: 25px;
        }
        
        .bullet-points li {
            margin-bottom: 8px;
            color: #555;
        }
        
        /* Formulario */
        .form-container {
            padding: 0 10px;
        }
        
        .form-row {
            display: table;
            width: 100%;
            margin-bottom: 12px;
        }
        
        .form-label {
            display: table-cell;
            width: 35%;
            vertical-align: middle;
            padding-right: 15px;
            font-weight: normal;
            color: #333;
        }
        
        .form-value {
            display: table-cell;
            width: 65%;
            vertical-align: middle;
        }
        
        .form-input {
            border: 1px solid #ccc;
            padding: 6px 8px;
            font-size: 11px;
            background-color: #f9f9f9;
        }
        
        .input-full {
            width: 100%;
            max-width: 200px;
        }
        
        .input-medium {
            width: 80px;
        }
        
        .input-large {
            width: 120px;
        }
        
        .input-date {
            width: 100px;
        }
        
        .input-separator {
            margin: 0 8px;
            font-weight: bold;
        }
        
        /* Campos requeridos */
        .required {
            color: #d9534f;
            font-weight: bold;
        }
        
        /* Botones */
        .button-container {
            text-align: center;
            margin: 20px 0;
        }
        
        .btn {
            padding: 8px 20px;
            font-size: 12px;
            border: none;
            cursor: pointer;
            margin: 0 5px;
            color: white;
            font-weight: bold;
        }
        
        .btn-primary {
            background-color: #4a90c2;
        }
        
        .btn-danger {
            background-color: #d9534f;
        }
        
        /* Resultado */
        .result-header {
            background-color: #4a90c2;
            color: white;
            padding: 10px 15px;
            font-weight: bold;
            margin: 20px 0 0 0;
        }
        
        .result-container {
            border: 1px solid #4a90c2;
            border-top: none;
            padding: 15px;
            background-color: #f8f9fa;
        }
        
        .result-row {
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }
        
        .result-label {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            padding-right: 15px;
            font-weight: normal;
            color: #333;
        }
        
        .result-value {
            display: table-cell;
            width: 50%;
            vertical-align: middle;
            font-weight: bold;
            color: #2c5aa0;
        }
        
        /* Notas al pie */
        .footer-notes {
            margin-top: 15px;
            padding: 0 10px;
            font-size: 10px;
            color: #666;
        }
        
        /* Colon separator */
        .colon {
            margin-right: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Header -->
        <div class="header">
            CONSULTA INDIVIDUAL DE COMPROBANTES DE PAGO
        </div>
        
        <!-- Descripción -->
        <div class="description">
            <p>A través de esta opción puede consultar la validez de determinados comprobantes de pago.</p>
            <ul class="bullet-points">
                <li>Se recuerda que los Comprobantes de Pago Electrónicos pueden ser informados a SUNAT dentro del plazo establecido según normativa vigente.</li>
                <li>En el caso de Comprobantes de Pago Físicos se valida que esté autorizado por SUNAT y la fecha de emisión permite validar la condición y estado del RUC</li>
            </ul>
        </div>
        
        <!-- Formulario -->
        <div class="form-container">
            <div class="form-row">
                <div class="form-label">
                    Número de RUC del emisor <span class="required">*</span><span class="colon">:</span>
                </div>
                <div class="form-value">
                    <input type="text" class="form-input input-full" value="{{ $datos['ruc_emisor'] ?? '20603682271' }}" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label">
                    Tipo de comprobante <span class="required">*</span><span class="colon">:</span>
                </div>
                <div class="form-value">
                    <input type="text" class="form-input input-full" value="{{ $datos['tipo_comprobante'] ?? 'Factura' }}" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label">
                    Serie y número de comprobante <span class="required">*</span><span class="colon">:</span>
                </div>
                <div class="form-value">
                    <input type="text" class="form-input input-medium" value="{{ $datos['serie'] ?? 'F004' }}" readonly>
                    <span class="input-separator">-</span>
                    <input type="text" class="form-input input-medium" value="{{ $datos['numero'] ?? '550' }}" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label">
                    Tipo y número de documento del receptor<span class="colon">:</span>
                </div>
                <div class="form-value">
                    <input type="text" class="form-input input-medium" value="{{ $datos['tipo_documento'] ?? 'RUC' }}" readonly>
                    <span class="input-separator">-</span>
                    <input type="text" class="form-input input-large" value="{{ $datos['documento_receptor'] ?? '20602740278' }}" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label">
                    Fecha de emisión <span class="required">*</span><span class="colon">:</span>
                </div>
                <div class="form-value">
                    <input type="text" class="form-input input-date" value="{{ $datos['fecha_emision'] ?? '11/07/2025' }}" readonly>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-label">
                    Importe total <span class="required">**</span><span class="colon">:</span>
                </div>
                <div class="form-value">
                    <input type="text" class="form-input input-medium" value="{{ $datos['importe_total'] ?? '100.00' }}" readonly style="text-align: right;">
                </div>
            </div>
        </div>
        
        <!-- Notas de campos obligatorios -->
        <div class="footer-notes">
            <p>Los campos con (<span class="required">*</span>) son obligatorios</p>
            <p>Los campos con (<span class="required">**</span>) son obligatorios para comprobantes electrónicos</p>
        </div>
        
        <!-- Botones -->
        <div class="button-container">
            <button class="btn btn-primary">Consultar</button>
            <button class="btn btn-danger">Limpiar</button>
        </div>
        
        <!-- Resultado de la búsqueda -->
        @if(isset($mostrar_resultado) && $mostrar_resultado)
        <div class="result-header">
            Resultado de la Búsqueda
        </div>
        <div class="result-container">
            <div class="result-row">
                <div class="result-label">
                    Estado del comprobante a la fecha de la consulta<span class="colon">:</span>
                </div>
                <div class="result-value">
                    {{ $resultado['estado_comprobante'] ?? 'ACEPTADO' }}
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">
                    Estado del contribuyente a la fecha de emisión<span class="colon">:</span>
                </div>
                <div class="result-value">
                    {{ $resultado['estado_contribuyente'] ?? 'ACTIVO' }}
                </div>
            </div>
            
            <div class="result-row">
                <div class="result-label">
                    Condición de domicilio a la fecha de emisión<span class="colon">:</span>
                </div>
                <div class="result-value">
                    {{ $resultado['condicion_domicilio'] ?? 'HABIDO' }}
                </div>
            </div>
        </div>
        @endif
    </div>
</body>
</html>