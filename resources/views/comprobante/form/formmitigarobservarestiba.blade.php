<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.estiba.comparar')
  </div>
  @IF($fedocumento->OPERACION != 'DOCUMENTO_INTERNO_COMPRA')
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      @include('comprobante.form.contrato.consultaapi')
  </div>
  @ENDIF
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.seguimiento')
  </div> 
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.estiba.archivos')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    @include('comprobante.form.estiba.informacion')
  </div>
</div>

@IF($fedocumento->OPERACION != 'DOCUMENTO_INTERNO_COMPRA')
  <div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
      <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
          <div><h4>DETRACION DE LA FACTURACION : {{$fedocumento->TOTAL_VENTA_ORIG}} x 4% = {{$fedocumento->TOTAL_VENTA_ORIG * 0.04}}</h4> </div>
          <div><h6>* Solo llenar para montos mayores a 401</h6> </div>
        </div>
        <div class="panel-body panel-body-contrast">
                <div class="row">

                      <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">


                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Cuenta Detracción (*): solo numero</b></label>
                              <div class="col-sm-12 abajocaja" >
                                  <input type="text" name="ctadetraccion" id='ctadetraccion' class="form-control control input-sm cuentanumero" value = '{{$empresa->TXT_DETRACCION}}'>
                              </div>
                            </div>
                          </div>


                          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Valor Detraccion (*):</b></label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'tipo_detraccion_id', $combotipodetraccion, array($fedocumento->VALOR_DETRACCION),
                                                    [
                                                      'class'       => 'select2 form-control control input-xs' ,
                                                      'id'          => 'tipo_detraccion_id',
                                                      'data-aw'     => '1',
                                                    ]) !!}
                                </div>
                              </div>
                          </div>

                          <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                            <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Monto de Detracion (*):</b></label>
                              <div class="col-sm-12 abajocaja" >
                                  <input type="text" name="monto_detraccion" id='monto_detraccion' class="form-control control input-sm importe" value = '{{$fedocumento->MONTO_DETRACCION}}'>
                              </div>
                            </div>
                          </div>

                          <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                              <div class="form-group">
                                <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Pago Detraccion (*):</b></label>
                                <div class="col-sm-12 abajocaja" >
                                  {!! Form::select( 'pago_detraccion', $combopagodetraccion, array($fedocumento->COD_PAGO_DETRACCION),
                                                    [
                                                      'class'       => 'select2 form-control control input-xs' ,
                                                      'id'          => 'pago_detraccion',
                                                      'data-aw'     => '1',
                                                    ]) !!}
                                </div>
                              </div>
                          </div>



                      </div>


                </div>
        </div>
      </div>
    </div>
  </div>
@ENDIF

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

