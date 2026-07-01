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
            <th class= 'tabladp'>FECHA CARGA DATOS</th>
            <th class= 'tabladp'>FECHA REVISION CONTABILIDAD</th>

            <th class= 'tabladp'>TIPO DE DOCUMENTO</th>
            <th class= 'tabladp'>CODIGO DE DOCUMENTO</th>
            <th class= 'tabladp'>N° DOCUMENTO</th>
            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>MONEDA</th>

            <th class= 'tabladp'>TIPO DE CAMBIO</th>
            <th class= 'tabladp'>TOTAL</th>

            <th class= 'tabladp'>COD OPERACION CAJA</th>
            <th class= 'tabladp'>MOVIMIENTO</th>
            <th class= 'tabladp'>BANCO</th>
            <th class= 'tabladp'>CUENTA</th>


            <th class= 'tabladp'>MEDIO PAGO</th>
            <th class= 'tabladp'>FECHA PAGO</th>
            <th class= 'tabladp'>NOMBRE BANCO</th>
            <th class= 'tabladp'>IMPORTE PAGADO</th>
            <th class= 'tabladp'>PDF PAGO MERGE</th>


        </tr>
        <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td><?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y')); ?></td>
            <td><?php echo e($item->fecha_pr ? date_format(date_create($item->fecha_pr), 'd-m-Y') : ''); ?></td>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    FACTURA
                <?php else: ?>
                    <?php if($item->ID_TIPO_DOC == 'R1'): ?>
                        RECIBO POR HONORARIO
                    <?php else: ?>
                        RECIBO DE SERVICIOS
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td>
                <?php if($item->ID_TIPO_DOC == '01'): ?>
                    <?php echo e($item->ID_TIPO_DOC); ?>

                <?php else: ?>
                    <?php if($item->ID_TIPO_DOC == 'R1'): ?>
                        02
                    <?php else: ?>
                        14
                    <?php endif; ?>
                <?php endif; ?>
            </td>
            <td><?php echo e($item->SERIE); ?> - <?php echo e(str_pad($item->NUMERO, 7, "0", STR_PAD_LEFT)); ?></td>
            <td><?php echo e($item->RZ_PROVEEDOR); ?></td>
            <td><?php echo e($item->RUC_PROVEEDOR); ?></td>
            <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
            <td><?php echo e($item->CAN_TIPO_CAMBIO); ?></td>
            <td>
                <?php echo e($item->TOTAL_VENTA_ORIG); ?>

            </td>
            <td><?php echo e($item->COD_OPERACION_CAJA); ?></td>
            <td><?php echo e($item->TXT_ITEM_MOVIMIENTO); ?></td>
            <td><?php echo e($item->NOMBRE_BANCO_CAJA); ?></td>
            <td><?php echo e($item->CUENTA); ?></td>


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
