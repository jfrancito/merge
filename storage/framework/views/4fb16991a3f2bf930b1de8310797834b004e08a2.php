<html>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">    
        h1{
            text-align: center;
        }
        .subtitulos{
            font-weight: bold;
            font-style: italic;
        }
        .titulotabla{
            background: #4285f4;
            color: #fff;
            font-weight: bold;
        }
        .tabladp{
            background: #bababa;
            color:#fff;
        }
        .tablaho{
            background: #37b358;
            color:#fff;
        }
        .tablamar{
            background: #4285f4;
            color:#fff;
        }
        .tablaagrupado{
            background: #ea4335;
            color:#fff;
        }
        .negrita{
            font-weight: bold;
        }
        .center{
            text-align: center;
        }
        .reportevacadesc{
                background: #ea4335;
            color: #fff;
            font-weight: bold;
        }
        .tablafila2{
          background: #f5f5f5;
        }
        .tablafila1{
          background: #ffffff;
        }
        .warning{
          background-color: #f6c163 !important;
        }

        .vcent{ display: table-cell; vertical-align:middle;text-align: center;}

        .gris{
            background: #C8C9CA;
        }
        .blanco{
          background: #ffffff;
        }
        </style>
    <table>
        <tr>
            <th class= 'tabladp'>FECHA EMISIÓN DE COMPROBANTE</th>
            <th class= 'tabladp'>FECHA REVISION CONTABILIDAD</th>

            <th class= 'tabladp'>FECHA AUTORIZACION</th>
            <th class= 'tabladp'>TIPO DE DOCUMENTO</th>
            <th class= 'tabladp'>CODIGO DE DOCUMENTO</th>
            <th class= 'tabladp'>N° DOCUMENTO</th>

            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>DESCRIPCION DE BIEN O SERVICIO SEGÚN FACTURA</th>
            <th class= 'tabladp'>DESCRIPCION GUIA RR</th>

            <th class= 'tabladp'>BIEN / SERVICIO</th>
            <th class= 'tabladp'>MONEDA</th>


            <th class= 'tabladp'>TIPO DE CAMBIO</th>
            <th class= 'tabladp'>CANTIDAD</th>
            <th class= 'tabladp'>BASE</th>
            <th class= 'tabladp'>IGV</th>
            <th class= 'tabladp'>TOTAL</th>


            <th class= 'tabladp'>DETRACIÓN</th>
            <th class= 'tabladp'>COD DETRACCIÓN</th>
            <th class= 'tabladp'>IMPORTE DETRACCIÓN</th>
            <th class= 'tabladp'>CONSTANCIA DETRACCIÓN</th>
            <th class= 'tabladp'>NUMERO DE CONSTANCIA</th>
            <th class= 'tabladp'>NUMERO DE CUENTA CONTABLE</th>
            <th class= 'tabladp'>USUARIO CONTACTO</th>
            <th class= 'tabladp'>REPARABLE</th>
            <th class= 'tabladp'>MENSAJE REPARABLE</th>
            <th class= 'tabladp'>FECHA SE LEVANTO REPARABLE (USUARIO)</th>
            <th class= 'tabladp'>FECHA SE LEVANTO REPARABLE (CONTA)</th>

            <th class= 'tabladp'>MEDIO PAGO</th>
            <th class= 'tabladp'>FECHA PAGO</th>
            <th class= 'tabladp'>NOMBRE BANCO</th>
            <th class= 'tabladp'>IMPORTE PAGADO</th>
            <th class= 'tabladp'>PDF PAGO MERGE</th>

        </tr>
        <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td><?php echo e(date_format(date_create($item->FEC_VENTA), 'd-m-Y')); ?></td>
            <td><?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y')); ?></td>
            
            <td><?php echo e(date_format(date_create($item->fecha_ap), 'd-m-Y h:i:s')); ?></td>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    FACTURA
                <?php else: ?>
                    RECIBO POR HONORARIO
                <?php endif; ?>
            </td>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    <?php echo e($item->ID_TIPO_DOC); ?>

                <?php else: ?>
                    02
                <?php endif; ?>
            </td>
            <td><?php echo e($item->SERIE); ?> - <?php echo e(str_pad($item->NUMERO, 7, "0", STR_PAD_LEFT)); ?></td>

            <td><?php echo e($item->RZ_PROVEEDOR); ?></td>
            <td><?php echo e($item->RUC_PROVEEDOR); ?></td>
            <td><?php echo e($item->TXT_NOMBRE_PRODUCTO); ?></td>
            <td><?php echo e($item->productos_cabecera2); ?></td>


            <td><?php echo e($item->IND_MATERIAL_SERVICIO); ?></td>
            <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
            <td><?php echo e($item->CAN_TIPO_CAMBIO); ?></td>

            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    <?php echo e($item->CANTIDAD); ?>

                <?php else: ?>
                    1
                <?php endif; ?>
            </td>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    <?php echo e($item->VAL_SUBTOTAL_ORIG); ?>

                <?php else: ?>
                    <?php echo e($item->SUB_TOTAL_VENTA_ORIG); ?>

                <?php endif; ?>
            </td>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    <?php echo e($item->VAL_IGV_ORIG); ?>

                <?php else: ?>
                    <?php echo e($item->VALOR_IGV_ORIG); ?>

                <?php endif; ?>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    <?php echo e($item->VAL_VENTA_ORIG); ?>

                <?php else: ?>
                    <?php echo e($item->TOTAL_VENTA_ORIG); ?>

                <?php endif; ?>
            </td>



            <td>          
                <?php if($item->MONTO_DETRACCION_RED>0): ?>
                    SI
                <?php else: ?>
                    NO
                <?php endif; ?>
            </td>
            <td>-</td>
            <td><?php echo e($item->MONTO_DETRACCION_RED); ?></td>
            <td>-</td>
            <td>-</td>
            <td><?php echo e($item->NRO_CUENTA); ?></td>
            <td><?php echo e($item->TXT_CONTACTO_N); ?></td>
            <td>          
                <?php if(count($item->productos_reparable)>0): ?>
                    SI
                <?php else: ?>
                    NO
                <?php endif; ?>
            </td>
            <td><?php echo e($item->productos_reparable); ?></td>
            <td><?php echo e($item->fecha_reparable); ?></td>
            <td><?php echo e($item->fecha_reparable_conta); ?></td>
            
            <td><?php echo e($item->MEDIO_PAGO); ?></td>
            <td><?php echo e($item->FECHA_PAGO); ?></td>
            <td><?php echo e($item->NOMBRE_BANCO); ?></td>
            <td><?php echo e($item->IMPORTE); ?></td>

            <td>
                <?php if($item->COD_ESTADO_FE == 'ETM0000000000008'): ?>
                    SI
                <?php else: ?>
                    NO
                <?php endif; ?>
            </td>
            
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</html>
