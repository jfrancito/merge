
  <label class="col-sm-3 control-label">Distritos <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
    {!! Form::select( 'distrito_id', $combodistrito, $select_distrito,
                      [
                        'class'       => 'select2 form-control control input-xs' ,
                        'id'          => 'distrito_id',
                        'required'    => '',
                        'disabled'    => false,
                        'data-aw'     => '6'
                      ]) !!}

      @include('error.erroresvalidate', [ 'id' => $errors->has('distrito_id')  , 
                                          'error' => $errors->first('distrito_id', ':message') , 
                                          'data' => '6'])

  </div>
@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
    App.formElements();
    });

    $("#distrito_id").select2({
      width: '100%'
    });
  </script> 
@endif