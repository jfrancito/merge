

<div class="form-field">
    <label class="form-label">SUB CUENTA : <span class="text-danger">(*)</span></label>
    {!! Form::select('subcuenta_id', $combo_subcuenta, array($subcuenta_id), ['class' => 'select2 form-control', 'id' => 'subcuenta_id', 'required' => '']) !!}
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
