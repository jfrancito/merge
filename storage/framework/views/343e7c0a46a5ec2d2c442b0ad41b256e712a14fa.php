<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color: #f5f5f5; border-bottom: 2px solid #34aadc;">
                <h4 style="font-weight: bold; margin: 0;">
                    <i class="mdi mdi-check-circle"></i> LISTA DE CONSOLIDADOS APROBADOS
                </h4>
            </div>
            <div class="panel-body">
                <div class="container-lista-aprobados">
                    <?php echo $__env->make('ordenpedido.consolidadoap.ajax.listaconsolidadosaprobados_ajax', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-detalle-consolidados-aprobado">
</div>
