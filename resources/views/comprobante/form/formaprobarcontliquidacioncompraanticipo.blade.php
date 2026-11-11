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
        @include('comprobante.form.ordencompra.verarchivopdfmultiple')
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4">
        @include('comprobante.form.liquidacioncompraanticipo.archivosobservados')
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">SUBIR ARCHIVOS
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>OTROS DOCUMENTOS</b>
                                <br><br></label>
                            <div class="col-sm-12">
                                <div class="file-loading">
                                    <input
                                            id="file-otros"
                                            name="otros[]"
                                            class="file-es"
                                            type="file"
                                            multiple data-max-file-count="1"
                                    >
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default panel-contrast">
            <div class="panel-heading" style="background: #1d3a6d;color: #fff;">OBSERVACIONES
            </div>
            <div class="panel-body panel-body-contrast">
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="form-group sectioncargarimagen">
                            <label class="col-sm-12 control-label" style="text-align: left;"><b>REALIZAR UNA
                                    OBSERVACION</b> <br><br></label>
                            <div class="col-sm-12">
                          <textarea
                                  name="descripcion"
                                  id="descripcion"
                                  class="form-control input-sm validarmayusculas"
                                  rows="15"
                                  cols="200"
                                  data-aw="2"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="div_cuenta_contable">
        <input type="hidden" name="nro_cuenta_contable" id="nro_cuenta_contable" value="">
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        @include('comprobante.asiento.listaasientotabla')
        @include('comprobante.asiento.contenedorasientoorden')
    </div>

</div>

@if(isset($contrato_anticipo) && $contrato_anticipo)
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px;">
          <div class="panel panel-default panel-contrast" style="border-left: 5px solid #2563eb; box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.1);">
            <div class="panel-heading" style="background: #f8fafc; color: #1e293b; font-weight: 700; border-bottom: 1px solid #e2e8f0;">
                <i class="mdi mdi-file-document-outline" style="color: #2563eb; margin-right: 8px;"></i>
                RESUMEN DEL CONTRATO ANTICIPO: {{ $contrato_anticipo->NRO_CONTRATO }}
            </div>
            <div class="panel-body" style="padding: 20px;">
                <div class="row" style="margin-bottom: 25px;">
                    <div class="col-md-3">
                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Proveedor</div>
                        <div style="font-weight: 600; color: #334155;">{{ $contrato_anticipo->TXT_PROVEEDOR }}</div>
                    </div>
                    <div class="col-md-2">
                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Variedad</div>
                        <div style="font-weight: 600; color: #334155;">{{ $contrato_anticipo->TXT_VARIEDAD }}</div>
                    </div>
                    <div class="col-md-2">
                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Hectáreas</div>
                        <div style="font-weight: 600; color: #334155;">{{ number_format($contrato_anticipo->HECTAREAS, 2) }} ha</div>
                    </div>
                    <div class="col-md-3">
                        <div style="font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px;">Importe Total Habilitar</div>
                        <div style="font-weight: 700; color: #2563eb; font-size: 16px;">S/ {{ number_format($contrato_anticipo->IMPORTE_HABILITAR, 2) }}</div>
                    </div>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover" style="font-size: 12px; border: 1px solid #e2e8f0;">
                      <thead>
                        <tr style="background: #f1f5f9;">
                          <th style="width: 60px; text-align: center;">Item</th>
                          <th>Fecha Pago Prog.</th>      
                          <th class="text-right">Importe Cuota</th>
                          <th class="text-center">Estado</th>
                          <th>Referencia / Pago Asoc.</th>
                        </tr>
                      </thead>
                      <tbody>
                          @foreach($detalles_contrato as $det)
                            @php 
                                $pago = null;
                                foreach($pagos_contrato as $p) {
                                    if ((int)trim($p->ITEM_CUOTA) == (int)trim($det->ITEM)) {
                                        $pago = $p;
                                        break;
                                    }
                                }
                            @endphp
                            <tr @if($pago) style="background: #f0fdf4;" @endif>
                              <td style="text-align: center; font-weight: 700; color: #64748b;">{{ $det->ITEM }}</td>
                              <td style="font-weight: 500;">
                                  <div style="display: flex; align-items: center; gap: 4px; margin-bottom: 4px;">
                                      <span style="background: #f1f5f9; color: #475569; padding: 2px 8px; border-radius: 4px; font-weight: 700; font-size: 13px; border: 1px solid #e2e8f0;">
                                          {{ date_format(date_create($det->FECHA), 'd-m-Y') }}
                                      </span>
                                  </div>
                              </td>
                              @php 
                                  $monto_det = isset($det->IMPORTE) ? $det->IMPORTE : (isset($det->importe) ? $det->importe : 0);
                              @endphp
                              <td class="text-right" style="font-weight: 700; color: #1e293b; font-size: 14px;">S/ {{ number_format($monto_det, 2, '.', ',') }}</td>
                              <td class="text-center">
                                  @if($pago)
                                      <span class="label label-success" style="border-radius: 12px; padding: 4px 12px; font-weight: 700; border: 1px solid #bbf7d0;">EN PROCESO</span>
                                  @else
                                      <span class="label label-warning" style="border-radius: 12px; padding: 4px 12px; font-weight: 700; border: 1px solid #fed7aa;">PENDIENTE</span>
                                  @endif
                              </td>

                              <td>
                                  @if($pago)
                                      <div style="font-weight: 700; color: #166534; display: flex; align-items: center; gap: 4px;">
                                          <i class="mdi mdi-check-circle" style="font-size: 14px;"></i>
                                          {{ $pago->ID_AUTORIZACION }}
                                      </div>
                                  @else
                                      <span style="color: #cbd5e1; font-style: italic; font-size: 11px;">Esperando liquidación...</span>
                                  @endif
                              </td>
                            </tr>
                          @endforeach
                      </tbody>
                    </table>
                </div>
            </div>
          </div>
        </div>
    </div>
@endif

@if(isset($fecha_entrega_c) && $fecha_entrega_c != '')
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 20px; margin-bottom: 10px;">
          <div style="background: #fdf2f2; border-left: 5px solid #ef4444; padding: 15px; border-radius: 4px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 15px;">
              <div style="background: #fee2e2; color: #ef4444; width: 45px; height: 45px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                  <i class="mdi mdi-truck-delivery" style="font-size: 24px;"></i>
              </div>
              <div>
                  <div style="font-size: 12px; color: #991b1b; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px;">Fecha de Entrega Estimada</div>
                  <div style="font-size: 1.8em; color: #7f1d1d; font-weight: 900; line-height: 1; display: flex; gap: 20px; align-items: baseline;">
                      {{ date_format(date_create($fecha_entrega_c), 'd-m-Y') }}
                      @if(isset($peso_entrega_c))
                        <span style="font-size: 0.6em; background: #ef4444; color: white; padding: 2px 10px; border-radius: 20px;">
                            PESO: {{ number_format($peso_entrega_c, 2) }} KG
                        </span>
                      @endif
                  </div>
              </div>
          </div>
        </div>
    </div>
@endif

<div class="row xs-pt-15">
    <div class="col-xs-6">
        <div class="be-checkbox">

        </div>
    </div>
    <div class="col-xs-6">
        <p class="text-right">
            <a href="{{ url('/gestion-de-administracion-aprobar/'.$idopcion) }}">
                <button type="button" class="btn btn-space btn-danger btncancelar">Cancelar</button>
            </a>
            <button type="submit" class="btn btn-space btn-primary btnaprobarcomporbatntenuevo">Guardar</button>
        </p>
    </div>
</div>
