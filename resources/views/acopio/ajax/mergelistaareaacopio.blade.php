@if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
  @include('acopio.ajax.alistaliquidacioncompraanticipoareaacopio')
@else
  @include('acopio.ajax.alistaestibaareaacopio')
@endif
