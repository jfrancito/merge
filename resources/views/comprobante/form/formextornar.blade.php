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
  <label class="col-sm-3 control-label">Descripcion de Extorno<span class="obligatorio">(*)</span> :</label>
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

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="{{ url('/gestion-evaluar-requerimiento/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
    </p>
  </div>
</div>