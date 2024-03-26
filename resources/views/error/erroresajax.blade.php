@if ($error)

    <div class="panel-bod errorflotanteajax">
      <div role="alert" class="alertaw alert alert-danger alert-icon alert-icon-border alert-dismissible">
        <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
        <div class="message">
          	<button type="button" data-dismiss="alert" aria-label="Close" class="close">
          		<span aria-hidden="true" class="mdi mdi-close">
        		</span>
        	</button><strong>Error!</strong> {{$error}}.
        </div>
      </div>
    </div>

@endif