<div class="table-responsive mt-4">
    <table id="{{ $id_tabla ?? 'tablaConsolidado' }}" 
    class="table table-striped table-bordered table-hover td-color-borde td-padding-7 display nowrap"
           cellspacing="0" width="100%">
        <thead class="background-th-azul">
            <tr>
                <th>COD PRODUCTO</th>
                <th>PRODUCTO</th>
                <th>UNIDA MEDIDA</th>
                <th>CANTIDAD</th>
                <th>STOCK</th>
                <th>RESERVADO</th>
                <th>DIFERENCIA</th>
                <th>FAMILIA</th>
            </tr>
        </thead>
        <tbody id="{{ $id_body ?? 'bodyConsolidado' }}" style="cursor: pointer;"></tbody>
    </table>
</div>