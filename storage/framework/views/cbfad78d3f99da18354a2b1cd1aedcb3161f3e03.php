<table border="1">
<?php $__currentLoopData = $pedidos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pedido): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

<?php  $cab = $pedido->first();  ?>

<tr>
    <td colspan="6"
        style="background-color:#1d3a6d; color:#ffffff !important; 
               text-align:center; font-weight:bold; border : 1px solid #000000;">
        PEDIDO DE COMPRA
    </td>
</tr>
<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000 ; text-align:center;"><b>N° PEDIDO</b></td>
    <td style="border : 1px solid #000000"><?php echo e($cab->ID_PEDIDO); ?></td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>ESTADO</b></td>
    <td colspan="2" style="border : 1px solid #000000" ><?php echo e($cab->TXT_ESTADO); ?></td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>FECHA</b></td>
    <td><?php echo e($cab->FEC_PEDIDO); ?></td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>ÁREA</b></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($cab->TXT_AREA); ?></td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>AÑO</b></td>
    <td style="text-align:left; border : 1px solid #000000"><?php echo e($cab->COD_ANIO); ?></td>

    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>REALIZADO POR</b></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($cab->TXT_TRABAJADOR_SOLICITA); ?></td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>MES</b></td>
    <td style="border : 1px solid #000000"><?php echo e($cab->TXT_NOMBRE); ?></td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>AUTORIZA JEFE</b></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($cab->TXT_TRABAJADOR_AUTORIZA); ?></td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>EMPRESA</b></td>
    <td style="border : 1px solid #000000"><?php echo e($cab->NOM_EMPR); ?></td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>APRUEBA GERENCIA</b></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($cab->TXT_TRABAJADOR_APRUEBA_GER); ?></td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>SEDE</b></td>
    <td style="border : 1px solid #000000"><?php echo e($cab->NOM_CENTRO); ?></td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>APRUEBA ADMINISTRACIÓN</b></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($cab->TXT_TRABAJADOR_APRUEBA_ADM); ?></td>
</tr>

<tr>
    <td style="background-color:#eeeeee; border : 1px solid #000000"><b>TIPO</b></td>
    <td style="border : 1px solid #000000"><?php echo e($cab->TXT_TIPO_PEDIDO); ?></td>
    <td colspan="2" style="background-color:#eeeeee; border : 1px solid #000000"><b>OBSERVACIÓN</b></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($cab->TXT_GLOSA); ?></td>
</tr>


<tr>
    <th style="background-color:#1d3a6d; color:#ffffff !important ;  border : 1px solid #000000 ;
               text-align:center; font-weight:bold;">N°</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important; border : 1px solid #000000 ; 
               text-align:center; font-weight:bold;">CÓDIGO</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important;  border : 1px solid #000000 ;
               text-align:center; font-weight:bold;" colspan="2">PRODUCTO</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important; border : 1px solid #000000 ;
               text-align:center; font-weight:bold;">CANTIDAD</th>
    <th style="background-color:#1d3a6d; color:#ffffff !important; border : 1px solid #000000 ;
               text-align:center; font-weight:bold;">OBSERVACIÓN</th>
</tr>

<?php $__currentLoopData = $pedido; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i => $det): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<tr>
    <td style="background-color:#d9edf7; border : 1px solid #000000 ; text-align:center"><?php echo e($i + 1); ?></td>
    <td style="border : 1px solid #000000"><?php echo e($det->COD_PRODUCTO); ?></td>
    <td colspan="2" style="border : 1px solid #000000"><?php echo e($det->NOM_PRODUCTO); ?></td>
    <td style="background-color:#d9edf7; text-align:center ; border : 1px solid #000000"><?php echo e($det->CANTIDAD); ?></td>
    <td style="border : 1px solid #000000"><?php echo e($det->TXT_OBSERVACION); ?></td>
</tr>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<tr><td colspan="6"></td></tr>

<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</table>
