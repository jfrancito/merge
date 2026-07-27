<form method="POST" action="<?php echo e(url('/configurar-ubicacion-conta-orden/'.$prefijo_id.'/'.$orden_id.'/'.$idopcion)); ?>" class="form-ajax-ubicacion">
  <?php echo e(csrf_field()); ?>

  <input type="hidden" name="device_info" id="device_info">

  <!-- Estilos Premium Embebidos -->
  <style type="text/css">
      .premium-modal-wrapper {
          font-family: 'Segoe UI', system-ui, -apple-system, sans-serif;
          background-color: #f8fafc;
          border-radius: 8px;
          overflow: hidden;
      }
      .premium-modal-wrapper .modal-header {
          background: linear-gradient(135deg, #1e293b, #0f172a); /* Gradiente elegante gris oscuro */
          color: #f8fafc;
          border-bottom: 2px solid #334155;
          padding: 16px 20px;
          position: relative;
      }
      .premium-modal-wrapper .modal-title {
          margin: 0;
          color: #f1f5f9;
          font-size: 18px;
          font-weight: 600;
          letter-spacing: -0.025em;
          display: flex;
          align-items: center;
      }
      .premium-modal-wrapper .modal-title i {
          margin-right: 8px;
          font-size: 20px;
      }
      .premium-modal-wrapper .modal-close {
          color: #94a3b8;
          opacity: 0.8;
          font-size: 20px;
          position: absolute;
          right: 18px;
          top: 16px;
          background: transparent;
          border: none;
          outline: none;
          transition: all 0.2s ease-in-out;
      }
      .premium-modal-wrapper .modal-close:hover {
          color: #ffffff;
          opacity: 1;
          transform: rotate(90deg);
      }
      .premium-modal-wrapper .modal-body {
          padding: 24px;
          background-color: #f8fafc;
      }
      .premium-modal-wrapper .form-group {
          margin-bottom: 18px;
      }
      .premium-modal-wrapper .control-label {
          font-size: 13px;
          color: #475569; /* Slate 600 */
          font-weight: 600;
          letter-spacing: 0.03em;
          margin-bottom: 6px;
          display: inline-block;
          text-align: left;
      }
      .premium-modal-wrapper .input-premium {
          border-radius: 6px !important;
          border: 1px solid #cbd5e1 !important;
          padding: 8px 12px !important;
          font-size: 13.5px !important;
          color: #1e293b !important;
          background-color: #ffffff !important;
          box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
          height: 38px !important;
          transition: all 0.2s ease !important;
          width: 100%;
      }
      .premium-modal-wrapper .input-premium:focus {
          border-color: #6366f1 !important;
          box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.15) !important;
          outline: none !important;
      }
      /* Select2 Estilo Premium */
      .premium-modal-wrapper .select2-container--default .select2-selection--single {
          border: 1px solid #cbd5e1 !important;
          border-radius: 6px !important;
          height: 38px !important;
          padding: 4px 12px !important;
          box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05) !important;
          background-color: #ffffff !important;
      }
      .premium-modal-wrapper .select2-container--default .select2-selection--single .select2-selection__rendered {
          line-height: 28px !important;
          color: #1e293b !important;
          font-size: 13.5px !important;
      }
      .premium-modal-wrapper .select2-container--default .select2-selection--single .select2-selection__arrow {
          height: 36px !important;
          right: 8px !important;
      }
      .premium-modal-wrapper .modal-footer {
          background-color: #ffffff;
          padding: 16px 20px;
          border-top: 1px solid #e2e8f0;
          display: flex;
          justify-content: space-between;
          align-items: center;
      }
      .premium-modal-wrapper .btn-premium-secondary {
          background-color: #f1f5f9;
          color: #334155;
          border: 1px solid #cbd5e1;
          border-radius: 6px;
          padding: 8px 14px;
          font-size: 13px;
          font-weight: 500;
          transition: all 0.2s ease-in-out;
      }
      .premium-modal-wrapper .btn-premium-secondary:hover {
          background-color: #e2e8f0;
          color: #0f172a;
          border-color: #94a3b8;
      }
      .premium-modal-wrapper .btn-premium-success {
          background: linear-gradient(135deg, #10b981, #059669); /* Esmeralda */
          color: #ffffff;
          border: none;
          border-radius: 6px;
          padding: 8px 18px;
          font-size: 13.5px;
          font-weight: 600;
          box-shadow: 0 4px 6px -1px rgba(16, 185, 129, 0.2);
          transition: all 0.2s ease-in-out;
      }
      .premium-modal-wrapper .btn-premium-success:hover {
          background: linear-gradient(135deg, #059669, #047857);
          box-shadow: 0 6px 8px -1px rgba(16, 185, 129, 0.3);
          transform: translateY(-1px);
      }
  </style>

  <div class="premium-modal-wrapper">
    <div class="modal-header">
      <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
      <h3 class="modal-title">
         <i class="mdi mdi-plus-circle-o"></i><b>Registrar Sede</b>
      </h3>
    </div>
    
    <div class="modal-body">
      <div class="row regla-modal">
        <div class="col-md-12">
          
          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="form-group">
              <label class="control-label negrita">Sede (*):</label>
              <div>
                <input type="text"
                       id="ubicacion" name="ubicacion" value="" placeholder="Ingrese nombre de la sede..."
                       required=""
                       autocomplete="off" class="form-control input-premium" data-aw="1"/>
              </div>
            </div>
          </div>

          <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-top: 10px;">
            <div class="form-group">
              <label class="control-label negrita">Estado (*):</label>
              <div>
                <select name="estado" id="estado" class="form-control select3" style="width: 100%;" required>
                  <option value="1" selected>Activo</option>
                  <option value="0">Inactivo</option>
                </select>
              </div>
            </div>
          </div>

        </div>
      </div>
    </div>

    <div class="modal-footer">
      <button type="button" class="btn-premium-secondary btn-volver-grupo-modal"><i class="mdi mdi-arrow-left"></i> Volver</button>
      <div>
        <button type="button" data-dismiss="modal" class="btn-premium-secondary" style="margin-right: 8px;">Cancelar</button>
        <button type="submit" class="btn-premium-success">Guardar</button>
      </div>
    </div>
  </div>
</form>

<?php if(isset($ajax)): ?>
  <script type="text/javascript">
    $(document).ready(function(){
      $('.select3').select2({
          dropdownParent: $('#modal-configuracion-usuario-detalle')
      });
    });
  </script>
<?php endif; ?>
