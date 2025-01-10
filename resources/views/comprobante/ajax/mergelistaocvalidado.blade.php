@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocvalidado')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistaocvalidadocontrato')
  @else
    @include('comprobante.ajax.alistaocvalidadoestiba')
  @endif
@endif