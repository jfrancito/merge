<div class="listadatos">  
        <div class="container">
          <?php if(count($fedocumento)>0): ?>
            <form method="POST" action="<?php echo e(url('validar-xml-oc-administrator-sx-pg/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9)))); ?>" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

              <input type="hidden" name="procedencia" id='procedencia' value = '<?php echo e($procedencia); ?>'>
              <input type="hidden" name="rutaorden" id='rutaorden' value = '<?php echo e($rutaorden); ?>'>
              
              
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <?php echo $__env->make('comprobante.form.ordencompra.compararsxpg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
                    </div>
                    <div class="panel-body panel-body-contrast">
                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#oc" data-toggle="tab">PROVISION DE GASTOS</a></li>
                                          </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Orden</th>
                                                        <th>Fecha Orden</th>      
                                                        <th>Proveedor</th>       
                                                        <th>Total</th>
                                                      </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr>
                                                          <td><?php echo e($ordencompra->COD_DOCUMENTO_CTBLE); ?></td>
                                                          <td><?php echo e($ordencompra->FEC_EMISION); ?></td>
                                                          <td><?php echo e($ordencompra->TXT_EMPR_EMISOR); ?></td>
                                                          <td><?php echo e($ordencompra->CAN_TOTAL); ?></td>
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

                                                       <?php $__currentLoopData = $detalleordencompra; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                                                          <tr>
                                                            <td><?php echo e($item->COD_PRODUCTO); ?></td>
                                                            <td><?php echo e($item->TXT_NOMBRE_PRODUCTO); ?></td>
                                                            <td><?php echo e($item->UNID_MED); ?></td>

                                                            <td><?php echo e(number_format($item->CAN_PRODUCTO, 4, '.', ',')); ?></td>
                                                            <td><?php echo e(number_format($item->CAN_PRECIO_UNIT_IGV, 4, '.', ',')); ?></td>
                                                            <td><?php echo e(number_format($item->CAN_VALOR_VENTA_IGV, 4, '.', ',')); ?></td>

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

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS

                      <div class="tools ver_cuenta_bancaria_pg select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria_pg select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

                    </div>
                    <div class="panel-body panel-body-contrast">
                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" ><b>Entidad Bancaria que se le va a pagar al proveedor :</b></label>
                                            <div class="col-sm-12 abajocaja" >
                                              <?php echo Form::select( 'entidadbanco_id', $combobancos, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-xs entidadbancopg' ,
                                                                  'id'          => 'entidadbanco_id',
                                                                  'required'    => '',
                                                                  'data-aw'     => '1',
                                                                ]); ?>

                                            </div>
                                          </div>
                                      </div>
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte ajax_cb">
                                        <?php echo $__env->make('comprobante.combo.combo_cuenta_bancaria', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                                      </div>
                                  </div>


                            </div>
                            
                    </div>
                  </div>
                </div>
              </div>





              <div class="row <?php if((float)$ordencompra_f->CAN_DETRACCION<=0): ?> ocultar <?php endif; ?>" >
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
                      <div><h4>DETRACION DE LA FACTURACION : <?php echo e(round($fedocumento->TOTAL_VENTA_ORIG,2)); ?> x 4% = <?php echo e($ordencompra_f->CAN_DETRACCION); ?></h4></div>
                    </div>
                    <div class="panel-body panel-body-contrast">
                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">

                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Cuenta Detracción (*)</b>
                                                <span class="tooltiptext">Solo numeros</span>
                                              </div>
                                          </label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="ctadetraccion" id='ctadetraccion' class="form-control control input-sm cuentanumero" 
                                              value = '<?php echo e($empresa->TXT_DETRACCION); ?>'>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Monto de Detracion (*):</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="monto_detraccion" id='monto_detraccion' class="form-control control input-sm importe" 
                                              value = '<?php echo e($ordencompra_f->CAN_DETRACCION); ?>' readonly>
                                          </div>
                                        </div>
                                      </div>

                                      <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Pago Detraccion (*)</b>
                                                <span class="tooltiptext">Seleccione quien va hacer el pago de la detraccion</span>
                                              </div>
                                            </label>
                                            <div class="col-sm-12 abajocaja" >
                                              <?php echo Form::select( 'pago_detraccion', $combopagodetraccion, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-xs' ,
                                                                  'id'          => 'pago_detraccion',
                                                                  'data-aw'     => '1',
                                                                ]); ?>

                                            </div>
                                          </div>
                                      </div>



                                  </div>


                            </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">
                                  <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000001'): ?>
                                      <?php if($rutaorden != ''): ?>
                                        <div><b>LA ORDEN DE COMPRA SE CARGARA DESPUES DE GUARDAR</b></div><br>
                                      <?php else: ?>
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php if($item->TXT_FORMATO == 'ZIP'): ?> XML <?php else: ?> <?php echo e($item->TXT_FORMATO); ?> <?php endif; ?>)</b> 
                                              <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?> <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) <?php else: ?> <br><br> <?php endif; ?>
                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>" 
                                                      name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1"
                                                      required>
                                                  </div>
                                              </div>
                                          </div>
                                        </div> 
                                      <?php endif; ?>
                                    <?php else: ?>
                                      <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009'): ?>
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 autodetraccion">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;">
                                              <div class="tooltipfr"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> <?php echo e($item->TXT_FORMATO); ?></b>
                                                <span class="tooltiptext">Solo subir si selecciono que usted pagara la detracion</span>
                                              </div>
                                            </label>
                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>" 
                                                      name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1">
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                      <?php else: ?>
                                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php if($item->TXT_FORMATO == 'ZIP'): ?> XML <?php else: ?> <?php echo e($item->TXT_FORMATO); ?> <?php endif; ?>)</b> 
                                              <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?> <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) <?php else: ?> <br><br> <?php endif; ?>
                                              <div class="col-sm-12">
                                                  <div class="file-loading">
                                                      <input 
                                                      id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>" 
                                                      name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]" 
                                                      class="file-es"  
                                                      type="file" 
                                                      multiple data-max-file-count="1"
                                                      required>
                                                  </div>
                                              </div>
                                          </div>
                                        </div>
                                      <?php endif; ?>


                                    <?php endif; ?>
                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                            <div class="row">
                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Usuario Contacto :</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="contacto_nombre" id='contacto_nombre' class="form-control control input-sm" value = '<?php echo e($usuario->NOM_TRABAJADOR); ?>' readonly>
                                          </div>
                                        </div>
                                      </div>


                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte <?php if((float)$monto_anticipo<=0): ?> ocultar <?php endif; ?>">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" >
                                              <div class="tooltipfr"><b>Aplicar Anticipo </b>
                                                <span class="tooltiptext">¿Se le aplicara el anticipo a esta factura?</span>
                                              </div>
                                            :</label>
                                            <div class="col-sm-12 abajocaja" >
                                              <?php echo Form::select( 'monto_anticipo', $comboant, array(),
                                                                [
                                                                  'class'       => 'select2 form-control control input-sm' ,
                                                                  'id'          => 'monto_anticipo',
                                                                  'data-aw'     => '1',
                                                                ]); ?>

                                            </div>
                                          </div>
                                      </div>
                                      
                                  </div>

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">

                                      </div>
                                      <div class="col-xs-6">
                                        <p class="text-right">

                                          <input type="hidden" name="idopcion" id='idopcion' value = '<?php echo e($idopcion); ?>'>
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '<?php echo e($ordencompra_f->COD_EMPR); ?>'>
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '<?php echo e(substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,7)); ?>'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '<?php echo e(Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -9))); ?>'>
                                          <input type="hidden" name="detraccion" id='detraccion' value = '<?php echo e((float)$ordencompra_f->CAN_DETRACCION); ?>'>
                                          <input type="hidden" name="te" id='te' value = '<?php echo e($fedocumento->ind_errototal); ?>'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '<?php echo e($usuario->COD_TRABAJADOR); ?>'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-sin-xml">Guardar</button>
                                        </p>
                                      </div>
                                  </div>
                            </div>
                    </div>
                  </div>
                </div>
              </div>
            </form>
          <?php endif; ?>
        </div>
</div>


