<div class="modal-header bg-primary text-white py-2">
    <h5 class="modal-title w-50 text-center fw-bold">
        DETALLE VIÁTICOS DE VIAJE
    </h5>
</div>

<div class="modal-body p-3">

<div class="tab-content mt-3">
    <?php echo $__env->make('valerendir.gestion.modalaumvaledetalleimportegestion', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
</div>

</div>

