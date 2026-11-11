<div class="col-md-12">
  <div class="panel panel-contrast">
    <!-- <div class="panel-heading panel-heading-contrast"><b>CONTRATO</b></div> -->
    <div class="panel-body">
    <div class="row">
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">PENDIENTES
            <span class="panel-subtitle" style="color: #fff;">Documentos por aprobar</span>
            <div class="chart-legend">
              <a href="{{ url($urlcontrato) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Aprobar</a>
            </div>
            <span class="count-das">{{$count_x_aprobar_con}}</span>
          </div>
        </div>
      </div>

      @if($trol->ind_uc == 1)
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">INTEGRACION
            <span class="panel-subtitle" style="color: #fff;">Documentos por integrar</span>
            <div class="chart-legend">
              <a href="{{ url($url_gestion) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir a Integrar</a>
            </div>
            <span class="count-das">{{$count_x_aprobar_gestion_con}}</span>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVADOS
            <span class="panel-subtitle" style="color: #fff;">Documentos observados</span>
            <div class="chart-legend">
              <a href="{{ url($url_obs) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
            </div>
            <span class="count-das">{{$count_observados_con}}</span>
          </div>
        </div>
      </div>

        <div class="col-xs-12 col-md-4">
          <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">REPARABLE
              <span class="panel-subtitle" style="color: #fff;">Documentos reparables</span>
              <div class="chart-legend">
                <a href="{{ url($url_rep) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Reparable</a>
              </div>
              <span class="count-das">{{$count_reparables_con}}</span>
            </div>
          </div>
        </div>


      @endif

      @if($trol->ind_uc != 1)


      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">REPARABLE
            <span class="panel-subtitle" style="color: #fff;">Documentos reparables</span>
            <div class="chart-legend">
              <a href="{{ url($url_rep_contrato) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Reparable</a>
            </div>
            <span class="count-das">{{$count_reparables_con}}</span>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">REVISAR REPARABLE
            <span class="panel-subtitle" style="color: #fff;">Documentos reparables</span>
            <div class="chart-legend">
              <a href="{{ url($url_rep_contrato_revisar) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Reparable</a>
            </div>
            <span class="count-das">{{$count_reparables__revcon}}</span>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVADOS
            <span class="panel-subtitle" style="color: #fff;">Documentos observados</span>
            <div class="chart-legend">
              <a href="{{ url($urlcontrato.'&tab_id=observado') }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
            </div>
            <span class="count-das">{{$count_observados_con}}</span>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES LEVANTADAS
            <span class="panel-subtitle" style="color: #fff;">Documentos observados levantadas</span>
            <div class="chart-legend">
              <a href="{{ url($urlcontrato.'&tab_id=observadole') }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
            </div>
            <span class="count-das">{{$count_observadosct_le}}</span>
          </div>
        </div>
      </div>

      
<!-- 
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-table">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;"><b>POR USUARIO</b>
                        <span class="panel-subtitle" style="color: #fff;">Documentos sin integrar</span>
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
                @foreach($listaocpendientes_con as $index => $item)
                  <tr>
                    <td>{{$index}}</td>
                    <td class="text-center"> <span class="badge badge-success" style="font-size: 16px;">{{count($item)}}</span></td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        </div>
      </div>

      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-table">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;"><b>POR ESTADOS</b>
            <span class="panel-subtitle" style="color: #fff;">Documentos integrados</span>
            
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
                @foreach($listadocestados_con as $index => $item)
                  <tr>
                    <td>{{$item->TXT_ESTADO}}</td>
                    <td class="text-center"> <span class="badge badge-success" style="font-size: 16px;">{{$item->CANT}}</span></td>
                  </tr>
                @endforeach

              </tbody>
            </table>
          </div>
        </div>
      </div> -->


      @endif

    </div>
    </div>
  </div>
</div>


