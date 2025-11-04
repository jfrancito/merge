<div class="form-group">
  <label class="col-sm-3 control-label">TRABAJADOR:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $semanaimpulso->TXT_EMPRESA_TRABAJADOR }}">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">DOCUMENTO:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $semanaimpulso->ID_DOCUMENTO }}">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">SEMANA:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{$semanaimpulso->FECHA_INICIO}} / {{$semanaimpulso->FECHA_FIN}}">
  </div>
</div>


<div class="form-group">
  <label class="col-sm-3 control-label">Descripcion de Extorno Comprobante<span class="obligatorio">(*)</span> :</label>
  <div class="col-sm-6">
        <textarea 
        name="descripcionextorno"
        id = "descripcionextorno"
        class="form-control input-sm validarmayusculas"
        rows="5" 
        cols="50"
        required = ""       
        data-aw="2"></textarea>
  </div>
</div>



