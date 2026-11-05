<table id="tabla-consolidados-aprobados" class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap">
  <thead class="background-th-azul">
    <tr>
      <th class="text-center" style="width: 40px;">
          <input type="checkbox" id="check-all-consolidados">
      </th>
      <th class="text-center">ID CONSOLIDADO</th>
      <th>EMPRESA</th>
      <th>CENTRO</th>
      <th class="text-center">FEC PEDIDO</th>
      <th class="text-center">PERIODO</th>
      <th>FAMILIA</th>
      <th class="text-center">ESTADO</th>
      <th class="text-center">ACCIONES</th>
    </tr>
  </thead>
  <tbody>
    @foreach($lista_aprobados as $id => $detalles)
        @php 
            $item = $detalles->first(); 
            $familias = $detalles->unique('COD_CATEGORIA_FAMILIA')->pluck('NOM_CATEGORIA_FAMILIA')->implode(', ');
        @endphp
        <tr class="fila-consolidado-ap-aprobado" data-id="{{$item->ID_PEDIDO_CONSOLIDADO}}" style="cursor: pointer;">
            <td class="text-center" onclick="event.stopPropagation();">
                <input type="checkbox" class="chk-consolidado" value="{{$item->ID_PEDIDO_CONSOLIDADO}}" data-centro="{{$item->NOM_CENTRO}}" data-familia="{{$familias}}">
            </td>
            <td class="text-center">{{$item->ID_PEDIDO_CONSOLIDADO}}</td>
            <td>{{$item->NOM_EMPR}}</td>
            <td>{{$item->NOM_CENTRO}}</td>
            <td class="text-center">{{date('d-m-Y', strtotime($item->FEC_PEDIDO))}}</td>
            <td class="text-center">{{$item->TXT_NOMBRE}}</td>
            <td>{{$familias}}</td>
            <td class="text-center">
                <span class="label label-success" style="background-color: #27ae60;">
                    {{$item->TXT_ESTADO}}
                </span>
            </td>
            <td class="text-center">
                <a href="{{ url('/exportar-excel-consolidado/'.$item->ID_PEDIDO_CONSOLIDADO) }}" 
                   class="btn btn-sm btn-success" 
                   title="Exportar Excel"
                   style="border-radius: 4px; padding: 4px 8px;">
                    <i class="mdi mdi-file-excel"></i> Excel
                </a>
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
