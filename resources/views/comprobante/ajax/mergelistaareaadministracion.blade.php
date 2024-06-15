@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaadministracion')
@else
  @include('comprobante.ajax.alistacontratoareaadministrador')
@endif