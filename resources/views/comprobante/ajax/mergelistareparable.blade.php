@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocreparable')
@else
  @include('comprobante.ajax.alistaocreparablecontrato')
@endif