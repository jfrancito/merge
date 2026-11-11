<div class="form-group">
  <label class="col-sm-3 control-label">PROVEEDOR:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $cuartacategoria->RAZON_SOCIAL }}">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Codigo Registro:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $cuartacategoria->ID_DOCUMENTO }}">
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



