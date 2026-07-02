<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-bcp-excel/'.$item->FOLIO)); ?>">
    Detalle Informativo
  </a>  
</li>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000001'): ?>
  <li>
    <a href="<?php echo e(url('/descargar-pago-proveedor-macro-excel/'.$item->FOLIO)); ?>">
      Macro de BCP
    </a>  
  </li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000003'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-bbva-excel/'.$item->FOLIO)); ?>">
    Macro de BBVA
  </a>  
</li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000004'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-sbk-excel/'.$item->FOLIO)); ?>">
    Macro de SBK
  </a>  
</li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000002'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-interbank-excel/'.$item->FOLIO)); ?>">
    Macro de INTERBANK
  </a>  
</li>
<?php endif; ?>