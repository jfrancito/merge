<div class="control-group">
  <div class="row">
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" style="text-align: left;">EMPRESA <span class="obligatorio">(*)</span>:</label>
          <div class="col-sm-12 abajocaja" >
            <?php echo Form::select( 'empresa_id', $combo_empresa, array($empresa_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'empresa_id',
                                'required'    => '',
                                'readonly'     => 'readonly'
                              ]); ?>

          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
                <div class="form-group">
                  <label class="col-sm-12 control-label labelleft negrita" >MONEDA <span class="obligatorio">(*)</span> :</label>
                  <div class="col-sm-12">
                      <?php echo Form::select( 'moneda_sel_c_id', $combo_moneda_sel, array($moneda_sel_id),
                                      [
                                        'class'       => 'select2 form-control control input-xs' ,
                                        'id'          => 'moneda_sel_c_id',
                                        'required'    => '',    
                                      ]); ?>

                  </div>
                </div>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta_moneda">
        <?php echo $__env->make('general.ajax.combocuenta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <?php echo $__env->make('general.ajax.combosubcuenta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3" style="display: none;">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">FECHA CREACION <span class="obligatorio">(*)</span>:</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="fecha_creacion" name='fecha_creacion' 
                    value="<?php echo e(date_format(date_create($fecha_creacion), 'd-m-Y h:i:s')); ?>"                         
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

  <div class="row">

    <div class="ol-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">CENTRO <span class="obligatorio">(*)</span>:</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="centro_txt" name='centro_txt' 
                    value="<?php echo e($centro->NOM_CENTRO); ?>"                         
                    placeholder="NUMERO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm"/>
        </div>
      </div>
    </div>



    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" style="text-align: left;">¿TIENE A RENDIR?  <span class="obligatorio">(*)</span>:</label>
          <div class="col-sm-12 abajocaja" >
            <?php echo Form::select( 'arendir_id', $combo_arendir, array($arendir_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'arendir_id',
                                'required'    => '',
                                'readonly'     => 'readonly'
                              ]); ?>

          </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 cajaautoriza sectorarendir ajax_combo_arendir">
      <?php echo $__env->make('liquidaciongasto.ajax.comboarendir', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

  </div>

  <div class="row">

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 cajaautoriza ajax_combo_autoriza">
      <?php echo $__env->make('liquidaciongasto.ajax.comboautoriza', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
    </div>

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">AREA <span class="obligatorio">(*)</span>:</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="area_txt" name='area_txt' 
                    value="<?php echo e($area_txt); ?>"                         
                    placeholder="AREA"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="4"/>
        </div>
      </div>
    </div>


    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
      <div class="form-group">
        <label class="col-sm-12 control-label labelleft negrita">GLOSA :</label>
          <div class="col-sm-12">
              <textarea 
              name="glosa"
              id = "glosa"
              class="form-control input-sm validarmayusculas"
              rows="2"></textarea>
          </div>
      </div>
    </div>
  </div>

</div>
