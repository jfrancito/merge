<div class="form-group">
  <label class="col-sm-12 control-label labelleft" ><b>Cuenta Bancaria que se le va a pagar al proveedor :</b></label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'cb_id', $combocb, array(),
                      [
                        'class'       => 'select4 form-control control input-xs' ,
                        'id'          => 'cb_id',
                        'data-aw'     => '1',
                      ]) !!}
  </div>
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
      $('.select4').select2();
    });
  </script>
@endif