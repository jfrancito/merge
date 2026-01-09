@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaadministracion')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratoareaadministrador')
  @else
    @if($operacion_id == 'LIQUIDACION_COMPRA_ANTICIPO')
      @include('comprobante.ajax.alistaliquidacioncompraanticipoareaadministrador')
    @else
      @if($operacion_id == 'NOTA_CREDITO')
        @include('comprobante.ajax.alistanotacreditoareaadministrador')
      @else
        @if($operacion_id == 'NOTA_DEBITO')
          @include('comprobante.ajax.alistanotadebitoareaadministrador')
        @else

          @if($operacion_id == 'PROVISION_GASTO')
            @include('comprobante.ajax.alistapgareaadministrador')
          @else

            @if($operacion_id == 'DOCUMENTO_INTERNO_COMPRA')
              @include('comprobante.ajax.alistaestibaareaadministradordic')
            @else
              @include('comprobante.ajax.alistaestibaareaadministrador')
            @endif


          @endif


        @endif
      @endif
    @endif
  @endif
@endif