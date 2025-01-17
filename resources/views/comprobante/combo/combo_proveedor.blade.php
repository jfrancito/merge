<div class="form-group">
  <label class="col-sm-12 control-label labelleft" >Proveedor :</label>
  <div class="col-sm-12 abajocaja" >
    {!! Form::select( 'proveedor_id', $combo_proveedor, array($proveedor_id),
                      [
                        'class'       => 'select4 form-control control input-sm' ,
                        'id'          => 'proveedor_id',
                        'required'    => '',
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