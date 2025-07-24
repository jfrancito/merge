<div class="col-md-12">
  <div class="panel panel-contrast">
    <!-- <div class="panel-heading panel-heading-contrast"><b>ESTIBA</b></div> -->
    <div class="panel-body">
    <div class="row">
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">PENDIENTES
            <span class="panel-subtitle" style="color: #fff;">Documentos por aprobar</span>
            <div class="chart-legend">
              <a href="{{ url($urllg) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Aprobar</a>
            </div>
            <span class="count-das">{{$count_x_aprobar_lg}}</span>
          </div>
        </div>
      </div>
      @if($trol->ind_uc == 1)
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVADOS
            <span class="panel-subtitle" style="color: #fff;">Documentos observados</span>
            <div class="chart-legend">
              <a href="{{ url($url_obs_lg) }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
            </div>
            <span class="count-das">{{$count_observados_lg}}</span>
          </div>
        </div>
      </div>
      @endif
      @if($trol->ind_uc != 1)
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVADOS
            <span class="panel-subtitle" style="color: #fff;">Documentos observados</span>
            <div class="chart-legend">
              <a href="{{ url($urllg.'&tab_id=observado') }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
            </div>
            <span class="count-das">{{$count_observados_lg}}</span>
          </div>
        </div>
      </div>
      <div class="col-xs-12 col-md-4">
        <div class="panel panel-default panel-contrast">
          <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES LEVANTADAS
            <span class="panel-subtitle" style="color: #fff;">Documentos observados levantadas</span>
            <div class="chart-legend">
              <a href="{{ url($urllg.'&tab_id=observadole') }}" class="btn btn-rounded btn-space btn-primary dasboark">Ir Observados</a>
            </div>
            <span class="count-das">{{$count_observadoslg_le}}</span>
          </div>
        </div>
      </div>
      @endif
    </div>
    </div>
  </div>
</div>


