
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.comparar')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
      @include('comprobante.form.contrato.consultaapi')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.seguimiento')
  </div> 
</div>

<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.archivosreparable')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    @include('comprobante.form.contrato.informacion')
  </div>
</div>


<div class="row xs-pt-15">
  <div class="col-xs-6">
      <div class="be-checkbox">
      </div>
  </div>
  <div class="col-xs-6">
    <p class="text-right">
      <a href="{{ url('/gestion-de-comprobantes-reparable/'.$idopcion) }}"><button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button></a>
      <button type="submit" class="btn btn-space btn-primary btnguardarcliente">Guardar</button>
    </p>
  </div>
</div>




