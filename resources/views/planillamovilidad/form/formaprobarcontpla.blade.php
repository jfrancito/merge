<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('planillamovilidad.form.planillamovilidad.cabecera')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('planillamovilidad.form.planillamovilidad.seguimiento')
  </div>
</div>
<div class="row">
  <div class="col-xs-12">
    @include('planillamovilidad.form.planillamovilidad.verpdfmultiple')
  </div>

</div>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ACOTACION
      </div>
      <div class="panel-body panel-body-contrast">
          <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

              <div class="form-group sectioncargarimagen">
                  <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA ACOTACION</b> <br><br></label>
                  <div class="col-sm-12">
                      <textarea 
                      name="descripcion"
                      id = "descripcion"
                      class="form-control input-sm validarmayusculas"
                      rows="12" 
                      cols="200"    
                      data-aw="2"></textarea>
                  </div>
              </div>



              <div class="form-group">
                <label class="col-sm-12 control-label izquierda" style="text-align: left;">Cuenta Contable <b>(*)</b></label>
                <div class="col-sm-12">
                    <input  type="text"
                            id="nro_cuenta_contable" 
                            name='nro_cuenta_contable' 
                            value=""
                            placeholder="Cuenta Contable"
                            required = ""
                            data-parsley-type="number"
                            data-parsley-length="[6, 6]" 
                            data-parsley-length-message="El código debe tener exactamente 6 caracteres."
                            autocomplete="off" class="form-control dinero input-sm"/>

                </div>
              </div>
              
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
