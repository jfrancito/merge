<div class="panel panel-default">
    <div class="tab-container">
        <ul class="nav nav-tabs">
            <?php if($todos === '' or $todos === 'IACHEM0000010394'): ?>
                <li class="<?php if($todos === '' or $todos === 'IACHEM0000010394'): ?> active <?php endif; ?> negrita"><a
                            href="#cenvasesii" data-toggle="tab">Compras Internacional</a>
                </li>
            <?php endif; ?>
            <?php if($todos === '' or $todos === 'IACHEM0000007086'): ?>
                <li class="<?php if($todos === 'IACHEM0000007086'): ?> active <?php endif; ?> negrita"><a href="#cenvasesic"
                                                                                        data-toggle="tab">Compras
                        Comercial</a></li>
            <?php endif; ?>
        </ul>

        <div class="tab-content">
            <?php if($todos === '' or $todos === 'IACHEM0000010394'): ?>
                <div id="cenvasesii"
                     class="tab-pane cont <?php if($todos === '' or $todos === 'IACHEM0000010394'): ?> active <?php endif; ?>">
                    <?php echo $__env->make('reporte.logistica.ajax.listacomprasenvasesinternacional', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                </div>
            <?php endif; ?>
            <?php if($todos === '' or $todos === 'IACHEM0000007086'): ?>
                <div id="cenvasesic" class="tab-pane cont <?php if($todos === 'IACHEM0000007086'): ?> active <?php endif; ?>">
                    <?php echo $__env->make('reporte.logistica.ajax.listacomprasenvasescomercial', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
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
