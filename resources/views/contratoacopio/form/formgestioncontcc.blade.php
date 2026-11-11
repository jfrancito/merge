
<div class="row">
    <div class="col-xs-12 col-sm-5 col-md-5 col-lg-5">
        @include('contratoacopio.form.contratoacopio.cabecera')
    </div>
    <div class="col-xs-12 col-sm-7 col-md-7 col-lg-7">
        <div class="panel panel-default panel-contrast" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05);">
          <div class="panel-heading" style="background: #1d3a6d; color: #fff; font-weight: bold; padding: 15px;">
            <i class="bi bi-list-task"></i> DETALLE DE ANTICIPOS (PROYECCIÓN)
          </div>
          <div class="panel-body panel-body-contrast" style="padding: 0;">
            <table class="table table-condensed table-striped" style="margin-bottom: 0;">
              <thead>
                <tr style="background: #f8fafc;">
                  <th style="padding: 12px 15px; font-size: 11px; text-transform: uppercase;">#</th>
                  <th style="padding: 12px 15px; font-size: 11px; text-transform: uppercase;">Fecha Entrega</th>
                  <th style="padding: 12px 15px; font-size: 11px; text-transform: uppercase;">Tercero / Beneficiario</th>
                  <th style="padding: 12px 15px; font-size: 11px; text-transform: uppercase;" class="text-right">Importe</th>
                </tr>
              </thead>
              <tbody>
                @foreach($contratoanticipodet as $index => $item)
                  <tr>
                    <td style="padding: 10px 15px;">{{$index + 1}}</td>
                    <td style="padding: 10px 15px;">{{date_format(date_create($item->FECHA), 'd-m-Y')}}</td>
                    <td style="padding: 10px 15px;">{{$item->TXT_PROVEEDOR}}</td>
                    <td style="padding: 10px 15px;" class="text-right"><b>{{number_format($item->IMPORTE, 2, '.', ',')}}</b></td>
                  </tr>
                @endforeach
              </tbody>
              <tfoot style="background: #f8fafc; font-weight: bold;">
                  <tr>
                      <td colspan="3" class="text-right" style="padding: 10px 15px;">TOTAL DETALLE:</td>
                      <td class="text-right" style="padding: 10px 15px; color: #2b6cb0;">{{number_format($contratoanticipodet->sum('IMPORTE'), 2, '.', ',')}}</td>
                  </tr>
              </tfoot>
            </table>
          </div>
        </div>
    </div>
</div>

<div class="panel panel-default panel-contrast ver-archivos" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-top: 20px;">
  <div class="panel-heading" style="background: #1d3a6d; color: #fff; font-weight: bold; padding: 15px;">
    <i class="bi bi-file-earmark-pdf"></i> ARCHIVOS ADJUNTOS (PDF)
  </div>
  <div class="panel-body panel-body-contrast">
      <div class="file-loading">
          <input id="input-24" name="input24[]" type="file" multiple>
      </div>
  </div>
</div>
