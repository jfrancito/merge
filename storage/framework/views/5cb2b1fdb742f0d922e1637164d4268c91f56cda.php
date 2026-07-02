<input type="hidden" name="rutaorden" id='rutaorden' value = '<?php echo e($rutaorden); ?>'>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.sunat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <?php echo $__env->make('comprobante.form.ordencompra.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div> 
</div>

<?php if(count($area_mkt)>0): ?>
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background: #1d3a6d;color: #fff;">GRUPO MARKETING
          <div class="tools agregar_grupo_marketing_oc select" style="cursor: pointer;"> <span class="label label-success">Agregar Grupo</span></div>
        </div>
        <div class="panel-body panel-body-contrast">
                <div class="row">
                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                          <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" ><b>Grupo :</b></label>
                                <div class="col-sm-12 abajocaja" >
                                    <?php echo Form::select( 'grupo_id', $combogrupo, array(''),
                                                      [
                                                        'class'       => 'select2 form-control control input-xs' ,
                                                        'id'          => 'grupo_id',
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


  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
        <table class="table table-condensed table-striped">
          <thead>
            <tr>
              <th>Nro</th>
              <th>Nombre</th>      
              <th>Archivo</th>       
              <th>Opciones</th>
            </tr>
          </thead>
          <tbody>
              <?php $__currentLoopData = $archivos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                <?php  
                  $es_pdf = str_contains(strtolower($item->NOMBRE_ARCHIVO), 'pdf');
                 ?>
                <tr>
                  <td><?php echo e($index + 1); ?></td>
                  <td><?php echo e($item->DESCRIPCION_ARCHIVO); ?></td>
                  <td><?php echo e($item->NOMBRE_ARCHIVO); ?></td>

                  <td class="rigth">
                    <div class="btn-group btn-hspace">
                      <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                      <ul role="menu" class="dropdown-menu pull-right">
                        <li>
                          <a href="<?php echo e(url('/descargar-archivo-requerimiento/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>">
                            Descargar
                          </a>  
                        </li>

                          <?php if($es_pdf): ?>
                            <li>
                              <a class="elimnaritem" href="<?php echo e(url('/eliminar-archivo-item/'.$item->TIPO_ARCHIVO.'/'.$item->NOMBRE_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>">
                                Eliminar Item
                              </a>
                            </li>
                          <?php endif; ?>

                          <?php if($es_pdf): ?>
                            <li>
                                <a href="#" class="modificar-pdf" 
                                   data-tipo="<?php echo e($item->TIPO_ARCHIVO); ?>" 
                                   data-nombre="<?php echo e($item->DESCRIPCION_ARCHIVO); ?>">
                                  Modificar
                                </a>
                            </li>
                          <?php endif; ?>

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

  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
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
    <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>
</div>

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


                    <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000001'): ?>
                      <?php if($rutaorden != ''): ?>
                        <div><b>LA ORDEN DE COMPRA SE CARGARA DESPUES DE GUARDAR</b></div>
                      <?php else: ?>
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                          <div class="form-group sectioncargarimagen">
                              <label class="col-sm-12 control-label" style="text-align: left;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)</b> 
                                <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?> <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) <?php else: ?> <br><br> <?php endif; ?>
                              </label>
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
                      <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b><?php echo e($item->NOM_CATEGORIA_DOCUMENTO); ?> (<?php echo e($item->TXT_FORMATO); ?>)</b> 
                              <?php if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005'): ?> <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) <?php else: ?> <br><br> <?php endif; ?>
                            </label>
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
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <?php echo $__env->make('comprobante.form.ordencompra.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
  </div>


  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                  <div class="form-group sectioncargarimagen">
                      <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA OBSERVACION</b> <br><br></label>
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


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cajareporte <?php if((float)$monto_anticipo<=0): ?> ocultar <?php endif; ?>">
                    <div class="form-group">
                      <label class="col-sm-12 control-label labelleft" style="text-align: left;">
                        <div class="tooltipfr" style="text-align: left;"><b>Aplicar Anticipo </b>
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
      </div>
    </div>



  </div>


              <input type="hidden" name="rutasuspencion" id='rutasuspencion' value = '<?php echo e($rutasuspencion); ?>'>
              <input type="hidden" name="idopcion" id='idopcion' value = '<?php echo e($idopcion); ?>'>
              <input type="hidden" name="prefijo_id" id='prefijo_id' value = '<?php echo e(substr($ordencompra->COD_ORDEN, 0,6)); ?>'>
              <input type="hidden" name="orden_id" id='orden_id' value = '<?php echo e(Hashids::encode(substr($ordencompra->COD_ORDEN, -10))); ?>'>
              <input type="hidden" name="grupo_data" id='grupo_data' value = '<?php echo e(count($area_mkt)); ?>'>


</div>




<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="<?php echo e(url('/gestion-de-comprobante-us/'.$idopcion)); ?>"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <?php if($fedocumento->COD_ESTADO != 'ETM0000000000007'): ?>
            <button type="submit" class="btn btn-space btn-primary btnaprobarcomporbatnteus">Guardar</button>
      <?php endif; ?>
    </p>
  </div>
</div>