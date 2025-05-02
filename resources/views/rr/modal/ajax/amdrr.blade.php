
<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<h3 class="modal-title">
		 LISTA DOCUMENTOS DE {{$data_cliente}}
	</h3>
</div>
<div class="modal-body">
	<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 

  	<table id="tableRR" class="table table-striped table-hover table-fw-widget listatabla">
        <thead>
          <tr>
            <th>RESULTADO</th>
            <th>ANEXO</th>
            <th>CENTRO</th>
            <th>MES</th>
            <th>FECHA</th>
            <th>CODIGO</th>
            <th>TIPO_VENTA</th>
            <th>CLIENTE</th>
            <th>IMPORTE</th>
            <th>CONCEPTO_CENTRO_COSTO</th>
          </tr>
        </thead>
        <tbody>
          	@foreach($resultados as $index=>$item)
                <tr>
                    <td>{{$item->RESULTADO}}</td>
                    <td>{{$item->ANEXO}}</td>
                    <td>{{$item->CENTRO}}</td>
                    <td>{{$item->MES}}</td>
                    <td>{{$item->FECHA}}</td>
                    <td>{{$item->CODIGO}}</td>
                    <td>{{$item->TIPO_VENTA}}</td>
                    <td>{{$item->CLIENTE}}</td>
                    <td>{{$item->IMPORTE}}</td>
                    <td>{{$item->CONCEPTO_CENTRO_COSTO}}</td>
                </tr>                    
          	@endforeach
        </tbody>
  	</table>



  	<table id="tableRRD" class="table table-striped table-hover table-fw-widget listatabla">
        <thead>
          <tr>
            <th>RESULTADO OTROS</th>
            <th>ANEXO OTROS</th>
            <th>CENTRO OTROS</th>
            <th>MES OTROS</th>
            <th>CODIGO OTROS</th>
            <th>TIPO_VENTA OTROS</th>
            <th>CLIENTE OTROS</th>
            <th>IMPORTE OTROS</th>
            <th>CONCEPTO_CENTRO_COSTO_OTROS</th>

            <th>RESULTADO</th>
            <th>ANEXO</th>
            <th>CENTRO</th>
            <th>MES</th>
            <th>CODIGO</th>
            <th>TIPO_VENTA</th>
            <th>CLIENTE</th>
            <th>IMPORTE</th>
            <th>CONCEPTO_CENTRO_COSTO</th>

          </tr>
        </thead>
        <tbody>
          	@foreach($resultado02 as $index=>$item)
                <tr>
                    <td>{{$item->RESULTADO_O}}</td>
                    <td>{{$item->ANEXO_O}}</td>
                    <td>{{$item->CENTRO_O}}</td>
                    <td>{{$item->MES_O}}</td>
                    <td>{{$item->CODIGO_O}}</td>
                    <td>{{$item->TIPO_VENTA_O}}</td>
                    <td>{{$item->CLIENTE_O}}</td>
                    <td>{{$item->IMPORTE_O}}</td>
                    <td>{{$item->CONCEPTO_CENTRO_COSTO_O}}</td>


                    <td>{{$item->RESULTADO}}</td>
                    <td>{{$item->ANEXO}}</td>
                    <td>{{$item->CENTRO}}</td>
                    <td>{{$item->MES}}</td>
                    <td>{{$item->CODIGO}}</td>
                    <td>{{$item->TIPO_VENTA}}</td>
                    <td>{{$item->CLIENTE}}</td>
                    <td>{{$item->IMPORTE}}</td>
                    <td>{{$item->CONCEPTO_CENTRO_COSTO}}</td>
                </tr>                    
          	@endforeach
        </tbody>
  	</table>




	</div>

</div>

<div class="modal-footer">
  <button type="submit" data-dismiss="modal" class="btn btn-success btn-asigna-asiento-pc">Asignar</button>
</div>
@if(isset($ajax))
  <script type="text/javascript">
    $("#tableRR").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 0, "asc" ]]
    });
    $("#tableRRD").dataTable({
        dom: 'Bfrtip',
        buttons: [
            'csv', 'excel', 'pdf'
        ],
        "lengthMenu": [[500, 1000, -1], [500, 1000, "All"]],
        order : [[ 0, "asc" ]]
    });

  </script> 
@endif



