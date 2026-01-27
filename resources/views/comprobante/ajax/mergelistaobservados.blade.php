@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocobservados')
@else

  @if($operacion_id == 'ORDEN_COMPRA_ANTICIPO')
    @include('comprobante.ajax.alistaococaobservados')
  @else


      @if($operacion_id == 'CONTRATO')
        @include('comprobante.ajax.alistaocobservadoscontrato')
      @else
        @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
          @include('comprobante.ajax.alistaocobservadosliquidacioncompraanticipo')
        @else
          @if($operacion_id == 'NOTA_CREDITO')
            @include('comprobante.ajax.alistaocobservadosnotacredito')
          @else
            @if($operacion_id == 'NOTA_DEBITO')
              @include('comprobante.ajax.alistaocobservadosnotadebito')
            @else
              @if($operacion_id == 'PROVISION_GASTO')
                @include('comprobante.ajax.alistaocobservadospg')
              @else
                @include('comprobante.ajax.alistaocobservadosestiba')
              @endif
            @endif
          @endif
        @endif
      @endif
  @endif

@endif