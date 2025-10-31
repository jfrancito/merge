<div class="control-group">

  <div class="row">

    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3 ajax_combo_cuenta">
        <div class="form-group">
          <label class="col-sm-12 control-label labelleft" style="text-align: left;">SEMANA <span class="obligatorio">(*)</span>:</label>
          <div class="col-sm-12 abajocaja" >
            {!! Form::select( 'semana_id', $combosemana, array($semana_id),
                              [
                                'class'       => 'select2 form-control control input-sm' ,
                                'id'          => 'semana_id',
                                'required'    => '',
                              ]) !!}
          </div>
        </div>
    </div>

</div>



