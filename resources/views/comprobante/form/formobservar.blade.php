<div class="form-group">
  <label class="col-sm-3 control-label">Cliente:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $ordencompra->TXT_EMPR_CLIENTE }}">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Codigo Orden:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $fedocumento->ID_DOCUMENTO }}">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Documento:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $fedocumento->SERIE }}-{{ $fedocumento->NUMERO }}">
  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Usario Contacto:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{$trabajador->TXT_APE_PATERNO}} {{$trabajador->TXT_APE_MATERNO}} {{$trabajador->TXT_NOMBRES}}">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Archivos Faltantes:</label>
  <div class="col-sm-6">

    @foreach($documentoscompra as $index => $item)
      <div class="be-checkbox">
        <input id="{{$item->COD_CATEGORIA}}" value="{{$item->COD_CATEGORIA}}"  type="checkbox" name="archivoob[]" >
        <label for="{{$item->COD_CATEGORIA}}">{{$item->NOM_CATEGORIA}} ({{$item->COD_CTBLE}}) @if(in_array($item->COD_CATEGORIA, $totalarchivos)) <span class="label label-success">registrado</span> @endif </label>
      </div>
    @endforeach

  </div>
</div>



<div class="form-group">
  <label class="col-sm-3 control-label">Descripcion de Observacion<span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
        <textarea 
        name="descripcion"
        id = "descripcion"
        class="form-control input-sm validarmayusculas"
        rows="5" 
        cols="50"
        required = ""       
        data-aw="2"></textarea>
  </div>
</div>

