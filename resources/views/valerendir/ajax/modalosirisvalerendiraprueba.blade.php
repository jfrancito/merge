<div class="modal-header" style="padding: 12px 20px;">
    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
    <div class="col-xs-12">
        <h5 class="modal-title" style="font-size: 1.2em; font-family: 'Times New Roman', serif;">
            <b>SOLICITUD VALE A RENDIR</b>
        </h5>
    </div>
</div>
<div class="modal-body">
    <div class="scroll_text scroll_text_heigth_aler"> 
        <form id="aprobarForm">
            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="cuenta_id" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Serie</label>
                 {{--  <select name="cuenta_id" id="cuenta_id" class="select2 form-control input-custom" required data-aw="1">
                        <option value="" disabled selected>Seleccione Serie</option>
                        @foreach($combo_series as $key => $value)
                            <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
                    </select>--}} 
                 {{--   <input type="text" id="cuenta_id" name="cuenta_id" class="form-control input-custom"
                        value="{{ reset($combo_series) }}" readonly>--}} 

                        <input type="text" id="cuenta_id" name="cuenta_id" class="form-control input-custom"
                        value="{{ is_array($combo_series) ? reset($combo_series) : '' }}" readonly>

                </div>

                 <div class="form-group col-md-6">
                    <label for="numeroVale" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Número</label>
                    <input type="text" class="form-control input-custom" id="nrodoc" name="nrodoc" 
                        value="{{ $nro_documento_formateado }}" readonly>
                </div>
            </div>   

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control input-custom" 
                        value="{{ $fecha_actual }}" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="estado" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Estado</label>
                    <input type="text" id="estado" name="estado" class="form-control input-custom" 
                        value="{{ $estado }}" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="cliente" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Cliente</label>
                <input type="text" id="cliente" name="cliente" class="form-control input-custom"
                    value="{{$txtNombreCliente}}" readonly>
            </div>

             @php
                reset($contrato_diferente); 
                $codigoContrato = key($contrato_diferente); 
                $textoContrato = current($contrato_diferente); 
            @endphp

            <div class="form-group">
                <label for="cuenta" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Cuenta</label>

                {{-- Visible para el usuario --}}
                <input type="text" class="form-control input-custom"
                       value="{{ $textoContrato }}" readonly>

                {{-- Enviado al backend --}}
                <input type="hidden" id="cuenta_id_contrato" name="cuenta_id_contrato"
                       value="{{ $codigoContrato }}">
            </div>
            

            <div class="form-group">
                <label for="cuenta" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Sub-Cuenta</label>
                <input type="text" id="cuenta_id_subcuenta" name="cuenta_id_subcuenta" class="form-control input-custom"
                        value="{{ reset($subcuentas) }}" readonly>
            </div>

            <div class="form-group">
                <label for="glosaRegistrada" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Glosa Autoriza</label>
                <textarea id="glosaRegistrada" name="glosaRegistrada" class="form-control input-custom" 
                    rows="2" readonly>{{ $glosaCliente }}</textarea>
            </div>

         {{--  <div class="form-group">
                <label style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Tipo de Pago</label>
                <div class="custom-radio-group">
                    <label style="font-family: 'Times New Roman', serif; color: #708090; font-size: 13px;"><input type="radio" name="tipo_pago" id="radioEfectivo" value="efectivo"> Efectivo</label>
                    <label style="font-family: 'Times New Roman', serif; color: #708090; font-size: 13px;"> <input type="radio" name="tipo_pago" id="radioCaja" value="caja"> Transferencia</label>
                   
                </div>
            </div> 

            @php
                $moneda = $cod_moneda === 'MON0000000000001';
                $valorNomBanco = $moneda ? $nombreBanco : '';
                $valorNumBanco = $moneda ? $numeroBanco : '';
            @endphp

          <div id="selectContainer" class="form-row" style="display: none;">
                <div class="form-group col-md-6">
                    <label for="nomBanco" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Entidad Bancaria</label>
                    <input type="text" id="nomBanco" name="nomBanco" class="form-control input-custom" 
                        value="{{ $valorNomBanco }}"  data-nombanco="{{$valorNomBanco}}" autocomplete="off" @if($moneda) readonly @endif>
                </div>
                <div class="form-group col-md-6">
                    <label for="numBanco" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Cuenta Bancaria</label>
                    <input type="text" id="numBanco" name="numBanco" class="form-control input-custom"
                         value="{{ $valorNumBanco }}"  maxlength="20"  data-numbanco="{{$valorNumBanco}}" autocomplete="off" @if($moneda) readonly @endif>
                </div>
            </div>  --}}
 
            <div class="form-group">
                <label for="glosa" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Glosa</label>
                <textarea id="glosa" name="glosa" class="form-control input-custom" rows="2"
                    placeholder="Glosa"></textarea>
            </div>

        </form>
    </div>
</div>

<div class="modal-footer">
    <button type="button" data-dismiss="modal" class="btn btn-success btn-space"  id="aprobarvalerendir" >Guardar</button> 
</div>


<style>
    .scroll_text_heigth_aler {
        max-height: 400px;
        overflow-y: auto;
    }
    .input-custom {
        border-radius: 8px;
        border: 1px solid #ced4da;
        padding: 8px;
        font-size: 14px;
        font-family: 'Times New Roman', serif;
    }
    .form-control:focus {
        border-color: #007bff;
        box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
    }
    .custom-radio-group {
        display: flex;
        gap: 15px;
    }
    .custom-radio-group label {
        font-family: 'Times New Roman', serif;
        font-weight: bold;
    }

</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var today = new Date();
        var day = today.getDate().toString().padStart(2, '0'); 
        var month = (today.getMonth() + 1).toString().padStart(2, '0'); 
        var year = today.getFullYear();
        var dateString = year + '-' + month + '-' + day;

        var fechaInput = document.getElementById('fecha');
        fechaInput.value = dateString;
      
    });
</script>
{{--
<script>
  document.getElementById('numBanco').addEventListener('keypress', function (e) {
    if (!/[0-9]/.test(e.key)) {
      e.preventDefault();
    }
  });
</script>--}}







