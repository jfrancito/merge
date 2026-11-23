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
    }
    .premium-modal-wrapper .modal-close,
    .premium-modal-wrapper .btn-close-submodal {
        color: #ffffff !important;
        opacity: 0.95 !important;
        text-shadow: none !important;
        font-size: 20px !important;
        position: absolute;
        right: 18px;
        top: 16px;
        background: transparent !important;
        border: none !important;
        outline: none !important;
        transition: all 0.2s ease-in-out;
    }
    .premium-modal-wrapper .modal-close:hover,
    .premium-modal-wrapper .btn-close-submodal:hover {
        color: #ffffff !important;
        opacity: 1 !important;
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
    
    /* Estilos de tamaño exacto para el modal */
    #modal-configuracion-usuario-detalle {
        width: 600px !important;
        max-width: 95% !important;
        height: auto !important;
        top: 50% !important;
        left: 50% !important;
        transform: translate(-50%, -50%) !important;
    }
    #modal-configuracion-usuario-detalle .modal-content {
        border-radius: 8px !important;
        overflow: hidden !important;
        background-color: #f8fafc !important;
        border: none !important;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04) !important;
    }
    #modal-configuracion-usuario-detalle .modal-body {
        max-height: 400px !important;
        overflow-y: auto !important;
    }
    
    #grupo, #nueva_clasificacion_nombre, #nueva_sede_nombre {
        text-transform: uppercase;
    }

    /* Mensajes de error inline bajo el campo */
    .field-error-msg {
        display: none;
        margin-top: 5px;
        position: relative;
        background: #fff5f5;
        border: 1px solid #fca5a5;
        border-radius: 6px;
        padding: 7px 11px 7px 11px;
        font-size: 12.5px;
        color: #b91c1c;
        font-weight: 500;
        line-height: 1.4;
        animation: errorMsgIn 0.2s ease;
    }
    .field-error-msg::before {
        content: '';
        position: absolute;
        top: -7px;
        left: 14px;
        border-left: 7px solid transparent;
        border-right: 7px solid transparent;
        border-bottom: 7px solid #fca5a5;
    }
    .field-error-msg::after {
        content: '';
        position: absolute;
        top: -6px;
        left: 15px;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-bottom: 6px solid #fff5f5;
    }
    .field-error-msg i {
        margin-right: 5px;
        font-size: 13px;
    }
    @keyframes errorMsgIn {
        from { opacity: 0; transform: translateY(-4px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .input-error-highlight {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
    }
    .select2-error .select2-selection {
        border-color: #ef4444 !important;
        box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.15) !important;
    }

</style>

<div class="premium-modal-wrapper">
    <!-- Screen 1: Datos de la Actividad -->
    <div id="div-principal-actividad">
      <form method="POST" action="{{ url('/configurar-grupo-marketing/'.$orden_id.'/'.$idopcion) }}" id="form-configurar-grupo-mkt" novalidate>
          {{ csrf_field() }}
          <input type="hidden" name="device_info" id='device_info'>

          <div class="modal-header">
              <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
              <h3 class="modal-title">
                   <b>Datos de la Actividad</b>
              </h3>
          </div>
          <div class="modal-body">
              <div class="row regla-modal">
                  <div class="col-md-12">

                      <div class="form-group">
                          <label class="control-label">Actividad (*)</label>
                          <input type="text" id="grupo" name='grupo' value="" placeholder="Nombre de la actividad..." autocomplete="off" class="input-premium" />
                          <span class="field-error-msg" id="error-grupo"><i class="mdi mdi-alert-circle-o"></i> Por favor, ingrese el nombre de la Actividad.</span>
                      </div>

                      <div class="form-group">
                          <label class="control-label">Clasificación (*)</label>
                          {!! Form::select('catcontaorden_id', ['' => 'Seleccione Clasificación'] + $clasificaciones, null, [
                              'class' => 'select3 form-control input-premium',
                              'id' => 'catcontaorden_id'
                          ]) !!}
                          <span class="field-error-msg" id="error-catcontaorden"><i class="mdi mdi-alert-circle-o"></i> Por favor, seleccione una Clasificación.</span>
                      </div>

                      <div class="form-group">
                          <label class="control-label">Sede (*)</label>
                          {!! Form::select('ubicacioncontaorden_id', ['' => 'Seleccione Sede'] + $sedes, null, [
                              'class' => 'select3 form-control input-premium',
                              'id' => 'ubicacioncontaorden_id'
                          ]) !!}
                          <span class="field-error-msg" id="error-ubicacioncontaorden"><i class="mdi mdi-alert-circle-o"></i> Por favor, seleccione una Sede.</span>
                      </div>

                  </div>
              </div>
          </div>

          <div class="modal-footer">
              <div>
                  <button type="button" class="btn-premium-secondary" id="btn-abrir-clasificacion" style="margin-right: 5px;">
                      <i class="icon mdi mdi-plus-circle-o"></i> Clasificación
                  </button>
                  <button type="button" class="btn-premium-secondary" id="btn-abrir-sede">
                      <i class="icon mdi mdi-plus-circle-o"></i> Sede
                  </button>
              </div>
              <button type="submit" class="btn-premium-success btn-guardar-configuracion-cb">Guardar</button>
          </div>
      </form>
    </div>

    <!-- Screen 2: Registrar Clasificación -->
    <div id="div-registrar-clasificacion" style="display: none;">
      <div class="modal-header">
          <button type="button" class="close btn-close-submodal"><span class="mdi mdi-close"></span></button>
          <h3 class="modal-title">
               <b><span class="mdi mdi-plus-circle-o"></span> Registrar Clasificación</b>
          </h3>
      </div>
      <div class="modal-body">
          <div class="row regla-modal">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="control-label">Nombre de la Clasificación (*):</label>
                      <input type="text" id="nueva_clasificacion_nombre" class="input-premium" placeholder="Ingrese nombre de la clasificación...">
                       <span class="field-error-msg" id="error-nueva-clasificacion"><i class="mdi mdi-alert-circle-o"></i> Por favor, ingrese el nombre de la Clasificación.</span>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Estado (*):</label>
                      <select id="nueva_clasificacion_estado" class="input-premium">
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                      </select>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn-premium-secondary btn-volver-actividad">
              <i class="icon mdi mdi-arrow-left"></i> Volver
          </button>
          <div>
              <button type="button" class="btn-premium-secondary btn-volver-actividad" style="margin-right: 5px;">Cancelar</button>
              <button type="button" class="btn-premium-success" id="btn-guardar-clasificacion-ajax">Guardar</button>
          </div>
      </div>
    </div>

    <!-- Screen 3: Registrar Sede -->
    <div id="div-registrar-sede" style="display: none;">
      <div class="modal-header">
          <button type="button" class="close btn-close-submodal"><span class="mdi mdi-close"></span></button>
          <h3 class="modal-title">
               <b><span class="mdi mdi-plus-circle-o"></span> Registrar Sede</b>
          </h3>
      </div>
      <div class="modal-body">
          <div class="row regla-modal">
              <div class="col-md-12">
                  <div class="form-group">
                      <label class="control-label">Sede (*):</label>
                      <input type="text" id="nueva_sede_nombre" class="input-premium" placeholder="Ingrese nombre de la sede...">
                       <span class="field-error-msg" id="error-nueva-sede"><i class="mdi mdi-alert-circle-o"></i> Por favor, ingrese el nombre de la Sede.</span>
                  </div>
                  <div class="form-group">
                      <label class="control-label">Estado (*):</label>
                      <select id="nueva_sede_estado" class="input-premium">
                          <option value="1">Activo</option>
                          <option value="0">Inactivo</option>
                      </select>
                  </div>
              </div>
          </div>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn-premium-secondary btn-volver-actividad">
              <i class="icon mdi mdi-arrow-left"></i> Volver
          </button>
          <div>
              <button type="button" class="btn-premium-secondary btn-volver-actividad" style="margin-right: 5px;">Cancelar</button>
              <button type="button" class="btn-premium-success" id="btn-guardar-sede-ajax">Guardar</button>
          </div>
      </div>
    </div>
</div>

@if(isset($ajax))
  <script type="text/javascript">
    $(document).ready(function(){
      $('.select3').select2({
          dropdownParent: $('#modal-configuracion-usuario-detalle')
      });
      $('.importe').inputmask({ 
          'alias': 'numeric', 
          'groupSeparator': ',', 
          'autoGroup': true, 
          'digits': 0, 
          'digitsOptional': false, 
          'prefix': '', 
          'placeholder': '0'
      });

      // Helper: mostrar error inline bajo el campo
      function mostrarErrorCampo(spanId, inputSel) {
          $('.field-error-msg').hide();
          $('.input-error-highlight').removeClass('input-error-highlight');
          $('#' + spanId).show();
          if (inputSel) {
              $(inputSel).addClass('input-error-highlight');
          }
          setTimeout(function() { $('#' + spanId).fadeOut(300); }, 4000);
      }
      function limpiarErrorCampo(spanId, inputSel) {
          $('#' + spanId).hide();
          if (inputSel) $(inputSel).removeClass('input-error-highlight');
      }

      // Validación formulario principal Datos de la Actividad
      $('#form-configurar-grupo-mkt').on('submit', function(e) {
          var actividad     = $.trim($('#grupo').val());
          var clasificacion = $('#catcontaorden_id').val();
          var sede          = $('#ubicacioncontaorden_id').val();

          $('.field-error-msg').hide();
          $('.input-error-highlight').removeClass('input-error-highlight');

          if (!actividad) {
              e.preventDefault();
              mostrarErrorCampo('error-grupo', '#grupo');
              $('#grupo').focus();
              return false;
          }
          if (!clasificacion) {
              e.preventDefault();
              mostrarErrorCampo('error-catcontaorden', null);
              $('#catcontaorden_id').next('.select2-container').find('.select2-selection').addClass('input-error-highlight');
              return false;
          }
          if (!sede) {
              e.preventDefault();
              mostrarErrorCampo('error-ubicacioncontaorden', null);
              $('#ubicacioncontaorden_id').next('.select2-container').find('.select2-selection').addClass('input-error-highlight');
              return false;
          }
          return true;
      });

      // Limpiar errores al editar campos
      $('#grupo').on('input', function() { limpiarErrorCampo('error-grupo', '#grupo'); });
      $('#catcontaorden_id').on('change', function() {
          limpiarErrorCampo('error-catcontaorden', null);
          $('#catcontaorden_id').next('.select2-container').find('.select2-selection').removeClass('input-error-highlight');
      });
      $('#ubicacioncontaorden_id').on('change', function() {
          limpiarErrorCampo('error-ubicacioncontaorden', null);
          $('#ubicacioncontaorden_id').next('.select2-container').find('.select2-selection').removeClass('input-error-highlight');
      });

      // Swap to Clasificación
      $('#btn-abrir-clasificacion').on('click', function(e) {
          e.preventDefault();
          $('.field-error-msg').hide();
          $('.input-error-highlight').removeClass('input-error-highlight');
          $('#nueva_clasificacion_nombre').val('');
          $('#nueva_clasificacion_estado').val('1');
          $('#div-principal-actividad').hide();
          $('#div-registrar-clasificacion').show();
          $('#modal-configuracion-usuario-detalle').css('width', '450px');
          $('#modal-configuracion-usuario-detalle .modal-body').css('max-height', '350px');
          setTimeout(function() { $('#nueva_clasificacion_nombre').focus(); }, 150);
      });

      // Swap to Sede
      $('#btn-abrir-sede').on('click', function(e) {
          e.preventDefault();
          $('.field-error-msg').hide();
          $('.input-error-highlight').removeClass('input-error-highlight');
          $('#nueva_sede_nombre').val('');
          $('#nueva_sede_estado').val('1');
          $('#div-principal-actividad').hide();
          $('#div-registrar-sede').show();
          $('#modal-configuracion-usuario-detalle').css('width', '450px');
          $('#modal-configuracion-usuario-detalle .modal-body').css('max-height', '350px');
          setTimeout(function() { $('#nueva_sede_nombre').focus(); }, 150);
      });

      // Volver al principal
      $('.btn-volver-actividad').on('click', function(e) {
          e.preventDefault();
          $('.field-error-msg').hide();
          $('.input-error-highlight').removeClass('input-error-highlight');
          $('#div-registrar-clasificacion').hide();
          $('#div-registrar-sede').hide();
          $('#div-principal-actividad').show();
          $('#modal-configuracion-usuario-detalle').css('width', '600px');
          $('#modal-configuracion-usuario-detalle .modal-body').css('max-height', '400px');
      });

      // Cerrar modal desde sub-modal
      $('.btn-close-submodal').on('click', function(e) {
          e.preventDefault();
          $('.modal-close').first().trigger('click');
      });

      // Guardar Clasificación via AJAX
      $('#btn-guardar-clasificacion-ajax').on('click', function(e) {
          e.preventDefault();
          var nombre = $.trim($('#nueva_clasificacion_nombre').val());
          var estado = $('#nueva_clasificacion_estado').val();
          var _token = $('input[name="_token"]').val();

          if (!nombre) {
              mostrarErrorCampo('error-nueva-clasificacion', '#nueva_clasificacion_nombre');
              $('#nueva_clasificacion_nombre').focus();
              return;
          }

          var $btn = $(this);
          $btn.prop('disabled', true);

          $.ajax({
              type: "POST",
              url: "{{ url('/ajax-guardar-clasificacion') }}",
              data: { nombre: nombre, estado: estado, _token: _token },
              success: function(response) {
                  $btn.prop('disabled', false);
                  if (response.success) {
                      var select = $('#catcontaorden_id');
                      select.empty();
                      select.append('<option value="">Seleccione Clasificación</option>');
                      $.each(response.list, function(index, item) {
                          select.append('<option value="' + item.id + '">' + item.nombre + '</option>');
                      });
                      select.val('').trigger('change');
                      $('#nueva_clasificacion_nombre').val('');
                      $('#error-nueva-clasificacion').hide();
                      $('#div-registrar-clasificacion').hide();
                      $('#div-principal-actividad').show();
                      $('#modal-configuracion-usuario-detalle').css('width', '600px');
                      $('#modal-configuracion-usuario-detalle .modal-body').css('max-height', '400px');
                  } else {
                      alert('Ocurrió un error al registrar la clasificación.');
                  }
              },
              error: function() {
                  $btn.prop('disabled', false);
                  alert('Error al conectar con el servidor.');
              }
          });
      });

      $('#nueva_clasificacion_nombre').on('input', function() {
          limpiarErrorCampo('error-nueva-clasificacion', '#nueva_clasificacion_nombre');
      });

      // Guardar Sede via AJAX
      $('#btn-guardar-sede-ajax').on('click', function(e) {
          e.preventDefault();
          var ubicacion = $.trim($('#nueva_sede_nombre').val());
          var estado = $('#nueva_sede_estado').val();
          var _token = $('input[name="_token"]').val();

          if (!ubicacion) {
              mostrarErrorCampo('error-nueva-sede', '#nueva_sede_nombre');
              $('#nueva_sede_nombre').focus();
              return;
          }

          var $btn = $(this);
          $btn.prop('disabled', true);

          $.ajax({
              type: "POST",
              url: "{{ url('/ajax-guardar-sede') }}",
              data: { ubicacion: ubicacion, estado: estado, _token: _token },
              success: function(response) {
                  $btn.prop('disabled', false);
                  if (response.success) {
                      var select = $('#ubicacioncontaorden_id');
                      select.empty();
                      select.append('<option value="">Seleccione Sede</option>');
                      $.each(response.list, function(index, item) {
                          select.append('<option value="' + item.id + '">' + item.ubicacion + '</option>');
                      });
                      select.val('').trigger('change');
                      $('#nueva_sede_nombre').val('');
                      $('#error-nueva-sede').hide();
                      $('#div-registrar-sede').hide();
                      $('#div-principal-actividad').show();
                      $('#modal-configuracion-usuario-detalle').css('width', '600px');
                      $('#modal-configuracion-usuario-detalle .modal-body').css('max-height', '400px');
                  } else {
                      alert('Ocurrió un error al registrar la sede.');
                  }
              },
              error: function() {
                  $btn.prop('disabled', false);
                  alert('Error al conectar con el servidor.');
              }
          });
      });

      $('#nueva_sede_nombre').on('input', function() {
          limpiarErrorCampo('error-nueva-sede', '#nueva_sede_nombre');
      });

      $('.cuentanumero').on('paste', function (e) {
          var pasteData = e.originalEvent.clipboardData.getData('text');
          if (!/^\d+$/.test(pasteData)) {
              e.preventDefault();
          }
      });

      // Forzar mayúsculas en inputs
      $('#grupo, #nueva_clasificacion_nombre, #nueva_sede_nombre').on('input', function() {
          this.value = this.value.toUpperCase();
      });
    });
  </script>
@endif
