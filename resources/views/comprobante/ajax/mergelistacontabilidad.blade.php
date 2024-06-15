@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistacontabilidad')
@else
  @include('comprobante.ajax.alistacontabilidadcontrato')
@endif