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

        </style>

    </head>


    <body>
        <section>
            <div class='panelcontainer'>
                <div class="panel">
                    <div class='panelbodycodigo'>
                            <h3>LIQUIDACION  {{$item->ID_DOCUMENTO}}  ({{$oc->NRO_SERIE}} - {{$oc->NRO_DOC}})</h3>
                    </div>
                    <div class="panelhead">APLICAR VALE Y LIQUIDACION</div>
                    <div class='panelbody'>
                            <table  class="table demo">
                                <tr>
                                    <td>EMPRESA :</td>
                                    <td>{{$item->TXT_EMPR_EMISOR}}</td>
                                </tr>
                                <tr>
                                    <td>TRABAJADOR :</td>
                                    <td>{{$oc->TXT_EMPR_RECEPTOR}}</td>
                                </tr>
                                <tr>
                                    <td>LIQUIDACION :</td>
                                    <td>{{$oc->NRO_SERIE}} - {{$oc->NRO_DOC}}</td>
                                </tr>
                                <tr>
                                    <td>VALE :</td>
                                    <td>{{$vale_doc}}</td>
                                </tr>
                                <tr>
                                    <td>MONEDA :</td>
                                    <td>{{$oc->TXT_CATEGORIA_MONEDA}}</td>
                                </tr>
                                <tr>
                                    <td>MONTO DE LIQUIDACION :</td>
                                    <td><b>{{$oc->CAN_TOTAL}}</b></td>
                                </tr>
                                <tr>
                                    <td>MONTO DEL VALE :</td>
                                    <td><b>{{$monto_vale}}</b></td>
                                </tr>
                            </table>
                    </div>
                </div>
            </div>
        </section>
    </body>

</html>


