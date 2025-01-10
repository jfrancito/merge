@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaadministracion')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratoareaadministrador')
  @else
    @include('comprobante.ajax.alistaestibaareaadministrador')
  @endif
@endif