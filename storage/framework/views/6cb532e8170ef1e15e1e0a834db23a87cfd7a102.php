<?php if(isset($item) && isset($item['COD_ESTADO'])): ?>

    <?php if($item['COD_ESTADO'] == 'ETM0000000000001'): ?> 
        <span class="badge badge-default"><?php echo e($item['TXT_ESTADO']); ?></span> 

    <?php else: ?>
        <?php if(is_null($item['COD_ESTADO'])): ?> 
            <span class="badge badge-default">GENERADO</span>

        <?php else: ?>
            <?php if($item['COD_ESTADO'] == 'ETM0000000000002'): ?> 
                <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

            <?php else: ?>
                <?php if($item['COD_ESTADO'] == 'ETM0000000000003'): ?> 
                    <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

                <?php else: ?>
                    <?php if($item['COD_ESTADO'] == 'ETM0000000000004'): ?> 
                        <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

                    <?php else: ?>
                        <?php if($item['COD_ESTADO'] == 'ETM0000000000005'): ?> 
                            <span class="badge badge-primary"><?php echo e($item['TXT_ESTADO']); ?></span>

                        <?php else: ?>
                            <?php if($item['COD_ESTADO'] == 'ETM0000000000006'): ?> 
                                <span class="badge badge-danger"><?php echo e($item['TXT_ESTADO']); ?></span>

                            <?php else: ?>
                                <?php if($item['COD_ESTADO'] == 'ETM0000000000007'): ?> 
                                    <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

                                <?php else: ?>
                                    <?php if($item['COD_ESTADO'] == 'ETM0000000000008'): ?> 
                                        <span class="badge badge-success"><?php echo e($item['TXT_ESTADO']); ?></span>

                                    <?php else: ?>
                                        <?php if($item['COD_ESTADO'] == 'ETM0000000000009'): ?> 
                                            <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

                                        <?php else: ?>
                                            <?php if($item['COD_ESTADO'] == 'ETM0000000000010'): ?> 
                                                <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

                                            <?php else: ?>
                                                <?php if($item['COD_ESTADO'] == 'ETM0000000000012'): ?> 
                                                    <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>

                                                <?php else: ?>
                                                    <?php if($item['COD_ESTADO'] == 'ETM0000000000013'): ?> 
                                                        <span class="badge badge-primary"><?php echo e($item['TXT_ESTADO']); ?></span>

                                                    <?php else: ?>
                                                        <?php if($item['COD_ESTADO'] == 'ETM0000000000014'): ?> 
                                                            <span class="badge badge-danger"><?php echo e($item['TXT_ESTADO']); ?></span>

                                                        <?php else: ?>
                                                             <?php if($item['COD_ESTADO'] == 'ETM0000000000015'): ?> 
                                                                 <?php if(isset($item['COD_TRABAJADOR_APRUEBA_ADM']) && $item['COD_TRABAJADOR_APRUEBA_ADM'] == 'IITR000000000391'): ?>
                                                                     <span class="badge" style="background-color: #f57c00; color: #fff;">POR APROBAR GERENCIA ADM</span>
                                                                 <?php else: ?>
                                                                     <span class="badge badge-warning"><?php echo e($item['TXT_ESTADO']); ?></span>
                                                                 <?php endif; ?>

                                                            <?php else: ?>
                                                                <span class="badge badge-default"><?php echo e($item['TXT_ESTADO'] ?? 'SIN ESTADO'); ?></span>
                                                            <?php endif; ?> 
                                                        <?php endif; ?> 
                                                    <?php endif; ?> 
                                                <?php endif; ?> 
                                            <?php endif; ?> 
                                        <?php endif; ?> 
                                    <?php endif; ?> 
                                <?php endif; ?> 
                            <?php endif; ?> 
                        <?php endif; ?> 
                    <?php endif; ?> 
                <?php endif; ?> 
            <?php endif; ?> 
        <?php endif; ?> 
    <?php endif; ?> 

<?php else: ?>
    <span class="badge badge-default">SIN DATA</span>
<?php endif; ?>