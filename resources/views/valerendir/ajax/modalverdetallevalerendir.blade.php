<div class="modal-header" style="padding: 12px 10px; font-family: 'Times New Roman', serif;">
    <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close">
        <span class="mdi mdi-close"></span>
    </button>
    <div class="col-xs-12">
        <h5 class="modal-title" style="font-size: 1.4em; font-family: 'Times New Roman', serif; font-weight: bold; text-align: center;">
            DETALLE VALE A RENDIR
        </h5>
    </div>
</div>

<div class="modal-body">
    <div class="scroll_text scroll_text_heigth_aler">
        <form id="aprobarForm">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>ID MERGE:</strong></div>
                    <div class="col-sm-8">{{ $id }}</div>
                </div>
                 <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>ID OSIRIS:</strong></div>
                    <div class="col-sm-8">{{ $id_osiris }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>SERIE - NÚMERO:</strong></div>
                    <div class="col-sm-8">{{ $txt_serie }} - {{ $txt_numero }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>FECHA:</strong></div>
                    <div class="col-sm-8">{{ \Carbon\Carbon::parse($fec_autorizacion)->format('d/m/Y') }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>ESTADO:</strong></div>
                    <div class="col-sm-8">{{ $txt_estado }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>CLIENTE:</strong></div>
                    <div class="col-sm-8">{{ $txt_empresa }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>CUENTA:</strong></div>
                    <div class="col-sm-8">{{ $contrato_descripcion }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>SUB CUENTA:</strong></div>
                    <div class="col-sm-8">{{ $sub_cuenta }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>MONEDA:</strong></div>
                    <div class="col-sm-8">
                        @if($cod_moneda === 'MON0000000000001')
                            SOLES
                        @else
                            DÓLARES
                        @endif
                    </div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>TIPO PAGO:</strong></div>
                    <div class="col-sm-8">
                        {{ $tipo_pago == 1 ? 'CAJA' : 'EFECTIVO' }}
                    </div>
                </div>
                @if ($tipo_pago == 1)
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>BANCO:</strong></div>
                    <div class="col-sm-8">{{ $NomBanco }}</div>
                </div>
                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>NRO CUENTA:</strong></div>
                    <div class="col-sm-8">{{ $NumBanco }}</div>
                </div>
                @endif

                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>GLOSA JEFE AUTORIZA:</strong></div>
                    <div class="col-sm-8">{{ $txt_glosa_autorizado }}</div>
                </div>

                <div class="row mb-2">
                    <div class="col-sm-4" style="font-weight: bold;"><strong>GLOSA ADMINISTRACIÓN:</strong></div>
                    <div class="col-sm-8">{{ $txt_glosa_aprobado }}</div>
                </div>
            </div>
        </form>
    </div>
</div>

<div class="modal-footer" style="font-family: 'Times New Roman', serif;">
    <button type="button" data-dismiss="modal" class="btn btn-default btn-space modal-close" style="font-family: 'Times New Roman', serif;">Cerrar</button>
</div>

<style>
    .scroll_text_heigth_aler {
        max-height: 250px;
        overflow-y: auto;
    }

    .modal-body {
        font-family: 'Times New Roman', serif;
        font-size: 1em;
    }

    .row.mb-2 {
        margin-bottom: 1rem;
    }

    .col-sm-4 {
        font-weight: bold;
    }

    .col-sm-8 {
        font-size: 1.1em;
    }

    .modal-footer button {
        font-family: 'Times New Roman', serif;
        font-size: 1.1em;
    }

    .modal-header h5 {
        font-size: 1.4em;
        font-weight: bold;
        text-align: center;
    }
</style>
