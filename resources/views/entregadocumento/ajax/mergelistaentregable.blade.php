@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.ajax.alistaocentregable')
@else
  @include('entregadocumento.ajax.alistaocentregablecontrato')
@endif