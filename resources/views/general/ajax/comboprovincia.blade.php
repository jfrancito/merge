 <label class="col-sm-3 control-label">Provincia<span class="obligatorio">(**)</span> :</label>
  <div class="col-sm-6">
    {!! Form::select( 'provincia_id', $comboprovincia,$select_provincia,
                      [
                        'class'       => 'select2 form-control control input-xs' ,
                        'id'          => 'provincia_id',
                        'required'    => '',
                        'disabled'    => false,
                        'data-aw'     => '5'
                      ]) !!}

      @include('error.erroresvalidate', [ 'id' => $errors->has('provincia_id')  , 
                                          'error' => $errors->first('provincia_id', ':message') , 
                                          'data' => '5'])

  </div>

  @if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
    App.formElements();
    });
    
    $("#provincia_id").select2({
      width: '100%'
    });
  </script> 
@endif