	<div class="modal-header" style="background: #1d3a6d; color: white;">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close" style="color: white; opacity: 1;"><span class="mdi mdi-close"></span></button>
	  	<div class="row">
			<div class="col-xs-12">
				<h4 class="modal-title" style="color: white; font-weight: bold; margin: 0;">DETALLES DEL CONTRATO: {{$contratoanticipo->ID_DOCUMENTO}}</h4>
			</div>
		</div>
	</div>
	<div class="modal-body" style="padding: 15px; background-color: #f5f5f5;">
		<div class="row">
		    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		        <div class="panel panel-default panel-contrast" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 0;">
		          <div class="panel-heading" style="background: #ffffff; color: #1d3a6d; font-weight: bold; padding: 12px 15px; border-bottom: 2px solid #e2e8f0;">
		            <i class="bi bi-file-earmark-text"></i> DATOS DEL CONTRATO ACOPIO
		          </div>
		          <div class="panel-body panel-body-contrast" style="padding: 0;">
		            <table class="table table-condensed table-striped" style="margin-bottom: 0;">
		              <tbody>
		                  <tr>
		                    <td style="padding: 8px 15px; width: 40%;"><b>ID DOCUMENTO</b></td>
		                    <td style="padding: 8px 15px;"><b>{{$contratoanticipo->ID_DOCUMENTO}}</b></td>
		                  </tr>
		                  <tr>
		                    <td style="padding: 8px 15px;"><b>NRO CONTRATO</b></td>
		                    <td style="padding: 8px 15px;">{{$contratoanticipo->NRO_CONTRATO}}</td>
		                  </tr>
		                  <tr>
		                    <td style="padding: 8px 15px;"><b>FECHA</b></td>
		                    <td style="padding: 8px 15px;">{{date_format(date_create($contratoanticipo->FECHA_CONTRATO), 'd-m-Y')}}</td>
		                  </tr>
		                  <tr>
		                    <td style="padding: 8px 15px;"><b>EMPRESA</b></td>
		                    <td style="padding: 8px 15px;">{{$contratoanticipo->TXT_EMPRESA}}</td>
		                  </tr>
		                  <tr>
		                    <td style="padding: 8px 15px;"><b>PROVEEDOR</b></td>
		                    <td style="padding: 8px 15px;"><b>{{$contratoanticipo->TXT_PROVEEDOR}}</b></td>
		                  </tr>
		                  <tr>
		                    <td style="padding: 8px 15px;"><b>VARIEDAD</b></td>
		                    <td style="padding: 8px 15px;">{{$contratoanticipo->TXT_VARIEDAD}}</td>
		                  </tr>
		                  <tr>
		                    <td style="padding: 8px 15px;"><b>TOTAL KG</b></td>
		                    <td style="padding: 8px 15px;">{{number_format($contratoanticipo->TOTAL_KG, 2, '.', ',')}} KG</td>
		                  </tr>
		                  <tr style="background: #ebf8ff;">
		                    <td style="padding: 8px 15px;"><b>PROYECCIÓN TOTAL</b></td>
		                    <td style="padding: 8px 15px;"><b style="color: #2b6cb0;">{{number_format($contratoanticipo->PROYECCION, 2, '.', ',')}}</b></td>
		                  </tr>
		                  <tr style="background: #ebf8ff;">
		                    <td style="padding: 8px 15px;"><b>IMPORTE HABILITAR</b></td>
		                    <td style="padding: 8px 15px;"><b style="color: #2b6cb0;">{{number_format($contratoanticipo->IMPORTE_HABILITAR, 2, '.', ',')}}</b></td>
		                  </tr>
		              </tbody>
		            </table>
		          </div>
		        </div>
		    </div>

		    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
		        <div class="panel panel-default panel-contrast" style="border-radius: 8px; overflow: hidden; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 0;">
		          <div class="panel-heading" style="background: #ffffff; color: #1d3a6d; font-weight: bold; padding: 12px 15px; border-bottom: 2px solid #e2e8f0;">
		            <i class="bi bi-list-task"></i> DETALLE DE ANTICIPOS
		          </div>
		          <div class="panel-body panel-body-contrast" style="padding: 0;">
		            <table class="table table-condensed table-striped" style="margin-bottom: 0;">
		              <thead>
		                <tr style="background: #f8fafc;">
		                  <th style="padding: 10px 15px; font-size: 11px; text-transform: uppercase;">Fecha</th>
		                  <th style="padding: 10px 15px; font-size: 11px; text-transform: uppercase;">Beneficiario</th>
		                  <th style="padding: 10px 15px; font-size: 11px; text-transform: uppercase;" class="text-right">Importe</th>
		                </tr>
		              </thead>
		              <tbody>
		                @foreach($contratoanticipodet as $index => $item)
		                  <tr>
		                    <td style="padding: 8px 15px;">{{date_format(date_create($item->FECHA), 'd-m-Y')}}</td>
		                    <td style="padding: 8px 15px;">{{$item->TXT_PROVEEDOR}}</td>
		                    <td style="padding: 8px 15px;" class="text-right"><b>{{number_format($item->IMPORTE, 2, '.', ',')}}</b></td>
		                  </tr>
		                @endforeach
		              </tbody>
		              <tfoot style="background: #f8fafc; font-weight: bold;">
		                  <tr>
		                      <td colspan="2" class="text-right" style="padding: 8px 15px;">TOTAL:</td>
		                      <td class="text-right" style="padding: 8px 15px; color: #2b6cb0;">{{number_format($contratoanticipodet->sum('IMPORTE'), 2, '.', ',')}}</td>
		                  </tr>
		              </tfoot>
		            </table>
		          </div>
		        </div>
		    </div>
		</div>
	</div>
