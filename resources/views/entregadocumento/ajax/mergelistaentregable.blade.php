@if($operacion_id == 'ORDEN_COMPRA')
  @include('entregadocumento.ajax.alistaocentregable')
@else
  @if($operacion_id == 'CONTRATO')
    @include('entregadocumento.ajax.alistaocentregablecontrato')
  @else

      @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
        @include('entregadocumento.ajax.alistaocentregablelqa')
      @else
        @include('entregadocumento.ajax.alistaocentregableestiba')
      @endif

    
  @endif
@endif