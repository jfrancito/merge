<div class="panel panel-default box-seccion shadow-soft">
    <div class="panel-heading subheader-seccion">
        <i class="mdi mdi-format-list-bulleted"></i> Productos de Consolidados Seleccionados
        <div class="pull-right" style="margin-top: -5px;">
             <button class="btn btn-danger btn-sm btn-eliminar-seleccionados shadow-soft" title="Eliminar seleccionados">
                <i class="mdi mdi-delete"></i> Eliminar Productos
            </button>
        </div>
    </div>
    <div class="panel-body">
        <table id="table-productos-seleccionados" class="table table-striped table-hover table-fw-widget listatabla">
            <thead>
                <tr>
                    <th class="text-center" width="30">
                        <div class="be-checkbox be-checkbox-sm inline">
                            <input id="check-all-productos" type="checkbox" class="check-todos-productos">
                            <label for="check-all-productos"></label>
                        </div>
                    </th>
                    <th class="text-center" width="50">ITEM</th>
                    <th>ID CONSOLIDADO</th>
                    <th>CÓDIGO</th>
                    <th>PRODUCTO</th>
                    <th class="text-center">U.M.</th>
                    <th class="text-center">CANTIDAD</th>
                    <th class="text-center" width="120">PRECIO</th>
                    <th>FAMILIA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lista_detalle as $index => $item)
                <tr>
                    <td class="text-center">
                        <div class="be-checkbox be-checkbox-sm inline">
                            <input class="check-producto" type="checkbox" id="check-{{ $item->COD_PRODUCTO }}-{{ $index }}">
                            <label for="check-{{ $item->COD_PRODUCTO }}-{{ $index }}"></label>
                        </div>
                    </td>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $item->ID_PEDIDO_CONSOLIDADO_GENERAL }}</td>
                    <td class="text-primary">{{ $item->COD_PRODUCTO }}</td>
                    <td>{{ $item->NOM_PRODUCTO }}</td>
                    <td class="text-center">{{ $item->NOM_CATEGORIA_MEDIDA }}</td>
                    <td class="text-center font-bold" style="font-size: 15px; color: #1d3a6d;">{{ number_format($item->CANTIDAD, 2) }}</td>
                    <td class="text-center">
                        <div class="input-group" style="width: 110px; margin: 0 auto;">
                            <span class="input-group-addon moneda-simbolo" style="padding: 4px 8px; font-size: 12px;">S/</span>
                            <input type="number" 
                                   class="form-control input-sm text-right precio-producto premium-input" 
                                   value="0.00" 
                                   step="0.01" 
                                   min="0"
                                   style="height: 32px !important; font-weight: 700;"
                                   data-cantidad="{{ $item->CANTIDAD }}"
                                   data-id-consolidado="{{ $item->ID_PEDIDO_CONSOLIDADO_GENERAL }}"
                                   data-cod-producto="{{ $item->COD_PRODUCTO }}"
                                   data-nom-producto="{{ $item->NOM_PRODUCTO }}"
                                   data-cod-medida="{{ $item->COD_CATEGORIA_MEDIDA }}"
                                   data-nom-medida="{{ $item->NOM_CATEGORIA_MEDIDA }}"
                                   data-cod-familia="{{ $item->COD_CATEGORIA_FAMILIA }}"
                                   data-nom-familia="{{ $item->NOM_CATEGORIA_FAMILIA }}">
                        </div>
                    </td>
                    <td>{{ $item->NOM_CATEGORIA_FAMILIA }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="row" style="margin-top: 20px;">
            <div class="col-md-12 text-left">
                <button type="button" class="btn btn-primary btn-subir-archivo shadow-soft" style="margin-left: 10px;">
                    <i class="mdi mdi-upload" style="font-size: 16px; vertical-align: middle; margin-right: 5px;"></i> SUBIR ARCHIVO
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#table-productos-seleccionados').DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "No hay datos disponibles",
                "info": "Mostrando _START_ a _END_ de _TOTAL_ entradas",
                "infoEmpty": "Mostrando 0 a 0 de 0 entradas",
                "infoFiltered": "(filtrado de _MAX_ entradas totales)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Mostrar _MENU_ entradas",
                "loadingRecords": "Cargando...",
                "processing": "Procesando...",
                "search": "Buscar:",
                "zeroRecords": "No se encontraron registros coincidentes",
                "paginate": {
                    "first": "Primero",
                    "last": "Último",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
                "aria": {
                    "sortAscending": ": activar para ordenar la columna ascendente",
                    "sortDescending": ": activar para ordenar la columna descendente"
                }
            },
            "pageLength": 25,
            "order": [[ 1, "asc" ]]
        });
    });
</script>
