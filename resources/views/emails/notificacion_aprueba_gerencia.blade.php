<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Pedido - Aprobación Gerencia</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f0f2f5; font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f0f2f5; padding: 40px 0;">
        <tr>
            <td align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.08);">
                    
                    <!-- HEADER -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0b1a3d, #1f2a50); padding: 50px 40px; text-align: center;">
                            <div style="background-color: rgba(255,255,255,0.1); display: inline-block; padding: 12px 25px; border-radius: 50px; margin-bottom: 20px;">
                                <span style="color: #ffffff; font-size: 13px; font-weight: 700; letter-spacing: 2px; text-uppercase;">NOTIFICACIÓN INTERNA</span>
                            </div>
                            <h1 style="color: #ffffff; margin: 0; font-size: 28px; font-weight: 200; letter-spacing: 1px;">Aprobación de Gerencia</h1>
                        </td>
                    </tr>

                    <!-- CONTENT AREA -->
                    <tr>
                        <td style="padding: 50px 50px 40px 50px; color: #4a4a4a; line-height: 1.8;">
                            <p style="font-size: 18px; margin-bottom: 30px; color: #1f2a50;">
                                Estimado(a), <strong>{{ $manager_name }}</strong>
                            </p>
                            <p style="font-size: 16px; margin-bottom: 25px;">
                                Se ha generado un nuevo requerimiento en el <strong>Sistema de Órdenes de Pedido</strong> que requiere de su atenta revisión y aprobación para proceder con la gestión de compras.
                            </p>
                            
                            <!-- DATA CARD -->
                            <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #f8fafc; border-radius: 10px; border: 1px solid #e2e8f0; margin-bottom: 30px;">
                                <tr>
                                    <td style="padding: 25px;">
                                        <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                            <tr>
                                                <td width="40%" style="padding-bottom: 15px;">
                                                    <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Número de Pedido</span>
                                                    <div style="font-size: 18px; color: #1e293b; font-weight: 800;">{{ $pedido_id }}</div>
                                                </td>
                                                <td width="60%" style="padding-bottom: 15px;">
                                                    <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Solicitado por</span>
                                                    <div style="font-size: 15px; color: #1e293b; font-weight: 600;">{{ $solicita_name }}</div>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="2" style="border-top: 1px solid #e2e8f0; padding-top: 15px;">
                                                    <span style="font-size: 12px; color: #64748b; text-transform: uppercase; font-weight: 700; letter-spacing: 1px;">Glosa / Observación</span>
                                                    <div style="font-size: 14px; color: #334155; font-style: italic;">{{ $glosa ?: 'Sin detalles adicionales' }}</div>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>

                            <p style="font-size: 15px; margin-bottom: 20px; text-align: center;">
                                Por favor, acceda al portal corporativo para validar los detalles de esta orden.
                            </p>
                        </td>
                    </tr>

                    <!-- FOOTER BAR -->
                    <tr>
                        <td align="center" style="padding: 0 50px 50px 50px;">
                            <table border="0" cellpadding="0" cellspacing="0" style="background-color: #1f2a50; border-radius: 6px;">
                                <tr>
                                    <td align="center" style="padding: 15px 35px;">
                                        <a href="https://merge.grupoinduamerica.com/merge/login" style="color: #ffffff; text-decoration: none; font-weight: 700; font-size: 14px; letter-spacing: 1px;">INGRESAR AL SISTEMA</a>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <!-- LEGAL FOOTER -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 30px; text-align: center; border-top: 1px solid #e2e8f0;">
                            <p style="margin: 0; font-size: 11px; color: #94a3b8; line-height: 1.6;">
                                Este es un mensaje generado automáticamente por el Sistema de Gestión Institucional de <strong>INDUAMERICA</strong>.<br>
                                Por favor no responder a este correo electrónico.
                            </p>
                            <p style="margin: 10px 0 0 0; font-size: 11px; color: #94a3b8; font-weight: 700;">
                                &copy; {{ date('Y') }} INDUAMERICA. All Rights Reserved.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
