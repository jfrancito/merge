@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistatesoreriapagado')
@else
  @include('comprobante.ajax.alistacontratotesoreriapagado')
@endif