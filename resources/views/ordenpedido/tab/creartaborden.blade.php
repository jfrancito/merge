<div class="panel panel-default panel-table">

    <!-- ================= HEADER ORDEN ================= -->
    <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background:#1d3a6d;color:#fff;">
            ORDEN DE PEDIDO
        </div>
    </div>

    <!-- ================= BODY ORDEN ================= -->
    <div class="panel-body" style="padding:10px">

        <input type="hidden" id="orden_pedido_id" value=""/>

        <!-- FILA 1 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        N° PEDIDO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               id="nro_pedido"
                               class="form-control text-uppercase"
                               value="{{ $nro_pedido }}"
                               readonly>

                        <input type="hidden"
                               id="id_pedido"
                               name="id_pedido"
                               value="">
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        ESTADO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control text-uppercase"
                               value="{{ $estadosMerge[$estado_merge] ?? '' }}"
                               readonly>
                        <input type="hidden"
                               id="cod_estado"
                               name="cod_estado"
                               value="{{ $estado_merge }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 2 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        FECHA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="date"
                               id="fec_pedido"
                               name="fec_pedido"
                               class="form-control control"
                               style="height:38px"
                               value="{{ date('Y-m-d') }}"
                               readonly>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        REALIZADO POR <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control text-uppercase"
                               value="{{ strtoupper($listasolicita[$usuario_solicita] ?? '') }}"
                               readonly>
                        <input type="hidden"
                               id="cod_trabajador_solicita"
                               name="cod_trabajador_solicita"
                               value="{{ $usuario_solicita }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 3 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        AÑO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_anio', $periodo_anio, date('Y'), [
                            'id' => 'cod_anio',
                            'class' => 'form-control control select2',
                            'disabled' => 'disabled'
                        ]) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        ÁREA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control text-uppercase"
                               value="{{ strtoupper($nomArea ?? '') }}"
                               readonly>

                        <input type="hidden"
                               id="cod_area"
                               name="cod_area"
                               value="{{ $area_id }}">
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 4 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        MES <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {{--  {!! Form::select('cod_periodo', ['' => 'Seleccione Mes'], '', [
                                   'id' => 'cod_periodo',
                                   'class' => 'form-control control select2'
                               ]) !!}  --}}

                        {!! Form::select('cod_periodo', $periodo_mes, '', [
                          'id' => 'cod_periodo',
                          'class' => 'form-control control select2'
                      ]) !!}

                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        AUTORIZADO POR <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_trabajador_autoriza', $usuario_autoriza, '', [
                            'id' => 'cod_trabajador_autoriza',
                            'class' => 'form-control control select2'
                        ]) !!}
                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 5 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        EMPRESA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        <input type="text"
                               class="form-control control"
                               value="{{ $listaempresa[$empresa] ?? '' }}"
                               readonly>
                        <input type="hidden"
                               id="cod_empr"
                               name="cod_empr"
                               value="{{ $empresa }}">
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        APROBADO GERENCIA <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_trabajador_aprueba_ger', $usuario_aprueba_ger, '', [
                            'id' => 'cod_trabajador_aprueba_ger',
                            'class' => 'form-control control select2'
                        ]) !!}

                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 6 -->
        <div class="row form-row">
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        SEDE <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        @if(count($combo_sede) > 0)
                            {!! Form::select('cod_centro', $combo_sede, $cod_centro, [
                                'id' => 'cod_centro',
                                'class' => 'form-control control select2'
                            ]) !!}
                        @else
                            <input type="text"
                                   class="form-control control"
                                   value="{{ $nom_centro }}"
                                   readonly>
                            <input type="hidden"
                                   id="cod_centro"
                                   name="cod_centro"
                                   value="{{ $cod_centro }}">
                        @endif
                    </div>
                </div>
            </div>


            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        APROBADO ADMIN <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                        {!! Form::select('cod_trabajador_aprueba_adm', $usuario_aprueba_adm, '', [
                             'id' => 'cod_trabajador_aprueba_adm',
                             'class' => 'form-control control select2'
                         ]) !!}

                    </div>
                </div>
            </div>
        </div>

        <!-- FILA 7 -->
        <!-- FILA 7 -->
        <div class="row form-row">

            <!-- TIPO -->
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        TIPO <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                      {{--  {!! Form::select('cod_tipo_pedido', $listatipopedido, '', [
                            'id' => 'cod_tipo_pedido',
                            'class' => 'form-control control select2'
                        ]) !!} --}}

                            {!! Form::select('cod_tipo_pedido', $listatipopedido, '', [
                            'id' => 'cod_tipo_pedido',
                            'class' => 'form-control control select2',
                             'disabled' => 'disabled'
                        ]) !!}

                    </div>
                </div>
            </div>

            <!-- OBSERVACIÓN -->
            <div class="col-md-6">
                <div class="row">
                    <label class="col-md-4 control-label label-sm text-center negrita">
                        OBSERVACIÓN <span class="obligatorio">(*)</span>
                    </label>
                    <div class="col-md-8">
                <textarea id="txt_glosa"
                          name="txt_glosa"
                          class="form-control"
                          rows="2"
                          required
                          placeholder="Observación"></textarea>
                    </div>
                </div>
            </div>

        </div>

        <!-- FILA 7 -->
        <div class="row form-row">
            <div class="col-xs-12 cajareporte">
                <div class="form-group">
                    <div class="file-upload-wrapper" style="position: relative; width: 100%;">
                        <div class="file-upload-box" id="drop-area-orden" style="border: 2px dashed #1d3a6d; border-radius: 10px; padding: 12px; text-align: center; background: #f8f9fc; cursor: pointer; transition: all 0.3s; position: relative; display: flex; align-items: center; justify-content: center; gap: 15px;">
                            <input type="file" name="select_file[]" id="formFile" multiple accept=".xls,.xlsx,.csv,.pdf,.doc,.docx" style="position: absolute; width: 100%; height: 100%; top: 0; left: 0; opacity: 0; cursor: pointer; z-index: 10;">
                            <i class="mdi mdi-cloud-upload" style="font-size: 24px; color: #1d3a6d;"></i>
                            <div class="upload-content" style="text-align: left;">
                                <h5 style="font-weight: 700; color: #1d3a6d; margin: 0; font-size: 14px;">Cargar Informe / Documentos</h5>
                                <p style="color: #666; font-size: 11px; margin: 0;">Arrastre archivos aquí o haga clic</p>
                            </div>
                            <div style="display: flex; gap: 4px;">
                                <span class="file-tag">PDF</span>
                                <span class="file-tag">EXCEL</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- CONTENEDOR DE PREVISUALIZACIÓN -->
                    <div id="previsualizacion-archivos-orden" class="row" style="margin-top: 15px; display: flex; flex-wrap: wrap; gap: 15px; padding: 0 15px;">
                        <!-- Dinámico -->
                    </div>
                </div>
            </div>
        </div>
        <!-- FILA 8 -->

    </div>
    <!-- FIN panel-body ORDEN -->

    <!-- ================= HEADER DETALLE ================= -->
    <div class="panel panel-default panel-contrast">
        <div class="panel-heading" style="background:#1d3a6d;color:#fff;">
            DETALLE ORDEN PEDIDO
        </div>
    </div>

    <!-- ================= BODY DETALLE ================= -->
    <div class="panel-body" style="padding:10px">

        <div class="row mb-3 align-items-end">
            <div class="col-md-2">
                <label class="label-sm negrita">
                    TIPO PROD. <span class="obligatorio">(*)</span>
                </label>
                <select id="tipo_material_servicio" class="form-control select2">
                    <option value="">Seleccione...</option>
                    <option value="M">MATERIAL</option>
                    <option value="S">SERVICIO</option>
                </select>
            </div>

            <div class="col-md-4">
                <label class="label-sm negrita">
                    PRODUCTO <span class="obligatorio">(*)</span>
                </label>
                <select id="producto_id" class="form-control select2 select2-lg" style="width: 100%;">
                    <option value="">Buscar producto...</option>
                </select>
            </div>

            <div class="col-md-2">
                <label class="label-sm negrita">
                    MEDIDA <span class="obligatorio">(*)</span>
                </label>
                <input type="text"
                       id="unidad"
                       class="form-control text-center"
                       readonly>
            </div>


            <div class="col-md-1">
                <label class="label-sm negrita">
                    CANT. <span class="obligatorio">(*)</span>
                </label>
                <input type="number"
                       id="cantidad"
                       class="form-control cantidad-input"
                       min="0"
                       step="1"
                       oninput="this.value = Math.max(0, this.value)">
            </div>

            <div class="col-md-1 div-precio-servicio" style="display: none;">
                <label class="label-sm negrita">
                    PRECIO <span class="obligatorio">(*)</span>
                </label>
                <input type="number"
                       id="precio_servicio"
                       class="form-control text-center"
                       min="0"
                       step="0.01"
                       value="0.00">
            </div>

            <div class="col-md-3" id="div-observacion">
                <label class="label-sm negrita">
                    OBSERVACIÓN
                </label>
                <input type="text" id="txt_observacion"
                       class="form-control" placeholder="Opcional">
            </div>

            <div class="col-md-6 text-end mt-2">
                <button id="agregar_producto" class="btn btn-success btn-sm">
                    <i class="fa fa-plus"></i> Agregar Producto
                </button>
                <button id="eliminar_producto" class="btn btn-danger btn-sm">
                    <i class="fa fa-trash"></i> Eliminar Producto
                </button>
                <button id="asignarordenpedido" class="btn btn-primary btn-sm">
                    <i class="fa fa-save"></i> Guardar Pedido
                </button>
            </div>
        </div>

        <hr style="border-top: 2px solid transparent; margin: 10px 0;">


        <div class="table-responsive">
            <table class="table table-bordered table-striped" id="tabla_detalle_pedido">
                <thead>
                <tr>
                    <th class=" text-center">#</th>
                    <th class=" text-center">CÓDIGO</th>
                    <th class=" text-center">PRODUCTO</th>
                    <th class=" text-center">TIPO PRODUCTO</th>
                    <th class=" text-center">UNIDAD</th>
                    <th class=" text-center">CANTIDAD</th>
                    <th class=" text-center">PRECIO (S/)</th>
                    <th class=" text-center">SUBTOTAL (S/)</th>
                    <th class=" text-center">OBSERVACIÓN</th>
                </tr>
                </thead>
                <tbody></tbody>
                <tfoot>
                <tr>
                    <th colspan="7" class="text-right negrita" style="vertical-align: middle;">TOTAL PEDIDO:</th>
                    <th class="text-center negrita" id="total_pedido" style="font-size: 16px; color: #1d3a6d;">S/ 0.00</th>
                    <th></th>
                </tr>
                </tfoot>
            </table>
        </div>

    </div><!-- FIN panel-body DETALLE -->

</div><!-- FIN panel-table -->

<style>
    .form-row {
        margin-bottom: 4px;
    }

    .label-sm {
        font-weight: bold;
        font-size: 12px;
        position: relative;
        padding-right: 12px;
        line-height: 34px;
    }

    .cantidad-input {
        text-align: center;
        font-weight: 600;
        font-size: 14px;
    }

    .label-sm::after {
        content: ":";
        position: absolute;
        right: 0;
        top: 50%;
        transform: translateY(-50%);
    }

    .panel-heading {
        background: #003366;
        color: #fff;
        font-size: 14px;
        padding: 6px;
    }

    .select2-container--default .select2-selection--single {
        height: 38px;
        border-radius: 6px;
        border: 1px solid #dce1e7;
    }

    .select2-selection__rendered {
        line-height: 38px !important;
    }

    .select2-selection__arrow {
        height: 36px !important;
    }

    .form-control {
        border-radius: 6px;
        border: 1px solid #dce1e7;
        box-shadow: none;
        transition: .2s;
    }

    .form-control:focus {
        border-color: #4facfe;
        box-shadow: 0 0 0 2px rgba(79, 172, 254, .15);
    }

    .btn {
        border-radius: 6px;
        padding: 6px 14px;
        font-weight: 500;
    }

    .table {
        font-size: 13px;
    }

    .table thead th {
        background: #f5f7fa;
        font-weight: 600;
        color: #2c3e50;
    }

    .table tbody tr:hover {
        background: #f0f6ff;
    }

    .fila-seleccionada {
        background: #e3f2fd !important;
        cursor: pointer;
    }
    
    #cod_tipo_pedido + .select2 .select2-selection__arrow,
    #cod_anio + .select2 .select2-selection__arrow {
        display: none;
    }

    .file-upload-box:hover {
        background: #f0f4f8 !important;
        border-color: #4facfe !important;
        transform: translateY(-2px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    }

    .file-tag {
        font-size: 10px;
        background: #e2e8f0;
        color: #475569;
        padding: 2px 10px;
        border-radius: 20px;
        font-weight: 700;
        text-transform: uppercase;
    }


</style>

