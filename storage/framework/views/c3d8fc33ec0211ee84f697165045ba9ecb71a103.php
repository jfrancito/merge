<div class="listadatos">  
        <div class="container">
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CARGAR DOCUMENTO XML
                  (<?php echo e($xmlfactura); ?>)
                </div>
                <div class="panel-body panel-body-contrast">
                  <form method="POST" action="<?php echo e(url('subir-xml-cargar-datos-nota-credito-administrator/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -10)))); ?>" name="formcargardatos" id="formcargardatos" enctype="multipart/form-data" >
                     <?php echo e(csrf_field()); ?>

                        <input type="hidden" name="device_info" id='device_info'>
                      <div class="col-sm-12">
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


                        
                          <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" >Archivo :</label>
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
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-8">

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
            </div>
          </div>


          <?php if(count($fedocumento)>0): ?>
            <form method="POST" action="<?php echo e(url('validar-xml-nota-credito-administrator/'.$idopcion.'/'.substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -10)))); ?>" name="formguardardatos" id="formguardardatos" enctype="multipart/form-data" >
             <?php echo e(csrf_field()); ?>

<input type="hidden" name="device_info" id='device_info'>
              <input type="hidden" name="procedencia" id='procedencia' value = '<?php echo e($procedencia); ?>'>              
              <div class="row">

                <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">COMPARAR (XML - NOTA DE CREDITO)
                    </div>
                    <div class="panel-body panel-body-contrast">
                      <table class="table table-condensed table-striped">
                        <thead>
                          <tr>
                            <th>Valor</th>
                            <th>Nota de Credito</th>      
                            <th>XML</th>       
                          </tr>
                        </thead>
                        <tbody>
                            <tr>
                              <td><b>RUC</b></td>
                              <td><p class='subtitulomerge'><?php echo e($ordencompra->NRO_DOCUMENTO_CLIENTE); ?></p></td>
                              <td>
                                <div class='subtitulomerge <?php if($fedocumento->ind_ruc == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RUC_PROVEEDOR); ?></b>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>RAZON SOCIAL</b></td>
                              <td><p class='subtitulomerge'><?php echo e($ordencompra->TXT_EMPR_EMISOR); ?></p></td>
                              <td>
                                <div class='subtitulomerge <?php if($fedocumento->ind_rz == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'><b><?php echo e($fedocumento->RZ_PROVEEDOR); ?></b>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>Moneda</b></td>
                              <td><p class='subtitulomerge'><?php echo e($ordencompra->TXT_CATEGORIA_MONEDA); ?></p></td>
                              <td>
                                <div class='subtitulomerge <?php if($fedocumento->ind_moneda == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'> <b>
                                    <?php if($fedocumento->MONEDA == 'PEN'): ?>
                                        SOLES
                                    <?php else: ?>
                                        <?php echo e($fedocumento->MONEDA); ?>

                                    <?php endif; ?></b>
                                </div>
                              </td>
                            </tr>

                            <tr>
                              <td><b>Total</b></td>
                              <td><p class='subtitulomerge'><?php echo e(number_format($ordencompra->CAN_TOTAL, 4, '.', ',')); ?></p></td>
                              <td>
                                <div class='subtitulomerge <?php if($fedocumento->ind_total == 1): ?> msjexitoso <?php else: ?> msjerror <?php endif; ?>'>
                                    <b><?php echo e(number_format($fedocumento->TOTAL_VENTA_XML, 4, '.', ',')); ?></b>
                                </div>
                              </td>
                            </tr>

                        </tbody>
                      </table>
                    </div>
                  </div>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
                  <div class="panel panel-default panel-contrast">
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INFORMACION DEL DOCUMENTO
                    </div>
                    <div class="panel-body panel-body-contrast">

                                        <div class="tab-container">
                                          <ul class="nav nav-tabs">
                                            <li class="active"><a href="#oc" data-toggle="tab">Nota de Credito</a></li>
                                            <li><a href="#xml" data-toggle="tab">XML</a></li>
                                          </ul>
                                          <div class="tab-content">
                                            <div id="oc" class="tab-pane active cont">

                                                  <table class="table table-condensed table-striped">
                                                    <thead>
                                                      <tr>
                                                        <th>Codigo Nota Credito</th>
                                                        <th>Fecha Nota Credito</th>      
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
                    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
                    </div>
                    <div class="panel-body panel-body-contrast">

                            <div class="row">                                  
                                  <?php $__currentLoopData = $tarchivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                        <label class="col-sm-12 control-label" style="text-align: left;height: 50px;">
                                          <b>
                                            <?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)                                            
                                          </b> 
                                          <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?> <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) <?php else: ?> <?php endif; ?> </label>
                                      <div class="form-group sectioncargarimagen">

                                          <div class="col-sm-12">
                                              <div class="file-loading">
                                                  <input 
                                                  id="file-<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>" 
                                                  name="<?php echo e($item->COD_CATEGORIA_DOCUMENTO); ?>[]" 
                                                  class="file-es"  
                                                  type="file" 
                                                  multiple data-max-file-count="1"
                                                  required >
                                              </div>
                                          </div>
                                      </div>
                                    </div>                                    
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
                                  </div>

                                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                                      <div class="col-xs-6">

                                      </div>
                                      <div class="col-xs-6">
                                        <p class="text-right">
                                          <input type="hidden" name="idopcion" id='idopcion' value = '<?php echo e($idopcion); ?>'>
                                          <input type="hidden" name="te" id='te' value = '<?php echo e($fedocumento->ind_errototal); ?>'>
                                          <input type="hidden" name="valor_igv" id='valor_igv' value = '<?php echo e((float)$fedocumento->VALOR_IGV_ORIG); ?>'>
                                          <input type="hidden" name="empresa_id" id='empresa_id' value = '<?php echo e($ordencompra_f->COD_EMPR); ?>'>
                                          <input type="hidden" name="monto_total" id='monto_total' value = '<?php echo e($fedocumento->TOTAL_VENTA_ORIG); ?>'>
                                          <input type="hidden" name="prefijo_id" id='prefijo_id' value = '<?php echo e(substr($ordencompra->COD_DOCUMENTO_CTBLE, 0,6)); ?>'>
                                          <input type="hidden" name="orden_id" id='orden_id' value = '<?php echo e(Hashids::encode(substr($ordencompra->COD_DOCUMENTO_CTBLE, -10))); ?>'>
                                          <input type="hidden" name="contacto_id" id='contacto_id' value = '<?php echo e($usuario->COD_TRABAJADOR); ?>'>
                                          <button type="submit" class="btn btn-space btn-success btn-guardar-xml-nota-credito">Guardar</button>
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
