<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            <?php if($todos === '' or $todos === 'C'): ?>
                <li class="active negrita"><a href="#ccobrar" data-toggle="tab">Cuentas por Cobrar Terceros</a></li>
                <li class="negrita"><a href="#ccobrarrel" data-toggle="tab">Cuentas por Cobrar Relacionadas</a></li>
                <li class="negrita"><a href="#ccobrardudosa" data-toggle="tab">Cuentas por Cobrar Terceros Dudosa</a></li>
                <li class="negrita"><a href="#ccobrarriojaacopio" data-toggle="tab">Cuentas por Cobrar Terceros Rioja Acopio</a></li>
                <li class="negrita"><a href="#ccobrarbellavistaacopio" data-toggle="tab">Cuentas por Cobrar Terceros Bellavista Acopio</a></li>
            <?php endif; ?>
            <?php if($todos === '' or $todos === 'P'): ?>
                <li class="negrita"><a href="#cpagar" data-toggle="tab">Cuentas por Pagar Terceros</a></li>
                <li class="negrita"><a href="#cpagarrel" data-toggle="tab">Cuentas por Pagar Relacionadas</a></li>
                <li class="negrita"><a href="#retenciones" data-toggle="tab">Cuentas Retenciones</a></li>
                <li class="negrita"><a href="#bancos" data-toggle="tab">Cuentas Bancos</a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
            <?php if($todos === '' or $todos === 'C'): ?>
                <div id="ccobrar" class="tab-pane cont active">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentascobrarterceros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="ccobrarrel" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentascobrarrelacionadas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="ccobrardudosa" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentascobrartercerosdudosa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="ccobrarriojaacopio" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentascobrartercerosriojaacopio', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="ccobrarbellavistaacopio" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentascobrartercerosbellavistaacopio', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            <?php endif; ?>
            <?php if($todos === '' or $todos === 'P'): ?>
                <div id="cpagar" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentaspagarterceros', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="cpagarrel" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentaspagarrelacionadas', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="retenciones" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentaspagarrelacionadasretenciones', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
                <div id="bancos" class="tab-pane cont">
                    <?php echo $__env->make('reporte.administracion.ajax.listacuentaspagartercerosbancos', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
</div>

<?php if(isset($ajax)): ?>
    <script type="text/javascript">
        $(document).ready(function () {
            App.dataTables();
        });
    </script>
<?php endif; ?>
