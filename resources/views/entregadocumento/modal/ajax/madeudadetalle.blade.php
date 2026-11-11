
<div class="modal-header" style="padding: 12px 20px;">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<div class="col-xs-12">
		<h5 class="modal-title" style="font-size: 1.2em;">
			Deuda {{$empresa->NOM_EMPR}}
		</h5>
	</div>
</div>
<div class="modal-body">
	<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 
<table id="nso_f" class="table table-striped table-borderless table-hover td-color-borde td-padding-7 listatabla">
  <thead>

    <tr>
      <th>NOM_CLIENTE</th>
      <th>NRO_CONTRATO</th>
      <th>TIPO_CONTRATO</th>
      <th>CENTRO</th>
      <th>TIPO DOCUMENTO</th>
      <th>NRO DOCUMENTO</th>
      <th>JEFE_VENTA</th>
      <th>SALDO</th>
    </tr>
  </thead>
  <tbody>
    @foreach($listadatos as $index => $item)
      <tr class="@if($item->TIPO_CONTRATO<> 'PROVEEDOR') colordeuda @endif">
        <td>{{$item->NOM_CLIENTE}}</td>
        <td>{{$item->NRO_CONTRATO}}</td>
        <td>{{$item->TIPO_CONTRATO}}</td>
        <td>{{$item->Centro}}</td>
        <td>{{$item->TipoDocumento}}</td>
        <td>{{$item->NroDocumento}}</td>
        <td>{{$item->JEFE_VENTA}}</td>
        <td><b>{{$item->SALDO}}</b></td>
      </tr>                    
    @endforeach
  </tbody>

  <tfoot>
  	
      <tr>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td><b>{{$listadatos->sum('SALDO')}}</b></td>
      </tr>  

  </tfoot>
</table>




	</div>
</div>
<div class="modal-footer">

	<button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close">Cerrar</button>
</div>




@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){


      $("#nso_f").dataTable({
          dom: 'Bfrtip',
          buttons: [
              'csv', 'excel', 'pdf'
          ],
          "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
          columnDefs:[{
              targets: "_all",
              sortable: false
          }]
      });



    });
  </script> 
@endif