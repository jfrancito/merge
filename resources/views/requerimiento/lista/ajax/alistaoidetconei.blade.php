<div class="col-sm-12">
  <div class="panel panel-default panel-table">
    <div class="panel-heading">Otros integrantes <small class="opcional">(**) Opcional</small>
    </div>
    <div class="panel-body">
      <table class="table table-striped table-borderless">
        <thead>
          <tr>
            <th>Fila</th>
            <th>Tipo documento</th>
            <th>Documento</th>
            <th>Nombre</th>
            <th>Cargo</th>
          </tr>
        </thead>
        <tbody class="no-border-x">
          @foreach($listaoic as $index => $item)
            <tr>
              <td>{{$index}}</td>
              <td>{{$item->tipo_documento_nombre}}</td>
              <td>{{$item->documento}}</td>
              <td>{{$item->nombres}}</td>
              <td>{{$item->cargo}}</td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
