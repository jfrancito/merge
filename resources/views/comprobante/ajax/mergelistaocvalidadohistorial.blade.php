@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocvalidado')
@else
  @include('comprobante.ajax.alistaocvalidadocontrato')
@endif