<div class="control-group">

  <div class="row">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">PERIODO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="periodo" name='periodo' 
                    value="<?php if(isset($planillamovilidad)): ?> <?php echo e($planillamovilidad->TXT_PERIODO); ?> <?php else: ?> <?php echo e($periodo->TXT_NOMBRE); ?> <?php endif; ?>"                         
                    placeholder="PERIODO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="1"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('periodo')  , 
                                                'error' => $errors->first('periodo', ':message') , 
                                                'data' => '1'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">SERIE :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="serie" name='serie' 
                    value="<?php if(isset($planillamovilidad)): ?> <?php echo e($planillamovilidad->SERIE); ?> <?php else: ?> <?php echo e($serie); ?> <?php endif; ?>"                         
                    placeholder="SERIE"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('serie')  , 
                                                'error' => $errors->first('serie', ':message') , 
                                                'data' => '2'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">NUMERO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="numero" name='numero' 
                    value="<?php if(isset($planillamovilidad)): ?><?php echo e($planillamovilidad->NUMERO); ?><?php else: ?><?php echo e($numero); ?><?php endif; ?>"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="3"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('numero')  , 
                                                'error' => $errors->first('numero', ':message') , 
                                                'data' => '3'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">FECHA CREACION :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="fecha_creacion" name='fecha_creacion' 
                    value="<?php if(isset($planillamovilidad)): ?><?php echo e(date_format(date_create($planillamovilidad->FECHA_CREA), 'd-m-Y h:i:s')); ?><?php else: ?><?php echo e(date_format(date_create($fecha_creacion), 'd-m-Y h:i:s')); ?><?php endif; ?>"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="4"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('fecha_creacion')  , 
                                                'error' => $errors->first('fecha_creacion', ':message') , 
                                                'data' => '4'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>
  </div>

  <div class="row" style="margin-top: 15px;">
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">NOMBRES Y APELLIDOS :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="txttrabajador" name='txttrabajador' 
                    value="<?php echo e($txttrabajador); ?>"                         
                    placeholder="NOMBRES Y APELLIDOS"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="5"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('txttrabajador')  , 
                                                'error' => $errors->first('txttrabajador', ':message') , 
                                                'data' => '5'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">DNI :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="doctrabajador" name='doctrabajador' 
                    value="<?php echo e($doctrabajador); ?>"                         
                    placeholder="DNI"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('doctrabajador')  , 
                                                'error' => $errors->first('doctrabajador', ':message') , 
                                                'data' => '2'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">CENTRO :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="centro" name='centro' 
                    value="<?php echo e($centro); ?>"                         
                    placeholder="CENTRO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="2"/>

            <?php echo $__env->make('error.erroresvalidate', [ 'id' => $errors->has('centro')  , 
                                                'error' => $errors->first('centro', ':message') , 
                                                'data' => '2'], array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
        </div>
      </div>
    </div>
    <?php if(!isset($planillamovilidad)): ?>
      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                  <div class="form-group">
                    <label class="col-sm-12 control-label labelleft negrita" >LUGAR DE TRABAJO <span class="obligatorio">(*)</span> :</label>
                    <div class="col-sm-12">
                        <?php echo Form::select( 'direccion_id', $combodireccion, array($direccion_id),
                                        [
                                          'class'       => 'select2 form-control control input-xs' ,
                                          'id'          => 'direccion_id',
                                          'required'    => '',    
                                        ]); ?>

                    </div>
                  </div>
      </div>
    <?php endif; ?>


    <?php if(isset($planillamovilidad)): ?>
    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">TOTAL :</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="total" name='total' 
                    value="<?php echo e($planillamovilidad->TOTAL); ?>"                         
                    placeholder="TOTAL"
                    readonly = "readonly"
                    autocomplete="off" class="form-control input-sm" style="font-size: 22px; font-weight: bold;text-align: right;" />

        </div>
      </div>
    </div>
    <input type="hidden" name="codanio" id= 'codanio' value="<?php echo e($periodo_pm->COD_ANIO); ?>">
    <input type="hidden" name="codmes" id= 'codmes' value="<?php echo e($periodo_pm->COD_MES); ?>">

    <input type="hidden" name="cod_mes" id="cod_mes" value="<?php echo e($periodo_pm->COD_MES); ?>">
    <input type="hidden" name="cod_anio" id="cod_anio" value="<?php echo e($periodo_pm->COD_ANIO); ?>">
    
    <?php endif; ?>

  </div>


  <div class="row" style="margin-top: 15px;">
    <?php if(isset($planillamovilidad)): ?>
      <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft negrita">GLOSA :</label>
            <div class="col-sm-12">
                <textarea 
                name="glosa"
                id = "glosa"
                required = ""
                class="form-control input-sm validarmayusculas"
                rows="2"><?php echo e($planillamovilidad->TXT_GLOSA); ?></textarea>
            </div>
        </div>
      </div>
    
    <?php endif; ?>



  </div>




</div>



