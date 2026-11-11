    <div class="panel panel-default panel-contrast">
      <div class="panel-heading"  style="background: @if(count($transferencia)>0) @if($transferencia->TXT_CATEGORIA_ESTADO_ORDEN == 'TERMINADA') #cc0000 @else #1d3a6d @endif;color: #fff; @endif"
      >TRANSFERENCIA
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
                      {{$transferencia->TXT_CATEGORIA_ESTADO_ORDEN}} <b>
                        @if(count($transferencia_doc)>0)
                          ({{date_format(date_create($transferencia_doc->FEC_USUARIO_CREA_AUD), 'd-m-Y h:i:s')}})
                        @endif
                      </b>
                    @endif
                  </p>
              </div>
          @endif
      </div>
    </div>