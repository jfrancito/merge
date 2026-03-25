<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle Contrato Acopio - {{ $contrato->NRO_CONTRATO }}</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Icons -->
    <link rel="stylesheet" href="https://cdn.materialdesignicons.com/5.4.55/css/materialdesignicons.min.css">
    
    <style>
        :root {
            --primary: #2563eb;
            --primary-dark: #1e40af;
            --secondary: #64748b;
            --success: #10b981;
            --warning: #f59e0b;
            --error: #ef4444;
            --info: #0ea5e9;
            --dark: #0f172a;
            --light: #f8fafc;
            --white: #ffffff;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-300: #cbd5e1;
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: #f1f5f9;
            color: var(--dark);
            line-height: 1.5;
            padding: 20px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Header Animation */
        @keyframes slideDown {
            from { transform: translateY(-30px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            animation: slideDown 0.6s ease-out;
        }

        .header-title h1 {
            font-size: 28px;
            font-weight: 700;
            color: var(--dark);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .header-title h1 i {
            color: var(--primary);
            background: var(--white);
            padding: 10px;
            border-radius: 12px;
            box-shadow: var(--shadow);
        }

        .badge-numero {
            background: var(--primary);
            color: var(--white);
            padding: 4px 16px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 12px rgba(37, 99, 235, 0.2);
        }

        /* Stats Grid */
        .grid-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: var(--white);
            padding: 24px;
            border-radius: 16px;
            box-shadow: var(--shadow);
            border: 1px solid var(--slate-100);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            display: flex;
            flex-direction: column;
            gap: 8px;
            animation: fadeIn 0.8s ease-out backwards;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stat-card .label {
            font-size: 13px;
            font-weight: 600;
            color: var(--secondary);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-card .value {
            font-size: 24px;
            font-weight: 700;
            color: var(--dark);
        }

        .stat-card .value.highlight {
            color: var(--primary);
        }

        .delay-1 { animation-delay: 0.1s; }
        .delay-2 { animation-delay: 0.2s; }
        .delay-3 { animation-delay: 0.3s; }

        /* Main Grid */
        .main-grid {
            display: grid;
            grid-template-columns: 1fr 380px;
            gap: 24px;
        }

        @media (max-width: 992px) {
            .main-grid {
                grid-template-columns: 1fr;
            }
        }

        .card {
            background: var(--white);
            border-radius: 20px;
            box-shadow: var(--shadow);
            border: 1px solid var(--slate-100);
            overflow: hidden;
            animation: fadeIn 1s ease-out;
        }

        .card-header {
            padding: 20px 24px;
            background: var(--light);
            border-bottom: 1px solid var(--slate-200);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .card-header i {
            font-size: 20px;
            color: var(--primary);
        }

        .card-header h2 {
            font-size: 18px;
            font-weight: 700;
            color: var(--dark);
        }

        /* Info Grid */
        .info-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            padding: 24px;
        }

        .info-item {
            display: flex;
            flex-direction: column;
            gap: 4px;
        }

        .info-item label {
            font-size: 11px;
            font-weight: 700;
            color: var(--secondary);
            text-transform: uppercase;
        }

        .info-item .text {
            font-size: 15px;
            font-weight: 600;
            color: var(--dark);
        }

        .footer-info {
            padding: 20px 24px;
            background: #fdfdfd;
            border-top: 1px solid var(--slate-100);
        }

        .glosa {
            background: var(--light);
            padding: 12px;
            border-radius: 8px;
            font-size: 14px;
            color: var(--secondary);
            font-style: italic;
            border-left: 3px solid var(--primary);
        }

        /* Table Styles */
        .table-container {
            padding: 0;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            background: var(--light);
            padding: 16px 24px;
            text-align: left;
            font-size: 12px;
            font-weight: 700;
            color: var(--secondary);
            text-transform: uppercase;
            border-bottom: 1px solid var(--slate-200);
        }

        td {
            padding: 16px 24px;
            font-size: 14px;
            border-bottom: 1px solid var(--slate-100);
            vertical-align: middle;
        }

        tr:last-child td {
            border-bottom: none;
        }

        tr:hover td {
            background-color: #fcfcfc;
        }

        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .font-medium { font-weight: 500; }

        .badge {
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-error { background: #fee2e2; color: #991b1b; }
        .badge-info { background: #0ea5e9; color: var(--white); }

    </style>
</head>
<body>

    <div class="container">
        <!-- Header -->
        <header class="header">
            <div class="header-title">
                <h1>
                    <i class="mdi mdi-buffer"></i>
                    Contrato de Acopio 
                    <span class="badge-numero">{{ $contrato->NRO_CONTRATO }}</span>
                </h1>
            </div>
            <div style="text-align: right;">
                <div style="font-size: 12px; color: var(--secondary); font-weight: 600;">Estado del Contrato</div>
                <div style="color: var(--success); font-weight: 700; display: flex; align-items: center; gap: 5px; justify-content: flex-end;">
                    <i class="mdi mdi-check-decagram"></i> ACTIVO
                </div>
            </div>
        </header>

        <!-- Quick Stats -->
        <div class="grid-stats">
            <div class="stat-card delay-1">
                <span class="label">Proyección Total</span>
                <span class="value highlight">S/ {{ number_format($contrato->PROYECCION, 2) }}</span>
            </div>
            <div class="stat-card delay-2">
                <span class="label">Importe Habilitado</span>
                <span class="value">S/ {{ number_format($contrato->IMPORTE_HABILITAR, 2) }}</span>
            </div>
            <div class="stat-card delay-3">
                <span class="label">Total KG</span>
                <span class="value">{{ number_format($contrato->TOTAL_KG, 2) }} kg</span>
            </div>
            <div class="stat-card">
                <span class="label">Variedad</span>
                <span class="value" style="font-size: 16px;">{{ $contrato->TXT_VARIEDAD }}</span>
            </div>
        </div>

        <div class="main-grid">
            <!-- Left Side: Main Info Table -->
            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-calendar-clock"></i>
                    <h2>Proyección de Anticipos</h2>
                </div>
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Fecha Programada</th>                                   
                                <th class="text-right">Importe</th>
                                <th class="text-right">Días Restantes (+/-)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $total_prog = 0; @endphp
                            @forelse($detalles as $det)
                                @php
                                    $total_prog += $det->IMPORTE;
                                    $fecha_prog = \Carbon\Carbon::parse($det->FECHA);
                                    $diff = $fecha_prog->diffInDays(\Carbon\Carbon::today(), false);
                                @endphp
                                <tr>
                                    <td class="font-bold" style="color: var(--secondary);">{{ isset($det->ITEM) ? $det->ITEM : $loop->iteration }}</td>
                                    <td class="font-medium">
                                        <div style="font-weight: 600;">{{ date_format(date_create($det->FECHA), 'd/m/Y') }}</div>
                                        <div style="font-size: 10px; color: var(--secondary); background: #f1f5f9; padding: 2px 6px; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px; margin-top: 4px; border: 1px solid #e2e8f0;">
                                            <i class="mdi mdi-calendar-range" style="font-size: 12px; color: var(--primary);"></i>
                                            Ventana Pago: -2 / +2 días
                                        </div>
                                    </td>
                                    <td class="text-right font-bold" style="color: var(--dark);">S/ {{ number_format($det->IMPORTE, 2) }}</td>
                                    <td class="text-right">
                                        @if($diff > 0)
                                            <span class="badge badge-error">-{{ abs($diff) }} días</span>
                                        @elseif($diff < 0)
                                            <span class="badge badge-success">+{{ abs($diff) }} días</span>
                                        @else
                                            <span class="badge badge-info text-white">Hoy</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" style="text-align: center; padding: 40px; color: var(--secondary);">No se registraron detalles de proyección.</td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($detalles->count() > 0)
                        <tfoot>
                            <tr style="background: var(--dark); color: var(--white);">
                                <td colspan="2" class="text-right" style="font-weight: 700; color: white; padding: 18px 24px;">TOTAL PROGRAMADO</td>
                                <td class="text-right" style="font-weight: 700; font-size: 16px; color: white; padding: 18px 24px;">S/ {{ number_format($total_prog, 2) }}</td>
                                <td></td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Right Side: Contact / Business detail -->
            <div class="card">
                <div class="card-header">
                    <i class="mdi mdi-information-outline"></i>
                    <h2>Información del Contrato</h2>
                </div>
                <div class="panel-body">
                    <div class="info-grid" style="grid-template-columns: 1fr;">
                        <div class="info-item">
                            <label>Proveedor</label>
                            <span class="text" style="color: var(--primary); font-size: 16px;">{{ $contrato->TXT_PROVEEDOR }}</span>
                        </div>
                        <div class="info-item">
                            <label>Empresa</label>
                            <span class="text">{{ $contrato->TXT_EMPRESA }}</span>
                        </div>
                        <div class="info-item">
                            <label>Sede / Centro</label>
                            <span class="text">{{ $contrato->TXT_CENTRO }}</span>
                        </div>
                        <div class="info-item">
                            <label>Fecha Contrato</label>
                            <span class="text">{{ date_format(date_create($contrato->FECHA_CONTRATO), 'd/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Fecha Cosecha</label>
                            <span class="text">{{ date_format(date_create($contrato->FECHA_COSECHA), 'd/m/Y') }}</span>
                        </div>
                        <div class="info-item">
                            <label>Hectáreas</label>
                            <span class="text">{{ number_format($contrato->HECTAREAS, 2) }} ha</span>
                        </div>
                    </div>

                    @if($contrato->GLOSA)
                    <div class="footer-info">
                        <label style="font-size: 11px; font-weight: 700; color: var(--secondary); margin-bottom: 5px; display: block;">OBSERVACIONES</label>
                        <p class="glosa">{{ $contrato->GLOSA }}</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</body>
</html>
