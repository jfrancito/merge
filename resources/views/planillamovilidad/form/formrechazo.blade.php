<div class="form-group">
  <label class="col-sm-3 control-label">Trabajador:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $firma->TXT_NOMBRE }}">
  </div>
</div>
<div class="form-group">
  <label class="col-sm-3 control-label">Codigo Orden:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $firma->ID_DOCUMENTO }}">
  </div>
</div>

<div class="form-group">
  <label class="col-sm-3 control-label">Nombre Archivo:</label>
  <div class="col-sm-6">
  <input type="text" disabled class="form-control control input-sm" value="{{ $firma->NOMBRE_ARCHIVO }}">
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

