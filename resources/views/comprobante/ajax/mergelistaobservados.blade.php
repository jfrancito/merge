@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocobservados')
@else
  @include('comprobante.ajax.alistaocobservadoscontrato')
@endif