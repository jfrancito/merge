<div class="form-group">
  <label class="col-sm-3 control-label">Codigo <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="codigo" name='codigo' 
              value="@if(isset($producto)){{old('codigo' ,$producto->codigo)}}@else{{old('codigo' ,$cod_producto)}}@endif"
              value="{{ old('codigo') }}"                         
              placeholder="Codigo"
              readonly = "readonly"
              required = ""
              autocomplete="off" class="form-control input-sm" data-aw="1"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('codigo')  , 
                                          'error' => $errors->first('codigo', ':message') , 
                                          'data' => '1'])

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Descripcion <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">

      <input  type="text"
              id="descripcion" name='descripcion' 
              value="@if(isset($producto)){{old('descripcion' ,$producto->descripcion)}}@else{{old('descripcion')}}@endif"
              value="{{ old('descripcion') }}" 
              placeholder="Descripcion"
              required = ""
              autocomplete="off" class="form-control input-sm" data-aw="2"/>

      @include('error.erroresvalidate', [ 'id' => $errors->has('descripcion')  , 
                                          'error' => $errors->first('descripcion', ':message') , 
                                          'data' => '2'])

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label" >Peso <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
      <input  type="text"
              id="peso" name='peso' 
              value="@if(isset($producto)){{old('peso' ,$producto->peso)}}@endif" 
              placeholder="Peso"
              autocomplete="off" class="form-control input-sm importe" data-aw="3"/>

  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Unidad Medida <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
    {!! Form::select( 'unidad_medida_id', $combo_unidad_medida, $select_unidad_medida,
                      [
                        'class'       => 'select2 form-control control input-xs' ,
                        'id'          => 'unidad_medida_id',
                        'required'    => '',                        
                        'data-aw'     => '5'
                      ]) !!}

      @include('error.erroresvalidate', [ 'id' => $errors->has('unidad_medida_id')  , 
                                          'error' => $errors->first('unidad_medida_id', ':message') , 
                                          'data' => '5'])

  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Categoria <span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
      {!! Form::select( 'categoria_id', $combo_categoria, $select_categoria,
                      [
                        'class'       => 'select2 form-control control input-xs' ,
                        'id'          => 'categoria_id',
                        'required'    => '',                        
                        'data-aw'     => '6'
                      ]) !!}
      @include('error.erroresvalidate', [ 'id' => $errors->has('categoria_id')  , 
                                          'error' => $errors->first('categoria_id', ':message') , 
                                          'data' => '6'])
  </div>
</div>

@if(isset($producto))
<div class="form-group">
  <label class="col-sm-3 control-label">Activo</label>
  <div class="col-sm-6">
    <div class="be-radio has-success inline">
      <input type="radio" value='1' name="activo" id="rad6" @if($producto->activo == 1) checked @endif>
      <label for="rad6">Activado</label>
    </div>
    <div class="be-radio has-danger inline">
      <input type="radio" value='0' name="activo" id="rad8" @if($producto->activo == 0) checked @endif >
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
      <button type="submit" class="btn btn-space btn-primary btnguardarproducto">Guardar</button>
    </p>
  </div>
</div>


