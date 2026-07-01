<div class="be-left-sidebar">
    <div class="left-sidebar-wrapper"><a href="#" class="left-sidebar-toggle">Inicio</a>
        <div class="left-sidebar-spacer">
            <div class="left-sidebar-scroll">
                <div class="left-sidebar-content">
                    <ul class="sidebar-elements">
                        <li class="divider">Menú</li>
                        <li class="active"><a href="<?php echo e(url('/bienvenido')); ?>"><i class="icon mdi mdi-home"></i><span>Inicio</span></a>
                        </li>
                        <?php 
                            $visualizar = 0;
                         ?>
                        <?php $__currentLoopData = Session::get('listamenu'); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>

                            <?php if($grupo->orden >= 100 and $visualizar === 0): ?>
                                <?php 
                                    $visualizar = 1;
                                 ?>
                                <li class="divider">Reportes</li>
                            <?php endif; ?>


                            <li class="parent" @click="menu='4'"><a href="#"><i
                                            class="icon mdi <?php echo e($grupo->icono); ?>"></i><span><?php echo e($grupo->nombre); ?></span></a>
                                <ul class="sub-mensu">
                                    <?php $__currentLoopData = $grupo->opcion()->orderBy('orden', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opcion): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php if(in_array($opcion->id, Session::get('listaopciones'))): ?>
                                            <li>
                                                <a href="<?php echo e(url('/'.$opcion->pagina.'/'.Hashids::encode(substr($opcion->id, -8)))); ?>"><?php echo e($opcion->nombre); ?></a>
                                            </li>
                                        <?php endif; ?>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            </div>
        </div>

        <div class="progress-widget <?php echo e(Session::get('color')); ?>">
            <?php echo e(Session::get('empresas')->NOM_EMPR); ?>

        </div>

    </div>
</div>

