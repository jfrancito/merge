@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistatesoreria')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratotesoreria')
  @else
    @include('comprobante.ajax.alistaestibatesoreria')
  @endif
@endif