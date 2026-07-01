<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <?php echo $__env->make('comprobante.form.comision.comparar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 <?php if($fedocumento->OPERACION_DET == 'SIN_XML'): ?> ocultar <?php endif; ?>">
        <?php echo $__env->make('comprobante.form.comision.consultaapisunat', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <?php echo $__env->make('comprobante.form.contrato.seguimiento', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <?php echo $__env->make('comprobante.form.comision.archivos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
        <?php echo $__env->make('comprobante.form.comision.informacion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php echo $__env->make('comprobante.form.ordencompra.verarchivopdf', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        <?php echo $__env->make('comprobante.form.estiba.archivosobservados', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>OTROS DOCUMENTOS</b>
                                <br><br></label>
                            <div class="col-sm-12">
                                <div class="file-loading">
                                    <input
                                            id="file-otros"
                                            name="otros[]"
                                            class="file-es"
                                            type="file"
                                            multiple data-max-file-count="1"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA
                                    OBSERVACION</b> <br><br></label>
                            <div class="col-sm-12">
                          <textarea
                                  name="descripcion"
                                  id="descripcion"
                                  class="form-control input-sm validarmayusculas"
                                  rows="12"
                                  cols="200"
                                  data-aw="2"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-12 control-label izquierda" style="text-align: left;">Cuenta Contable
                                <b>(*)</b></label>
                            <div class="col-sm-12">
                                <input type="text"
                                       id="nro_cuenta_contable"
                                       name='nro_cuenta_contable'
                                       value=""
                                       placeholder="Cuenta Contable"
                                       required=""
                                       autocomplete="off" class="form-control input-sm"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <?php echo $__env->make('comprobante.asiento.listaasientotabla', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        <?php echo $__env->make('comprobante.asiento.contenedorasientoorden', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>
</div>

<div class="row xs-pt-15">
    <div class="col-xs-6">
        <div class="be-checkbox">
        </div>
    </div>
    <div class="col-xs-6">
        <p class="text-right">
            <a href="<?php echo e(url('/gestion-de-comprobante-contabilidad/'.$idopcion)); ?>">
                <button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button>
            </a>
            <button type="button" class="btn btn-space btn-primary btnaprobarcomporbatntenuevocomision">Guardar</button>
        </p>
    </div>
</div>
