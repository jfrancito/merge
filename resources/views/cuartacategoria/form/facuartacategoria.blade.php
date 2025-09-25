<div class="control-group">

  <div class="row">

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" style="text-align: left;">EMPRESA <span class="obligatorio">(*)</span>:</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'empresa_id', $combo_empresa, array($empresa_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'empresa_id',
                                'required'    => ''
                              ]) !!}
          </div>
        </div>
    </div>

    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
        <div class="form-group ">
          <label class="col-sm-12 control-label labelleft" >Fecha Constancia: <span class="obligatorio">(*)</span></label>
          <div class="col-sm-12 abajocaja" >
            <div data-min-view="2" 
                   data-date-format="dd-mm-yyyy"  
                   class="input-group date datetimepicker pickerfecha" style = 'padding: 0px 0;margin-top: -3px;'>
                   <input size="16" type="text" 
                          value="" 
                          placeholder="Fecha Constancia"
                          id='fecha_constancia' 
                          name='fecha_constancia' 
                          required = ""
                          class="form-control input-sm"/>
                    <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
              </div>
          </div>
        </div>
    </div> 


    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" style="text-align: left;">Nro. Operacion <span class="obligatorio">(*)</span>:</label>
          <div class="col-sm-12 abajocaja" >
              <input type="text" class="form-control control input-sm"  id='nro_operacion' 
                          name='nro_operacion'  required = "" value="" placeholder="Nro. Operacion">
          </div>
        </div>
    </div>





  </div>



</div>



