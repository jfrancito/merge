@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.excel.ajax.axlistaocentregable')
@else
  @if($operacion_id == 'CONTRATO')
    @include('entregadocumento.excel.ajax.axlistaocentregablecontrato')
  @else

    @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
      @include('entregadocumento.excel.ajax.axlistaocentregablelca')
    @else
      @include('entregadocumento.excel.ajax.axlistaocentregable')
    @endif

  @endif
@endif


