@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocvalidado')
@else
  @if($operacion_id == 'ORDEN_COMPRA_ANTICIPO')
    @include('comprobante.ajax.alistaocvalidadoestibaoca')
  @else

      @if($operacion_id == 'CONTRATO')
        @include('comprobante.ajax.alistaocvalidadocontrato')
      @else
        @if($operacion_id == 'COMISION')
          @include('comprobante.ajax.alistaocvalidadocomision')
        @else
          @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
            @include('comprobante.ajax.alistaocvalidadoliquidacioncompraanticipo')
          @else
            @if($operacion_id == 'NOTA_CREDITO')
              @include('comprobante.ajax.alistaocvalidadonotacredito')
            @else
              @if($operacion_id == 'NOTA_DEBITO')
                @include('comprobante.ajax.alistaocvalidadonotadebito')
              @else
                @if($operacion_id == 'PROVISION_GASTO')
                  @include('comprobante.ajax.alistaocvalidadopg')
                @else

                  @if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA')
                    @include('comprobante.ajax.alistaocvalidadoestibadic')
                  @else
                    @include('comprobante.ajax.alistaocvalidadoestiba')
                  @endif

                @endif
              @endif
            @endif
          @endif
        @endif
      @endif
  @endif

@endif