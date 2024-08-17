<input type="hidden" name="rutaorden" id='rutaorden' value = '{{$rutaorden}}'>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.comparar')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.ordencompra.sunat')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.seguimiento')
  </div> 
</div>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.archivos')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    @include('comprobante.form.contrato.informacion')
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include('comprobante.form.ordencompra.verarchivopdf')
  </div>
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
      </div>
      <div class="panel-body panel-body-contrast">

              <div class="row">
                    @if($rutaorden != '')
                      <div><b>LOS ARCHIVOS DE CONTRATOS Y GUIAS RELACIONADAS SE CARGARAN DESPUES DE GUARDAR</b></div><br>
                    @endif
                    @foreach($tarchivos_g as $index => $item) 
                      @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026')
                        @if($rutaorden != '')
                          
                        @else
                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                              <label class="col-sm-12 control-label" style="text-align: left; height: 50px;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
                                @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>)@endif </label>
                            <div class="form-group sectioncargarimagen">


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
                        @endif
                      @else
                          <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">

                              <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b> 
                                @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000005') <b>(Descargue el pdf de este enlace <a href="https://e-consultaruc.sunat.gob.pe/cl-ti-itmrconsruc/FrameCriterioBusquedaWeb.jsp" target="_blank">Sunat</a> y subalo para que pueda aprobar</b>) @else @endif </label>


                            <div class="form-group sectioncargarimagen">

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
                      @endif
                    @endforeach

                    @foreach($array_guias as $index => $item)
                      @if($item['rutaordenguia'] == '')
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                          <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>GUIA REMITENTE {{$item['NRO_SERIE']}} - {{$item['NRO_DOC']}} (PDF)</b></label>
                          <div class="form-group sectioncargarimagen">
                            
                              <div class="col-sm-12">
                                  <div class="file-loading">
                                      <input 
                                      id="file-{{$item['COD_DOCUMENTO_CTBLE']}}" 
                                      name="{{$item['COD_DOCUMENTO_CTBLE']}}[]" 
                                      class="file-es"  
                                      type="file" 
                                      multiple data-max-file-count="1"
                                      required>
                                  </div>
                              </div>
                          </div>
                        </div> 
                      @endif
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
      @if($fedocumento->COD_ESTADO != 'ETM0000000000007')
            <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
      @endif
    </p>
  </div>
</div>