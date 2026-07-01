<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000001'): ?>
  <li>
    <a href="<?php echo e(url('/descargar-pago-proveedor-macro-estiba-excel/'.$item->FOLIO)); ?>">
      Macro de BCP
    </a>  
  </li>

<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000003'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-bbva-balanza-excel/'.$item->FOLIO)); ?>">
    Macro de BBVA
  </a>  
</li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000004'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-sbk-estiba-excel/'.$item->FOLIO)); ?>">
    Macro de SBK
  </a>  
</li>
<?php endif; ?>
<?php if($item->COD_CATEGORIA_BANCO == 'BAM0000000000002'): ?>
<li>
  <a href="<?php echo e(url('/descargar-pago-proveedor-macro-interbank-estiba-excel/'.$item->FOLIO)); ?>">
    Macro de INTERBANK
  </a>  
</li>
<?php endif; ?>