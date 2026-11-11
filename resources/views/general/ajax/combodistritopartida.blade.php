<label class="col-sm-12 control-label labelleft negrita" >DISTRITO PARTIDA<span class="obligatorio">(*)</span> :</label>
<div class="col-sm-12">
  {!! Form::select( 'distritopartida_id', $combodistrito, $distrito_id,
                  [
                    'class'       => 'form-control control input-xs' ,
                    'id'          => 'distritopartida_id',        
                  ]) !!}
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $("#distritopartida_id").select2({
      width: '100%'
    });
  </script> 
@endif