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
                    
                        <div class="col-md-3 col-lg-3">
                          <div class="form-group">
                            <label for="tipo_pago" class="control-label labelleft negrita">
                              TIPO DE PAGO <span class="obligatorio">(*)</span> :
                            </label>
                            {!! Form::select('tipo_pago', $listausuarios5, '',
                              [
                                'class' => 'form-select select2',
                                'id' => 'tipo_pago',
                                'data-aw' => '1',
                                'style' => 'width:100%;'
                              ])
                            !!}
                          </div>
                        </div>

                    <div class="col-md-4 col-lg-3" id="grupo_entidad">
                        <label class="form-label fw-bold labelleft negrita">
                                        ENTIDAD FINANCIERA <span class="obligatorio">(*)</span> :
                         </label>
                        <input type="text" 
                               name="txt_categoria_banco" 
                               id="txt_categoria_banco"
                               value="{{ $txt_categoria_banco }}" 
                               data-valor="{{ $txt_categoria_banco }}"
                               class="form-control bg-light" readonly
                               autocomplete="off">
                    </div>

                    <div class="col-md-4 col-lg-3" id="grupo_cuenta">
                       <label class="form-label fw-bold labelleft negrita">
                                        CUENTA BANCARIA <span class="obligatorio">(*)</span> :
                         </label>
                        <input type="text" 
                               name="numero_cuenta" 
                               id="numero_cuenta"
                               value="{{ $numero_cuenta }}" 
                               data-valor="{{ $numero_cuenta }}"
                               class="form-control bg-light" readonly
                               autocomplete="off"
                               pattern="[0-9]*">
                    </div>


                    <div class="col-md-4 col-lg-3">
                      <label for="txt_glosa" class="form-label fw-bold labelleft negrita">OBJETIVO Y ACTIVIDADES A REALIZAR <span class="obligatorio">(*)</span>:</label>
                            <textarea id="txt_glosa" name="glosa" placeholder="Objetivo y Actividades a Realizar" required
                                      class="form-control w-100" rows="4"></textarea>
                   </div>
                  </div>
          </div>

      {{-- <div class="row xs-pt-15 mt-3" style="margin-bottom: 15px;">
              <div class="col-xs-6"></div>
              <div class="col-xs-6 text-right">
                   <button id="asignarvalerendir" type="button" class="btn btn-primary">
                       EMITIR VALE
                   </button>
              </div>
          </div> --}}
      </div>
    </div>


<script>
$(document).ready(function() {

    $(".agregar_cuenta_bancaria").on("click", function() {
        $("#form_cuenta").slideToggle("fast");
        $(this).text($(this).text().trim() === "Agregar Cuenta" ? "Ocultar" : "Agregar Cuenta");
    });

    function toggleCamposPago() {
        var tipo = $("#tipo_pago").val();
        var codMoneda = ($("#cod_moneda").val() || "").trim().toUpperCase();

        if (tipo == "0") { // EFECTIVO
            $("#grupo_entidad, #grupo_cuenta").hide();
            $("#txt_categoria_banco, #numero_cuenta").val('');
        } 
        else if (tipo == "1") { // TRANSFERENCIA
            $("#grupo_entidad, #grupo_cuenta").show();

            // 💵 Si la moneda es DÓLARES, los campos deben estar vacíos y editables
            if (codMoneda === "MON0000000000002") {
                $("#txt_categoria_banco, #numero_cuenta")
                    .val('')
                    .prop("readonly", false)
                    .removeClass("bg-light");
            } 
            else { // 💰 Si es SOLES u otra
                $("#txt_categoria_banco").val($("#txt_categoria_banco").data("valor"));
                $("#numero_cuenta").val($("#numero_cuenta").data("valor"));

                $("#txt_categoria_banco, #numero_cuenta")
                    .prop("readonly", true)
                    .addClass("bg-light");
            }
        } 
        else {
            $("#grupo_entidad, #grupo_cuenta").hide();
        }
    }

    function toggleCamposMoneda() {
        var codMoneda = ($("#cod_moneda").val() || "").trim().toUpperCase();
        var tipo = $("#tipo_pago").val();

        // Solo aplica si está seleccionada "Transferencia"
        if (tipo == "1") {
            if (codMoneda === "MON0000000000002") {
                $("#txt_categoria_banco, #numero_cuenta")
                    .val('')
                    .prop("readonly", false)
                    .removeClass("bg-light");
            } 
            else if (codMoneda === "MON0000000000001") {
                $("#txt_categoria_banco").val($("#txt_categoria_banco").data("valor"));
                $("#numero_cuenta").val($("#numero_cuenta").data("valor"));

                $("#txt_categoria_banco, #numero_cuenta")
                    .prop("readonly", true)
                    .addClass("bg-light");
            }
        }
    }

    $("#numero_cuenta").on("input", function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    toggleCamposPago();
    toggleCamposMoneda();

    // Eventos
    $("#tipo_pago").on("change", function() {
        toggleCamposPago();
        toggleCamposMoneda(); // <-- asegura coherencia
    });

    $('#cod_moneda').on('select2:select', function () {
        toggleCamposMoneda();
    });
});
</script>


