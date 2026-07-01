
<nav class="navbar navbar-default navbar-fixed-top be-top-header <?php echo e(Session::get('color_meta')); ?>">
  <div class="container-fluid">
    <div class="navbar-header" style="padding-top: 14px;"> 
      <div class="color-blanco"><img width="160px" style="margin-bottom: 12px" src="<?php echo e(asset('public/img/indulogo_menu.png')); ?>" alt="Avatar"> <span> | (<?php echo e(strtoupper(Session::get('usuario')->name)); ?>)</span></div>
    </div>

    <div class="be-right-navbar <?php echo e(Session::get('color_meta')); ?>">
      <ul class="nav navbar-nav navbar-right be-user-nav">
        <?php if(Session::get('usuario')->id == '1CIX00000001' || Session::has('usuario_original')): ?>
          <li class="dropdown">
            <div class="row" style="margin-top: 10px; margin-right: 15px;">
              <select name="user_imposter" id="user_imposter" class="form-control input-sm select2" onchange="location = this.value;">
                  <?php if(Session::has('usuario_original')): ?>
                    <option value="<?php echo e(url('/impostar-usuario/'.Session::get('usuario_original')->id)); ?>">VOLVER A: <?php echo e(Session::get('usuario_original')->nombre); ?></option>
                  <?php else: ?>
                    <option value="">IMPOSTAR USUARIO</option>
                  <?php endif; ?>
                  
                  <?php 
                    $usuarios_impostar = App\User::where('activo', 1)->orderBy('nombre', 'asc')->get();
                   ?>
                  <?php $__currentLoopData = $usuarios_impostar; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e(url('/impostar-usuario/'.$item->id)); ?>" <?php echo e(Session::get('usuario')->id == $item->id ? 'selected' : ''); ?>>
                      <?php echo e($item->nombre); ?>

                    </option>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
            </div>
          </li>
        <?php endif; ?>

        <li><div class="page-title"><span><?php echo e(Session::get('usuario')->nombre); ?></span></div></li>

        <li class="dropdown">
          <a href="#" data-toggle="dropdown" role="button" aria-expanded="false" class="dropdown-toggle">
            <img src="<?php echo e(asset('public/img/iconos_7.png')); ?>" alt="Avatar">
            <span class="user-name"><?php echo e(Session::get('usuario')->nombre); ?></span></a>
          <ul role="menu" class="dropdown-menu">
            <li>
              <div class="user-info color_azul" >
                <div class="user-name"><?php echo e(Session::get('usuario')->nombre); ?></div>
                <div class="user-position online">disponible</div>
              </div>
            </li>
            <li><a href="<?php echo e(url('/cambiarperfil/')); ?>"><span class="icon mdi mdi-settings"></span> Cambiar de perfil</a></li>
            <li><a href="#" id="cambiarclave"><span class="icon mdi mdi-key"></span> Cambiar clave</a></li>
            <li><a href="<?php echo e(url('/cerrarsession')); ?>"><span class="icon mdi mdi-power"></span>Cerrar sesión</a></li>


          </ul>
        </li>
      </ul>
    </div>
      <a href="#" data-toggle="collapse" data-target="#be-navbar-collapse" class="be-toggle-top-header-menu collapsed">Opciones</a>
      <div id="be-navbar-collapse" class="navbar-collapse collapse">
      </div>
  </div>
</nav>

<div id="modal-cambiar-clave" class="modal-container colored-header colored-header-primary modal-effect-8">
  <div class="modal-content ">
	<div class='modal-cambiar-clave-container'>
	</div>
  </div>
</div>
<div class="modal-overlay"></div>