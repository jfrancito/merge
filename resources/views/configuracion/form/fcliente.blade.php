<div class="formcliente">
  <div class="form-group">
    <label class="col-sm-3 control-label">Tipo documento <span class="obligatorio">(*)</span> :</label>
    <div class="col-sm-6">
      <input type="hidden" name="sindocumento" id='sindocumento' value="@if(isset($cliente)){{ $cliente->sindocumento}}@endif">
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
                value="@if(isset($cliente)){{old('numerodocumento' ,$cliente->numerodocumento)}}@else{{old('numerodocumento')}}@endif"
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
                value="@if(isset($cliente)){{old('nombre_razonsocial' ,$cliente->nombre_razonsocial)}}@else{{old('nombre_razonsocial')}}@endif"
                value="{{ old('nombre_razonsocial') }}" 
                placeholder="Nombres o  Razon Social"
                required = ""
                autocomplete="off" class="form-control input-sm" data-aw="3"/>

        @include('error.erroresvalidate', [ 'id' => $errors->has('nombre_razonsocial')  , 
                                            'error' => $errors->first('nombre_razonsocial', ':message') , 
                                            'data' => '3'])

    </div>
  </div>
  <div class="ajaxubigeo">
    <div class="form-group ajaxdepartamento">
      <label class="col-sm-3 control-label">Departamento <span class="obligatorio">(*)</span> :</label>
      <div class="col-sm-6">
        {!! Form::select( 'departamento_id', $combo_departamentos, $select_departamento,
                          [
                            'class'       => 'select2 form-control control input-xs' ,
                            'id'          => 'departamento_id',
                            'required'    => '',
                            'disabled'    => false,
                            'data-aw'     => '4'
                          ]) !!}

          @include('error.erroresvalidate', [ 'id' => $errors->has('departamento_id')  , 
                                              'error' => $errors->first('departamento_id', ':message') , 
                                              'data' => '4'])

      </div>
    </div>

    <div class="form-group ajaxprovincia">
      <label class="col-sm-3 control-label">Provincia<span class="obligatorio">(*)</span> :</label>
      <div class="col-sm-6">
        {!! Form::select( 'provincia_id', $combo_provincias, $select_provincia,
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
    </div>

    <div class="form-group ajaxdistrito">
      <label class="col-sm-3 control-label">Distritos <span class="obligatorio">(*)</span> :</label>
      <div class="col-sm-6">
        {!! Form::select( 'distrito_id', $combo_distritos, $select_distrito,
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
    </div>
  </div>

  <div class="form-group">
    <label class="col-sm-3 control-label">Direccion <span class="obligatorio">(*)</span> :</label>
    <div class="col-sm-6">

        <input  type="text"
                id="direccion" name='direccion' 
                value="@if(isset($cliente)){{old('direccion' ,$cliente->direccion)}}@else{{old('direccion')}}@endif"
                value="{{ old('direccion') }}" 
                placeholder="Direccion"
                required = ""
                autocomplete="off" class="form-control input-sm" data-aw="4"/>

        @include('error.erroresvalidate', [ 'id' => $errors->has('direccion')  , 
                                            'error' => $errors->first('direccion', ':message') , 
                                            'data' => '7'])

    </div>
  </div>



  <div class="form-group">
    <label class="col-sm-3 control-label">Correo :</label>
    <div class="col-sm-6">

        <input  type="email"
                id="correo" name='correo' 
                value="@if(isset($cliente)){{old('correo' ,$cliente->correo)}}@else{{old('correo')}}@endif"
                value="{{ old('correo') }}" 
                placeholder="Correo"
                autocomplete="off" class="form-control input-sm" data-aw="8"/>

        @include('error.erroresvalidate', [ 'id' => $errors->has('correo')  , 
                                            'error' => $errors->first('correo', ':message') , 
                                            'data' => '8'])

    </div>
  </div>


  <div class="form-group">
    <label class="col-sm-3 control-label">Celular :</label>
    <div class="col-sm-6">

        <input  type="text"
                id="celular" name='celular' 
                value="@if(isset($cliente)){{old('celular' ,$cliente->celular)}}@else{{old('celular')}}@endif"
                value="{{ old('celular') }}" 
                placeholder="Celular"
                data-parsley-type="number"
                autocomplete="off" class="form-control input-sm" data-aw="9"/>

        @include('error.erroresvalidate', [ 'id' => $errors->has('celular')  , 
                                            'error' => $errors->first('celular', ':message') , 
                                            'data' => '9'])

    </div>
  </div>

  @if(isset($cliente))
  <div class="form-group">
    <label class="col-sm-3 control-label">Activo</label>
    <div class="col-sm-6">
      <div class="be-radio has-success inline">
        <input type="radio" value='1' name="activo" id="rad6" @if($cliente->activo == 1) checked @endif>
        <label for="rad6">Activado</label>
      </div>
      <div class="be-radio has-danger inline">
        <input type="radio" value='0' name="activo" id="rad8" @if($cliente->activo == 0) checked @endif >
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
</div>
