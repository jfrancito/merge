
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
            <th>INFORMACION</th>
            <th>CUENTA BANCARIA</th>
            @if (isset($idopcion))
            <th>OPERACION</th> 
            @endif
          </tr>
        </thead>
        <tbody class="no-border-x">
          @foreach($cuentabancarias as $index => $item)
              <tr>
                <td class="cell-detail sorting_1" style="position: relative;">
                  <span><b>BANCO :  </b> {{$item->TXT_EMPR_BANCO}}</span>
                  <span><b>TIPO CUENTA  : </b> {{$item->TXT_REFERENCIA}}</span>
                  <span><b>MONEDA : </b> {{$item->TXT_CATEGORIA_MONEDA}}</span>
                </td>
                <td class="cell-detail sorting_1" style="position: relative;">
                  <span><b>NRO CUENTA BANCARIA :  </b> {{$item->TXT_NRO_CUENTA_BANCARIA}}</span>
                  <span><b>CCI  : </b> {{$item->TXT_NRO_CCI}}</span>
                  <span><b>CARNET EXTRANJERIA : </b> {{$item->CARNET_EXTRANJERIA}}</span>
                </td>
                @if (isset($idopcion))
                  <td>
                    <a href="{{ url('/cambiar-cuenta-corriente/'.$item->COD_EMPR_TITULAR.'/'.$item->COD_EMPR_BANCO.'/'.$item->TXT_NRO_CUENTA_BANCARIA.'/'.$item->COD_CATEGORIA_MONEDA.'/'.$idoc.'/'.$idopcion) }}" class="tools select"> <span class="label label-success">CAMBIAR CUENTA</span></a>
                  </td>
                @endif


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




