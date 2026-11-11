<div class="form-group">
  <label class="col-sm-3 control-label">Tipo documento <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
    {!! Form::select( 'tipo_documento_id', $combo_tipo_documento, $select_tipo_documento,
                      [
                        'class'       => 'select2 form-control control input-xs' ,
                        'id'          => 'tipo_documento_id',
                        'required'    => '',
                        'disabled'    => $disabletipodocumento,
                        'data-aw'     => '1'
                      ]) !!}

      @include('error.erroresvalidate', [ 'id' => $errors->has('tipo_documento_id')  , 
                                          'error' => $errors->first('tipo_documento_id', ':message') , 
                                          'data' => '1'])

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">DNI / RUC <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="numerodocumento" name='numerodocumento' 
              value="@if(isset($proveedor)){{old('numerodocumento' ,$proveedor->numerodocumento)}}@else{{old('numerodocumento')}}@endif"
              value="{{ old('numerodocumento') }}"
              data-parsley-type="number"
              data-parsley-length="[8,11]"
              placeholder="DNI o RUC"
              required = ""
              autocomplete="off" class="form-control input-sm" data-aw="2"
              @if($disablenumerodocumento) disabled @endif/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('numerodocumento')  , 
                                          'error' => $errors->first('numerodocumento', ':message') , 
                                          'data' => '2'])

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Nombres / Razon Social <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="nombre_razonsocial" name='nombre_razonsocial' 
              value="@if(isset($proveedor)){{old('nombre_razonsocial' ,$proveedor->nombre_razonsocial)}}@else{{old('nombre_razonsocial')}}@endif"
              value="{{ old('nombre_razonsocial') }}" 
              placeholder="Nombres o  Razon Social"
              required = ""
              autocomplete="off" class="form-control input-sm" data-aw="3"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('nombre_razonsocial')  , 
                                          'error' => $errors->first('nombre_razonsocial', ':message') , 
                                          'data' => '3'])

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Rubro <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
    {!! Form::select( 'rubro_id', $combo_rubro, $select_rubro,
                      [
                        'class'       => 'select2 form-control control input-xs' ,
                        'id'          => 'rubro_id',
                        'required'    => '',
                        'data-aw'     => '4'
                      ]) !!}

      @include('error.erroresvalidate', [ 'id' => $errors->has('rubro_id')  , 
                                          'error' => $errors->first('rubro_id', ':message') , 
                                          'data' => '4'])

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Direccion <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="direccion" name='direccion' 
              value="@if(isset($proveedor)){{old('direccion' ,$proveedor->direccion)}}@else{{old('direccion')}}@endif"
              value="{{ old('direccion') }}" 
              placeholder="Direccion"
              required = ""
              autocomplete="off" class="form-control input-sm" data-aw="4"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('direccion')  , 
                                          'error' => $errors->first('direccion', ':message') , 
                                          'data' => '5'])

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Correo :</label>
  <div class="col-sm-6">

      <input  type="email"
              id="correo" name='correo' 
              value="@if(isset($proveedor)){{old('correo' ,$proveedor->correo)}}@else{{old('correo')}}@endif"
              value="{{ old('correo') }}" 
              placeholder="Correo"
              autocomplete="off" class="form-control input-sm" data-aw="5"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('correo')  , 
                                          'error' => $errors->first('correo', ':message') , 
                                          'data' => '6'])

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Celular :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="celular" name='celular' 
              value="@if(isset($proveedor)){{old('celular' ,$proveedor->celular)}}@else{{old('celular')}}@endif"
              value="{{ old('celular') }}" 
              placeholder="Celular"
              data-parsley-type="number"
              autocomplete="off" class="form-control input-sm" data-aw="6"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('celular')  , 
                                          'error' => $errors->first('celular', ':message') , 
                                          'data' => '7'])

  </div>
</div>

@if(isset($proveedor))
<div class="form-group">
  <label class="col-sm-3 control-label">Activo</label>
  <div class="col-sm-6">
    <div class="be-radio has-success inline">
      <input type="radio" value='1' name="activo" id="rad6" @if($proveedor->activo == 1) checked @endif>
      <label for="rad6">Activado</label>
    </div>
    <div class="be-radio has-danger inline">
      <input type="radio" value='0' name="activo" id="rad8" @if($proveedor->activo == 0) checked @endif >
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
      <button type="submit" class="btn btn-space btn-primary btnguardarproveedor">Guardar</button>
    </p>
  </div>
</div>