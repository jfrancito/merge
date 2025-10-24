<div class="modal-header bg-primary text-white py-2">
    <h5 class="modal-title w-50 text-center fw-bold">
        DETALLE VIÁTICOS DE VIAJE
    </h5>
</div>

<div class="modal-body p-3">



<div class="tab-content mt-3">
  <div id="resumenviaticos" class="tab-pane active">
 {{--   @include('valerendir.ajax.modaldetalleimporteviaticosresumen')--}}
  </div>
 
     @include('valerendirreembolso.ajax.modaldetalleimporteviaticosreembolso')

</div>


  <div class="modal-footer justify-content-center bg-light" 
       style="margin-top:-10px; border-top:1px solid #dee2e6;">
    <button type="button" data-dismiss="modal" 
            class="btn btn-primary btn-space modal-close">
      Cerrar
    </button>
  </div>

</div>


      