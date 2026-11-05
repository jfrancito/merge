<table id="tabla-consolidado-aprueba" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap">
  <thead class="background-th-azul">
    <tr>
      <th>ID CONSOLIDADO</th>
      <th>EMPRESA</th>
      <th>CENTRO</th>
      <th>FEC PEDIDO</th>
      <th>PERIODO</th>
      <th>FAMILIA</th>
      <th>ESTADO</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listaconsolidadopedidoap as $id => $detalles)
        @php 
            $item = $detalles->first(); 
            // Obtener familias únicas para este consolidado
            $familias = $detalles->unique('COD_CATEGORIA_FAMILIA')->pluck('NOM_CATEGORIA_FAMILIA')->implode(', ');
        @endphp
        <tr class="fila-consolidado-ap" data-id="{{$item->ID_PEDIDO_CONSOLIDADO}}" style="cursor: pointer;">
            <td>{{$item->ID_PEDIDO_CONSOLIDADO}}</td>
            <td>{{$item->NOM_EMPR}}</td>
            <td>{{$item->NOM_CENTRO}}</td>
            <td>{{date('d-m-Y', strtotime($item->FEC_PEDIDO))}}</td>
            <td>{{$item->TXT_NOMBRE}}</td>
            <td>{{$familias}}</td>
            <td>
                <span class="label label-warning" style="background-color: #f39c12;">
                    {{$item->TXT_ESTADO}}
                </span>
            </td>
        </tr>
    @endforeach
  </tbody>
</table>

@if(isset($ajax))
<script type="text/javascript">
  $(document).ready(function(){
     App.dataTables();
  });
</script>
@endif
