<div tabindex="1" class="panel panel-default panel-contrast pnlasientos" style="border-radius: 10px; border: 1px solid #808080;">
    <div class="panel-heading"
         style="background:#1d3a6d; color:#fff; display:flex; justify-content:space-between; align-items:center;">
        <span>GENERACIÓN DE ASIENTOS</span>
        <button type="button" class="btn btn-lg btn-primary btn-guardar_asiento">
            Guardar Asiento
        </button>
    </div>

    <div class="tab-container">
        <ul class="nav nav-tabs">
            <li id="listone" class="active negrita"><a href="#astcabgeneral" data-toggle="tab">DATOS GENERALES</a></li>
            <li id="listtwo" class="negrita"><a href="#astcabcomplementario" data-toggle="tab">DATOS DESCUENTO</a></li>
            <li id="listtree" class="negrita"><a href="#astdetgeneral" data-toggle="tab">DETALLE</a></li>
        </ul>
        <div class="tab-content">
            <div id="astcabgeneral" class="tab-pane active row cont">

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Año :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'anio_asiento', isset($array_anio) ? $array_anio : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'anio_asiento',
                                                    'data-aw'     => '1'
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ajax_anio_asiento">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Periodo
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'periodo_asiento', isset($array_periodo) ? $array_periodo : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'periodo_asiento',
                                                    'data-aw'     => '2',
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Comprobante
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="comprobante_asiento" name="comprobante_asiento"
                                       class="form-control control input-sm" type="text" readonly
                                       value="">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Moneda :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'moneda_asiento', isset($combo_moneda_asiento) ? $combo_moneda_asiento : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'moneda_asiento',
                                                    'data-aw'     => '4',
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Cambio
                                :</label>
                            <div class="col-sm-12 abajocaja">

                                <input type="text"
                                       id="tipo_cambio_asiento" name='tipo_cambio_asiento'
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
                                {!! Form::select( 'empresa_asiento', isset($combo_empresa_proveedor) ? $combo_empresa_proveedor : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'empresa_asiento',
                                                    'data-aw'     => '6',
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Asiento :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_asiento', isset($combo_tipo_asiento) ? $combo_tipo_asiento : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'tipo_asiento',
                                                    'data-aw'     => '7',
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Fecha Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="fecha_asiento" name="fecha_asiento"
                                       class="form-control control input-sm" type="date"
                                       value="{{ date("Ymd") }}">
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Documento :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_documento_asiento', isset($combo_tipo_documento) ? $combo_tipo_documento : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'tipo_documento_asiento',
                                                    'data-aw'     => '8',
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Serie Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="serie_asiento" name="serie_asiento"
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
                                <input id="numero_asiento" name="numero_asiento"
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
                                {!! Form::select( 'tipo_documento_ref', isset($combo_tipo_documento) ? $combo_tipo_documento : [], '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm combo' ,
                                                    'id'          => 'tipo_documento_ref',
                                                    'data-aw'     => '9'
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Serie Documento Ref.
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input id="serie_ref_asiento" name="serie_ref_asiento"
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
                                <input id="numero_ref_asiento" name="numero_ref_asiento"
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
                                <input id="glosa_asiento" name="glosa_asiento"
                                       class="form-control control input-sm" type="text"
                                       value="">
                            </div>
                        </div>
                    </div>

                </div>

            </div>

            <div id="astcabcomplementario" class="tab-pane row cont">
                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft negrita">Tipo
                            Descuento
                            :</label>
                        <div class="col-sm-12 abajocaja">
                            {!! Form::select( 'tipo_descuento_asiento', isset($combo_descuento) ? $combo_descuento : [], '',
                                              [
                                                'class'       => 'select2 form-control control input-xs' ,
                                                'id'          => 'tipo_descuento_asiento',
                                                'data-aw'     => '1',
                                              ]) !!}
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft negrita">Constancia
                            :</label>
                        <div class="col-sm-12 abajocaja">
                            <input id="const_detraccion_asiento" name="const_detraccion_asiento"
                                   class="form-control control input-sm" type="text"
                                   value="">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft negrita">Fecha
                            :</label>
                        <div class="col-sm-12 abajocaja">
                            <input id="fecha_detraccion_asiento" name="fecha_detraccion_asiento"
                                   class="form-control control input-sm" type="date"
                                   value="{{ date("Ymd") }}">
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft negrita">Porcentaje
                            :</label>
                        <div class="col-sm-12 abajocaja">

                            <input type="text"
                                   id="porcentaje_detraccion"
                                   data_valor="0.00"
                                   name='porcentaje_detraccion'
                                   value="0.00"
                                   placeholder="0.00"
                                   autocomplete="off"
                                   class="form-control input-sm dinero"
                                   data-aw="1"/>
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft negrita">Total
                            :</label>
                        <div class="col-sm-12 abajocaja">

                            <input type="text"
                                   id="total_detraccion_asiento"
                                   data_valor="0.00"
                                   name='total_detraccion_asiento'
                                   value="0.00"
                                   placeholder="0.00"
                                   autocomplete="off"
                                   class="form-control input-sm dinero"
                                   data-aw="1"
                                   readonly/>
                        </div>
                    </div>
                </div>

            </div>

            <div id="astdetgeneral" class="tab-pane row cont">
                <div class="tablageneral">
                    <input type="hidden" id="asiento_cabecera_compra" name="asiento_cabecera_compra"
                           value=""/>
                    <input type="hidden" id="asiento_detalle_compra" name="asiento_detalle_compra"
                           value=""/>
                    <table id="asientototales"
                           class="table table-bordered table-hover td-color-borde td-padding-7 display nowrap"
                           cellspacing="0" width="100%">
                        <thead style="background: #1d3a6d; color: white">
                        <tr>
                            <th>Afecto IGV 18 %</th>
                            <th>Afecto IGV 10 %</th>
                            <th>Afecto IVAP</th>
                            <th>Inafecto</th>
                            <th>Exonerado</th>
                            <th>IGV</th>
                            <th>IVAP</th>
                            <th>Total</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="col-base-imponible"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-base-imponible-10"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-base-ivap"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-base-inafecto"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-base-exonerado"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-igv"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-ivap"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                            <td class="col-total"
                                style="text-align: right">{{ number_format(0.0000, 4, '.', ',') }}</td>
                        </tr>
                        </tbody>
                    </table>
                    <div class="col-lg-12" style="margin-top: 20px; text-align: right; margin-bottom: 40px;">
                        <div class="col-lg-12">
                            <button data="C" type="button" class="btn btn-lg btn-success agregar-linea">
                                ➕ Agregar Detalle
                            </button>
                        </div>
                    </div>
                    <table id="asientodetalle"
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
                    </table>
                </div>

                <div class="editarcuentas">

                    <div class="col-md-12"
                         style="background: #1d3a6d; color: white; padding: 10px; border-radius: 10px">
                        <h4 id="titulodetalle">Agregar o Modificar Detalle</h4>
                    </div>

                    <div class="col-md-12" style="background: white;">

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Nivel:</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'nivel', isset($combo_nivel_pc) ? $combo_nivel_pc : [], '6',
                                                      [
                                                        'class'       => 'select2 form-control control input-xs combo' ,
                                                        'id'          => 'nivel',
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
                                    {!! Form::select( 'partida_id', isset($combo_partida) ? $combo_partida : [], '',
                                                      [
                                                        'class'       => 'select2 form-control control input-xs combo' ,
                                                        'id'          => 'partida_id',
                                                        'data-aw'     => '2',
                                                      ]) !!}
                                </div>
                            </div>
                        </div>


                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 ajax_nivel">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Cuenta contable : </label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'cuenta_contable_id', isset($combo_cuenta) ? $combo_cuenta : [], '',
                                                      [
                                                        'class'       => 'select2 form-control control input-xs combo' ,
                                                        'id'          => 'cuenta_contable_id',
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
                                           id="monto"
                                           name="monto"
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
                                    {!! Form::select( 'tipo_igv_id', isset($combo_tipo_igv) ? $combo_tipo_igv : [], '',
                                                      [
                                                        'class'       => 'select2 form-control control input-xs combo' ,
                                                        'id'          => 'tipo_igv_id',
                                                        'data-aw'     => '4'
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">% IGV :</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'porc_tipo_igv_id', isset($combo_porc_tipo_igv) ? $combo_porc_tipo_igv : [], '',
                                                      [
                                                        'class'       => 'select2 form-control control input-xs combo' ,
                                                        'id'          => 'porc_tipo_igv_id',
                                                        'data-aw'     => '4'
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-3">
                            <div class="form-group">
                                <label class="col-sm-12 control-label labelleft negrita">Estado :</label>
                                <div class="col-sm-12 abajocaja">
                                    {!! Form::select( 'activo', isset($combo_activo) ? $combo_activo : [], '1',
                                                      [
                                                        'class'       => 'select2 form-control control input-xs combo' ,
                                                        'id'          => 'activo',
                                                        'data-aw'     => '5',
                                                        'disabled'    => true
                                                      ]) !!}
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="asiento_id_editar" id="asiento_id_editar" value="">
                        <input type="hidden" name="form_id_editar" id="form_id_editar" value="">
                        <input type="hidden" name="moneda_id_editar" id="moneda_id_editar" value="">
                        <input type="hidden" name="tc_editar" id="tc_editar" value="">

                        <div class="col-lg-12" style="margin-top: 20px; text-align: right; margin-bottom: 40px;">
                            <div class="col-lg-12">
                                <button type="button" class="btn btn-lg btn-default btn-regresar-lista">Regresar
                                </button>
                                <button type="button" class="btn btn-lg btn-success btn-registrar-movimiento">
                                    Registrar
                                </button>
                                <button type="button" class="btn btn-lg btn-primary btn-editar-movimiento">Editar
                                </button>
                            </div>
                        </div>
                    </div>


                </div>

            </div>

        </div>
    </div>

</div>
