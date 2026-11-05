@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistaocvalidadohistorial')
@else
  @include('comprobante.ajax.alistaocvalidadocontratohistorial')
@endif