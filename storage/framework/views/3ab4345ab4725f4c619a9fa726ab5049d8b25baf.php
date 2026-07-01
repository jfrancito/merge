<div class="row" style="font-size: 15px;padding-top: 20px;">
    <div class="col-sm-3">
        <aside class="sidebar">
                <div class="logo">Notificaciones</div>
                <nav>
                    <?php 
                      $countoc    =   $count_x_aprobar+$count_reparables+$count_reparables_rev+$count_observados+$count_observadosoc_le;
                      $countcon   =   $count_x_aprobar_con+$count_reparables_con+$count_reparables__revcon+$count_observados_con+$count_observadosct_le;
                      $countest   =   $count_x_aprobar_est+$count_reparables_est+$count_reparables__revest+$count_observados_est+$count_observadosest_le;
                      $countdip   =   $count_x_aprobar_dip+$count_reparables_dip+$count_reparables__revdip+$count_observados_dip+$count_observadosdip_le;
                      $countdis   =   $count_x_aprobar_dis+$count_reparables_dis+$count_reparables__revdis+$count_observados_dis+$count_observadosdis_le;
                      $countdib   =   $count_x_aprobar_dib+$count_reparables_dib+$count_reparables__revdib+$count_observados_dib+$count_observadosdib_le;
                      $countlg    =   $count_x_aprobar_lg+$count_observados_lg+$count_observadoslg_le;
                      $countdic    =   $count_x_aprobar_dic+$count_observados_dic+$count_observadosdic_le;
                      $countlqa    =   $count_x_aprobar_lqa+$count_observados_lqa+$count_observadoslqa_le;
                      $countpgs    =   $count_x_aprobar_pgs+$count_observados_pgs+$count_observadospgs_le;

                      $countnoc    =   $count_x_aprobar_noc+$count_observados_noc+$count_observadosnoc_le;
                      $countnod    =   $count_x_aprobar_nod+$count_observados_nod+$count_observadosnod_le;
                      $countoca    =   $count_x_aprobar_oca+$count_observados_oca+$count_observadosoca_le;
                      $countcom    =   $count_x_aprobar_com+$count_observados_com+$count_observadosoca_com;
                      $countcontratoa    =   $count_x_aprobar_contratoa+$count_observados_contratoa+$count_observadoscontratoa_le;

                      $countvl    =   $count_x_aprobar_vl;
                      $countrenta =   $count_x_aprobar_renta;
                      $cantotal   =   $countoc+$countcon+$countest+$countdip+$countdis+$countdib+$countrenta+$countdic+$countlqa+$countpgs+$countnoc+$countnod+$countoca+$countcom+$countcontratoa;
                     ?>

                    <?php if($trol->ind_uc == 1): ?>
                    <?php 
                      $countoc    =   $count_x_aprobar+$count_x_aprobar_gestion+$count_observados+$count_reparables;
                      $countcon   =   $count_x_aprobar_con+$count_x_aprobar_gestion_con+$count_observados_con+$count_reparables_con;
                     ?>
                    <?php endif; ?>

                    <ul class="nav-list">
                        <li class="nav-item">
                            <a class="nav-link active category-tab" data-category="ordencompra">
                                <span class="nav-text">ORDEN COMPRA</span>
                                <div class="notification-container">
                                    <?php if(($trol->UC=='OC' || $trol->UC==NULL)): ?><span class="notification-badge"><?php echo e($countoc); ?></span><?php endif; ?>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="contrato">
                                <span class="nav-text">CONTRATO</span>
                                <div class="notification-container">
                                    <?php if(($trol->UC=='CT' || $trol->UC==NULL)): ?><span class="notification-badge"><?php echo e($countcon); ?></span><?php endif; ?>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="estiba">
                                <span class="nav-text">ESTIBA</span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countest); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dip">
                                <span class="nav-text">DOCUMENTO INTERNO PRODUCCION</span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countdip); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dis">
                                <span class="nav-text">DOCUMENTO INTERNO SECADO</span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countdis); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dib">
                                <span class="nav-text">DOCUMENTO POR SERVICIO DE BALANZA</span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countdib); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dlg">
                                <span class="nav-text">LIQUIDACIONES DE GASTOS</span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countlg); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dvl">
                                <span class="nav-text">VALES A RENDIR</span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countvl); ?></span>
                                </div>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="rentaq">
                                <span class="nav-text">SUSPENSION RENTA DE 4TA </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countrenta); ?></span>
                                </div>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dic">
                                <span class="nav-text">DOCUMENTO INTERNO DE COMPRA </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countdic); ?></span>
                                </div>
                            </a>
                        </li>



                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="lqa">
                                <span class="nav-text">LIQUIDACION COMPRA ANTICIPO </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countlqa); ?></span>
                                </div>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="pgs">
                                <span class="nav-text">PROVISION DE GASTOS </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countpgs); ?></span>
                                </div>
                            </a>
                        </li>


                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="noc">
                                <span class="nav-text">NOTA DE CREDITO </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countnoc); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="nod">
                                <span class="nav-text">NOTA DE DEBITO </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countnod); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="oca">
                                <span class="nav-text">ORDEN COMPRA ANTICIPO </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countoca); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="com">
                                <span class="nav-text">COMISION </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countcom); ?></span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="cta">
                                <span class="nav-text">CONTRATO ANTICIPO </span>
                                <div class="notification-container">
                                    <span class="notification-badge"><?php echo e($countcontratoa); ?></span>
                                </div>
                            </a>
                        </li>



                    </ul>
                </nav>
                <?php if($trol->ind_uc != 1): ?>
                <div class="total-notifications" style="text-align:center;">
                    <div class="total-title">Total Pendientes</div>
                    <div class="total-count"><?php echo e($cantotal); ?> documentos</div>
                </div>
                <?php endif; ?>

            </aside>
    </div>
    <div class="col-sm-9">

        <main class="main-content">
            <!-- Contenido de Categoría 01 -->
            <div id="ordencompra" class="category-content active">
                <?php echo $__env->make('usuario.dashboard.ordencompra', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <!-- Contenido de Categoría 02 -->
            <div id="contrato" class="category-content">
                <?php echo $__env->make('usuario.dashboard.contrato', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <!-- Contenido de Categoría 03 -->
            <div id="estiba" class="category-content">
                <?php echo $__env->make('usuario.dashboard.estiba', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dip" class="category-content">
                <?php echo $__env->make('usuario.dashboard.dip', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dis" class="category-content">
                <?php echo $__env->make('usuario.dashboard.dis', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dib" class="category-content">
                <?php echo $__env->make('usuario.dashboard.dib', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div id="dlg" class="category-content">
                <?php echo $__env->make('usuario.dashboard.dlg', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div id="dvl" class="category-content">
                <?php echo $__env->make('usuario.dashboard.dvl', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div id="rentaq" class="category-content">
                <?php echo $__env->make('usuario.dashboard.rentaq', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dic" class="category-content">
                <?php echo $__env->make('usuario.dashboard.dic', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <!-- Contenido de Categoría 04 -->
            <div id="lqa" class="category-content">
                <?php echo $__env->make('usuario.dashboard.lqa', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div id="pgs" class="category-content">
                <?php echo $__env->make('usuario.dashboard.pgs', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>


            <div id="noc" class="category-content">
                <?php echo $__env->make('usuario.dashboard.noc', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div id="nod" class="category-content">
                <?php echo $__env->make('usuario.dashboard.nod', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
            <div id="oca" class="category-content">
                <?php echo $__env->make('usuario.dashboard.oca', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div id="com" class="category-content">
                <?php echo $__env->make('usuario.dashboard.com', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>

            <div id="cta" class="category-content">
                <?php echo $__env->make('usuario.dashboard.cta', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
            </div>
        </main>
    </div>
