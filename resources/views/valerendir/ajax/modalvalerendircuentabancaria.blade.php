<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background: #1d3a6d;color: #fff; ">DATOS PARA EMITIR VALE
            <span class="label label-success agregar_cuenta_bancaria select" 
                    style="cursor:pointer; font-size: 13px !important; float: right;">
                    Agregar Cuenta
              </span>
        </div>

      <div class="panel-body panel-body-contrast" id="form_cuenta" style="display:none;">
          <div class="container" style="margin-top:15px;">
                  <div class="row mt-4">
                      <div class="col-md-3 col-lg-2">
                          <label for="tipo_pago" class="form-label fw-bold">Tipo de Pago :</label>
                          {!! Form::select('tipo_pago', $listausuarios5, '',
                                 [
                                   'class'       => 'form-select select2',
                                   'id'          => 'tipo_pago',
                                   'data-aw'     => '1',
                                 ])
                          !!}
                      </div>
                    <div class="col-md-4 col-lg-3" id="grupo_entidad">
                        <label class="form-label fw-bold">Entidad Financiera :</label>
                        <input type="text" 
                               name="txt_categoria_banco" 
                               id="txt_categoria_banco"
                               value="{{ $txt_categoria_banco }}" 
                               data-valor="{{ $txt_categoria_banco }}"
                               class="form-control bg-light" readonly>
                    </div>

                    <div class="col-md-4 col-lg-3" id="grupo_cuenta">
                        <label class="form-label fw-bold">Cuenta Bancaria :</label>
                        <input type="text" 
                               name="numero_cuenta" 
                               id="numero_cuenta"
                               value="{{ $numero_cuenta }}" 
                               data-valor="{{ $numero_cuenta }}"
                               class="form-control bg-light" readonly>
                    </div>


                      <div class="col-md-4 col-lg-3">
                          <label for="txt_glosa" class="form-label fw-bold">Glosa :</label>
                          <textarea id="txt_glosa" name="glosa" placeholder="Glosa" required
                                    class="form-control" rows="2"></textarea>
                      </div>
                  </div>
          </div>

          <div class="row xs-pt-15 mt-3" style="margin-bottom: 15px;">
              <div class="col-xs-6"></div>
              <div class="col-xs-6 text-right">
                   <button id="asignarvalerendir" type="button" class="btn btn-primary">
                       EMITIR VALE
                   </button>
              </div>
          </div>
      </div>
    </div>


<script>
  $(document).ready(function() {

     
      $(".agregar_cuenta_bancaria").on("click", function() {
          $("#form_cuenta").slideToggle("fast");

          if ($(this).text().trim() === "Agregar Cuenta") {
              $(this).text("Ocultar");
          } else {
              $(this).text("Agregar Cuenta");
          }
      });

      function toggleCamposPago() {
          var tipo = $("#tipo_pago").val();

          if (tipo == "0") { // EFECTIVO
              $("#grupo_entidad, #grupo_cuenta").hide();

              // limpiar campos
              $("input[name='txt_categoria_banco']").val('');
              $("input[name='numero_cuenta']").val('');
          } 
          else if (tipo == "1") { // TRANSFERENCIA
              $("#grupo_entidad, #grupo_cuenta").show();

              // restaurar valores originales solo si están vacíos
              if ($("input[name='txt_categoria_banco']").val() === '') {
                  $("input[name='txt_categoria_banco']").val(
                      $("input[name='txt_categoria_banco']").data("valor")
                  );
              }
              if ($("input[name='numero_cuenta']").val() === '') {
                  $("input[name='numero_cuenta']").val(
                      $("input[name='numero_cuenta']").data("valor")
                  );
              }
          } 
          else {
              $("#grupo_entidad, #grupo_cuenta").hide();
          }
      }

      
      toggleCamposPago();

     
      $("#tipo_pago").on("change", function() {
          toggleCamposPago();
      });

  });
</script>
