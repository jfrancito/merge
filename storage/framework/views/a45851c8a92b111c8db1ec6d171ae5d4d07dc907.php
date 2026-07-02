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
                                    <td><?php echo e($oc->COD_DOCUMENTO_CTBLE); ?></td>
                                    <td>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($autorizacion->COD_AUTORIZACION); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>DOCUMENTO :</b></td>
                                    <td><?php echo e($oc->NRO_SERIE); ?> - <?php echo e($oc->NRO_DOC); ?></td>
                                    <td>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($autorizacion->TXT_SERIE); ?> - <?php echo e($autorizacion->TXT_NUMERO); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>EMPRESA :</b></td>
                                    <td><?php echo e($oc->TXT_EMPR_EMISOR); ?></td>
                                    <td>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($oc->TXT_EMPR_EMISOR); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>SOLICITADO POR :</b></td>
                                    <td><?php echo e($oc->TXT_EMPR_RECEPTOR); ?></td>
                                    <td>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($autorizacion->TXT_EMPRESA); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>AUTORIZADO POR :</b></td>
                                    <td><?php echo e($item->TXT_USUARIO_AUTORIZA); ?></td>
                                    <td>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($valeRendir->TXT_NOM_AUTORIZA); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>MONEDA :</b></td>
                                    <td><?php echo e($oc->TXT_CATEGORIA_MONEDA); ?></td>
                                    <td>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($autorizacion->TXT_CATEGORIA_MONEDA); ?>

                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <tr>
                                    <td><b>IMPORTE TOTAL :</b></td>
                                    <td><b><?php echo e($oc->CAN_TOTAL); ?></b></td>
                                    <td><b>
                                        <?php if(count($autorizacion)>0): ?>
                                            <?php echo e($autorizacion->CAN_TOTAL); ?>

                                        <?php endif; ?>
                                    </b></td>
                                </tr>
                                <tr>
                                    <td><b>ACCION :</b></td>
                                    <td class="termino"><b><?php echo e($termino); ?></b></td>
                                    <td class="termino"><b><?php echo e($montotermino); ?></b></td>
                                </tr>
                                <tr>
                                    <td><b>TIPO PAGO :</b></td>
                                    <td class=""><?php echo e($item->TXT_CATEGORIA_TIPOPAGO); ?></td>
                                    <td class="termino"></td>
                                </tr>

                                <tr>
                                    <td><b>TIPO CUENTA :</b></td>
                                    <td class=""><?php echo e($item->TXT_CATEGORIA_TIPOCUENTA); ?></td>
                                    <td class="termino"></td>
                                </tr>
                                <tr>
                                    <td><b>BANCO :</b></td>
                                    <td class=""><?php echo e($item->TXT_CATEGORIA_BANCARIO); ?></td>
                                    <td class="termino"></td>
                                </tr>
                                <tr>
                                    <td><b>CUENTA BANCARIA :</b></td>
                                    <td class=""><?php echo e($item->CUENTA_BANCARIA); ?></td>
                                    <td class="termino"></td>
                                </tr>

                                <tr>
                                    <td><b>CUENTA BANCARIA CCI :</b></td>
                                    <td class=""><?php echo e($item->CCI_CUENTA_BANCARIA); ?></td>
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

                            <?php $__currentLoopData = $documentos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <?php echo e($item->COD_DOCUMENTO_CTBLE); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->NRO_SERIE); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->NRO_DOC); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->FEC_EMISION); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->TXT_EMPR_EMISOR); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->TXT_CATEGORIA_TIPO_DOC); ?>

                                    </td>
                                    <td>
                                        <?php echo e($item->CAN_TOTAL); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                            </table>
                    </div>





                </div>
            </div>
        </section>
    </body>

</html>


