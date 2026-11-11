@if ($error)

    <div class="panel-body">
      <div role="alert" class="alertaw alert alert-warning alert-icon alert-icon-border alert-dismissible">
        <div class="icon"><span class="mdi mdi-alert-triangle"></span></div>
        <div class="message">
          	<button type="button" data-dismiss="alert" aria-label="Close" class="close">
          		<span aria-hidden="true" class="mdi mdi-close">
        		</span>
        	</button><strong>Advertencia!</strong> {{$error}}.
        </div>
      </div>
    </div>

@endif