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
                    <div class="panelhead">APLICAR VALE Y LIQUIDACION</div>
                    <div class='panelbody'>

                            <table  class="table demo">
                                <tr>
                                    <td>DATOS</td>
                                    <td>LIQUIDACION</td>
                                    <td>VALE</td>
                                </tr>
                                <tr>
                                    <td><b>ID :</b></td>
                                    <td>{{$oc->COD_DOCUMENTO_CTBLE}}</td>
                                    <td>{{$autorizacion->COD_AUTORIZACION}}</td>
                                </tr>
                                <tr>
                                    <td><b>DOCUMENTO :</b></td>
                                    <td>{{$oc->NRO_SERIE}} - {{$oc->NRO_DOC}}</td>
                                    <td>{{$autorizacion->TXT_SERIE}} - {{$autorizacion->TXT_NUMERO}}</td>
                                </tr>
                                <tr>
                                    <td><b>EMPRESA :</b></td>
                                    <td>{{$oc->TXT_EMPR_EMISOR}}</td>
                                    <td>{{$oc->TXT_EMPR_EMISOR}}</td>
                                </tr>
                                <tr>
                                    <td><b>SOLICITADO POR :</b></td>
                                    <td>{{$oc->TXT_EMPR_RECEPTOR}}</td>
                                    <td>{{$autorizacion->TXT_EMPRESA}}</td>
                                </tr>
                                <tr>
                                    <td><b>AUTORIZADO POR :</b></td>
                                    <td>{{$item->TXT_USUARIO_AUTORIZA}}</td>
                                    <td>{{$valeRendir->TXT_NOM_AUTORIZA}}</td>
                                </tr>
                                <tr>
                                    <td><b>MONEDA :</b></td>
                                    <td>{{$oc->TXT_CATEGORIA_MONEDA}}</td>
                                    <td>{{$autorizacion->TXT_CATEGORIA_MONEDA}}</td>
                                </tr>
                                <tr>
                                    <td><b>IMPORTE TOTAL :</b></td>
                                    <td><b>{{$oc->CAN_TOTAL}}</b></td>
                                    <td><b>{{$autorizacion->CAN_TOTAL}}</b></td>
                                </tr>


                                <tr>
                                    <td><b>ACCION :</b></td>
                                    <td class="termino"><b>{{$termino}}</b></td>
                                    <td class="termino"><b>{{$montotermino}}</b></td>
                                </tr>

                            </table>
                    </div>

                    <br><br>


                    <div class="panelhead">DETALLE DE LA LIQUIDACION</div>
                    <div class='panelbody'>

                            <table  class="table demo">
                            <tr>
                                <th>
                                    COD_DOCUMENTO_CTBLE
                                </th>
                                <th>
                                    SERIE
                                </th>
                                <th>
                                    DOCUMENTO
                                </th>
                                <th>
                                    FECHA EMISION
                                </th>
                                <th>
                                    PROVEEDOR
                                </th>
                                <th>
                                    TIPO DOCUMENTO
                                </th>
                                <th>
                                    IMPORTE
                                </th>
                            </tr>

                            @foreach($documentos as $index => $item)
                                <tr>
                                    <td>
                                        {{$item->COD_DOCUMENTO_CTBLE}}
                                    </td>
                                    <td>
                                        {{$item->NRO_SERIE}}
                                    </td>
                                    <td>
                                        {{$item->NRO_DOC}}
                                    </td>
                                    <td>
                                        {{$item->FEC_EMISION}}
                                    </td>
                                    <td>
                                        {{$item->TXT_EMPR_EMISOR}}
                                    </td>
                                    <td>
                                        {{$item->TXT_CATEGORIA_TIPO_DOC}}
                                    </td>
                                    <td>
                                        {{$item->CAN_TOTAL}}
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


