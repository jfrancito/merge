<table id="importegastos" class="table table-bordered td-color-borde td-padding-7 display nowrap"
       cellspacing="0" width="100%" style="font-style: italic;">
  <thead>
    <tr>
      <th rowspan="2" style="text-align: center;">ID</th>
      <th rowspan="2" style="text-align: center;">Centro</th>
      <th rowspan="2" style="text-align: center;">Departamento</th>
      <th rowspan="2" style="text-align: center;">Provincia</th>
      <th rowspan="2" style="text-align: center;">Distrito</th>
      <th colspan="3" style="text-align: center;">Importe - Línea</th> <!-- encabezado agrupado -->
      <th rowspan="2" style="text-align: center;">Tipo</th>
      <th rowspan="2" style="text-align: center;">Indicador<br>(Ruta corta)</th>
      <th rowspan="2" style="text-align: center;">Eliminar</th>
    </tr>
    <tr>
      <th style="text-align: center;">Gerente</th>
      <th style="text-align: center;">Jefe</th>
      <th style="text-align: center;">Demás Lineas</th>
    </tr>
  </thead>

  <tbody>
    @foreach($listarimportegastos as $index => $item)
      <tr style="cursor:pointer;"
          data_importe_gastos="{{ $item['ID'] }}"
          data-id-gerente="{{ $item['ID_GERENTE'] ?? '' }}"
          data-id-jefe="{{ $item['ID_JEFE'] ?? '' }}"
          data-id-demas="{{ $item['ID_DEMAS'] ?? '' }}">
          
        <td>{{ $item['ID'] }}</td>
        <td>{{ $item['NOM_CENTRO'] }}</td>
        <td>{{ $item['NOM_DEPARTAMENTO'] }}</td>
        <td>{{ $item['NOM_PROVINCIA'] }}</td>
        <td>{{ $item['NOM_DISTRITO'] }}</td>

        <td class="text-center">
          @if(isset($item['IMP_GERENTE']))
            S/. {{ number_format($item['IMP_GERENTE'], 2) }}
          @endif
        </td>
        <td class="text-center">
          @if(isset($item['IMP_JEFE']))
            S/. {{ number_format($item['IMP_JEFE'], 2) }}
          @endif
        </td>
        <td class="text-center">
          @if(isset($item['IMP_DEMAS']))
            S/. {{ number_format($item['IMP_DEMAS'], 2) }}
          @endif
        </td>

        <td>{{ $item['TIPO'] }}</td>
        <td>{{ $item['IND_DESTINO'] == 1 ? 'Sí' : 'No' }}</td>
        <td class="text-center align-middle">
          <button class="btn-rojo delete-registroimportegastos">
            <i class="icon mdi mdi-delete"></i>
          </button>
        </td>
      </tr>
    @endforeach
  </tbody>

</table>


<style>
thead th {
  background: #1d3a6d;
  color: white;
  text-align: center;
  vertical-align: middle;
}

.btn-rojo {
  background-color: #d9534f;
  color: white;
  border: none;
  padding: 6px 10px;
  border-radius: 4px;
}

.btn-rojo:hover {
  background-color: #c9302c;
}

.selected {
  background-color: #7d9ac0 !important;
  color: #FFFFFF;
}

thead th:last-child,
thead th[colspan] + th {
  border-right: 1px solid #dee2e6 !important;
}
thead tr:first-child th[colspan] {
  border-bottom: none !important;
}
</style>

<script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
</script>