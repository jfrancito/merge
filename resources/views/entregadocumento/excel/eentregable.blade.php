@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.excel.ajax.axlistaocentregable')
@else
  @if($operacion_id == 'CONTRATO')
    @include('entregadocumento.excel.ajax.axlistaocentregablecontrato')
  @else
    @include('entregadocumento.excel.ajax.axlistaocentregableestiba')
  @endif


@endif


