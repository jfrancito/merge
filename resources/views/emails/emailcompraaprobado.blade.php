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
            <div class='panelcontainer'>
                <div class="panel">
                    <div class='panelbody'>
                            <table  class="table demo" >
                                <tr>
                                    <th>
                                        ID DOCUMENTO
                                    </th>
                                    <th>
                                        PROVEEDOR
                                    </th>
                                    <th>
                                        DOCUMENTO
                                    </th>
                                    <th>
                                        MONEDA
                                    </th>
                                    <th>
                                        OPERACION
                                    </th>
                                    <th>
                                        TOTAL
                                    </th>                                     
                                </tr>
                                <tr>
                                    <td>{{$item->ID_DOCUMENTO}}</td>
                                    <td>{{$item->RZ_PROVEEDOR}}</td>
                                    <td>{{$item->SERIE}} - {{$item->NUMERO}}</td>
                                    <td>{{$item->MONEDA}}</td>
                                    <td>{{$item->OPERACION}}</td>
                                    <td>{{number_format($item->TOTAL_VENTA_ORIG, 2, '.', ',')}}</td>
                                </tr>
                            </table>
                    </div>

                    <div style="width: 50px;"></div>

                    <div class='panelbodycodigo'>
                        <div class='historial merge'>

                                <table>
                                    <tr>
                                        <td>
                                            <h3>HISTORIAL MERGE</h3>
                                            <table  class="table demo" >
                                                <tr>
                                                    <th class="label">
                                                        USUARIO
                                                    </th>
                                                    <th class="label">
                                                        ACCION
                                                    </th>
                                                    <th class="label">
                                                        FECHA
                                                    </th>                                    
                                                </tr>
                                                @foreach($fe_historial as $index => $item2)
                                                    <tr>
                                                        <td>{{$item2->USUARIO_NOMBRE}}</td>
                                                        <td>{{$item2->TIPO}}</td>
                                                        <td>{{$item2->FECHA}}</td>
                                                    </tr>
                                                @endforeach

                                            </table>

                                        </td>
                                        <td>
                                            @if($item->OPERACION == 'ORDEN_COMPRA') 
                                            <h3>HISTORIAL OSIRIS</h3>
                                            <table  class="table demo" >
                                                <tr>
                                                    <th class="labelo">
                                                        USUARIO
                                                    </th>
                                                    <th class="labelo">
                                                        ACCION
                                                    </th>                                  
                                                </tr>
                                                    <tr>
                                                        <td>{{$usuario_solicita}}</td>
                                                        <td>SOLICITA</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$usuario_autoriza}}</td>
                                                        <td>AUTORIZA</td>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$usuario_aprueba}}</td>
                                                        <td>APRUEBA</td>
                                                    </tr>
                                            </table>
                                            @endif

                                        </td>

                                    </tr>
                                </table>

                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>

</html>