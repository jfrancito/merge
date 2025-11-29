@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocreparableadmin')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistaocreparablecontratoadmin')
  @else
    @include('comprobante.ajax.alistaocreparableestibaadmin')
  @endif
@endif