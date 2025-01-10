@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistacontabilidad')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontabilidadcontrato')
  @else
    @include('comprobante.ajax.alistacontabilidadestiba')
  @endif
@endif