<div class="row" style="margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
    <div class="col-xs-6">
        <label style="font-weight: bold; margin-bottom: 5px; display: block; color: #555;">FILTRAR POR GRUPO:</label>
        <select id="selectGrupo" class="form-control select2" style="border-radius: 4px; border: 1px solid #ddd;">
            <option value="todos">MOSTRAR TODOS LOS GRUPOS</option>
            @foreach($listaopciones as $grupo => $opciones)
                <option value="{{ str_slug($grupo) }}">{{ $grupo }}</option>
            @endforeach
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
        @foreach($listaopciones as $grupo => $opciones)
          @php $slug = str_slug($grupo); @endphp
          <tr class="header-grupo" data-grupo="{{ $slug }}" style="background-color: #eef3ff; cursor: pointer; border-left: 4px solid #4285f4;" title="Clic para expandir/colapsar">
            <td colspan="5" style="padding: 12px 15px; color: #1a73e8; font-weight: bold; position: relative;">
              <i class="mdi mdi-plus-box icon-state" style="margin-right: 8px; font-size: 1.2em; vertical-align: middle;"></i> 
              <span style="letter-spacing: 0.5px;">{{ $grupo }}</span>
              <span class="pull-right badge badge-primary" style="background: #4285f4; border-radius: 12px; margin-top: 3px;">{{ count($opciones) }} ítems</span>
            </td>
          </tr>
          @foreach($opciones as $item)
            <tr class="permiso-row grupo-{{ $slug }}" style="display: none; background-color: #fff; transition: all 0.2s;">
              <td class="cell-detail" style="padding-left: 40px; border-left: 1px solid #eee;">
                <span class="opcion-nombre" style="font-weight: 500; color: #444;">{{$item->opcion->nombre}}</span>
              </td>
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-ver {{Hashids::encode(substr($item->id, -8))}}"
                          id="1{{Hashids::encode(substr($item->id, -8))}}"
                          @if ($item->ver == 1) checked @endif
                  >
                  <label  for="1{{Hashids::encode(substr($item->id, -8))}}"
                          data-atr = "ver"
                          class = "checkbox"                    
                          name="{{Hashids::encode(substr($item->id, -8))}}"
                    ></label>
                </div>
              </td> 
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-anadir {{Hashids::encode(substr($item->id, -8))}}"
                          id="2{{Hashids::encode(substr($item->id, -8))}}"
                          @if ($item->anadir == 1) checked @endif
                  >
                  <label  for="2{{Hashids::encode(substr($item->id, -8))}}"
                          data-atr = "anadir"
                          class = "checkbox"                   
                          name="{{Hashids::encode(substr($item->id, -8))}}"
                    ></label>
                </div>
              </td> 
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-modificar {{Hashids::encode(substr($item->id, -8))}}"
                          id="3{{Hashids::encode(substr($item->id, -8))}}"
                          @if ($item->modificar == 1) checked @endif
                  >
                  <label  for="3{{Hashids::encode(substr($item->id, -8))}}"
                          data-atr = "modificar"
                          class = "checkbox"                    
                          name="{{Hashids::encode(substr($item->id, -8))}}"
                    ></label>
                </div>
              </td> 
              <td class="text-center">
                <div class="be-checkbox be-checkbox-sm">
                  <input  type="checkbox"
                          class="check-col-todas {{Hashids::encode(substr($item->id, -8))}}"
                          id="4{{Hashids::encode(substr($item->id, -8))}}"
                          @if ($item->todas == 1) checked @endif
                  >
                  <label  for="4{{Hashids::encode(substr($item->id, -8))}}"
                          data-atr = "todas"
                          class = "checkbox"                      
                          name="{{Hashids::encode(substr($item->id, -8))}}"
                    ></label>
                </div>
              </td>
            </tr>                    
          @endforeach
        @endforeach
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