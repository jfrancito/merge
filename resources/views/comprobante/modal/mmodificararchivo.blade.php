<div id="modal-modificar-archivo" class="modal-container colored-header colored-header-primary modal-effect-8">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><span class="mdi mdi-close"></span></button>
            <h3 class="modal-title">Modificar Archivo PDF</h3>
        </div>
        <form action="{{ url('/modificar-archivo-pdf/'.$idopcion.'/'.$linea.'/'.substr($ordencompra->COD_ORDEN, 0,6).'/'.Hashids::encode(substr($ordencompra->COD_ORDEN, -10))) }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <div class="modal-body">
                <div class="form-group">
                    <label>Tipo de Archivo:</label>
                    <input type="text" id="modal-descripcion-archivo" class="form-control" disabled>
                    <input type="hidden" name="tipo_archivo" id="modal-tipo-archivo">
                </div>
                <div class="form-group">
                    <label>Seleccionar nuevo PDF:</label>
                    <input type="file" name="archivo_pdf" id="archivo_pdf_input" class="form-control" accept="application/pdf" required>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
