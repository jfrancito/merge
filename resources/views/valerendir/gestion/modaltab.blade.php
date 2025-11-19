<div class="modal-header bg-primary text-white py-2">
    <h5 class="modal-title w-50 text-center fw-bold">
        DETALLE VIÁTICOS DE VIAJE
    </h5>
</div>

<div class="modal-body p-3">

 <ul class="nav nav-tabs">
  <li class="active">
    <a href="#resumenviaticos" data-toggle="tab"><b>RESUMEN VIÁTICOS</b></a>
  </li>
  <li>
    <a href="#detalleviaticos" data-toggle="tab"><b>DETALLE VIÁTICOS</b></a>
  </li>
</ul>

<div class="tab-content mt-3">
  <div id="resumenviaticos" class="tab-pane active">
   @include('valerendir.gestion.modalvaledetalleimporteresumengestion') 
  </div>
  <div id="detalleviaticos" class="tab-pane">
    @include('valerendir.gestion.modalvaledetalleimportegestion')
  </div>
</div>


  <div class="modal-footer justify-content-center bg-light" 
       style="margin-top:-10px; border-top:1px solid #dee2e6;">
    <button type="button" data-dismiss="modal" 
            class="btn btn-primary btn-space modal-close">
      Cerrar
    </button>
  </div>

</div>


      