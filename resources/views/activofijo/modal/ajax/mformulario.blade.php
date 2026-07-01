<form id="form-activo" method="POST">
  <input type="hidden" name="id" id="activo_id" value="">
  <div class="row" style="max-height: 65vh; overflow-y: auto; overflow-x: hidden; padding-right: 10px;">
    
    <div class="col-sm-6">
      <div class="form-group">
        <label class="control-label">Item PLE</label>
        <input type="text" name="item_ple" id="activo_item_ple" class="form-control input-sm" required>
      </div>
      <div class="form-group">
        <label class="control-label">Nombre</label>
        <input type="text" name="nombre" id="activo_nombre" class="form-control input-sm" required>
      </div>
      <div class="form-group">
        <label class="control-label">Base de Cálculo</label>
        <input type="number" step="0.01" name="base_de_calculo" id="activo_base_de_calculo" class="form-control input-sm" required>
      </div>
      <div class="form-group">
        <label class="control-label">Depreciación Acumulada</label>
        <input type="number" step="0.01" name="depreciacion_acumulada" id="activo_depreciacion_acumulada" class="form-control input-sm" value="0" required>
      </div>
    </div>
    
    <div class="col-sm-6">
      <div class="form-group">
        <label class="control-label">Tipo Activo</label>
        <select name="tipo_activo" id="activo_tipo" class="form-control input-sm" required>
          <option value="Edificaciones">Edificaciones</option>
          <option value="Terrenos">Terrenos</option>
          <option value="Muebles">Muebles</option>
          <option value="Enseres">Enseres</option>
          <option value="Unidades Transportes">Unidades Transportes</option>
          <option value="Aplicaciones Informaticas">Aplicaciones Informaticas</option>
          <option value="Equipos para Procesamiento de informacion">Equipos para Procesamiento de info.</option>
        </select>
      </div>
      <div class="form-group">
        <label class="control-label">Fecha Emisión</label>
        <input type="date" name="fecha_emision" id="activo_fecha_emision" class="form-control input-sm" required>
      </div>
      <div class="form-group">
        <label class="control-label">Inicio Depreciación</label>
        <input type="date" name="fecha_inicio_depreciacion" id="activo_fecha_inicio_depreciacion" class="form-control input-sm" required>
      </div>
      <div class="form-group">
        <label class="control-label">Última Fecha Depreciación</label>
        <input type="date" name="ultima_fecha_depreciacion" id="activo_ultima_fecha_depreciacion" class="form-control input-sm" required>
      </div>
    </div>

  </div>
</form>
