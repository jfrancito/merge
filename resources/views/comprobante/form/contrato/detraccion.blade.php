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
                            <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Cuenta Detracción (*):</b></label>
                            <div class="col-sm-12 abajocaja" >
                                                              <input type="text"  class="form-control control input-sm" value = '{{$fedocumento->CTA_DETRACCION}}' readonly>
                            </div>
                          </div>
                        </div>


                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                            <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Valor Detraccion (*):</b></label>
                              <div class="col-sm-12 abajocaja" >
                                  <input type="text"  class="form-control control input-sm" value = '{{$fedocumento->VALOR_DETRACCION}}' readonly>
                              </div>
                            </div>
                        </div>

           

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-3">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Monto de Detracion (*):</b></label>
                            <div class="col-sm-12 abajocaja" >
                                                              <input type="text"  class="form-control control input-sm" value = '{{$fedocumento->MONTO_DETRACCION_XML}}' readonly>
                            </div>
                          </div>
                        </div>

                        <div class="col-xs-12 col-sm-6 col-md-4 col-lg-3 cajareporte">
                            <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Pago Detraccion (*):</b></label>
                              <div class="col-sm-12 abajocaja" >
                                  <input type="text"  class="form-control control input-sm" value = '{{$fedocumento->TXT_PAGO_DETRACCION}}' readonly>
                              </div>
                            </div>
                        </div>



                    </div>


              </div>
      </div>
    </div>
  </div>
              </div>