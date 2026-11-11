<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">DATOS PARA PAGOS
      </div>
      <div class="panel-body panel-body-contrast">
              <div class="row">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte">
                            <div class="form-group">
                              <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Entidad Bancaria que se le va a pagar al proveedor :</b></label>
                              <div class="col-sm-12 abajocaja" >
                                <input type="text"  class="form-control control input-sm" value = '{{$fedocumento->TXT_CATEGORIA_BANCO}}' readonly>
                              </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 cajareporte ajax_cb">
                          <div class="form-group">
                            <label class="col-sm-12 control-label labelleft" style="text-align: left;"><b>Cuenta Bancaria que se le va a pagar al proveedor :</b></label>
                            <div class="col-sm-12 abajocaja" >
                              <input type="text"  class="form-control control input-sm" value = '{{$fedocumento->TXT_NRO_CUENTA_BANCARIA}}' readonly>
                            </div>
                          </div>
                        </div>
                    </div>


              </div>
      </div>
    </div>
  </div>
</div>