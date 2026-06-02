<style>
    .btn-excel-premium {
        background: linear-gradient(135deg, #1d976c 0%, #11998e 100%);
        color: #ffffff;
        border: none;
        padding: 8px 18px;
        border-radius: 30px;
        font-weight: 600;
        font-size: 13px;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 8px rgba(17, 153, 142, 0.25);
        transition: all 0.3s ease;
        display: inline-flex;
        align-items: center;
    }
    .btn-excel-premium i {
        font-size: 18px;
        margin-right: 6px;
    }
    .btn-excel-premium:hover, .btn-excel-premium:focus {
        background: linear-gradient(135deg, #157956 0%, #0d7a71 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(17, 153, 142, 0.35);
        color: #ffffff;
        outline: none;
    }
    .btn-excel-premium:active {
        transform: translateY(1px);
        box-shadow: 0 2px 4px rgba(17, 153, 142, 0.2);
    }
</style>

<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #f5f5f5; border-bottom: 2px solid #34aadc; display: flex; justify-content: space-between; align-items: center;">
                <h4 style="font-weight: bold; margin: 0; display: flex; align-items: center; gap: 8px; color: #2c3e50;">
                    <i class="mdi mdi-check-circle" style="color: #27ae60; font-size: 22px;"></i> LISTA DE CONSOLIDADOS APROBADOS
                </h4>
                <button type="button" class="btn-excel-premium" id="btn-descargar-excel-masivo">
                    <i class="mdi mdi-file-excel"></i> DESCARGAR EXCEL MASIVO
                </button>
            </div>
            <div class="panel-body">
                <div class="container-lista-aprobados">
                    @include('ordenpedido.consolidadoap.ajax.listaconsolidadosaprobados_ajax')
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-detalle-consolidados-aprobado">
</div>
