    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">ORDEN DE INGRESO
      </div>
      <div class="panel-body panel-body-contrast">
          @if(count($ordeningreso)<=0)
              <div class="col-sm-12">
                  <p style="margin:0px;">SIN ORDEN DE INGRESO</p>
              </div>
          @else
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Codigo Orden Ingreso</b> : {{$ordeningreso->COD_ORDEN}}</p>
                  <p style="margin:0px;"><b>Estado Orden Ingreso</b> : {{$ordeningreso->TXT_CATEGORIA_ESTADO_ORDEN}}
                     <span class="mdi mdi-eye mdidetoi" data_doc='{{$ordeningreso->COD_ORDEN}}'></span>
                  </p>


              </div>
          @endif
      </div>
    </div>