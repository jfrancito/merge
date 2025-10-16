@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaadministracion')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratoareaadministrador')
  @else
    @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
      @include('comprobante.ajax.alistaliquidacioncompraanticipoareaadministrador')
    @else
      @include('comprobante.ajax.alistaestibaareaadministrador')
    @endif
  @endif
@endif