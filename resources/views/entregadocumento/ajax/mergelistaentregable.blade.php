@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.ajax.alistaocentregable')
@else
  @if($operacion_id == 'CONTRATO')
    @include('entregadocumento.ajax.alistaocentregablecontrato')
  @else
    @include('entregadocumento.ajax.alistaocentregableestiba')
  @endif
@endif