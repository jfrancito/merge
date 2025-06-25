@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocvalidado')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistaocvalidadocontrato')
  @else
    @if($operacion_id == 'COMISION')
      @include('comprobante.ajax.alistaocvalidadocomision')
    @else
      @include('comprobante.ajax.alistaocvalidadoestiba')
    @endif
  @endif
@endif