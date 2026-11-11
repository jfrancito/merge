<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8" />
        <style type="text/css">
            section{
                width: 100%;
                background: #E8E8E8;
                padding: 0px;
                margin: 0px;
            }

            .panelcontainer{
                width: 50%;
                background: #fff;
                margin: 0 auto;
            }
            .fondogris{
                background: #cce6fd;
                text-align: center;
            }
            .panelhead{
                background: #eb6357;
                padding-top: 10px;
                padding-bottom: 10px;
                color: #fff;
                text-align: center;
                font-size: 1.2em;
            }
            .panelbody,.panelbodycodigo{
                padding-left: 15px;
                padding-right: 15px;
            }
            .panelbodycodigo h3 small{
                color: #08257C;
            }

            table, td, th {    
                border: 1px solid #ddd;
                text-align: left;
            }

            table {
                border-collapse: collapse;
                width: 100%;
            }

            th, td {
                padding: 15px;
                font-size: 12px;
            }
            th.label {
                font-weight: bold;
                color: #333;
                width: 40%;
                border-bottom: 1px solid #eee;
            }

            th.labelo {
                background-color: #37b358;
                font-weight: bold;
                color: #333;
                width: 40%;
                border-bottom: 1px solid #eee;
            }


            .merge{
                width: 50%;
            }
            .osiris{
                width: 50%;
            }
        </style>
    </head>


    <body>
        <section>
            <p>Por los periodos Enero , Febrero y Marzo, del 2026.</p>
            <p>De forma reiterativa,  se les comunica que tiene planillas de movilidad del ejercicio 2026 que a la fecha no han sido cargadas al Merge con su firma correspondiente. <br>
                Se le solicita regularizar hasta el <b>10/04/2026</b>,  caso contrario se procederá bloquear permisos para generar planillas de movilidad, y a su vez se comunicará al área de Gestión de Talento Humano para que evalúen cómo proceder.
            </p>

            <p>Adjunto detalle:</p>
            <table  class="table" >
                <tr>
                    <th class="label">
                        Periodo
                    </th>
                    <th class="label">
                        Trabajador
                    </th>
                    <th class="label">
                        Nro Planilla
                    </th>
                    <th class="label">
                        Fecha de Emisión de Planilla
                    </th>
                    <th class="label">
                        Cargo
                    </th>
                    <th class="label">
                        Total
                    </th>
                    <th class="label">
                        Id Liquidación
                    </th> 
                </tr>
                @foreach($listadocumentosdet as $index => $item2)
                    <tr>
                        <td>{{$item2->TXT_PERIODO}}</td>
                        <td>{{$item2->TRABAJADOR}}</td>
                        <td>{{$item2->SERIE}}-{{$item2->NUMERO}}</td>
                        <td>{{$item2->FECHA_EMI}}</td>
                        <td>{{$item2->cadcargo}}</td>
                        <td>{{$item2->TOTAL}}</td>
                        <td>{{$item2->ID_DOCUMENTO}}</td>
                    </tr>
                @endforeach
            </table>

            <p>Tomar en cuenta que, desde el 1ero de Abril ya no existe planilla de movilidad consolidado. En el Merge se ha cargado un video instructivo de como deben generar la planilla.</p>
            <p><b>Saludos.</b></p>

        </section>
    </body>

</html>