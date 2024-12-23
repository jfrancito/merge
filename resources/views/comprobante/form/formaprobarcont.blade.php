<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.comparar')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @if($fedocumento->OPERACION_DET != 'SIN_XML') @include('comprobante.form.ordencompra.sunat') @endif 
    @include('comprobante.form.ordencompra.infodetraccion')
    @include('comprobante.form.ordencompra.ordeningreso')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.seguimiento')
  </div> 
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.archivos')
  </div>

  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    @include('comprobante.form.ordencompra.informacion')
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include('comprobante.form.ordencompra.verarchivopdf')
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.archivosobservados')
  </div>
</div>
<div class="row">
  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                  <div class="form-group sectioncargarimagen">
                      <label class="col-sm-12 control-label" style="text-align: left;"><b>OTROS DOCUMENTOS</b> <br><br></label>
                      <div class="col-sm-12">
                          <div class="file-loading">
                              <input 
                              id="file-otros" 
                              name="otros[]" 
                              class="file-es"  
                              type="file" 
                              multiple data-max-file-count="1"
                              >
                          </div>
                      </div>
                  </div>
                </div>
              </div>
      </div>
    </div>
  </div>



  <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">RECOMENDACION
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">


                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

                  <div class="form-group sectioncargarimagen">
                      <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA RECOMENDCION</b> <br><br></label>
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
