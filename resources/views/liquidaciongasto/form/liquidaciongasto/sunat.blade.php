<div class="panel panel-default panel-contrast">
  <div class="panel-heading" style="background: #1d3a6d;color: #fff;">CONSULTA API SUNAT
  </div>
  <div class="panel-body panel-body-contrast">
          <div class="col-sm-12">
              <p style="margin:0px;"><b>Respuesta Sunat</b> : {{$liquidaciongastos->message}}</p>
              <p style="margin:0px;" class='@if($liquidaciongastos->estadoCp == 1) msjexitoso @else msjerror @endif'><b>Estado Comprobante</b> : 
                  {{$liquidaciongastos->nestadoCp}}
              </p>
              <p style="margin:0px;"><b>Estado Ruc</b> : {{$liquidaciongastos->nestadoRuc}}</p>
              <p style="margin:0px;"><b>Estado Domicilio</b> : {{$liquidaciongastos->ncondDomiRuc}}</p>
              <p style="margin:0px;"><b>Respuesta CDR</b> : {{$liquidaciongastos->RESPUESTA_CDR}}</p>
          </div>
  </div>
</div>