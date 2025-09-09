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
                                    <td>
                                        @if(count($autorizacion)>0)
                                            {{$autorizacion->COD_AUTORIZACION}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>DOCUMENTO :</b></td>
                                    <td>{{$oc->NRO_SERIE}} - {{$oc->NRO_DOC}}</td>
                                    <td>
                                        @if(count($autorizacion)>0)
                                            {{$autorizacion->TXT_SERIE}} - {{$autorizacion->TXT_NUMERO}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>EMPRESA :</b></td>
                                    <td>{{$oc->TXT_EMPR_EMISOR}}</td>
                                    <td>
                                        @if(count($autorizacion)>0)
                                            {{$oc->TXT_EMPR_EMISOR}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>SOLICITADO POR :</b></td>
                                    <td>{{$oc->TXT_EMPR_RECEPTOR}}</td>
                                    <td>
                                        @if(count($autorizacion)>0)
                                            {{$autorizacion->TXT_EMPRESA}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>AUTORIZADO POR :</b></td>
                                    <td>{{$item->TXT_USUARIO_AUTORIZA}}</td>
                                    <td>
                                        @if(count($autorizacion)>0)
                                            {{$valeRendir->TXT_NOM_AUTORIZA}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>MONEDA :</b></td>
                                    <td>{{$oc->TXT_CATEGORIA_MONEDA}}</td>
                                    <td>
                                        @if(count($autorizacion)>0)
                                            {{$autorizacion->TXT_CATEGORIA_MONEDA}}
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>IMPORTE TOTAL :</b></td>
                                    <td><b>{{$oc->CAN_TOTAL}}</b></td>
                                    <td><b>
                                        @if(count($autorizacion)>0)
                                            {{$autorizacion->CAN_TOTAL}}
                                        @endif
                                    </b></td>
                                </tr>
                                <tr>
                                    <td><b>ACCION :</b></td>
                                    <td class="termino"><b>{{$termino}}</b></td>
                                    <td class="termino"><b>{{$montotermino}}</b></td>
                                </tr>
                                <tr>
                                    <td><b>TIPO PAGO :</b></td>
                                    <td class="">{{$item->TXT_CATEGORIA_TIPOPAGO}}</td>
                                    <td class="termino"></td>
                                </tr>

                                <tr>
                                    <td><b>TIPO CUENTA :</b></td>
                                    <td class="">{{$item->TXT_CATEGORIA_TIPOCUENTA}}</td>
                                    <td class="termino"></td>
                                </tr>
                                <tr>
                                    <td><b>BANCO :</b></td>
                                    <td class="">{{$item->TXT_CATEGORIA_BANCARIO}}</td>
                                    <td class="termino"></td>
                                </tr>
                                <tr>
                                    <td><b>CUENTA BANCARIA :</b></td>
                                    <td class="">{{$item->CUENTA_BANCARIA}}</td>
                                    <td class="termino"></td>
                                </tr>

                                <tr>
                                    <td><b>CUENTA BANCARIA CCI :</b></td>
                                    <td class="">{{$item->CCI_CUENTA_BANCARIA}}</td>
                                    <td class="termino"></td>
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


