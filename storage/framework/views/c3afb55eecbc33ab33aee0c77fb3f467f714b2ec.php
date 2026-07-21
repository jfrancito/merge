<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000001'): ?>
  <li>
    <a href="<?php echo e(url('/descargar-pago-proveedor-macro-excel-oca/'.$item->FOLIO)); ?>">
      Macro de BCP
    </a>  
  </li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000001'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-bbva-excel-oca/'.$item->FOLIO)); ?>">
    Macro de BBVA
  </a>  
</li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000001'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-sbk-excel-oca/'.$item->FOLIO)); ?>">
    Macro de SBK
  </a>  
</li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000001'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-interbank-excel-oca/'.$item->FOLIO)); ?>">
    Macro de INTERBANK
  </a>  
</li>
<?php endif; ?>