<div class="panel panel-default panel-table">

    <!-- Panel Heading -->
    <div class="panel panel-default panel-border-color panel-border-color-success">
        <div class="panel-heading">Solicitud de Vale</div>
    </div>

    <!-- Panel Body -->
    <div class="panel-body selectfiltro">
        <div class="filtrotabla">
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">

                        <input type="hidden" id="vale_rendir_id" value=""/>

                        <!-- AUTORIZA -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    AUTORIZA <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select('cliente_select', $listausuarios, $usuario_autoriza_predeterminado, [
                                        'class'    => 'form-control control select2',
                                        'id'       => 'cliente_select',
                                        'data-aw'  => '1',
                                        'disabled' => 'disabled'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <!-- MOTIVO -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    MOTIVO <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select('tipo_motivo', $listausuarios2, '', [
                                        'class'   => 'form-control control select2',
                                        'id'      => 'tipo_motivo',
                                        'data-aw' => '1'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <!-- MONEDA -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    MONEDA <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select('cod_moneda', $listausuarios4, '', [
                                        'class'   => 'form-control control select2',
                                        'id'      => 'cod_moneda',
                                        'data-aw' => '1'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <!-- IMPORTE -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    IMPORTE <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 input-group xs-mb-15">
                                    <input type="text"
                                           id="can_total_importe"
                                           value=""
                                           placeholder="Importe"
                                           required
                                           autocomplete="off"
                                           class="form-control input-md dinero_masivo"
                                           data-aw="4"/>
                                </div>
                            </div>
                        </div>

                        <!-- SALDO -->
                        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    SALDO <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 input-group xs-mb-15">
                                    <input type="text"
                                           id="can_total_saldo"
                                           name="can_total_saldo"
                                           value=""
                                           placeholder="Saldo"
                                           required
                                           autocomplete="off"
                                           class="form-control input-md dinero_masivo"
                                           data-aw="4"/>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Listado y Modales -->
            <div class="listadetalleajax"></div>
            @include('valerendir.ajax.modalvalerendircuentabancaria')
            <div class="ajaxvacio text-center fw-bold"></div>
            <input type="hidden" id="vale_rendir_id">

            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        @include('valerendir.modal.detallerendir')
                    </div>
                </div>

                <!-- DETALLE A RENDIR -->
                <div id="vale_rendir_detalle" style="display: none;">
                    <div class="panel panel-default panel-border-color panel-border-color-success">
                        <div class="panel-heading">Detalle a Rendir</div>
                    </div>

                    <div class="row" style="gap:15px; flex-wrap:wrap; align-items:flex-start;">

                        <!-- FECHA INICIO -->
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    FECHA INICIO <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 input-group xs-mb-15">
                                    <input type="datetime-local"
                                           id="fecha_inicio"
                                           name="fecha_inicio"
                                           class="form-control control"
                                           style="height:38px"
                                           data-aw="1">
                                </div>
                            </div>
                        </div>

                        <!-- FECHA FIN -->
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    FECHA FIN <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 input-group xs-mb-15">
                                    <input type="datetime-local"
                                           id="fecha_fin"
                                           name="fecha_fin"
                                           class="form-control control"
                                           style="height:38px"
                                           data-aw="1">
                                </div>
                            </div>
                        </div>

                        <!-- DESTINO -->
                        <div class="col-xs-12 col-sm-12 col-md-2 col-lg-3 cajareporte ind_producto">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">
                                    DESTINO <span class="obligatorio">(*)</span> :
                                </label>
                                <div class="col-sm-12 input-group xs-mb-12">
                                    {!! Form::select('destino', $listausuarios3, '', [
                                        'class'   => 'form-control control select2',
                                        'id'      => 'destino',
                                        'data-aw' => '1',
                                        'style'   => 'height:38px'
                                    ]) !!}
                                </div>
                            </div>
                        </div>

                        <!-- MONTOS APROXIMADOS (COMERCIAL) -->
                        @if(isset($areacomercial) && strtoupper($areacomercial) == 'COMERCIAL')
                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                <label for="txt_glosa_venta" class="form-label fw-bold labelleft negrita">
                                    MONTO APROX. DE VENTA <span class="obligatorio">(*)</span> :
                                </label>
                                <textarea id="txt_glosa_venta" name="glosa" placeholder="Monto Aprox. de Venta" required
                                          class="form-control" rows="3"></textarea>
                            </div>

                            <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ind_producto">
                                <label for="txt_glosa_cobranza" class="form-label fw-bold labelleft negrita">
                                    MONTO APROX. DE COBRANZA <span class="obligatorio">(*)</span> :
                                </label>
                                <textarea id="txt_glosa_cobranza" name="glosa" placeholder="Monto Aprox. de Cobranza" required
                                          class="form-control" rows="3"></textarea>
                            </div>
                        @endif

                        <!-- CHECKBOXES + BOTONES -->
                        <div class="row" style="gap:15px; flex-wrap:wrap; align-items:center; margin-top:10px;">

                            <!-- CHECKBOXES -->
                            <div class="col-12 col-md-3 d-flex flex-column gap-2">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ind_propio" value="1">
                                    <label class="form-check-label negrita">MOVILIDAD PROPIA</label>
                                </div>
                                @if($codlinea == 'TPL0000000000001' || $codlinea == 'TPL0000000000002')
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="ind_aereo" value="1">
                                    <label class="form-check-label negrita">PASAJE AÉREO</label>
                                </div>
                                @endif
                            </div>

                            <!-- BOTONES -->
                            <div class="col-12 col-md-3 d-flex align-items-center gap-2">
                                <input type="hidden" id="detalle_id" value=""/>
                                <button id="agregarImporteGasto" type="button"
                                        class="btn btn-success rounded-circle btn-icon"
                                        style="width:30px; height:30px;" title="Agregar">
                                    <i class="fa fa-plus"></i>
                                </button>

                                <button type="button" class="btn btn-primary verdetalleimportegastos-valerendir"
                                        title="Ver detalle de importes">
                                    <i class="mdi mdi-eye mdi-24px"></i>
                                </button>
                            </div>

                        </div>

                        <!-- Hidden Inputs -->
                        <input type="hidden" id="nom_centro" value="{{ $nom_centro }}">
                        <input type="hidden" id="importeDestinos" value="{{ json_encode($importeDestinos) }}">

                    </div> <!-- row -->
                       @include('valerendir.ajax.modalverdetalleimportegastosvalerendir')

                       <div class="col-xs-12">
                         <div class="listacontratomasiva listajax reporteajax"></div>
                        </div>
                         @include('valerendir.ajax.listamodaldetalleregistroimporte')
                </div> <!-- vale_rendir_detalle -->
            </div> <!-- container -->

            <div class="col-xs-12">
                <div class="listacontratomasiva listajax reporteajax"></div>
            </div>

            <div class="listajax">
                @include('valerendir.ajax.listamodalvalerendir')
            </div>

        </div> <!-- filtrotabla -->
    </div> <!-- panel-body -->
</div> <!-- panel-table -->
