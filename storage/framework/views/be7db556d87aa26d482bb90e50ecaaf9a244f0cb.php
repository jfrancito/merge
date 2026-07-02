<div class="listadatos">  
        <div class="container">

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <?php echo $__env->make('comprobante.form.ordencompra.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> <?php echo $__env->make('comprobante.form.ordencompra.datosfactura', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?>
              <?php if($fedocumento->OPERACION_DET != 'SIN_XML'): ?> <?php echo $__env->make('comprobante.form.ordencompra.sunat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?> <?php endif; ?> 
              <?php echo $__env->make('comprobante.form.ordencompra.infodetraccion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
              <?php echo $__env->make('comprobante.form.ordencompra.ordeningreso', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <?php echo $__env->make('comprobante.form.ordencompra.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div> 
          </div>

          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <?php echo $__env->make('comprobante.form.ordencompra.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
              <?php echo $__env->make('comprobante.form.ordencompra.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php if(count($lista_anticipo_merge)>0): ?>
                    <?php echo $__env->make('comprobante.form.ordencompra.anticipomerge', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                  <?php endif; ?>
              
            </div>
          </div>

          
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php echo $__env->make('comprobante.form.ordencompra.pagobanco', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
          </div>

          
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
              <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
          </div>
          
          <div class="row">
            <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
              <div class="panel panel-default panel-contrast">
                <div class="panel-heading" style="background: #cc0000;color: #fff;">ARCHIVOS OBSERVADOS
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
                        <?php $__currentLoopData = $archivosanulados; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>  
                          <tr>
                            <td><?php echo e($index + 1); ?></td>
                            <td><?php echo e($item->DESCRIPCION_ARCHIVO); ?></td>
                            <td><?php echo e($item->NOMBRE_ARCHIVO); ?></td>

                            <td class="rigth">
                              <div class="btn-group btn-hspace">
                                <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle">Acción <span class="icon-dropdown mdi mdi-chevron-down"></span></button>
                                <ul role="menu" class="dropdown-menu pull-right">
                                  <li>
                                    <a href="<?php echo e(url('/descargar-archivo-requerimiento-anulado/'.$item->TIPO_ARCHIVO.'/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10)))); ?>">
                                      Descargar
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


