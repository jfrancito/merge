@if(Session::get('usuario')->rol_id != '1CIX00000024')


  <div class="row">
    <div class="col-md-12">
      <div class="panel panel-contrast">
        <div class="panel-heading panel-heading-contrast"><b>DOCUMENTOS</b></div>
        <div class="panel-body">

            <div class="col-sm-4">
              <div class="panel panel-default panel-table">
                <div class="panel-heading"><b>ORDENES DE COMPRA POR INTEGRAR</b>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th>USUARIO CONTACTO</th>
                        <th>CANTIDAD</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x">
                      @foreach($listaocpendientes as $index => $item)
                        <tr>
                          <td>{{$index}}</td>
                          <td class="text-center"> <span class="badge badge-success">{{count($item)}}</span></td>
                        </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
              </div>
            </div>

            <div class="col-sm-4">
              <div class="panel panel-default panel-table">
                <div class="panel-heading"><b>DOCUMENTOS POR ESTADOS</b>
                </div>
                <div class="panel-body">
                  <table class="table table-striped table-borderless">
                    <thead>
                      <tr>
                        <th>ESTADOS</th>
                        <th>CANTIDAD</th>
                      </tr>
                    </thead>
                    <tbody class="no-border-x">
                      @foreach($listadocestados as $index => $item)
                        <tr>
                          <td>{{$item->TXT_ESTADO}}</td>
                          <td class="text-center"> <span class="badge badge-success">{{$item->CANT}}</span></td>
                        </tr>
                      @endforeach

                        <tr>
                          <td>OBSERVADOS</td>
                          <td class="text-center"> <span class="badge badge-success">{{count($listaobservados)}}</span></td>
                        </tr>

                    </tbody>
                  </table>
                </div>
              </div>
            </div>


        </div>
      </div>
    </div>
  </div>



@endif