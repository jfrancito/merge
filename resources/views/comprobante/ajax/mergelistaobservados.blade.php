@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocobservados')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistaocobservadoscontrato')
  @else
    @include('comprobante.ajax.alistaocobservadosestiba')
  @endif
@endif