<div class="row" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
    <div class="col-xs-6">
        <label style="font-weight: bold; margin-bottom: 5px; display: block; color: #555;">FILTRAR POR GRUPO:</label>
        <select id="selectGrupo" class="form-control select2" style="border-radius: 4px; border: 1px solid #ddd;">
            <option value="todos">MOSTRAR TODOS LOS GRUPOS</option>
            <?php $__currentLoopData = $listaopciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo => $opciones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e(str_slug($grupo)); ?>"><?php echo e($grupo); ?></option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
    </div>
    <div class="col-xs-6">
        <label style="font-weight: bold; margin-bottom: 5px; display: block; color: #555;">BUSCAR OPCIÓN:</label>
        <div class="input-group">
            <span class="input-group-addon" style="background: #f5f5f5; border-color: #ddd;"><i class="mdi mdi-search"></i></span>
            <input type="text" id="filterPermisos" class="form-control" placeholder="Nombre de la opción..." style="border-color: #ddd;">
        </div>
    </div>
</div>

<div class="table-responsive" style="border: 1px solid #eee; border-radius: 8px; overflow: hidden; background: white;">
    <table class="table table-hover table-fw-widget" id="tablePermisos">
      <thead style="background-color: #fcfcfc;">
        <tr>
          <th style="width: 40%; padding: 15px;">Nombre de Opción</th>
          <th class="text-center" style="padding: 15px;">
            <div class="be-checkbox be-checkbox-sm inline">
                <input id="checkAllVer" type="checkbox" class="check-all-column" data-column="ver">
                <label for="checkAllVer" data-toggle="tooltip" title="Seleccionar todo Ver"><b>V</b></label>
            </div>
          </th>
          <th class="text-center" style="padding: 15px;">
            <div class="be-checkbox be-checkbox-sm inline">
                <input id="checkAllAnadir" type="checkbox" class="check-all-column" data-column="anadir">
                <label for="checkAllAnadir" data-toggle="tooltip" title="Seleccionar todo Añadir"><b>A</b></label>
            </div>
          </th>
          <th class="text-center" style="padding: 15px;">
            <div class="be-checkbox be-checkbox-sm inline">
                <input id="checkAllModificar" type="checkbox" class="check-all-column" data-column="modificar">
                <label for="checkAllModificar" data-toggle="tooltip" title="Seleccionar todo Modificar"><b>M</b></label>
            </div>
          </th>
          <th class="text-center" style="padding: 15px;">
            <div class="be-checkbox be-checkbox-sm inline">
                <input id="checkAllTodas" type="checkbox" class="check-all-column" data-column="todas">
                <label for="checkAllTodas" data-toggle="tooltip" title="Seleccionar todas las acciones"><b>T</b></label>
            </div>
          </th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $listaopciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $grupo => $opciones): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <?php  $slug = str_slug($grupo);  ?>
          <tr class="header-grupo" data-grupo="<?php echo e($slug); ?>" style="background-color: #eef3ff; cursor: pointer; border-left: 4px solid #4285f4;" title="Clic para expandir/colapsar">
            <td colspan="5" style="padding: 12px 15px; color: #1a73e8; font-weight: bold; position: relative;">
              <i class="mdi mdi-plus-box icon-state" style="margin-right: 8px; font-size: 1.2em; vertical-align: middle;"></i> 
              <span style="letter-spacing: 0.5px;"><?php echo e($grupo); ?></span>
              <span class="pull-right badge badge-primary" style="background: #4285f4; border-radius: 12px; margin-top: 3px;"><?php echo e(count($opciones)); ?> ítems</span>
            </td>
          </tr>
          <?php $__currentLoopData = $opciones; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <tr class="permiso-row grupo-<?php echo e($slug); ?>" style="display: none; background-color: #fff; transition: all 0.2s;">
              <td class="cell-detail" style="padding-left: 40px; border-left: 1px solid #eee;">
                <span class="opcion-nombre" style="font-weight: 500; color: #444;"><?php echo e($item->opcion->nombre); ?></span>
              </td>
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-ver <?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          id="1<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          <?php if($item->ver == 1): ?> checked <?php endif; ?>
                  >
                  <label  for="1<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          data-atr = "ver"
                          class = "checkbox"                    
                          name="<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                    ></label>
                </div>
              </td> 
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-anadir <?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          id="2<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          <?php if($item->anadir == 1): ?> checked <?php endif; ?>
                  >
                  <label  for="2<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          data-atr = "anadir"
                          class = "checkbox"                   
                          name="<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                    ></label>
                </div>
              </td> 
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-modificar <?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          id="3<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          <?php if($item->modificar == 1): ?> checked <?php endif; ?>
                  >
                  <label  for="3<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          data-atr = "modificar"
                          class = "checkbox"                    
                          name="<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                    ></label>
                </div>
              </td> 
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-todas <?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          id="4<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          <?php if($item->todas == 1): ?> checked <?php endif; ?>
                  >
                  <label  for="4<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                          data-atr = "todas"
                          class = "checkbox"                      
                          name="<?php echo e(Hashids::encode(substr($item->id, -8))); ?>"
                    ></label>
                </div>
              </td>
            </tr>                    
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();

    // Inicializar Select2 para búsqueda dentro del combo de grupos
    if ($.isFunction($.fn.select2)) {
        $("#selectGrupo").select2({
            width: '100%',
            placeholder: "Buscar un grupo...",
            allowClear: true
        });
    }

    // Filtro por SELECT de Grupo
    $("#selectGrupo").on("change", function() {
        var groupValue = $(this).val();
        
        if(groupValue === 'todos') {
            $(".header-grupo").show();
            // Mantener el estado de colapsado actual o colapsar todo
            $(".permiso-row").hide();
            $(".header-grupo i.icon-state").removeClass("mdi-minus-box").addClass("mdi-plus-box");
        } else {
            $(".header-grupo").hide();
            $(".permiso-row").hide();
            
            var targetHeader = $(".header-grupo[data-grupo='" + groupValue + "']");
            targetHeader.show();
            $(".grupo-" + groupValue).show();
            targetHeader.find("i.icon-state").removeClass("mdi-plus-box").addClass("mdi-minus-box");
        }
    });

    // Filtro de búsqueda por TEXTO
    $("#filterPermisos").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        
        if(value === "") {
            // Si el buscador está vacío, volvemos al estado inicial (filtrado por combo o todos colapsados)
            $("#selectGrupo").trigger("change");
            return;
        }

        // Si hay texto, expandimos todo y filtramos filas individuales
        $(".header-grupo").hide(); 
        $(".permiso-row").each(function() {
            var text = $(this).find(".opcion-nombre").text().toLowerCase();
            $(this).toggle(text.indexOf(value) > -1);
        });
    });

    // Toggle de Expandir/Colapsar cabeceras
    $(".header-grupo").on("click", function() {
        var group = $(this).data("grupo");
        var rows = $(".grupo-" + group);
        var icon = $(this).find("i.icon-state");

        if(rows.is(":visible")) {
            rows.hide();
            icon.removeClass("mdi-minus-box").addClass("mdi-plus-box");
        } else {
            rows.fadeIn(200);
            icon.removeClass("mdi-plus-box").addClass("mdi-minus-box");
        }
    });

    // Seleccionar todo por columna (solo en filas visibles)
    $('.check-all-column').on('change', function() {
        var column = $(this).data('column');
        var isChecked = $(this).is(':checked');
        var targetClass = '.check-col-' + column;
        
        $("#tablePermisos tbody tr.permiso-row:visible").each(function() {
            var checkbox = $(this).find(targetClass);
            var label = $(this).find('label[data-atr="' + column + '"]');
            
            if (checkbox.is(':checked') !== isChecked) {
                label.click();
            }
        });
    });
  });
</script>