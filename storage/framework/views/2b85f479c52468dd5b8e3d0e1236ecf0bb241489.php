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
            <th class= 'tabladp'>ID</th>
            <th class= 'tabladp'>MOVIMIENTO</th>
            <th class= 'tabladp'>BANCO</th>
            <th class= 'tabladp'>CUENTA</th>
            <th class= 'tabladp'>GLOSA</th>
            <th class= 'tabladp'>FECHA REGISTRO</th>
            <th class= 'tabladp'>FECHA MOVIMIENTO</th>
            <th class= 'tabladp'>NRO VOUCHER</th>
            <th class= 'tabladp'>MONEDA</th>
            <th class= 'tabladp'>USUARIO</th>
            <th class= 'tabladp'>TOTAL</th>
            <th class= 'tabladp'>INTEGRADO</th>
            <th class= 'tabladp'>INTEGRAR</th>
        </tr>
        <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
        <tr>
            <td><?php echo e($item->COD_OPERACION_CAJA); ?></td>
            <td><?php echo e($item->TXT_ITEM_MOVIMIENTO); ?></td>
            <td><?php echo e($item->NOMBRE_BANCO_CAJA); ?></td>
            <td><?php echo e($item->CUENTA); ?></td>
            <td><?php echo e($item->TXT_GLOSA); ?></td>

            <td><?php echo e($item->FEC_REGISTRO); ?></td>
            <td><?php echo e($item->FEC_MOVIMIENTO); ?></td>
            <td><?php echo e($item->NRO_VOUCHER); ?></td>
            <td><?php echo e($item->MONEDA); ?></td>
            <td><?php echo e($item->NOM_TRABAJADOR); ?></td> 

            <td><?php echo e($item->MONTO); ?></td>
            <td><?php echo e($item->MONTOATENDIDO); ?></td>
            <td><?php echo e($item->MONTO - $item->MONTOATENDIDO); ?></td> 


        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </table>
</html>
