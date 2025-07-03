<div class="form-group">
  <label class="col-sm-12 control-label labelleft negrita" style="text-align: left;">SUB CUENTA :<span class="obligatorio">(*)</span></label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'subcuenta_id', $combo_subcuenta, array($subcuenta_id),
                      [
                        'class'       => 'select4 form-control control input-sm' ,
                        'id'          => 'subcuenta_id',
                        'required' => ''
                      ]) !!}
  </div>
</div>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
        $(".subcuenta_id").select2({
            width: '100%'
        });
    });
  </script>
@endif
