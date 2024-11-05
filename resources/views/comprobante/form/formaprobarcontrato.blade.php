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
    @include('comprobante.form.contrato.pagobanco')
</div>

<div class="row">
    @include('comprobante.form.contrato.detraccion')
</div>


<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include('comprobante.form.ordencompra.verarchivopdf')
  </div>
</div>



<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ARCHIVOS QUE SUBIRAN AUTOMATICAMENTE
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">
                    @if($rutaorden == '')
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                <label class="col-sm-12 control-label" style="text-align: left; height: 50px;"><b>CONTRATO DE TRANS. CARGA (PDF)</b></label>
                              <div class="form-group sectioncargarimagen">
                                  <div class="col-sm-12">
                                      <div class="file-loading">
                                          <input 
                                          id="file-{{$ordencompra->COD_DOCUMENTO_CTBLE}}" 
                                          name="DCC0000000000026[]" 
                                          class="file-es"  
                                          type="file" 
                                          multiple data-max-file-count="1"
                                          required>
                                      </div>
                                  </div>
                              </div>
                            </div> 
                    @else
                      @foreach($tarchivos_g as $index => $item) 
                        @if($item->COD_CATEGORIA_DOCUMENTO == 'DCC0000000000026')
                            <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                                <label class="col-sm-12 control-label" style="text-align: left; height: 50px;"><b>{{$item->NOM_CATEGORIA_DOCUMENTO}} ({{$item->TXT_FORMATO}})</b></label>
                              <div class="form-group sectioncargarimagen">
                                  <div class="col-sm-12">
                                      <div class="file-loading">
                                          <input 
                                          id="file-{{$item->COD_ORDEN}}" 
                                          name="{{$item['COD_CATEGORIA_DOCUMENTO']}}[]" 
                                          class="file-es"  
                                          type="file" 
                                          multiple data-max-file-count="1">
                                      </div>
                                  </div>
                              </div>
                            </div> 
                        @endif
                      @endforeach
                    @endif

                    @foreach($array_guias as $index => $item)
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                          <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>GUIA REMITENTE {{$item['NRO_SERIE']}} - {{$item['NRO_DOC']}} (PDF)</b></label>
                          <div class="form-group sectioncargarimagen">
                              <div class="col-sm-12">
                                  <div class="file-loading">
                                      <input 
                                      id="file-{{$item['COD_DOCUMENTO_CTBLE']}}" 
                                      name="{{$item['COD_DOCUMENTO_CTBLE']}}[]" 
                                      class="file-ver"  
                                      type="file" 
                                      multiple data-max-file-count="1">
                                  </div>
                              </div>
                          </div>
                        </div> 
                    @endforeach

                    @foreach($array_guias_no as $index => $item)
                        <div class="col-xs-12 col-sm-4 col-md-3 col-lg-3" style="margin-top:15px;">
                          <label class="col-sm-12 control-label" style="text-align: left;height: 50px;"><b>GUIA REMITENTE {{$item['NRO_SERIE']}} - {{$item['NRO_DOC']}} (PDF)</b></label>
                          <div class="form-group sectioncargarimagen">
                              <div class="col-sm-12">
                                  <div class="file-loading">
                                      <input 
                                      id="file-{{$item['COD_DOCUMENTO_CTBLE']}}" 
                                      name="{{$item['COD_DOCUMENTO_CTBLE']}}[]" 
                                      class="file-ver"  
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


<div class="row">



  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    @include('comprobante.form.contrato.archivosobservados')
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
                </div>

<!--                 <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                      <div class="form-group">
                        <label class="col-sm-12 control-label labelleft" style="text-align: left;">Entidad Bancaria que se le va a pagar al proveedor :</label>
                        <div class="col-sm-12 abajocaja" >
                          {!! Form::select( 'entidadbanco_id', $combobancos, array(),
                                            [
                                              'class'       => 'select2 form-control control input-xs' ,
                                              'id'          => 'entidadbanco_id',
                                              'required'    => '',
                                              'data-aw'     => '1',
                                            ]) !!}
                        </div>
                      </div>
                </div> -->


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
            <button type="submit" class="btn btn-space btn-primary btnaprobarcomporbatnte">Guardar</button>
      @endif
    </p>
  </div>
</div>