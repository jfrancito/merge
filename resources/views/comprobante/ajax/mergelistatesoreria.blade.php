@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistatesoreria')
@else
  @include('comprobante.ajax.alistacontratotesoreria')
@endif