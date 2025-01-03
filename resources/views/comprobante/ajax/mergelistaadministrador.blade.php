@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaoc_administrador')
@else
  @if($operacion_id == 'CONTRATO')
    @include('comprobante.ajax.alistacontratoadministrador')
  @else
    @include('comprobante.ajax.alistaestibaadministrador')
  @endif
@endif