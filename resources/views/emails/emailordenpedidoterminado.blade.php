<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8"/>
<style>
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: #eef2f7;
    margin: 0;
    padding: 20px;
}

/* CONTENEDOR */
.container {
    max-width: 680px;
    margin: auto;
    background: #ffffff;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 12px 30px rgba(0,0,0,0.08);
}

/* HEADER */
.header {
    background: linear-gradient(135deg, #0f172a, #1e3a8a);
    color: #fff;
    text-align: center;
    padding: 30px 20px;
}

.header h1 {
    margin: 0;
    font-size: 20px;
    letter-spacing: 1px;
}

/* STATUS BADGE */
.status {
    display: inline-block;
    margin-top: 10px;
    padding: 8px 18px;
    border-radius: 50px;
    background: #22c55e;
    font-size: 13px;
    font-weight: bold;
}

/* CONTENT */
.content {
    padding: 30px 35px;
}

/* TEXTO */
.intro {
    font-size: 15px;
    color: #374151;
    line-height: 1.6;
    margin-bottom: 25px;
}

/* CARD INFO */
.card {
    background: #f9fafb;
    border-radius: 10px;
    padding: 20px;
    border: 1px solid #e5e7eb;
}

/* TABLA */
table {
    width: 100%;
    border-collapse: collapse;
}

th {
    text-align: left;
    font-size: 12px;
    color: #6b7280;
    padding: 10px 0;
    width: 35%;
}

td {
    font-size: 14px;
    font-weight: 600;
    color: #111827;
}

/* ID DESTACADO */
.id {
    color: #1e3a8a;
    font-weight: bold;
    font-size: 16px;
}

/* FOOTER */
.footer {
    text-align: center;
    padding: 20px;
    font-size: 12px;
    color: #9ca3af;
    border-top: 1px solid #e5e7eb;
}

/* LINEA SEPARADORA */
.divider {
    height: 1px;
    background: #e5e7eb;
    margin: 25px 0;
}
</style>
</head>

<body>

<div class="container">

    <!-- HEADER -->
    <div class="header">
        <h1>ORDEN DE PEDIDO</h1>
        <div class="status">DISPONIBLE PARA RECOJO</div>
    </div>

    <!-- CONTENT -->
    <div class="content">

      <p class="intro" style="font-family: 'Segoe UI', 'Helvetica Neue', Arial, sans-serif; font-size: 15px; color: #374151; line-height: 1.6;">
            Estimados,<br><br>
            Su <strong style="color:#000;">Orden de Pedido</strong> ha sido procesada correctamente y se encuentra 
            <strong style="color:#000;">lista para su recojo</strong>.
    </p>

        <div class="card">
            <table>
                <tr>
                    <th>ID Pedido</th>
                    <td class="id">{{ $pedido->ID_PEDIDO }}</td>
                </tr>
                <tr>
                    <th>Fecha</th>
                    <td>{{ date('d/m/Y', strtotime($pedido->FEC_PEDIDO)) }}</td>
                </tr>
                <tr>
                    <th>Solicitante</th>
                    <td>{{ $pedido->TXT_TRABAJADOR_SOLICITA }}</td>
                </tr>
                <tr>
                    <th>Autorizado por</th>
                    <td>{{ $pedido->TXT_TRABAJADOR_AUTORIZA }}</td>
                </tr>
                <tr>
                    <th>Área</th>
                    <td>{{ $pedido->TXT_AREA }}</td>
                </tr>
                <tr>
                    <th>Motivo</th>
                    <td>{{ $pedido->TXT_GLOSA }}</td>
                </tr>
            </table>
        </div>

        <div class="divider"></div>

        <p style="font-size:13px; color:#6b7280;">
            Por favor, acérquese al área correspondiente dentro del horario establecido para recoger su pedido.
        </p>

    </div>

    <!-- FOOTER -->
    <div class="footer">
        © {{ date('Y') }} INDUAMERICA<br>
        Sistema de Gestión de Orden de Pedidos
    </div>

</div>

</body>
</html>