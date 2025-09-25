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
                background: #34a853;
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
            .termino{
                font-size: 16px;
                color: #dc3545;
            }

        </style>

    </head>


    <body>
        <section>
            <div class='panelcontainer'>
                <div class="panel">

                    <div class="panelhead">DETALLE DE LA LIQUIDACION</div>
                    <div class='panelbody'>

                            <table  class="table demo">
                                <tr>
                                    <th>
                                        DOCUMENTO
                                    </th>
                                </tr>
                            @foreach($larchivos as $index => $item)
                                <tr>
                                    <td>
                                        {{$item->NOM_CATEGORIA_DOCUMENTO}}
                                    </td>
                                </tr>
                            @endforeach
                            </table>
                    </div>
                    
                </div>
            </div>
        </section>
    </body>

</html>


