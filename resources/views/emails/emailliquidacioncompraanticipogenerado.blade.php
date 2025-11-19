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
                            <h3>Orden de Pago  ({{$estado}}) </h3>
                    </div>
                    <div class="panelhead">ORDEN PAGO</div>
                    <div class='panelbody'>
                            <table  class="table demo" >
                                <tr>
                                    <th>
                                        ORDEN PAGO
                                    </th>
                                    <th>
                                        DOCUMENTO
                                    </th>
                                    <th>
                                        FECHA ORDEN
                                    </th>
                                    <th>
                                        MONEDA
                                    </th>
                                    <th>
                                        PROVEEDOR
                                    </th>
                                    <th>
                                        TOTAL
                                    </th>                                     
                                </tr>
                                <tr>
                                    <td>{{$ordenpago->COD_AUTORIZACION}}</td>

                                    <td>{{$ordenpago->TXT_SERIE}} - {{$ordenpago->TXT_NUMERO}}</td>
                                    
                                    <td>{{date_format(date_create($ordenpago->FEC_AUTORIZACION), 'd-m-Y H:i')}}</td>
                                    <td>{{$ordenpago->TXT_CATEGORIA_MONEDA}}</td>
                                    <td>{{$ordenpago->TXT_EMPRESA}}</td>
                                    <td>{{$ordenpago->CAN_TOTAL}}</td>
                                </tr>
                            </table>
                    </div>




                </div>
            </div>
        </section>
    </body>

</html>