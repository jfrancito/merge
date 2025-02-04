
<div class="row" style="font-size: 15px;padding-top: 20px;">
    <div class="col-sm-3">
        <aside class="sidebar">
                <div class="logo">Notificaciones</div>
                <nav>
                    @php
                      $countoc    =   $count_x_aprobar+$count_reparables+$count_reparables_rev+$count_observados+$count_observadosoc_le;
                      $countcon   =   $count_x_aprobar_con+$count_reparables_con+$count_reparables__revcon+$count_observados_con+$count_observadosct_le;
                      $countest   =   $count_x_aprobar_est+$count_reparables_est+$count_reparables__revest+$count_observados_est+$count_observadosest_le;
                      $countdip   =   $count_x_aprobar_dip+$count_reparables_dip+$count_reparables__revdip+$count_observados_dip+$count_observadosdip_le;
                      $countdis   =   $count_x_aprobar_dis+$count_reparables_dis+$count_reparables__revdis+$count_observados_dis+$count_observadosdis_le;
                      $countdib   =   $count_x_aprobar_dib+$count_reparables_dib+$count_reparables__revdib+$count_observados_dib+$count_observadosdib_le;
                      $cantotal   =   $countoc+$countcon+$countest+$countdip+$countdis+$countdib;
                    @endphp

                    @if($trol->ind_uc == 1)
                    @php
                      $countoc    =   $count_x_aprobar+$count_x_aprobar_gestion+$count_observados+$count_reparables;
                      $countcon   =   $count_x_aprobar_con+$count_x_aprobar_gestion_con+$count_observados_con+$count_reparables_con;
                    @endphp
                    @endif

                    <ul class="nav-list">
                        <li class="nav-item">
                            <a class="nav-link active category-tab" data-category="ordencompra">
                                <span class="nav-text">ORDEN COMPRA</span>
                                <div class="notification-container">
                                    @if(($trol->UC=='OC' || $trol->UC==NULL))<span class="notification-badge">{{$countoc}}</span>@endif
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="contrato">
                                <span class="nav-text">CONTRATO</span>
                                <div class="notification-container">
                                    @if(($trol->UC=='CT' || $trol->UC==NULL))<span class="notification-badge">{{$countcon}}</span>@endif
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="estiba">
                                <span class="nav-text">ESTIBA</span>
                                <div class="notification-container">
                                    <span class="notification-badge">{{$countest}}</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dip">
                                <span class="nav-text">DOCUMENTO INTERNO PRODUCCION</span>
                                <div class="notification-container">
                                    <span class="notification-badge">{{$countdip}}</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dis">
                                <span class="nav-text">DOCUMENTO INTERNO SECADO</span>
                                <div class="notification-container">
                                    <span class="notification-badge">{{$countdis}}</span>
                                </div>
                            </a>
                        </li>

                        <li class="nav-item">
                            <a class="nav-link category-tab" data-category="dib">
                                <span class="nav-text">DOCUMENTO POR SERVICIO DE BALANZA</span>
                                <div class="notification-container">
                                    <span class="notification-badge">{{$countdib}}</span>
                                </div>
                            </a>
                        </li>


                    </ul>
                </nav>
                @if($trol->ind_uc != 1)
                <div class="total-notifications" style="text-align:center;">
                    <div class="total-title">Total Pendientes</div>
                    <div class="total-count">{{$cantotal}} documentos</div>
                </div>
                @endif

            </aside>
    </div>
    <div class="col-sm-9">

        <main class="main-content">
            <!-- Contenido de Categoría 01 -->
            <div id="ordencompra" class="category-content active">
                @include('usuario.dashboard.ordencompra')
            </div>

            <!-- Contenido de Categoría 02 -->
            <div id="contrato" class="category-content">
                @include('usuario.dashboard.contrato')
            </div>

            <!-- Contenido de Categoría 03 -->
            <div id="estiba" class="category-content">
                @include('usuario.dashboard.estiba')
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dip" class="category-content">
                @include('usuario.dashboard.dip')
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dis" class="category-content">
                @include('usuario.dashboard.dis')
            </div>

            <!-- Contenido de Categoría 04 -->
            <div id="dib" class="category-content">
                @include('usuario.dashboard.dib')
            </div>

        </main>
    </div>
