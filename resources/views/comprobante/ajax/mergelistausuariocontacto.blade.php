@if($operacion_id == 'ORDEN_COMPRA')
  @include('comprobante.ajax.alistausuariocontacto')
@else
  @include('comprobante.ajax.alistausuariocontactocontrato')
@endif