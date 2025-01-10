@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocreparable')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistaocreparablecontrato')
  @else
    @include('comprobante.ajax.alistaocreparableestiba')
  @endif
@endif