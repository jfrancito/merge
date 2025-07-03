<div class="form-group">
  <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">CUENTA :<span class="obligatorio">(*)</span></label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'cuenta_id', $combo_cuenta, array($cuenta_id),
                      [
                        'class'       => 'select3 form-control control input-sm cuenta_id' ,
                        'id'          => 'cuenta_id',
                        'required' => ''
                      ]) !!}
  </div>
</div>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
        $(".cuenta_id").select2({
            width: '100%'
        });
    });
  </script>
@endif
