<div class="panel panel-default panel-contrast">
    <div class="panel-heading" style="background: #1d3a6d;color: #fff;">
        GENERACIÓN DE ASIENTOS
    </div>

    <div class="tab-container">
        <ul class="nav nav-tabs">
            <li class="active negrita"><a href="#astcabgeneral" data-toggle="tab">DATOS GENERALES</a></li>
            <li class="negrita"><a href="#astcabcomplementario" data-toggle="tab">DATOS DESCUENTO</a></li>
        </ul>
        <div class="tab-content">
            <div id="astcabgeneral" class="tab-pane active row cont">

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Año :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'anio_asiento', $array_anio, $defecto_anio,
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'anio_asiento',
                                                    'data-aw'     => '1',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte ajax_anio_asiento">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Periodo
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'periodo_asiento', $array_periodo, $defecto_periodo,
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'periodo_asiento',
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
                                <input required id="comprobante_asiento" name="comprobante_asiento"
                                       class="form-control control input-sm" type="text" readonly
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['TXT_REFERENCIA'] : $fedocumento->ID_DOCUMENTO }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Moneda :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'moneda_asiento', $combo_moneda_asiento, !empty($asiento_compra) ? $asiento_compra[1][0]['COD_CATEGORIA_MONEDA'] : ($fedocumento->MONEDA === 'PEN' ? 'MON0000000000001' : 'MON0000000000002'),
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'moneda_asiento',
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
                                       id="tipo_cambio_asiento" name='tipo_cambio_asiento'
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['CAN_TIPO_CAMBIO'] : 0.0000 }}"
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
                                {!! Form::select( 'empresa_asiento', $combo_empresa_proveedor, !empty($asiento_compra) ? $asiento_compra[1][0]['COD_EMPR_CLI'] : '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'empresa_asiento',
                                                    'data-aw'     => '6',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Asiento :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_asiento', $combo_tipo_asiento, !empty($asiento_compra) ? $asiento_compra[1][0]['COD_CATEGORIA_TIPO_ASIENTO'] : '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'tipo_asiento',
                                                    'data-aw'     => '7',
                                                    'required'    => true,
                                                  ]) !!}
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Fecha Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input required id="fecha_asiento" name="fecha_asiento"
                                       class="form-control control input-sm" type="date"
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['FEC_ASIENTO'] : $fedocumento->FEC_VENTA }}">
                            </div>
                        </div>
                    </div>


                </div>

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Documento :</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_documento_asiento', $combo_tipo_documento, !empty($asiento_compra) ? $asiento_compra[1][0]['COD_CATEGORIA_TIPO_DOCUMENTO'] : '',
                                                  [
                                                    'class'       => 'select2 form-control control input-sm' ,
                                                    'id'          => 'tipo_documento_asiento',
                                                    'data-aw'     => '8',
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
                                <input required id="serie_asiento" name="serie_asiento"
                                       class="form-control control input-sm" type="text"
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['NRO_SERIE'] : $fedocumento->SERIE }}">
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Nro. Documento
                                :</label>
                            <div class="col-sm-12 abajocaja">
                                <input required id="numero_asiento" name="numero_asiento"
                                       class="form-control control input-sm" type="text"
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['NRO_DOC'] : $fedocumento->NUMERO }}">
                            </div>
                        </div>
                    </div>

                </div>
                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Tipo Documento Ref.:</label>
                            <div class="col-sm-12 abajocaja">
                                {!! Form::select( 'tipo_documento_ref', $combo_tipo_documento, !empty($asiento_compra) ? $asiento_compra[1][0]['COD_CATEGORIA_TIPO_DOCUMENTO_REF'] : '',
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
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['NRO_SERIE_REF'] : ''  }}">
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
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['NRO_DOC_REF'] : ''  }}">
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
                                <input required id="glosa_asiento" name="glosa_asiento"
                                       class="form-control control input-sm" type="text"
                                       value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['TXT_GLOSA'] : ($tipo_doc_fe->NOM_CATEGORIA.': '.$fedocumento->SERIE.'-'.$fedocumento->NUMERO.'//'.$fedocumento->FEC_VENTA.'//'.($fedocumento->MONEDA === 'PEN' ? 'SOLES' : 'DOLARES').'//'.$empresa_doc_fe->NOM_EMPR.'//CANJE: '.$fedocumento->ID_DOCUMENTO) }}">
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-xs-12">

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">IGV XML
                                :</label>
                            <div class="col-sm-12 abajocaja">

                                <input type="text"
                                       id="igv_xml"
                                       data_valor="{{(!empty($fedocumento->VALOR_IGV_SOLES) ? $fedocumento->VALOR_IGV_SOLES : 0.00) > 0.00 ? $fedocumento->VALOR_IGV_SOLES : 0.00}}"
                                       name='igv_xml'
                                       value="{{(!empty($fedocumento->VALOR_IGV_SOLES) ? $fedocumento->VALOR_IGV_SOLES : 0.00) > 0.00 ? $fedocumento->VALOR_IGV_SOLES : 0.00}}"
                                       placeholder="0.00"
                                       autocomplete="off"
                                       class="form-control input-sm dinero"
                                       data-aw="1"
                                       readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Subtotal XML
                                :</label>
                            <div class="col-sm-12 abajocaja">

                                <input type="text"
                                       id="subtotal_xml"
                                       data_valor="{{(!empty($fedocumento->SUB_TOTAL_VENTA_SOLES) ? $fedocumento->SUB_TOTAL_VENTA_SOLES : 0.00) > 0.00 ? $fedocumento->SUB_TOTAL_VENTA_SOLES : 0.00}}"
                                       name='subtotal_xml'
                                       value="{{(!empty($fedocumento->SUB_TOTAL_VENTA_SOLES) ? $fedocumento->SUB_TOTAL_VENTA_SOLES : 0.00) > 0.00 ? $fedocumento->SUB_TOTAL_VENTA_SOLES : 0.00}}"
                                       placeholder="0.00"
                                       autocomplete="off"
                                       class="form-control input-sm dinero"
                                       data-aw="1"
                                       readonly/>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 cajareporte">
                        <div class="form-group">
                            <label class="col-sm-12 control-label labelleft negrita">Total XML
                                :</label>
                            <div class="col-sm-12 abajocaja">

                                <input type="text"
                                       id="total_xml"
                                       data_valor="{{(!empty($fedocumento->TOTAL_VENTA_SOLES) ? $fedocumento->TOTAL_VENTA_SOLES : 0.00) > 0.00 ? $fedocumento->TOTAL_VENTA_SOLES : 0.00}}"
                                       name='total_xml'
                                       value="{{(!empty($fedocumento->TOTAL_VENTA_SOLES) ? $fedocumento->TOTAL_VENTA_SOLES : 0.00) > 0.00 ? $fedocumento->TOTAL_VENTA_SOLES : 0.00}}"
                                       placeholder="0.00"
                                       autocomplete="off"
                                       class="form-control input-sm dinero"
                                       data-aw="1"
                                       readonly/>
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
                            {!! Form::select( 'tipo_descuento_asiento', $combo_descuento, !empty($asiento_compra) ? $asiento_compra[1][0]['COD_CATEGORIA_TIPO_DETRACCION'] : ((!empty($fedocumento->MONTO_DETRACCION_XML) ? $fedocumento->MONTO_DETRACCION_XML : 0.00) > 0.00 ? 'DCT0000000000002' : ''),
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
                                   value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['NRO_DETRACCION'] : '' }}">
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
                                   value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['FEC_DETRACCION'] : $fedocumento->FEC_VENTA }}">
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
                                   data_valor="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['CAN_DESCUENTO_DETRACCION'] : ((!empty($fedocumento->MONTO_DETRACCION_XML) ? $fedocumento->MONTO_DETRACCION_XML : 0.00) > 0.00 ? $fedocumento->PORC_DETRACCION : 0.00) }}"
                                   name='porcentaje_detraccion'
                                   value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['CAN_DESCUENTO_DETRACCION'] : ((!empty($fedocumento->MONTO_DETRACCION_XML) ? $fedocumento->MONTO_DETRACCION_XML : 0.00) > 0.00 ? $fedocumento->PORC_DETRACCION : 0.00) }}"
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
                                   data_valor="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['CAN_TOTAL_DETRACCION'] : ((!empty($fedocumento->MONTO_DETRACCION_XML) ? $fedocumento->MONTO_DETRACCION_XML : 0.00) > 0.00 ? $fedocumento->MONTO_DETRACCION_RED : 0.00) }}"
                                   name='total_detraccion_asiento'
                                   value="{{ !empty($asiento_compra) ? $asiento_compra[1][0]['CAN_TOTAL_DETRACCION'] : ((!empty($fedocumento->MONTO_DETRACCION_XML) ? $fedocumento->MONTO_DETRACCION_XML : 0.00) > 0.00 ? $fedocumento->MONTO_DETRACCION_RED : 0.00) }}"
                                   placeholder="0.00"
                                   autocomplete="off"
                                   class="form-control input-sm dinero"
                                   data-aw="1"
                                   readonly/>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>

    <div class="panel-body panel-body-contrast">

        <div class="tab-container tablageneral">
            <ul class="nav nav-tabs">
                <li class="active negrita"><a href="#astcompra" data-toggle="tab">COMPRA</a></li>
                <li class="negrita "><a href="#astreversion" data-toggle="tab">DIARIO REVERSION REPARABLE</a></li>
                <li class="negrita"><a href="#astdeduccion" data-toggle="tab">DIARIO DEDUCCIÓN ANTICIPO</a></li>
                <li class="negrita"><a href="#astpercepcion" data-toggle="tab">COMPRA - PERCEPCIÓN</a></li>
            </ul>
            <div class="tab-content">
                <div id="astcompra" class="tab-pane active cont">
                    <input type="hidden" id="asiento_cabecera_compra" name="asiento_cabecera_compra"
                           value="{{ json_encode(!empty($asiento_compra) ? $asiento_compra[1] : []) }}"/>
                    <input type="hidden" id="asiento_detalle_compra" name="asiento_detalle_compra"
                           value="{{ json_encode(!empty($asiento_compra) ? $asiento_compra[2] : []) }}"/>
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
                        @if(!empty($asiento_compra))
                            @foreach($asiento_compra[1] as $key => $asiento_cabecera)
                                <tr>
                                    <td class="col-base-imponible"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_IMPONIBLE'], 4, '.', ',') }}</td>
                                    <td class="col-base-imponible-10"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_IMPONIBLE_10'], 4, '.', ',') }}</td>
                                    <td class="col-base-ivap"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_AFECTO_IVAP'], 4, '.', ',') }}</td>
                                    <td class="col-base-inafecto"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_INAFECTA'], 4, '.', ',') }}</td>
                                    <td class="col-base-exonerado"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_EXONERADA'], 4, '.', ',') }}</td>
                                    <td class="col-igv"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_IGV'], 4, '.', ',') }}</td>
                                    <td class="col-ivap"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_IVAP'], 4, '.', ',') }}</td>
                                    <td class="col-total" style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_IMPONIBLE'] +
                                        $asiento_cabecera['TOTAL_BASE_IMPONIBLE_10'] +
                                        $asiento_cabecera['TOTAL_AFECTO_IVAP'] +
                                        $asiento_cabecera['TOTAL_BASE_INAFECTA'] +
                                        $asiento_cabecera['TOTAL_BASE_EXONERADA'] +
                                        $asiento_cabecera['TOTAL_IGV'] + $asiento_cabecera['TOTAL_IVAP'], 4, '.', ',') }}</td>
                                </tr>
                            @endforeach
                        @else
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
                        @endif
                        </tbody>
                    </table>
                    <button data="C" type="button" class="btn btn-success agregar-linea">
                        ➕ Agregar línea
                    </button>
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
                        @if(!empty($asiento_compra))
                            @foreach($asiento_compra[2] as $key => $asiento_movimiento)
                                <tr class="fila" data_codigo="{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}"
                                    data_asiento="C"
                                    data_moneda="{{ $asiento_compra[1][0]['COD_CATEGORIA_MONEDA'] }}"
                                    data_tc="{{ $asiento_compra[1][0]['CAN_TIPO_CAMBIO'] }}">
                                    <td class="col-codigo">{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}</td>
                                    <td class="col-cuenta">{{ $asiento_movimiento['TXT_CUENTA_CONTABLE'] }}</td>
                                    <td class="col-glosa">{{ $asiento_movimiento['TXT_GLOSA'] }}</td>
                                    <td class="col-debe-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_MN'], 4, '.', ',') }}</td>
                                    <td class="col-haber-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_MN'], 4, '.', ',') }}</td>
                                    <td class="col-debe-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_ME'], 4, '.', ',') }}</td>
                                    <td class="col-haber-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_ME'], 4, '.', ',') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary editar-cuenta">
                                            ✏ Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-cuenta">
                                            🗑 Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>
                <div id="astreversion" class="tab-pane cont">
                    <input type="hidden" id="asiento_cabecera_reparable_reversion"
                           name="asiento_cabecera_reparable_reversion"
                           value="{{ json_encode(!empty($asiento_reparable_reversion) ? $asiento_reparable_reversion[1] : []) }}"/>
                    <input type="hidden" id="asiento_detalle_reparable_reversion"
                           name="asiento_detalle_reparable_reversion"
                           value="{{ json_encode(!empty($asiento_reparable_reversion) ? $asiento_reparable_reversion[2] : []) }}"/>
                    <button data="RV" type="button" class="btn btn-success agregar-linea">
                        ➕ Agregar línea
                    </button>
                    <table id="asientodetallereversion"
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
                        @if(!empty($asiento_reparable_reversion))
                            @foreach($asiento_reparable_reversion[2] as $key => $asiento_movimiento)
                                <tr class="fila" data_codigo="{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}"
                                    data_asiento="RV"
                                    data_moneda="{{ $asiento_compra[1][0]['COD_CATEGORIA_MONEDA'] }}"
                                    data_tc="{{ $asiento_compra[1][0]['CAN_TIPO_CAMBIO'] }}">
                                    <td class="col-codigo">{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}</td>
                                    <td class="col-cuenta">{{ $asiento_movimiento['TXT_CUENTA_CONTABLE'] }}</td>
                                    <td class="col-glosa">{{ $asiento_movimiento['TXT_GLOSA'] }}</td>
                                    <td class="col-debe-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_MN'], 4, '.', ',') }}</td>
                                    <td class="col-haber-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_MN'], 4, '.', ',') }}</td>
                                    <td class="col-debe-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_ME'], 4, '.', ',') }}</td>
                                    <td class="col-haber-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_ME'], 4, '.', ',') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary editar-cuenta">
                                            ✏ Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-cuenta">
                                            🗑 Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>

                <div id="astdeduccion" class="tab-pane cont">
                    <input type="hidden" id="asiento_cabecera_deduccion" name="asiento_cabecera_deduccion"
                           value="{{ json_encode(!empty($asiento_deduccion) ? $asiento_deduccion[1] : []) }}"/>
                    <input type="hidden" id="asiento_detalle_deduccion" name="asiento_detalle_deduccion"
                           value="{{ json_encode(!empty($asiento_deduccion) ? $asiento_deduccion[2] : []) }}"/>
                    <button data="D" type="button" class="btn btn-success agregar-linea">
                        ➕ Agregar línea
                    </button>
                    <table id="asientodetallededuccion"
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
                        @if(!empty($asiento_deduccion))
                            @foreach($asiento_deduccion[2] as $key => $asiento_movimiento)
                                <tr class="fila" data_codigo="{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}"
                                    data_asiento="D"
                                    data_moneda="{{ $asiento_compra[1][0]['COD_CATEGORIA_MONEDA'] }}"
                                    data_tc="{{ $asiento_compra[1][0]['CAN_TIPO_CAMBIO'] }}">
                                    <td class="col-codigo">{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}</td>
                                    <td class="col-cuenta">{{ $asiento_movimiento['TXT_CUENTA_CONTABLE'] }}</td>
                                    <td class="col-glosa">{{ $asiento_movimiento['TXT_GLOSA'] }}</td>
                                    <td class="col-debe-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_MN'], 4, '.', ',') }}</td>
                                    <td class="col-haber-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_MN'], 4, '.', ',') }}</td>
                                    <td class="col-debe-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_ME'], 4, '.', ',') }}</td>
                                    <td class="col-haber-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_ME'], 4, '.', ',') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary editar-cuenta">
                                            ✏ Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-cuenta">
                                            🗑 Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>

                <div id="astpercepcion" class="tab-pane cont">
                    <input type="hidden" id="asiento_cabecera_percepcion" name="asiento_cabecera_percepcion"
                           value="{{ json_encode(!empty($asiento_percepcion) ? $asiento_percepcion[1] : []) }}"/>
                    <input type="hidden" id="asiento_detalle_percepcion" name="asiento_detalle_percepcion"
                           value="{{ json_encode(!empty($asiento_percepcion) ? $asiento_percepcion[2] : []) }}"/>
                    <table id="asiento_totales_percepcion"
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
                        @if(!empty($asiento_percepcion))
                            @foreach($asiento_percepcion[1] as $key => $asiento_cabecera)
                                <tr>
                                    <td class="col-base-imponible"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_IMPONIBLE'], 4, '.', ',') }}</td>
                                    <td class="col-base-imponible-10"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_IMPONIBLE_10'], 4, '.', ',') }}</td>
                                    <td class="col-base-ivap"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_AFECTO_IVAP'], 4, '.', ',') }}</td>
                                    <td class="col-base-inafecto"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_INAFECTA'], 4, '.', ',') }}</td>
                                    <td class="col-base-exonerado"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_EXONERADA'], 4, '.', ',') }}</td>
                                    <td class="col-igv"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_IGV'], 4, '.', ',') }}</td>
                                    <td class="col-ivap"
                                        style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_IVAP'], 4, '.', ',') }}</td>
                                    <td class="col-total" style="text-align: right">{{ number_format($asiento_cabecera['TOTAL_BASE_IMPONIBLE'] +
                                        $asiento_cabecera['TOTAL_BASE_IMPONIBLE_10'] +
                                        $asiento_cabecera['TOTAL_AFECTO_IVAP'] +
                                        $asiento_cabecera['TOTAL_BASE_INAFECTA'] +
                                        $asiento_cabecera['TOTAL_BASE_EXONERADA'] +
                                        $asiento_cabecera['TOTAL_IGV'] + $asiento_cabecera['TOTAL_IVAP'], 4, '.', ',') }}</td>
                                </tr>
                            @endforeach
                        @else
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
                        @endif
                        </tbody>
                    </table>

                    <button data="P" type="button" class="btn btn-success agregar-linea">
                        ➕ Agregar línea
                    </button>

                    <table id="asientodetallepercepcion"
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
                        @if(!empty($asiento_percepcion))
                            @foreach($asiento_percepcion[2] as $key => $asiento_movimiento)
                                <tr class="fila" data_codigo="{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}"
                                    data_asiento="P"
                                    data_moneda="{{ $asiento_compra[1][0]['COD_CATEGORIA_MONEDA'] }}"
                                    data_tc="{{ $asiento_compra[1][0]['CAN_TIPO_CAMBIO'] }}">
                                    <td class="col-codigo">{{ $asiento_movimiento['COD_ASIENTO_MOVIMIENTO'] }}</td>
                                    <td class="col-cuenta">{{ $asiento_movimiento['TXT_CUENTA_CONTABLE'] }}</td>
                                    <td class="col-glosa">{{ $asiento_movimiento['TXT_GLOSA'] }}</td>
                                    <td class="col-debe-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_MN'], 4, '.', ',') }}</td>
                                    <td class="col-haber-mn"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_MN'], 4, '.', ',') }}</td>
                                    <td class="col-debe-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_DEBE_ME'], 4, '.', ',') }}</td>
                                    <td class="col-haber-me"
                                        style="text-align: right">{{ number_format($asiento_movimiento['CAN_HABER_ME'], 4, '.', ',') }}</td>
                                    <td>
                                        <button type="button" class="btn btn-sm btn-primary editar-cuenta">
                                            ✏ Editar
                                        </button>
                                        <button type="button" class="btn btn-sm btn-danger eliminar-cuenta">
                                            🗑 Eliminar
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                </div>

            </div>
        </div>

        <div class="editarcuentas" style="border-radius: 10px; padding: 10px">

            <div class="col-md-12"
                 style="background: #1d3a6d; color: white; padding: 10px; border-radius: 10px">
                <h4 id="titulodetalle">Agregar o Modificar Detalle</h4>
            </div>

            <div class="col-md-12" style="background: white;">

                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-2">
                    <div class="form-group">
                        <label class="col-sm-12 control-label labelleft negrita">Nivel:</label>
                        <div class="col-sm-12 abajocaja">
                            {!! Form::select( 'nivel', $combo_nivel_pc, '6',
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
                            {!! Form::select( 'partida_id', $combo_partida, '',
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
                            {!! Form::select( 'cuenta_contable_id', $combo_cuenta, '',
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
                            {!! Form::select( 'tipo_igv_id', $combo_tipo_igv, '',
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
                            {!! Form::select( 'porc_tipo_igv_id', $combo_porc_tipo_igv, '',
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
                            {!! Form::select( 'activo', $combo_activo, '1',
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
                        <button type="button" class="btn btn-lg btn-default btn-regresar-lista">Regresar</button>
                        <button type="button" class="btn btn-lg btn-success btn-registrar-movimiento">Registrar</button>
                        <button type="button" class="btn btn-lg btn-primary btn-editar-movimiento">Editar</button>
                    </div>
                </div>
            </div>


        </div>

    </div>

</div>
