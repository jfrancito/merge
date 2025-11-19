@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaoc_administrador')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratoadministrador')
  @else
    @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
      @include('comprobante.ajax.alistaliquidacioncompraanticipoadministrador')
    @else
      @if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA')
        @include('comprobante.ajax.alistaestibaadministradordocintcom')
      @else
        @include('comprobante.ajax.alistaestibaadministrador')
      @endif
    @endif
  @endif
@endif