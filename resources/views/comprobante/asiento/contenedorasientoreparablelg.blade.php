<div class="panel panel-default panel-contrast pnl-asiento-reparable" style="border-radius: 10px; border: 1px solid #808080;">
    <div class="panel-heading encabezado-asiento">
        <div class="titulo-panel">
            ASIENTO REPARABLE
        </div>
        <div class="acciones-panel">
            <button type="button" class="btn btn-lg btn-success btn-guardar-asiento-reparable">
                Guardar Asiento
            </button>
            <button type="button" class="btn btn-lg btn-warning btn-anular-asiento-reparable">
                Anular Asiento
            </button>
            <button type="button" class="btn btn-lg btn-danger btn-eliminar-asiento-reparable">
                Eliminar Asiento
            </button>
        </div>
    </div>

    <div class="tab-container">
        <ul class="nav nav-tabs">
            <li id="listonereparable" class="active negrita"><a href="#astcabgeneralreparable" data-toggle="tab">DATOS GENERALES</a></li>
            <li id="listtworeparable" class="negrita"><a href="#astdetgeneralreparable" data-toggle="tab">DETALLE</a></li>
        </ul>
        <div class="tab-content">
            <div id="astcabgeneralreparable" class="tab-pane active row cont">

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Año :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'anio_asiento_reparable', $array_anio, '',
                                                  [
                                                    'class'       => 'slim',
                                                    'id'          => 'anio_asiento_reparable',
                                                    'data-aw'     => '1',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ajax_anio_asiento_reparable">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Periodo
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'periodo_asiento_reparable', $array_periodo, '',
                                                  [
                                                    'class'       => 'slim',
                                                    'id'          => 'periodo_asiento_reparable',
                                                    'data-aw'     => '2',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Comprobante
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input required id="comprobante_asiento_reparable" name="comprobante_asiento_reparable"
                                       class="form-control control input-sm" type="text" readonly
                                       value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Moneda :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'moneda_asiento_reparable', $combo_moneda_asiento, 'MON0000000000001',
                                                  [
                                                    'class'       => 'slim',
                                                    'id'          => 'moneda_asiento_reparable',
                                                    'data-aw'     => '4',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Cambio
                                :</label>
                            <div class="col-sm-12 abajocaja">

                                <input type="text" required
                                       id="tipo_cambio_asiento_reparable" name='tipo_cambio_asiento_reparable'
                                       value="0.0000"
                                       placeholder="Tipo de cambio"
                                       autocomplete="off" class="form-control dinero input-sm" data-aw="5"/>

                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Proveedor :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'empresa_asiento_reparable', [], null,
                                                  [
                                                    'id'          => 'empresa_asiento_reparable',
                                                    'data-aw'     => '6',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <script>
                        let defaultIdReparable = "{{ !empty($asiento_reparable) ? $asiento_reparable[1][0]['COD_EMPR_CLI'] : '' }}";
                        let defaultTextReparable = "{{ !empty($asiento_reparable) ? $asiento_reparable[1][0]['TXT_EMPR_CLI'] : '' }}";
                    </script>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Asiento :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_asiento_reparable', $combo_tipo_asiento, '',
                                                  [
                                                    'class'       => 'slim',
                                                    'id'          => 'tipo_asiento_reparable',
                                                    'data-aw'     => '7',
                                                    'required'    => true,
                                                    'disabled'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Fecha Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input required id="fecha_asiento_reparable" name="fecha_asiento_reparable"
                                       class="form-control control input-sm" type="date"
                                       value="">
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Documento :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_documento_asiento_reparable', $combo_tipo_documento, '',
                                                  [
                                                    'class'       => 'slim',
                                                    'id'          => 'tipo_documento_asiento_reparable',
                                                    'data-aw'     => '7',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Serie Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input required id="serie_asiento_reparable" name="serie_asiento_reparable"
                                       class="form-control control input-sm" type="text"
                                       value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Nro. Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input required id="numero_asiento_reparable" name="numero_asiento_reparable"
                                       class="form-control control input-sm" type="text"
                                       value="">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Documento Ref.:</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_documento_ref_reparable', $combo_tipo_documento, '',
                                                  [
                                                    'class'       => 'slim',
                                                    'id'          => 'tipo_documento_ref_reparable',
                                                    'data-aw'     => '8'
                                                  ]) !!}
                            </div>
                        </div>
                    </div>


                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Serie Documento Ref.
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="serie_ref_asiento_reparable" name="serie_ref_asiento_reparable"
                                       class="form-control control input-sm" type="text"
                                       value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Numero Documento Ref.
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="numero_ref_asiento_reparable" name="numero_ref_asiento_reparable"
                                       class="form-control control input-sm" type="text"
                                       value="">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Glosa
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="glosa_asiento_reparable" name="glosa_asiento_reparable"
                                       class="form-control control input-sm" type="text"
                                       value="">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div id="astdetgeneralreparable" class="tab-pane row cont">

                <div class="tablageneralreparable">
                    <input type="hidden" id="asiento_cabecera_reparable" name="asiento_cabecera_reparable"
                           value=""/>
                    <input type="hidden" id="asiento_detalle_reparable" name="asiento_detalle_reparable"
                           value=""/>
                    <div class="col-lg-12" style="margin-top: 20px; text-align: right; margin-bottom: 40px;">
                        <div class="col-lg-12">
                            <button type="button" class="btn btn-success btn-lg agregar-linea-reparable">
                                ➕ Agregar Detalle
                            </button>
                        </div>
                    </div>
                    <table id="asientodetallereparable"
                           class="table table-bordered table-hover td-color-borde td-padding-7 display nowrap"
                           cellspacing="0" width="100%">
                        <thead style="background: #1d3a6d; color: white">
                        <tr>
                            <th>#</th>
                            <th>Cuenta</th>
                            <th>Descripción</th>
                            <th>Debe MN</th>
                            <th>Haber MN</th>
                            <th>Debe ME</th>
                            <th>Haber ME</th>
                            <th>Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        <tfoot>
                        <tr>
                            <th colspan="3" class="text-right">Totales:</th>
                            <th class="totalDebeMN"
                                style="text-align: right"></th>
                            <th class="totalHaberMN"
                                style="text-align: right"></th>
                            <th class="totalDebeME"
                                style="text-align: right"></th>
                            <th class="totalHaberME"
                                style="text-align: right"></th>
                            <th></th>
                        </tr>
                        </tfoot>
                    </table>

                </div>

                <div class="editarcuentasreparable">

                    <div class="col-md-12"
                         style="background: #1d3a6d; color: white; padding: 10px; border-radius: 10px">
                        <h4 id="titulodetallereparable">Agregar o Modificar Detalle</h4>
                    </div>

                    <div class="col-md-12" style="background: white;">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Nivel:</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'nivel_reparable', $combo_nivel_pc, '6',
                                                      [
                                                        'class'       => 'slim',
                                                        'id'          => 'nivel_reparable',
                                                        'data-aw'     => '1',
                                                         'disabled'   => 'disabled'
                                                      ]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Partida :</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'partida_id_reparable', $combo_partida, '',
                                                      [
                                                        'class'       => 'slim',
                                                        'id'          => 'partida_id_reparable',
                                                        'data-aw'     => '2',
                                                      ]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 ajax_nivel">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Cuenta contable : </label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'cuenta_contable_id_reparable', $combo_cuenta, '',
                                                      [
                                                        'class'       => 'slim',
                                                        'id'          => 'cuenta_contable_id_reparable',
                                                        'data-aw'     => '3',
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Monto :</label>
                                <div class="col-sm-12">
                                    <input type="text"
                                           id="monto_reparable"
                                           name="monto_reparable"
                                           value=""
                                           placeholder="Monto"
                                           autocomplete="off" class="form-control dinero input-sm" data-aw="4"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Tipo IGV :</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'tipo_igv_id_reparable', $combo_tipo_igv, '',
                                                      [
                                                        'class'       => 'slim',
                                                        'id'          => 'tipo_igv_id_reparable',
                                                        'data-aw'     => '4'
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">% IGV :</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'porc_tipo_igv_id_reparable', $combo_porc_tipo_igv, '',
                                                      [
                                                        'class'       => 'slim',
                                                        'id'          => 'porc_tipo_igv_id_reparable',
                                                        'data-aw'     => '4'
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Estado :</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'activo_reparable', $combo_activo, '1',
                                                      [
                                                        'class'       => 'slim',
                                                        'id'          => 'activo_reparable',
                                                        'data-aw'     => '5',
                                                        'disabled'    => true
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="asiento_id_editar_reparable" id="asiento_id_editar_reparable"
                               value="">
                        <input type="hidden" name="moneda_id_editar_reparable" id="moneda_id_editar_reparable" value="">
                        <input type="hidden" name="tc_editar_reparable" id="tc_editar_reparable" value="">

                        <div class="col-lg-12" style="margin-top: 20px; text-align: right; margin-bottom: 40px;">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-lg btn-default btn-regresar-lista-reparable">
                                    Regresar
                                </button>
                                <button type="button" class="btn btn-lg btn-success btn-registrar-movimiento-reparable">
                                    Registrar
                                </button>
                                <button type="button" class="btn btn-lg btn-primary btn-editar-movimiento-reparable">
                                    Editar
                                </button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>
</div>
