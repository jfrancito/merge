<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @if($fedocumento->OPERACION_DET == 'SIN_XML') @include('comprobante.form.ordencompra.compararanticiposxml') @endif    
    @if($fedocumento->OPERACION_DET != 'SIN_XML') @include('comprobante.form.ordencompra.compararanticipo') @endif 
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @if($fedocumento->OPERACION_DET == 'SIN_XML') @include('comprobante.form.ordencompra.datosfactura') @endif    
    @if($fedocumento->OPERACION_DET != 'SIN_XML') @include('comprobante.form.ordencompra.sunat') @endif 
    @include('comprobante.form.ordencompra.infodetraccion')
    @include('comprobante.form.ordencompra.ordeningreso')
    @include('comprobante.form.ordencompra.ordensalida')


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
    @include('comprobante.form.ordencompra.verarchivopdfmultiple')
  </div>
</div>



<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.archivosobservados')
  </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                @foreach($tarchivos as $index => $item)  
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="form-group sectioncargarimagen">
                        <label class="col-sm-12 control-label" style="text-align: left;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
                          @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else <br><br> @endif
                        </label>
                        <div class="col-sm-12">
                            <div class="file-loading">
                                <input 
                                id="file-{{$item->COD_CATEGORIA_DOCUMENTO}}" 
                                name="{{$item->COD_CATEGORIA_DOCUMENTO}}[]" 
                                class="file-es"  
                                type="file" 
                                multiple data-max-file-count="1"
                                required>
                            </div>
                        </div>
                    </div>
                  </div>
                @endforeach
              </div>
      </div>
    </div>
  </div>
</div>

<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">

      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="{{ url('/gestion-de-comprobante-us/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
    </p>
  </div>
</div>

