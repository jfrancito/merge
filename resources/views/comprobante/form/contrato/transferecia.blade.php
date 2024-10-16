    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">TRANSFERENCIA
      </div>
      <div class="panel-body panel-body-contrast">
          @if(count($transferencia)<=0)
              <div class="col-sm-12">
                  <p style="margin:0px;">SIN TRANSFERENCIA</p>
              </div>
          @else
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Codigo Transferencia</b> : {{$transferencia->COD_ORDEN}}</p>
                  <p style="margin:0px;"><b>Estado Transferencia</b> : 
                    @if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA')
                      NO RECEPCIONADO
                    @else
                      {{$transferencia->TXT_CATEGORIA_ESTADO_ORDEN}}
                    @endif
                  </p>
              </div>
          @endif
      </div>
    </div>