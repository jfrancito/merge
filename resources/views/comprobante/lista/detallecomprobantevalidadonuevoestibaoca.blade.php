
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