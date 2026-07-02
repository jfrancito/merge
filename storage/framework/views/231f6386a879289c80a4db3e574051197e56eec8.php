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
                  
                  

                        <input type="text" id="cuenta_id" name="cuenta_id" class="form-control input-custom"
                        value="<?php echo e(is_array($combo_series) ? reset($combo_series) : ''); ?>" readonly>

                </div>

                 <div class="form-group col-md-6">
                    <label for="numeroVale" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Número</label>
                    <input type="text" class="form-control input-custom" id="nrodoc" name="nrodoc" 
                        value="<?php echo e($nro_documento_formateado); ?>" readonly>
                </div>
            </div>   

            <div class="form-row">
                <div class="form-group col-md-6">
                    <label for="fecha" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Fecha</label>
                    <input type="date" id="fecha" name="fecha" class="form-control input-custom" 
                        value="<?php echo e($fecha_actual); ?>" readonly>
                </div>
                <div class="form-group col-md-6">
                    <label for="estado" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Estado</label>
                    <input type="text" id="estado" name="estado" class="form-control input-custom" 
                        value="<?php echo e($estado); ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label for="cliente" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Cliente</label>
                <input type="text" id="cliente" name="cliente" class="form-control input-custom"
                    value="<?php echo e($txtNombreCliente); ?>" readonly>
            </div>

             <?php 
                reset($contrato_diferente); 
                $codigoContrato = key($contrato_diferente); 
                $textoContrato = current($contrato_diferente); 
             ?>

            <div class="form-group">
                <label for="cuenta" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Cuenta</label>

                
                <input type="text" class="form-control input-custom"
                       value="<?php echo e($textoContrato); ?>" readonly>

                
                <input type="hidden" id="cuenta_id_contrato" name="cuenta_id_contrato"
                       value="<?php echo e($codigoContrato); ?>">
            </div>
            

            <div class="form-group">
                <label for="cuenta" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Sub-Cuenta</label>
                <input type="text" id="cuenta_id_subcuenta" name="cuenta_id_subcuenta" class="form-control input-custom"
                        value="<?php echo e(reset($subcuentas)); ?>" readonly>
            </div>

            <div class="form-group">
                <label for="glosaRegistrada" style="font-family: 'Times New Roman', serif; color: #1E90FF; font-size: 15px;">* Glosa Autoriza</label>
                <textarea id="glosaRegistrada" name="glosaRegistrada" class="form-control input-custom" 
                    rows="2" readonly><?php echo e($glosaCliente); ?></textarea>
            </div>

         
 
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








