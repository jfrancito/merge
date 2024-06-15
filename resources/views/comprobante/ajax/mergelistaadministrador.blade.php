@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaoc_administrador')
@else
  @include('comprobante.ajax.alistacontratoadministrador')
@endif