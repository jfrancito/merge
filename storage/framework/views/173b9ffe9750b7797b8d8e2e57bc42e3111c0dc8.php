<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
  </div>
<div class="panel-body panel-body-contrast">
                          <div class="tab-container">
                            <ul class="nav nav-tabs">
                              <li class="active"><a href="#oc" data-toggle="tab">DOCUMENTO</a></li>
                              <li><a href="#xml" data-toggle="tab">XML</a></li>
                            </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">
                                             <table class="table table-condensed table-striped">
                                                <thead>
                                                  <tr>

                                                    <th>Documento</th>
                                                    <th>Fecha Emision</th>
                                                    <th>Fecha Movimiento</th>
                                                    <th>Banco</th>     
                                                    <th>Cuenta</th>
                                                    <th>Voucher</th>
                                                    <th>Total</th>
                                                  </tr>
                                                </thead>
                                                <tbody>
                                                   <?php $__currentLoopData = $documento_asociados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                                      <tr>
                                                        <td><?php echo e($item->COD_OPERACION_CAJA); ?></td>
                                                        <td><?php echo e($item->FEC_REGISTRO); ?></td>
                                                        <td><?php echo e($item->FEC_MOVIMIENTO); ?></td>
                                                        <td><?php echo e($item->NOMBRE_BANCO_CAJA); ?></td>
                                                        <td><?php echo e($item->NRO_CUENTA_BANCARIA); ?></td>
                                                        <td><?php echo e($item->NRO_VOUCHER); ?></td>
                                                        <td><?php echo e($item->MONTOATENDIDOREAL); ?></td>
                                                      </tr>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </tbody>
                                                <tfooter>
                                                  <tr>
                                                    <th></th>
                                                    <th></th>      
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>      
                                                    <th></th>
                                                    
                                                    <th><?php echo e($documento_asociados->sum('MONTOATENDIDOREAL')); ?></th>
                                                  </tr>

                                                </tfooter>
                                              </table>

                                            </div>
                                            <div id="xml" class="tab-pane cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Serie</th>
                                                        <th>Numero</th>      
                                                        <th>Fecha Emision</th>       
                                                        <th>Forma Pago</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                          <td><?php echo e($fedocumento->SERIE); ?></td>
                                                          <td><?php echo e($fedocumento->NUMERO); ?></td>
                                                          <td><?php echo e($fedocumento->FEC_VENTA); ?></td>
                                                          <td><?php echo e($fedocumento->FORMA_PAGO); ?></td>
                                                        </tr>
                                                    </tbody>
                                                  </table>


                                                <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Producto</th>
                                                        <th>Nombre Producto</th>
                                                        <th>Unidad</th>
                                                        <th>Cantidad</th>
                                                        <th>Precio</th>
                                                        <th>Total</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                       <?php $__currentLoopData = $detallefedocumento; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                                          <tr>
                                                            <td><?php echo e($item->CODPROD); ?></td>
                                                            <td><?php echo e($item->PRODUCTO); ?></td>
                                                            <td><?php echo e($item->UND_PROD); ?></td>
                                                            <td><?php echo e(number_format($item->CANTIDAD, 4, '.', ',')); ?></td>
                                                            <td><?php echo e(number_format($item->PRECIO_ORIG, 4, '.', ',')); ?></td>
                                                            <td><?php echo e(number_format($item->VAL_VENTA_ORIG, 4, '.', ',')); ?></td>
                                                          </tr>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </tbody>
                                                </table>


                                            </div>

                                          </div>
                          </div>


      </div>
    </div>