<label class="col-sm-12 control-label labelleft negrita" >PROVINCIA LLEGADA<span class="obligatorio">(*)</span> :</label>
<div class="col-sm-12">
  {!! Form::select( 'provinciallegada_id', $comboprovinciall, $provincia_idll,
                  [
                    'class'       => 'form-control control input-xs' ,
                    'id'          => 'provinciallegada_id',        
                  ]) !!}
</div>

@if(isset($ajax))
  <script type="text/javascript">    
    $("#provinciallegada_id").select2({
      width: '100%'
    });
  </script> 
@endif