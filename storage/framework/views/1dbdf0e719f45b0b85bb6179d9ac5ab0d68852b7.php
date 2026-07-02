<div class="main-content container-fluid">
  <!--Tabs-->
  <div class="row">
    <!--Default Tabs-->
    <div class="col-sm-12">
      <div class="panel panel-default">
        <div class="tab-container">
          <ul class="nav nav-tabs">
            <li class="<?php if($tab_id=='oc'): ?> active <?php endif; ?>"><a href="#oc" data-toggle="tab">ESTIBA <span class="badge badge-success" style="font-size:16px"><?php echo e(count($listadatos)); ?></span></a></li>
            <li class="<?php if($tab_id=='observado'): ?> active <?php endif; ?>"><a href="#observado" data-toggle="tab">OBSERVADOS <span class="badge badge-danger" style="font-size:16px"><?php echo e(count($listadatos_obs)); ?></span></a></li>
            <li class="<?php if($tab_id=='observadole'): ?> active <?php endif; ?>"><a href="#observadole" data-toggle="tab">OBSERVACIONES LEVANTADAS <span class="badge badge-primary" style="font-size:16px"><?php echo e(count($listadatos_obs_le)); ?></span></a></li>
          </ul>
          <div class="tab-content">
            <div id="oc" class="tab-pane <?php if($tab_id=='oc'): ?> active <?php endif; ?> cont">
              <table id="nso" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th>DOCUMENTO</th>
                    <th>INFORMACION</th>
                    <th>REGISTRO</th>
                    <th>ESTADO</th>
                    <th>OPCION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $listadatos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php  $NOMBRE_OSIRIS =  $funcion->funciones->cuenta_osiris_lic($item->ID_DOCUMENTO)  ?>

                    <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
                      <td><?php echo e($index+1); ?></td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
                        <span><b>PROVEEDOR : </b> <?php echo e($item->RZ_PROVEEDOR); ?></span>
                        <span><b>CUENTA OSIRIS : </b> <?php echo e($NOMBRE_OSIRIS); ?></span>
                        <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
                        <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
                        <span><b>FECHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
                        <span><b>CENTRO : </b> <?php echo e($item->NOM_CENTRO); ?></span>
                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
                        <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
                        <span><b>ORSERVACION : </b>               
                            <?php if($item->ind_observacion == 1): ?> 
                                <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
                            <?php else: ?>
                              <?php if($item->ind_observacion == 0): ?> 
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              <?php else: ?>
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              <?php endif; ?>
                            <?php endif; ?>
                        </span>
                        <span>
                          <b>DEUDA:
                            <?php if($item->CAN_DEUDA > 0): ?>
                             <span data_id_doc = '<?php echo e($item->COD_EMPR); ?>' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;">DEUDA</span>
                            <?php else: ?>
                              <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
                            <?php endif; ?>
                          </b>
                        </span>
                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
                        <?php if($item->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
                          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
                          <span style="font-size: 18px;"><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
                        <?php else: ?>
                          <span style="font-size: 18px;"><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>                          
                        <?php endif; ?>
                      </td>

                      <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <td class="rigth">
                        <div class="btn-group btn-hspace">
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li>
                              <a href="<?php echo e(url('/aprobar-comprobante-acopio-estiba/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">
                                Revision Comprobante
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>

            </div>
            <div id="observado" class="tab-pane <?php if($tab_id=='observado'): ?> active <?php endif; ?> cont">
               <table id="nso_obs" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th>DOCUMENTO</th>
                    <th>INFORMACION</th>
                    <th>REGISTRO</th>
                    <th>ESTADO</th>
                    <th>OPCION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $listadatos_obs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
                      <td><?php echo e($index+1); ?></td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>

                        <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
                        <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
                        <span><b>FECHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
                        <span><b>CENTRO : </b> <?php echo e($item->NOM_CENTRO); ?></span>
                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
                        <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
                        <span><b>ORSERVACION : </b>               
                            <?php if($item->ind_observacion == 1): ?> 
                                <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
                            <?php else: ?>
                              <?php if($item->ind_observacion == 0): ?> 
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              <?php else: ?>
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              <?php endif; ?>
                            <?php endif; ?>
                        </span>
                        <span>
                          <b>DEUDA:
                            <?php if($item->CAN_DEUDA > 0): ?>
                             <span data_id_doc = '<?php echo e($item->COD_EMPR_EMISOR); ?>' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;">DEUDA</span>
                            <?php else: ?>
                              <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
                            <?php endif; ?>
                          </b>
                        </span>
                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
                        <?php if($item->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
                          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
                          <span style="font-size: 18px;"><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
                        <?php else: ?>
                          <span style="font-size: 18px;"><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>                          
                        <?php endif; ?>
                      </td>
                      <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <td class="rigth">
                        <div class="btn-group btn-hspace">
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li>
                              <a href="<?php echo e(url('/aprobar-comprobante-acopio-estiba/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">
                                Revision Comprobante
                              </a>
                            </li>
                          </ul>
                        </div>
                      </td>
                    </tr>                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>
            </div>

            <div id="observadole" class="tab-pane <?php if($tab_id=='observadole'): ?> active <?php endif; ?> cont">
               <table id="nso_obs_le" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
                <thead>
                  <tr>
                    <th>ITEM</th>
                    <th>DOCUMENTO</th>
                    <th>INFORMACION</th>
                    <th>REGISTRO</th>
                    <th>ESTADO</th>
                    <th>OPCION</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $__currentLoopData = $listadatos_obs_le; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr data_requerimiento_id = "<?php echo e($item->ID_DOCUMENTO); ?>">
                      <td><?php echo e($index+1); ?></td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>LOTE : <?php echo e($item->ID_DOCUMENTO); ?> </b> </span>
                        <span><b>SERIE : <?php echo e($item->SERIE); ?> </b> </span>
                        <span><b>NUMERO  : <?php echo e($item->NUMERO); ?></b></span>
                        <span><b>FECHA : </b> <?php echo e($item->FEC_VENTA); ?></span>
                        <span><b>CENTRO : </b> <?php echo e($item->NOM_CENTRO); ?></span>
                      </td>
                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>FORMA PAGO : </b> <?php echo e($item->FORMA_PAGO); ?></span>
                        <span><b>TOTAL : </b> <?php echo e(number_format($item->TOTAL_VENTA_ORIG, 4, '.', ',')); ?></span>
                        <span><b>ORSERVACION : </b>               
                            <?php if($item->ind_observacion == 1): ?> 
                                <span class="badge badge-danger" style="display: inline-block;">EN PROCESO</span>
                            <?php else: ?>
                              <?php if($item->ind_observacion == 0): ?> 
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              <?php else: ?>
                                  <span class="badge badge-default" style="display: inline-block;">SIN OBSERVACIONES</span>
                              <?php endif; ?>
                            <?php endif; ?>
                        </span>
                        <span>
                          <b>DEUDA:
                            <?php if($item->CAN_DEUDA > 0): ?>
                             <span data_id_doc = '<?php echo e($item->COD_EMPR_EMISOR); ?>' class="badge badge-danger btn_detalle_deuda" style="width: 100px;cursor: pointer;">DEUDA</span>
                            <?php else: ?>
                              <span class="badge badge-default" style="width: 100px;display: inline-block;">SIN DEUDA</span>
                            <?php endif; ?>
                          </b>
                        </span>
                      </td>

                      <td class="cell-detail sorting_1" style="position: relative;">
                        <span><b>PROVEEDOR : </b>  <?php echo e(date_format(date_create($item->fecha_pa), 'd-m-Y h:i:s')); ?></span>
                        <?php if($item->OPERACION != 'DOCUMENTO_INTERNO_COMPRA'): ?>
                          <span><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>
                          <span style="font-size: 18px;"><b>CONTABILIDAD : </b> <?php echo e(date_format(date_create($item->fecha_pr), 'd-m-Y h:i:s')); ?></span>
                        <?php else: ?>
                          <span style="font-size: 18px;"><b>U. CONTACTO: </b><?php echo e(date_format(date_create($item->fecha_uc), 'd-m-Y h:i:s')); ?></span>                          
                        <?php endif; ?>
                      </td>

                      <?php echo $__env->make('comprobante.ajax.estados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                      <td class="rigth">
                        <div class="btn-group btn-hspace">
                          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                          <ul role="menu" class="dropdown-menu pull-right">
                            <li>
                              <a href="<?php echo e(url('/aprobar-comprobante-acopio-estiba/'.$idopcion.'/'.$item->ID_DOCUMENTO)); ?>">
                                Revision Comprobante
                              </a>  
                            </li>



                          </ul>
                        </div>
                      </td>
                    </tr>                    
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
              </table>


            </div>



          </div>
        </div>
      </div>
    </div>
  </div>
</div>



<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
       App.dataTables();
    });
  </script> 
<?php endif; ?>





