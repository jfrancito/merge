@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistacontabilidad')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontabilidadcontrato')
  @else
    @if($operacion_id == 'NOTA_CREDITO')
      @include('comprobante.ajax.alistacontabilidadnotacredito')
    @else
      @if($operacion_id == 'NOTA_DEBITO')
        @include('comprobante.ajax.alistacontabilidadnotadebito')
      @else

        @if($operacion_id == 'PROVISION_GASTO')
          @include('comprobante.ajax.alistacontabilidadpg')
        @else
          @include('comprobante.ajax.alistacontabilidadestiba')
        @endif

      @endif
    @endif
  @endif
@endif