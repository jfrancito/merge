<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.liquidacioncompraanticipo.comparar')
  </div> 
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.liquidacioncompraanticipo.seguimiento')
  </div> 
</div>
<div class="row">

  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.liquidacioncompraanticipo.archivos')
  </div>
  <div class="col-xs-12 col-sm-6 col-md-8 col-lg-8">
    @include('comprobante.form.liquidacioncompraanticipo.informacion')
  </div>
</div>

<div class="row">
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    @include('comprobante.form.ordencompra.verarchivopdf')
  </div>
</div>
<div class="row">
  <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
    @include('comprobante.form.liquidacioncompraanticipo.archivosobservados')
  </div>
</div>

@if(isset($contrato_anticipo) && $contrato_anticipo)
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 15px;">
          <label class="col-sm-12 control-label labelleft"><b>RESUMEN DEL CONTRATO ANTICIPO:</b></label>
          <div class="col-sm-12 abajocaja">
              <table class="table table-condensed table-striped" style="margin-bottom: 20px;">
                <thead>
                  <tr>
                    <th>Nro Contrato</th>
                    <th>Proveedor</th>      
                    <th>Variedad</th>       
                    <th>Hectareas</th>
                    <th>Importe a Habilitar</th>
                  </tr>
                </thead>
                <tbody>
                    <tr>
                      <td>{{$contrato_anticipo->NRO_CONTRATO}}</td>
                      <td>{{$contrato_anticipo->TXT_PROVEEDOR}}</td>
                      <td>{{$contrato_anticipo->TXT_VARIEDAD}}</td>
                      <td>{{number_format($contrato_anticipo->HECTAREAS, 2, '.', ',')}}</td>
                      <td>{{number_format($contrato_anticipo->IMPORTE_HABILITAR, 2, '.', ',')}}</td>
                    </tr>
                </tbody>
              </table>
          </div>
        </div>
    </div>
@endif

@if(isset($fecha_entrega_c) && $fecha_entrega_c != '')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 15px;">
          <label class="col-sm-12 control-label labelleft"><b>FECHA DE ENTREGA:</b></label>
          <div class="col-sm-12 abajocaja">
            <p class='subtitulomerge' style="font-size: 1.5em; text-align: left;"><b>{{ date_format(date_create($fecha_entrega_c), 'd-m-Y') }}</b></p>
          </div>
        </div>
    </div>
@endif