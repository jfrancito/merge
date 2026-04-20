    <div class="panel panel-default panel-contrast">
      <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT
      </div>
      <div class="panel-body panel-body-contrast">
          @if(count($fedocumento)<=0)
              <div class="col-sm-12">
                  <b>CARGAR XML</b>
              </div>
          @else
              <div class="col-sm-12">
                  <p style="margin:0px;"><b>Respuesta Sunat</b> : {{$fedocumento->message}}</p>
                  <p style="margin:0px;" class='@if($fedocumento->estadoCp == 1) msjexitoso @else msjerror @endif'><b>Estado Comprobante</b> : 
                      {{$fedocumento->nestadoCp}}
                  </p>
                  <p style="margin:0px;"><b>Estado Ruc</b> : {{$fedocumento->nestadoRuc}}</p>
                  <p style="margin:0px;"><b>Estado Domicilio</b> : {{$fedocumento->ncondDomiRuc}}</p>
                  <p style="margin:0px;"><b>Respuesta CDR</b> : {{$fedocumento->RESPUESTA_CDR}}</p>
              </div>
          @endif
      </div>
    </div>