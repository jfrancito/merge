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
            <th class= 'tabladp'>ID LIQUIDACION</th>
            <th class= 'tabladp'>TRABAJADOR</th>
            <th class= 'tabladp'>FECHA EMISIÓN DE LIQUIDACION</th>
            <th class= 'tabladp'>FECHA EMISIÓN DE COMPROBANTE</th>
            <th class= 'tabladp'>TIPO DE DOCUMENTO</th>
            <th class= 'tabladp'>N° DOCUMENTO</th>
            <th class= 'tabladp'>PROVEEDOR</th>
            <th class= 'tabladp'>RUC</th>
            <th class= 'tabladp'>DESCRIPCION DE BIEN O SERVICIO SEGÚN FACTURA</th>
            <th class= 'tabladp'>MONEDA</th>
            <th class= 'tabladp'>CANTIDAD</th>
            <th class= 'tabladp'>BASE</th>
            <th class= 'tabladp'>IGV</th>
            <th class= 'tabladp'>TOTAL</th>
            <th class= 'tabladp'>USUARIO AUTORIZA</th>
            <th class= 'tabladp'>USUARIO</th>
            <th class= 'tabladp'>CORREO USUARIO</th>
            <th class= 'tabladp'>JEFE</th>
            <th class= 'tabladp'>CORREO JEFE</th>
            <th class= 'tabladp'>CUENTA CONTABLE</th>
        </tr>
        <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
            <td><?php echo e($item->ID_DOCUMENTO); ?></td>
            <td><?php echo e($item->TXT_EMPRESA_TRABAJADOR); ?></td>
            <td><?php echo e(date_format(date_create($item->FECHA_EMI), 'd-m-Y')); ?></td>
            <td><?php echo e(date_format(date_create($item->FECHA_EMISION), 'd-m-Y')); ?></td>
            <td><?php echo e($item->TXT_TIPODOCUMENTO); ?></td>
            <td><?php echo e($item->SERIE); ?> - <?php echo e($item->NUMERO); ?></td>
            <td><?php echo e($item->TXT_EMPRESA_PROVEEDOR); ?></td>
            <td><?php echo e($item->NRO_DOCUMENTO); ?></td>
            <td><?php echo e($item->TXT_PRODUCTO); ?></td>
            <td><?php echo e($item->TXT_CATEGORIA_MONEDA); ?></td>
            <td><?php echo e($item->CANTIDAD); ?></td>
            <td><?php echo e($item->SUBTOTAL); ?></td>
            <td><?php echo e($item->IGV); ?></td>
            <td><?php echo e($item->TOTAL); ?></td>
            <td><?php echo e($item->TXT_USUARIO_AUTORIZA); ?></td>
            <td><?php echo e($item->TXT_EMPRESA_TRABAJADOR); ?></td>
            <td><?php echo e($item->EMAIL_USUARIO); ?></td>
            <td><?php echo e($item->TXT_USUARIO_AUTORIZA); ?></td>
            <td><?php echo e($item->EMAIL_JEFE); ?></td>
            <td><?php echo e($item->CUENTA); ?></td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</html>
