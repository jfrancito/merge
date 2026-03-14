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
                background-color: #2371f2;
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
            <p>Estimado(a): <b>{{$item->trabajador}}</b></p>
            <p>Se les comunica que tiene planillas de movilidad del ejercicio 2026, enero y Febrero,  que a la fecha no han sido cargadas al Merge con su firma correspondiente.
               <br>Se le solicita regularizar de forma inmediata hasta el <b>13/03/2026</b>.</p>
            <p>Considerar que las planillas de movilidad consolidado tienen que estar cargadas dentro del mes, o hasta la fecha de corte que son los 02 del mes siguiente al periodo del gasto.</p>

        </section>
    </body>

</html>