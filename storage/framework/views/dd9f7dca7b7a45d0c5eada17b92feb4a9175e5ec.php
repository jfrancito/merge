<div id="modal-verdetallepedido-solicitud" class="modal-container colored-header colored-header-primary modal-effect-8">
  <div class="modal-content ">
	<div class='modal-verdetallepedido-solicitud-container'>
	</div>
  </div>
</div>

<div class="modal-overlay"></div>


<style>
    /* ── Contenedor principal: centrado fijo en pantalla ── */
    #modal-verdetallepedido-solicitud {
        position: fixed !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
        width: 95%;
        max-width: 1100px;
        max-height: 90vh;          /* nunca más alto que el 90% de la pantalla */
        display: flex;
        flex-direction: column;
        margin: 0 !important;
        z-index: 9999;
    }

    /* ── Caja blanca interior ── */
    #modal-verdetallepedido-solicitud .modal-content {
        border-radius: 14px;
        overflow: hidden;
        display: flex;
        flex-direction: column;
        max-height: 90vh;           /* igual que el contenedor */
    }

    /* ── La zona scrollable es SOLO el body de la tabla ── */
    #modal-verdetallepedido-solicitud .detalle-scroll {
        flex: 1 1 auto;
        max-height: 55vh !important;  /* altura fija para el área de productos */
        overflow-y: auto;
    }
</style>