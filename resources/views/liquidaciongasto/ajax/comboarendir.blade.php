<div class="form-group">
  <label class="col-sm-12 control-label labelleft negrita" >ARENDIR <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-12">
      {!! Form::select( 'arendir_sel_id', $combo_arendir_sel, array($arendir_sel_id),
                      [
                        'class'       => 'select20 form-control control input-xs' ,
                        'id'          => 'arendir_sel_id',
                        'required'    => '', 
                      ]) !!}
  </div>
</div>
@if(isset($ajax))
  <script type="text/javascript">
        $(".select20").select2({
            width: '100%'
        });
  </script>
@endif