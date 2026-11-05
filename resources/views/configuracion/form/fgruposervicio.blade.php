<div class="form-group">
  <label class="col-sm-3 control-label">Descripcion <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
      <input  type="text"
              id="descripcion" name='descripcion' 
              value="@if(isset($categoria)){{old('descripcion' ,$categoria->descripcion)}}@else{{old('descripcion')}}@endif"
              value="{{ old('descripcion') }}" 
              placeholder="Descripcion"
              required = ""
              autocomplete="off" class="form-control input-sm" data-aw="4"
              @if($disabledescripcion) disabled @endif
              />
      @include('error.erroresvalidate', [ 'id' => $errors->has('descripcion')  , 
                                          'error' => $errors->first('descripcion', ':message') , 
                                          'data' => '4'])
  </div>
</div>

@if(isset($categoria))
<div class="form-group">
  <label class="col-sm-3 control-label">Activo</label>
  <div class="col-sm-6">
    <div class="be-radio has-success inline">
      <input type="radio" value='1' name="activo" id="rad6" @if($categoria->activo == 1) checked @endif>
      <label for="rad6">Activado</label>
    </div>
    <div class="be-radio has-danger inline">
      <input type="radio" value='0' name="activo" id="rad8" @if($categoria->activo == 0) checked @endif >
      <label for="rad8">Desactivado</label>
    </div>
  </div>
</div> 
@endif

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
    </p>
  </div>
</div>