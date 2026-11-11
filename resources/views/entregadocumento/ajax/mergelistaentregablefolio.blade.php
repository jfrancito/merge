@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.ajax.alistaocentregablefolio')
@else
  @include('entregadocumento.ajax.alistaocentregablecontratofolio')
@endif