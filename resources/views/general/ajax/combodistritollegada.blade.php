<label class="col-sm-12 control-label labelleft negrita" >DISTRITO LLEGADA<span class="obligatorio">(*)</span> :</label>
<div class="col-sm-12">
  {!! Form::select( 'distritollegada_id', $combodistritoll, $distrito_idll,
                  [
                    'class'       => 'form-control control input-xs' ,
                    'id'          => 'distritollegada_id',        
                  ]) !!}
</div>

@if(isset($ajax))
  <script type="text/javascript">
    
    $("#distritollegada_id").select2({
      width: '100%'
    });
  </script> 
@endif