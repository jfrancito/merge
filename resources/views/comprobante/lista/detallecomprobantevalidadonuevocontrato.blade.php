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
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.contrato.archivosobservados')
  </div>
</div>