@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistatesoreriapagado')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratotesoreriapagado')
  @else
    @include('comprobante.ajax.alistacomisiontesoreriapagado')
  @endif
@endif