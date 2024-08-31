@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.excel.ajax.axlistaocentregable')
@else
  @include('entregadocumento.excel.ajax.axlistaocentregablecontrato')
@endif


