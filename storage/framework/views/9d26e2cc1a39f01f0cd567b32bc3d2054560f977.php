<div class="listadatos">  
        <div class="container">
          <div class="row">

            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML (<?php echo e($xmlfactura); ?>)
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="<?php echo e(url('subir-xml-cargar-datos-proveedor/'.$idopcion.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

                            <div class="col-sm-12">
                                <div class="form-group">
                                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                        <input name="inputxml" id='inputxml' class="form-control inputxml" type="file" accept="text/xml" />
                                    </div>
                                    <input type="hidden" name="procedencia" id='procedencia' value = '<?php echo e($procedencia); ?>'>
                                    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                        <button  type="submit" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i> Subir</button>
                                    </div>
                                    
                                </div>
                            </div>
                  </form>
                </div>
              </div>
            </div>

<!--             <div class="col-xs-12 col-sm-6 col-md-4 col-lg-8">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT
                </div>
                <div class="panel-body panel-body-contrast">
                    <?php if(count($fedocumento)<=0): ?>
                        <div class="col-sm-12">
                            <b>CARGAR XML</b>
                        </div>
                    <?php else: ?>
                        <div class="col-sm-12">
                            <p style="margin:0px;"><b>Respuesta Sunat</b> : <?php echo e($fedocumento->message); ?></p>
                            <p style="margin:0px;" class='<?php if($fedocumento->estadoCp == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b>Estado Comprobante</b> : 
                                <?php echo e($fedocumento->nestadoCp); ?>

                            </p>
                            <p style="margin:0px;"><b>Estado Ruc</b> : <?php echo e($fedocumento->nestadoRuc); ?></p>
                            <p style="margin:0px;"><b>Estado Domicilio</b> : <?php echo e($fedocumento->ncondDomiRuc); ?></p>
                            <p style="margin:0px;"><b>Respuesta CDR</b> : <?php echo e($fedocumento->RESPUESTA_CDR); ?></p>
                        </div>
                    <?php endif; ?>
                </div>
              </div>
            </div> -->
          </div>


          <?php if(count($fedocumento)>0): ?>
            <form method="POST" action="<?php echo e(url('validar-xml-oc-proveedor/'.$idopcion.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>

              <input type="hidden" name="procedencia" id='procedencia' value = '<?php echo e($procedencia); ?>'>

              <div class="row">


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
                  <?php echo $__env->make('comprobante.form.ordencompra.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
                    </div>
                    <div class="panel-body panel-body-contrast">

                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#oc" data-toggle="tab">ORDEN COMPRA</a></li>
                                            <li><a href="#xml" data-toggle="tab">XML</a></li>
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
                                                          <td><?php echo e($ordencompra->COD_ORDEN); ?></td>
                                                          <td><?php echo e($ordencompra->FEC_ORDEN); ?></td>
                                                          <td><?php echo e($ordencompra->TXT_EMPR_CLIENTE); ?></td>
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
                </div>
              </div>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS

                      <div class="tools ver_cuenta_bancaria_oc select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria_oc select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

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
                                                                  'class'       => 'select2 form-control control input-xs entidadbancooc' ,
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
                      <!-- <div><h4>DETRACION DE LA FACTURACION : <?php echo e(round($fedocumento->TOTAL_VENTA_ORIG,2)); ?> x 4% = <?php echo e($ordencompra_f->CAN_DETRACCION); ?></h4></div> -->
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
                                              <input type="text" name="ctadetraccion" id='ctadetraccion' class="form-control control input-sm cuentanumero" value = '<?php echo e($empresa->TXT_DETRACCION); ?>'>
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

                                      <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009'): ?>

                                        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4 autodetraccion">
                                          <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;">
                                              <div class="tooltipfr"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> <?php echo e($item->TXT_FORMATO); ?></b>
                                                <span class="tooltiptext">Solo subir si selecciono que usted pagara la detracion</span>
                                              </div>
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

                                      <?php else: ?>

                                      <div class="col-xs-12 col-sm-12 col-md-6 col-lg-4">
                                        <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php if($item->TXT_FORMATO == 'ZIP'): ?> XML <?php else: ?> <?php echo e($item->TXT_FORMATO); ?> <?php endif; ?>)</b></label>
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



                                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                  
                            </div>

                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">
                                        <div class="form-group">
                                          <label class="col-sm-12 control-label labelleft" ><b>Usuario Contacto :</b></label>
                                          <div class="col-sm-12 abajocaja" >
                                              <input type="text" name="contacto_nombre" id='contacto_nombre' class="form-control control input-sm" value = '<?php echo e($usuario->NOM_TRABAJADOR); ?>' readonly>
                                          </div>
                                        </div>
                                      </div>
                                      <div class="col-xs-6">
                                      </div>
                                  </div>

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">

                                      </div>
                                      <div class="col-xs-6">
                                        <p class="text-right">

                                          <input type="hidden" name="idopcion" id='idopcion' value = '<?php echo e($idopcion); ?>'>
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '<?php echo e(substr($ordencompra->COD_ORDEN, 0,6)); ?>'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '<?php echo e(Hashids::encode(substr($ordencompra->COD_ORDEN, -10))); ?>'>
                                          
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '<?php echo e($ordencompra_f->COD_EMPR); ?>'>
                                          <input type="hidden" name="detraccion" id='detraccion' value = '<?php echo e((float)$ordencompra_f->CAN_DETRACCION); ?>'>
                                          
                                          <input type="hidden" name="te" id='te' value = '<?php echo e($fedocumento->ind_errototal); ?>'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '<?php echo e($usuario->COD_TRABAJADOR); ?>'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-xml">Guardar</button>
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


