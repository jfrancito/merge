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
                    <th class="text-center" width="120">PRECIO IGV</th>
                    <th>FAMILIA</th>
                </tr>
            </thead>
            <tbody>
                @foreach($lista_detalle as $index => $item)
                @php
                    $id_pedido_consolidado = $item->ID_PEDIDO_CONSOLIDADO_GENERAL ?? ($item->ID_PEDIDO_CONSOLIDADO_GENERAL_DETALLE ?? '');
                    $cod_producto = $item->COD_PRODUCTO;
                    $nom_producto = $item->NOM_PRODUCTO;
                    $nom_medida = $item->NOM_CATEGORIA_MEDIDA;
                    $cod_medida = $item->COD_CATEGORIA_MEDIDA;
                    $cantidad = $item->CANTIDAD ?? ($item->CAN_COTIZACION ?? 0);
                    $precio = $item->CAN_PRECIO ?? ($item->CAN_PRECIO_UNITARIO ?? 0);
                    $precio_igv = $item->CAN_PRECIO_IGV ?? 0;
                    $cod_familia = $item->COD_CATEGORIA_FAMILIA;
                    $nom_familia = $item->NOM_CATEGORIA_FAMILIA;
                @endphp
                <tr>
                    <td class="text-center">
                        <div class="be-checkbox be-checkbox-sm inline">
                            <input class="check-producto" type="checkbox" id="check-{{ $cod_producto }}-{{ $index }}">
                            <label for="check-{{ $cod_producto }}-{{ $index }}"></label>
                        </div>
                    </td>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td class="font-bold">{{ $id_pedido_consolidado }}</td>
                    <td class="text-primary">{{ $cod_producto }}</td>
                    <td>{{ $nom_producto }}</td>
                    <td class="text-center">{{ $nom_medida }}</td>
                    <td class="text-center">
                        <input type="number" 
                               class="form-control input-sm text-center cantidad-producto premium-input" 
                               value="{{ number_format($cantidad, 2, '.', '') }}" 
                               step="0.01" 
                               min="0.01"
                               style="height: 32px !important; font-weight: 700; color: #1d3a6d; width: 100px; margin: 0 auto;">
                    </td>
                    <td class="text-center">
                        <div class="input-group" style="width: 110px; margin: 0 auto;">
                            <span class="input-group-addon moneda-simbolo" style="padding: 4px 8px; font-size: 12px;">S/</span>
                            <input type="number" 
                                   class="form-control input-sm text-right precio-producto premium-input" 
                                   value="{{ number_format($precio, 2, '.', '') }}" 
                                   step="0.01" 
                                   min="0"
                                   style="height: 32px !important; font-weight: 700;"
                                   data-cantidad="{{ $cantidad }}"
                                   data-id-consolidado="{{ $id_pedido_consolidado }}"
                                   data-cod-producto="{{ $cod_producto }}"
                                   data-nom-producto="{{ $nom_producto }}"
                                   data-cod-medida="{{ $cod_medida }}"
                                   data-nom-medida="{{ $nom_medida }}"
                                   data-cod-familia="{{ $cod_familia }}"
                                   data-nom-familia="{{ $nom_familia }}">
                        </div>
                    </td>
                    <td class="text-center">
                        <div class="input-group" style="width: 110px; margin: 0 auto;">
                            <span class="input-group-addon moneda-simbolo" style="padding: 4px 8px; font-size: 12px;">S/</span>
                            <input type="number" 
                                   class="form-control input-sm text-right precio-igv-producto premium-input" 
                                   value="{{ number_format($precio_igv, 2, '.', '') }}" 
                                   step="0.01" 
                                   min="0"
                                   style="height: 32px !important; font-weight: 700; color: #1d3a6d;">
                        </div>
                    </td>
                    <td>{{ $nom_familia }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
<!-- Cerca del botón de SUBIR ARCHIVO en ajax/listaproductoscotizacion.blade.php -->
<input type="file" class="input-file-general-cotizacion" accept=".pdf" style="display: none;">

        <!-- Se eliminó el botón de subir aquí para usar la sección general de la cabecera -->
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
