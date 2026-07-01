<div class="listadatos">  
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="<?php echo e(url('subir-xml-cargar-datos-estiba-administrator-contrato-anticipo/'.$idopcion.'/'.$idoc)); ?>" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     <?php echo e(csrf_field()); ?>

                      <input type="hidden" name="device_info" id='device_info'>
                      <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 cajareporte">

                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" >Tipo Documento :</label>
                            <div class="col-sm-12 abajocaja" >
                              <?php echo Form::select( 'tipodocumento_id', $combotipodocumento, array($tipodocumento_id),
                                                [
                                                  'class'       => 'select2 form-control control input-sm' ,
                                                  'id'          => 'tipodocumento_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1',
                                                ]); ?>

                            </div>
                          </div>


                          <div class="form-group" style="display:none;">
                            <label class="col-sm-12 control-label labelleft" >Documento :</label>
                            <div class="col-sm-12 abajocaja" >
                              <?php echo Form::select( 'documento_id', $combodocumento, array($documento_id),
                                                [
                                                  'class'       => 'select2 form-control control input-sm' ,
                                                  'id'          => 'documento_id',
                                                  'required'    => '',
                                                  'data-aw'     => '1',
                                                ]); ?>

                            </div>
                          </div>
                      </div> 
                      <input type="hidden" name="operacion_id" id="operacion_id" value="<?php echo e($fereftop1->OPERACION); ?>">
                      <div class="col-sm-12">
                          <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" >Archivo :</label>
                              <div style="display:none;" class="col-xs-6 col-sm-6 col-md-6 col-lg-10 negrita" align="left">
                                  <input name="inputxml" id='inputxml' class="form-control inputxml" type="file" accept="text/xml" />
                              </div>
                              <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 negrita" align="center">
                                  <button  type="submit" style="height:48px;" class="btn btn-space btn-success btn-lg cargardatosliq" id='cargardatosliq' title="Cargar Datos"><i class="icon icon-left mdi mdi-upload"></i> Subir</button>
                              </div>
                          
                          </div>
                      </div>

                  </form>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT
                </div>
                <div class="panel-body panel-body-contrast">
                    <?php if(count($fedocumento)<=0): ?>
                        <div class="col-sm-12">
                            <b>CARGAR XML</b>
                        </div>
                    <?php else: ?>
                      <?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?>
                          <div class="col-sm-12">
                              <b>SIN CPE</b>
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
                    <?php endif; ?>
                </div>
              </div>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DOCUMENTOS ASOCIADOS 
                  <?php echo e(number_format($fereftop1->TOTAL_MERGE, 2, '.', ',')); ?>

                </div>
                <div class="panel-body panel-body-contrast">

                <table class="table table-condensed table-striped">
                    <thead>
                      <tr>
                        <th>Item</th>
                        <th>Codigo</th>    
                        <th>Proveedor</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php $__currentLoopData = $documento_asociados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                          <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($item->COD_DOCUMENTO_CTBLE); ?></td>
                            <td><?php echo e($item->TXT_EMPR_EMISOR); ?></td>
                            <td><?php echo e(number_format($fereftop1->TOTAL_MERGE, 2, '.', ',')); ?></td>
                          </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </tbody>
                  </table>

                </div>
              </div>
            </div>
          </div>

          <?php if(count($fedocumento)>0): ?>
            <form method="POST" action="<?php echo e(url('validar-xml-oc-estiba-administrator-contratoa/'.$idopcion.'/'.$idoc)); ?>" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             <?php echo e(csrf_field()); ?>

            <input type="hidden" name="device_info" id='device_info'>
              <input type="hidden" name="rutaorden" id='rutaorden' value = '<?php echo e($rutaorden); ?>'>
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?>
                    <?php echo $__env->make('comprobante.form.contrato.compararanticiposxml', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php else: ?>
                    <?php echo $__env->make('comprobante.form.contrato.compararanticipo', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php endif; ?>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  <?php if($fedocumento->OPERACION_DET != 'SIN_XML'): ?>
                    <?php echo $__env->make('comprobante.form.contrato.informacionoca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php endif; ?>
                </div>
              </div>
              
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS

                      <div class="tools ver_cuenta_bancaria_estiba select" style="cursor: pointer;padding-left: 12px;"> <span class="label label-success">Ver Cuenta</span></div>
                      <div class="tools agregar_cuenta_bancaria_estiba select" style="cursor: pointer;"> <span class="label label-success">Agregar Cuenta</span></div>

                    </div>
                    <div class="panel-body panel-body-contrast">
                            <div class="row">

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" ><b>Entidad Bancaria que se le va a pagar al proveedor :</b></label>
                                            <div class="col-sm-12 abajocaja" >

                                              <?php if($banco_id=='BAM0000000000011'): ?>
                                                <input type="hidden" name="entidadbanco_id" value ='<?php echo e($banco_id); ?>'>
                                                <?php echo Form::select( 'entidadbanco_id', $combobancos, array($banco_id),
                                                                  [
                                                                    'class'       => 'select2 form-control control input-xs entidadbancoestiba' ,
                                                                    'id'          => 'entidadbanco_id',
                                                                    'required'    => '',
                                                                    'data-aw'     => '1',
                                                                    'disabled' => 'disabled'
                                                                  ]); ?>

                                              <?php else: ?>
                                                <?php echo Form::select( 'entidadbanco_id', $combobancos, array($banco_id),
                                                                  [
                                                                    'class'       => 'select2 form-control control input-xs entidadbancoestiba' ,
                                                                    'id'          => 'entidadbanco_id',
                                                                    'required'    => '',
                                                                    'data-aw'     => '1',
                                                                  ]); ?>

                                              <?php endif; ?>


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

              
              <?php if($fedocumento->MONTO_DETRACCION_RED > 0): ?>
                <div class="row <?php if($fedocumento->ID_TIPO_DOC =='R1'): ?> ocultar <?php endif; ?>">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="panel panel-default panel-contrast">
                      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
                        <!-- <div><h4>DETRACION DE LA FACTURACION : <?php echo e(round($fedocumento->TOTAL_VENTA_ORIG,2)); ?> x 4% = <?php echo e($fedocumento->TOTAL_VENTA_ORIG * 0.04); ?></h4> </div> -->
                        <div><h6>* Solo llenar para montos mayores a 401 o cuando sea traslado de la selva</h6> </div>
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


                                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                                            <div class="form-group">
                                              <label class="col-sm-12 control-label labelleft" >
                                                <div class="tooltipfr"><b>Valor Detraccion (*)</b>
                                                  <span class="tooltiptext">Si la detraccion corresponde a la factura o aun monto referencial</span>
                                                </div>
                                              </label>
                                              <div class="col-sm-12 abajocaja" >
                                                <?php echo Form::select( 'tipo_detraccion_id', $combotipodetraccion, array('MONTO_FACTURACION'),
                                                                  [
                                                                    'class'       => 'select2 form-control control input-xs' ,
                                                                    'id'          => 'tipo_detraccion_id',
                                                                    'data-aw'     => '1',
                                                                  ]); ?>

                                              </div>
                                            </div>
                                        </div>

                                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                                          <div class="form-group">
                                            <label class="col-sm-12 control-label labelleft" ><b>Monto de Detracion (*):</b></label>
                                            <div class="col-sm-12 abajocaja" >
                                                <input type="text" name="monto_detraccion" id='monto_detraccion' value="<?php echo e($fedocumento->MONTO_DETRACCION_RED); ?>" class="form-control control input-sm importe" 
                                                value = '0.0' readonly>
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
              <?php endif; ?>

              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">

                                  <?php if($rutasuspencion != ''): ?>
                                    <div><b style="color: #4285f4;">LA SUSPENSION DE 4TA CATEGORIA SE CARGARA DESPUES DE GUARDAR</b></div><br>
                                  <?php endif; ?>

                                  <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?> 
                                    <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026'): ?>
                                      <?php if($rutaorden != ''): ?>
                                        <div><b>EL CONTRATO SE CARGARA DESPUES DE GUARDAR</b></div><br>
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
                                      <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000009' && $fedocumento->MONTO_DETRACCION_RED > 0): ?>
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
                                        <?php if($item->COD_CATEGORIA_DOCUMENTO != 'DCC0000000000009' ): ?>
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

                                        <div class="form-group sectioncargarimagen">
                                            <label class="col-sm-12 control-label" style="text-align: left;margin-top:20px;"><b>REALIZAR UNA OBSERVACION :</b> <br><br></label>
                                            <div class="col-sm-12">
                                                <textarea 
                                                name="descripcion"
                                                id = "descripcion"
                                                class="form-control input-sm validarmayusculas"
                                                rows="12" 
                                                cols="200"    
                                                data-aw="2"></textarea>
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
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '<?php echo e(substr($ordencompra->COD_ORDEN, 0,6)); ?>'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '<?php echo e($idoc); ?>'>
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