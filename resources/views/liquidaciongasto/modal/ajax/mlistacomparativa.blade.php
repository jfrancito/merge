<div class="panel panel-default">
      <div class="tab-container">
        <ul class="nav nav-tabs">
          <li class="active"><a href="#acumulado" data-toggle="tab">COMPARATIVA</a></li> 
        </ul>

        <div class="tab-content">
          	<div id="registro" class="tab-pane active cont">

								<div class="modal-header">
									<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
									<h3 class="modal-title">
										<span>{{$liquidaciongastos->ID_DOCUMENTO}}</span>
									</h3>
								</div>
								<div class="modal-body">
									<div  class="row regla-modal">
										<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

								        <table id="tblactivos" class="table table-condensed table-striped">
								            <thead>
								            <tr>
								                <th>VALE</th>
								                <th>LIQUIDACION</th>
								                <th>MONTO VALE</th>
								                <th>MONTO LIQUIDACION</th>
								                <th>DIFERENCIA</th>
								            </tr>
								            </thead>
								            <tbody>
								            @foreach($listaarendirlg as $item)
								            <tr>
								                <td>{{ $item['concepto'] }}</td>
								                <td>{{ $item['TXT_PRODUCTO'] }}</td>
								                <td>{{ number_format($item['monto'], 2) }}</td>
								                <td>{{ number_format($item['TOTAL'], 2) }}</td>
								                <td>{{ number_format($item['restante'], 2) }}</td>
								            </tr>
								            @endforeach
								            </tbody>
								        </table>



					            </div>

									</div>
								</div>
          	</div>

        </div>
       </div>
	</div>





