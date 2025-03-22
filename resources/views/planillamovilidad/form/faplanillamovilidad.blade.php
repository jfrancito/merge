<div class="control-group">

  <div class="row">
    <div class="col-sm-2">
      <div class="form-group">
        <label class="control-label">PERIODO</label>
        <div class="col-sm-12">
            <input  type="text"
                    id="lote" name='lote' 
                    value="{{$periodo}}"                         
                    placeholder="PERIODO"
                    readonly = "readonly"
                    required = ""
                    autocomplete="off" class="form-control input-sm" data-aw="7"/>

            @include('error.erroresvalidate', [ 'id' => $errors->has('lote')  , 
                                                'error' => $errors->first('lote', ':message') , 
                                                'data' => '7'])
        </div>
      </div>
    </div>

  </div>  
</div>
<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">
      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
        <button type="submit" class="btn btn-space btn-primary btnguardarcompra">Crear Nueva Planilla Movilidad</button>     
    </p>
  </div>
</div>


