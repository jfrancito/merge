<div class="form-group">
  <label class="col-sm-12 control-label labelleft negrita" >AUTORIZA <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-12">
      {!! Form::select( 'autoriza_id', $combo_autoriza, array($autoriza_id),
                      [
                        'class'       => 'select21 form-control control input-xs' ,
                        'id'          => 'autoriza_id', 
                        'required'    => '',       
                      ]) !!}
  </div>
</div>
@if(isset($ajax))
  <script type="text/javascript">
        $(".select21").select2({
            width: '100%'
        });
  </script>
@endif