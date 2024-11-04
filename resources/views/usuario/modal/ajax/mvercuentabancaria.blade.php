
	<div class="modal-header">
		<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
		<h3 class="modal-title">
			 <b>Lista de la Cuenta Bancaria</b>
		</h3>
	</div>
	<div class="modal-body">
		<div  class="row regla-modal">
		    <div class="col-md-12">
      <table class="table table-striped table-borderless">
        <thead>
          <tr>
            <th>Banco</th>
            <th>Tipo Cuenta</th>
            <th>Moneda</th>
            <th>Nro. Cuenta</th>
            <th>Nro. CCI</th>
          </tr>
        </thead>
        <tbody class="no-border-x">

          @foreach($cuentabancarias as $index => $item)
              <tr>
                <td>{{$item->TXT_EMPR_BANCO}}</td>
                <td>{{$item->TXT_REFERENCIA}}</td>
                <td>{{$item->TXT_CATEGORIA_MONEDA}}</td>
                <td>{{$item->TXT_NRO_CUENTA_BANCARIA}}</td>
                <td>{{$item->TXT_NRO_CCI}}</td>
              </tr>

          @endforeach



        </tbody>
      </table>

		        
				</div>
		    </div>
		</div>
	</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){


    });
  </script>
@endif




