<div class="modal-header" style="background: #1d3a6d; color: #fff;">
	<button type="button" data-dismiss="modal" class="close modal-close"><b><span style="color: white;font-size: 20px;margin-top: -15px;" class="mdi mdi-close"></span></b></button>
	<div class="row">
		<div class="col-xs-12">
			<h3 style="color: #fff; margin: 0; font-size: 16px;"><i class="mdi mdi-wrench" style="margin-right: 6px;"></i> PRODUCTO: {{ $oeProducto->TXT_NOMBRE_PRODUCTO }}</h3>
		</div>
	</div>
</div>
<form 
	action="{{ url('/registrar-activo-fijo-categoria/'.$idopcion.'/'.$idoc.'/'.$COD_PRODUCTO) }}" 
	method="POST" 
	class="frmAgregarCategoriaActivoFijo" 
	name="frmAgregarCategoriaActivoFijo"
	id="frmAgregarCategoriaActivoFijo"
>    
{{ csrf_field() }}
<input type="hidden" name="device_info" id='device_info'>

	<div class="modal-body loteestiba" style="padding: 15px 20px;">
		<div class="scroll_text scroll_text_heigth_aler" style="padding: 0px !important;"> 
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<div class="row">
					<!-- Datos básicos -->
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-6">
							<div class="form-group" style="margin-bottom: 8px;">
								<label style="font-size: 12px; color: #555;">Código de Producto:</label>
								<input type="text" class="form-control input-sm" id="codprod" readonly value="{{ $oeProducto->COD_PRODUCTO }}" style="background: #f8f9fa;">
								<input type="hidden" name="COD_TABLA" id="COD_TABLA" value="{{ $oeProducto->COD_TABLA }}">
								<input type="hidden" name="COD_PRODUCTO" id="COD_PRODUCTO" value="{{ $oeProducto->COD_PRODUCTO }}">
								<input type="hidden" name="NRO_LINEA" id="NRO_LINEA" value="{{ $NRO_LINEA }}">
								<input type="hidden" name="COD_LOTE" id="COD_LOTE" value="{{ $COD_LOTE }}">
								<input type="hidden" name="CAN_PRODUCTO" id="CAN_PRODUCTO" value="{{ $CAN_PRODUCTO }}">
								<input type="hidden" name="TXT_DETALLE_PRODUCTO" id="TXT_DETALLE_PRODUCTO" value="{{ $TXT_DETALLE_PRODUCTO }}">
								<input type="hidden" name="TXT_NOMBRE_PRODUCTO" id="TXT_NOMBRE_PRODUCTO" value="{{ $oeProducto->TXT_NOMBRE_PRODUCTO }}">
								<input type="hidden" name="idcheckbox" id="idcheckbox" value="{{ $idcheckbox }}">
								<!-- Campo oculto con el ID real de categoría que se enviará -->
								<input type="hidden" name="COD_CATEGORIA_AF" id="COD_CATEGORIA_AF" value="{{ $select_categoria_id }}">
							</div>
						</div>
						<div class="col-xs-6">
							<div class="form-group" style="margin-bottom: 8px;">
								<label style="font-size: 12px; color: #555;">Cantidad:</label>
								<input type="text" class="form-control input-sm" id="cantprod" readonly value="{{ $oeProducto->CAN_PRODUCTO }}" style="background: #f8f9fa;">
							</div>
						</div>
					</div>

					<!-- Categoría Principal -->
					<div class="form-group" style="margin-bottom: 12px;">
						<label style="font-weight: 700; color: #1d3a6d;"><i class="mdi mdi-tag" style="margin-right: 4px;"></i> CATEGORÍA (*):</label>
						{!! Form::select('cat_principal', $combo_categoria_activo_fijo, $select_cat_principal, [
							'class' => 'form-control control input-sm select3',
							'id' => 'cat_principal',
							'required' => true,
							'style' => 'width: 100%;'
						]) !!}
					</div>

					<!-- Sub-opción para Obras en curso o Por recibir -->
					<div class="form-group" id="sec_subopcion" style="display: {{ in_array($select_cat_principal, ['OBRAS_EN_CURSO', 'POR_RECIBIR']) ? 'block' : 'none' }}; margin-bottom: 12px; background: #eef4fc; border: 1px solid #b8d4f7; border-radius: 4px; padding: 10px 12px;">
						<label id="lbl_subopcion" style="font-weight: 700; color: #1d3a6d;"><i class="mdi mdi-arrow-right-bold" style="margin-right: 4px;"></i> SUB-OPCIÓN (*):</label>
						<select id="sub_opcion" name="sub_opcion" class="form-control input-sm select3" style="width: 100%;">
							<option value="">SELECCIONE SUB-OPCIÓN</option>
						</select>
					</div>

					<!-- Sección Arrendamiento Financiero & Leasing -->
					<div class="form-group" style="margin-top: 10px; margin-bottom: 12px; background: #fdfefe; border: 1px solid #d2d6de; border-radius: 4px; padding: 10px 12px;">
						<div class="checkbox" style="margin: 0;">
							<label style="font-weight: 700; color: #2c3e50; font-size: 13px; cursor: pointer;">
								<input type="checkbox" id="chk_es_arrendamiento" name="chk_es_arrendamiento" value="1" {{ !empty($es_arrendamiento_inicial) ? 'checked' : '' }} style="cursor: pointer;">
								¿Es Arrendamiento Financiero?
							</label>
						</div>
						<div id="sec_anios_contrato" style="display: {{ !empty($es_arrendamiento_inicial) ? 'block' : 'none' }}; margin-top: 10px; padding-top: 8px; border-top: 1px dashed #e1e4e8;">
							<label style="font-size: 12px; color: #555;">Años de Contrato de Arrendamiento:</label>
							<input type="number" step="1" min="1" max="50" class="form-control input-sm" id="anios_contrato" name="anios_contrato" placeholder="Ejemplo: 2" style="width: 140px;">
							<small class="text-muted" style="display: block; margin-top: 4px;">La tasa anual se calculará automáticamente: (100% / años de contrato).</small>
						</div>
						<div class="checkbox" style="margin-top: 10px; padding-top: 8px; border-top: 1px dashed #e1e4e8;">
							<label style="font-weight: 700; color: #2c3e50; font-size: 13px; cursor: pointer;">
								<input type="checkbox" id="chk_es_leasing" name="chk_es_leasing" value="1" {{ !empty($es_leasing_inicial) ? 'checked' : '' }} style="cursor: pointer;">
								¿Es Leasing?
							</label>
						</div>
					</div>

					<!-- Área y Proceso (Contabilidad) -->
					<div class="row" style="margin-bottom: 10px;">
						<div class="col-xs-12 col-sm-6">
							<div class="form-group" style="margin-bottom: 8px;">
								<label style="font-weight: 700; color: #2c3e50;"><i class="mdi mdi-domain" style="margin-right: 4px;"></i> ÁREA (*):</label>
								{!! Form::select('area_clasif', $lista_areas, $area_defecto, [
									'class' => 'form-control control input-sm select3',
									'id' => 'area_clasif',
									'required' => true,
									'style' => 'width: 100%;'
								]) !!}
							</div>
						</div>
						<div class="col-xs-12 col-sm-6" id="sec_proceso_planta" style="display: {{ $area_defecto == 'Produccion' ? 'block' : 'none' }};">
							<div class="form-group" style="margin-bottom: 8px;">
								<label style="font-weight: 700; color: #2c3e50;"><i class="mdi mdi-factory" style="margin-right: 4px;"></i> PROCESO (PLANTA) (*):</label>
								{!! Form::select('proceso_clasif', $lista_procesos, $proceso_defecto, [
									'class' => 'form-control control input-sm select3',
									'id' => 'proceso_clasif',
									'style' => 'width: 100%;'
								]) !!}
							</div>
						</div>
					</div>

					<!-- Tasa de Depreciación -->
					<div class="form-group" style="margin-top: 8px; margin-bottom: 5px;">
						<label style="font-weight: 600; color: #333;">Tasa de Depreciación Anual (%):</label>
						<input type="number" step="0.01" min="0" max="100" class="form-control input-sm" id="txt_tasa_depreciacion" name="txt_tasa_depreciacion" value="{{ $tasa_depreciacion_defecto ?? '10.00' }}" required>
						<small class="text-muted" style="display: block; margin-top: 4px;">Tasa legal predeterminada según la categoría o calculada por contrato leasing.</small>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="modal-footer" style="padding: 12px 20px; background: #f8f9fa; border-top: 1px solid #e5e5e5;">
		<button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancelar</button>
		<button type="submit" id='btnGuardarCatAF' class="btn btn-success btnGuardarCatAF"><i class="mdi mdi-check"></i> Guardar Clasificación</button>
	</div>
</form>

@if(isset($ajax))
	<script type="text/javascript">
		$(document).ready(function(){
			App.init();
			$('.select3').select2();

			var mapaTasas = {!! json_encode($mapa_tasas_categorias ?? []) !!};
			var subopcionesObras = {!! json_encode($subopciones_obras ?? []) !!};
			var subopcionesPorRecibir = {!! json_encode($subopciones_por_recibir ?? []) !!};
			var subOpcionSeleccionada = {!! json_encode($select_sub_opcion ?? '') !!};

			function actualizarTasa(catId) {
				if(!$('#chk_es_arrendamiento').is(':checked')){
					if(mapaTasas[catId]){
						$('#txt_tasa_depreciacion').val(parseFloat(mapaTasas[catId]).toFixed(2));
					} else {
						$('#txt_tasa_depreciacion').val('10.00');
					}
				}
			}

			function poblarSubopciones(tipo, seleccionPrevia) {
				var $sub = $('#sub_opcion');
				$sub.empty();
				var dataset = (tipo === 'OBRAS_EN_CURSO') ? subopcionesObras : subopcionesPorRecibir;
				var primerValorValido = '';

				$.each(dataset, function(key, val) {
					var isSelected = (key === seleccionPrevia);
					$sub.append(new Option(val, key, false, isSelected));
					if (key !== '' && primerValorValido === '') {
						primerValorValido = key;
					}
				});

				var elegido = $sub.val();
				if (!elegido && primerValorValido) {
					elegido = primerValorValido;
					$sub.val(elegido);
				}
				$sub.trigger('change.select2');
				$('#COD_CATEGORIA_AF').val(elegido);
				actualizarTasa(elegido);
			}

			// Manejador del combo principal
			$('#cat_principal').on('change', function(){
				var val = $(this).val();
				if (val === 'OBRAS_EN_CURSO') {
					$('#lbl_subopcion').html('<i class="mdi mdi-arrow-right-bold" style="margin-right: 4px;"></i> SUB-OPCIÓN (OBRAS EN CURSO) (*):');
					$('#sec_subopcion').slideDown(200);
					poblarSubopciones('OBRAS_EN_CURSO', subOpcionSeleccionada);
				} else if (val === 'POR_RECIBIR') {
					$('#lbl_subopcion').html('<i class="mdi mdi-arrow-right-bold" style="margin-right: 4px;"></i> SUB-OPCIÓN (POR RECIBIR) (*):');
					$('#sec_subopcion').slideDown(200);
					poblarSubopciones('POR_RECIBIR', subOpcionSeleccionada);
				} else {
					$('#sec_subopcion').slideUp(200);
					$('#COD_CATEGORIA_AF').val(val);
					actualizarTasa(val);
				}
			});

			// Inicializar sub-opciones si ya viene seleccionado Obras en curso o Por recibir
			var catInicial = $('#cat_principal').val();
			if (catInicial === 'OBRAS_EN_CURSO') {
				poblarSubopciones('OBRAS_EN_CURSO', subOpcionSeleccionada);
			} else if (catInicial === 'POR_RECIBIR') {
				poblarSubopciones('POR_RECIBIR', subOpcionSeleccionada);
			}

			// Cambio en combo secundario (sub-opción)
			$('#sub_opcion').on('change', function(){
				var valSub = $(this).val();
				if (valSub) {
					$('#COD_CATEGORIA_AF').val(valSub);
					actualizarTasa(valSub);
				}
			});

			// Cambio en Área -> muestra/oculta Proceso Planta
			$('#area_clasif').on('change', function(){
				var area = $(this).val();
				if (area === 'Produccion') {
					$('#sec_proceso_planta').slideDown(200);
				} else {
					$('#sec_proceso_planta').slideUp(200);
				}
			});

			// Checkbox Leasing
			$('#chk_es_arrendamiento').on('change', function(){
				if($(this).is(':checked')){
					$('#sec_anios_contrato').slideDown(200);
					var anios = parseFloat($('#anios_contrato').val()) || 0;
					if(anios > 0){
						$('#txt_tasa_depreciacion').val((100 / anios).toFixed(2));
					}
				} else {
					$('#sec_anios_contrato').slideUp(200);
					var catId = $('#COD_CATEGORIA_AF').val();
					actualizarTasa(catId);
				}
			});

			$('#anios_contrato').on('input change', function(){
				if($('#chk_es_arrendamiento').is(':checked')){
					var anios = parseFloat($(this).val()) || 0;
					if(anios > 0){
						$('#txt_tasa_depreciacion').val((100 / anios).toFixed(2));
					}
				}
			});
		});
	</script>
@endif
