@if(!empty($listaconsolidadopedidoap))
    @include('ordenpedido.consolidadoap.ajax.listaconsolidadopedidoaprueba')
@else
    <div class="alert alert-info text-center">
        No se encontraron consolidados pendientes para el periodo seleccionado.
    </div>
@endif

<div class="hidden-aprobados-ajax" style="display: none;">
    @include('ordenpedido.consolidadoap.ajax.listaconsolidadosaprobados_ajax')
</div>
