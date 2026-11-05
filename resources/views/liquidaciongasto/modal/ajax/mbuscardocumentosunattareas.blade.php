<div class="modal-header">
	<button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
	<h3 class="modal-title">
		BUSCAR DOCUMENTOS EN SUNAT
	</h3>
</div>
<div class="modal-body">
	<div class="container">
	    <div class="tab-container">
	        <ul class="nav nav-tabs">
	          <li class="active"><a href="#sunat" data-toggle="tab">TAREAS</a></li>
	        </ul>
	        <div class="tab-content">
	          <div id="sunat" class="tab-pane  active cont">
				<div class="scroll_text scroll_text_heigth_aler" style = "padding: 0px !important;"> 					
					<div class='listajax'>
	                    @include('liquidaciongasto.ajax.alistatareassunattareas')
	                </div>
				</div>
	          </div>
	        </div>
	    </div>
	</div>
</div>
@if(isset($ajax))
	<script type="text/javascript">
		$(document).ready(function(){
			$('.importe').inputmask({ 'alias': 'numeric', 
			'groupSeparator': ',', 'autoGroup': true, 'digits': 2, 
			'digitsOptional': false, 
			'prefix': '', 
			'placeholder': '0'});
		});
	</script>
@endif





