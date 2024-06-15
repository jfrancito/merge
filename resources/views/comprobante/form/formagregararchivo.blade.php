<div class="form-group">
  <label class="col-sm-3 control-label">Cliente:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $ordencompra->TXT_EMPR_CLIENTE }}">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Codigo Orden:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $ordencompra->COD_ORDEN }}">
  </div>
</div>



<div class="form-group">
  <label class="col-sm-3 control-label">Archivos Faltantes:</label>
  <div class="col-sm-6">

    @foreach($documentoscompra as $index => $item)
      @if(!in_array($item->COD_CATEGORIA, $totalarchivos))
        <div class="be-checkbox">
          <input id="{{$item->COD_CATEGORIA}}" value="{{$item->COD_CATEGORIA}}"  type="checkbox" name="archivoob[]" >
          <label for="{{$item->COD_CATEGORIA}}">{{$item->NOM_CATEGORIA}} ({{$item->COD_CTBLE}}) 
            @if(in_array($item->COD_CATEGORIA, $totalarchivos)) <span class="label label-success">registrado</span> 
            @endif 
          </label>
        </div>
      @endif
    @endforeach

  </div>
</div>

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="{{ url('/gestion-de-contabilidad-aprobar/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="submit" class="btn btn-space btn-primary btnobservar">Guardar</button>
    </p>
  </div>
</div>