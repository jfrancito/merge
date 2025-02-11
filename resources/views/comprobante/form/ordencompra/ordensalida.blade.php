@if(count($empresa_relacionada)>0) 
    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ORDEN DE SALIDA
      </div>
      <div class="panel-body panel-body-contrast">
          @if(count($ordensalida)<=0)
              <div class="col-sm-12">
                  <p style="margin:0px;">SIN ORDEN DE SALIDA</p>
              </div>
          @else
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Codigo Orden Ingreso</b> : {{$ordensalida->COD_ORDEN}}</p>
                  <p style="margin:0px;"><b>Estado Orden Ingreso</b> : {{$ordensalida->TXT_CATEGORIA_ESTADO_ORDEN}}
                     <span class="mdi mdi-eye mdidetoi" data_doc='{{$ordensalida->COD_ORDEN}}'></span>
                  </p>


              </div>
          @endif
      </div>
    </div>
@endif
