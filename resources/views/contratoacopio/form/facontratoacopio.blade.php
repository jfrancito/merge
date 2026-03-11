<div class="modern-form-container">
    <div class="row">


        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">EMPRESA <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-collection-text"></i></span>
                    <input type="text" class="form-control "  id='empresa_actual' name='empresa_actual' required="" value="{{Session::get('empresas')->NOM_EMPR}}"  readonly>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">SEDE <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-collection-text"></i></span>
                    <input type="text" class="form-control "  id='sede' name='sede' required="" value="{{$centro->NOM_CENTRO}}"  readonly>
                </div>
            </div>
        </div>


        <!-- N° CONTRATO -->
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">N° CONTRATO <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-collection-text"></i></span>
                    <input type="text" class="form-control" id='nro_contrato' name='nro_contrato' required="" value="" placeholder="Solo caracteres alfanuméricos" data-parsley-pattern="/^[a-zA-Z0-9]+$/" data-parsley-error-message="Solo se permiten letras y números">
                </div>
            </div>
        </div>

        <!-- FECHA COSECHA -->
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">FECHA COSECHA <span class="text-danger">(*)</span></label>
                <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker pickerfecha">
                    <input size="16" type="text" value="" placeholder="Seleccione fecha" id='fecha_cosecha' name='fecha_cosecha' required="" class="form-control"/>
                    <span class="input-group-addon"><i class="icon-th mdi mdi-calendar"></i></span>
                </div>
            </div>
        </div>
    </div>

    <!-- The combo ajax -->
    <div class="row">

        <!-- PROVEEDOR -->
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-field">
                <label class="form-label">PROVEEDOR <span class="text-danger">(*)</span></label>
                {!! Form::select('empresa_id', $combo_empresa, array($empresa_id), ['class' => 'select2 form-control', 'id' => 'empresa_id', 'required' => '']) !!}
            </div>
        </div>

        <div class="col-xs-12 col-sm-6 col-md-3 ajax_combo_cuenta">
            @include('general.ajax.combocuentaanti')
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3 ajax_combo_subcuenta">
            @include('general.ajax.combosubcuentaanti')
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4 class="section-title"><i class="mdi mdi-chart-line"></i> Detalles de Producción y Financieros</h4>
            <hr class="section-divider">
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">VARIEDAD <span class="text-danger">(*)</span></label>
                {!! Form::select('variedad_id', $combo_variedad, array($variedad_id), ['class' => 'select2 form-control', 'id' => 'variedad_id', 'required' => '']) !!}
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">N° HECTÁREAS <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-texture"></i></span>
                    <input type="text" class="form-control importe" id='hectareas' name='hectareas' required="" value="" placeholder="0.00">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">TOTAL KG <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><i class="mdi mdi-weight"></i></span>
                    <input type="text" class="form-control importe" id='total' name='total' required="" value="" placeholder="0.00">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-3">
            <div class="form-field">
                <label class="form-label">PRECIO REFERENCIA <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><b>S/</b></span>
                    <input type="text" class="form-control importe" id='precio_referencia' name='precio_referencia' required="" value="" placeholder="0.00">
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top: 15px;">
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-field">
                <label class="form-label">PROYECCIÓN <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon"><b>S/</b></span>
                    <input type="text" class="form-control importe"  id='proyeccion' name='proyeccion' required="" value="" placeholder="0.00" readonly>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6">
            <div class="form-field highlight-box">
                <label class="form-label text-primary">IMPORTE A HABILITAR <span class="text-danger">(*)</span></label>
                <div class="input-group">
                    <span class="input-group-addon bg-primary text-white" style="border-color: #4285f4; background-color: #4285f4; color: #fff;"><b>S/</b></span>
                    <input type="text" class="form-control importe text-bold text-primary" id='importe_habilitar' name='importe_habilitar' required="" value="" placeholder="0.00">
                </div>
            </div>
        </div>
    </div>

    <!-- SECTION PROYECCIÓN DE ANTICIPOS -->
    <div class="row">
        <div class="col-xs-12">
            <h4 class="section-title" style="margin-bottom: 5px;"><i class="mdi mdi-format-list-bulleted"></i> Proyección de Anticipos</h4>
        </div>
    </div>
    
    <div class="row" style="background: #f8fbfe; border: 1px dashed #cbd5e0; padding: 15px 0; margin-bottom: 20px; border-radius: 8px; margin-left: 0; margin-right: 0;">
        <div class="col-xs-12 col-sm-3">
            <div class="form-field">
                <label class="form-label">FECHA ANTICIPO</label>
                <div data-min-view="2" data-date-format="dd-mm-yyyy" class="input-group date datetimepicker pickerfecha">
                    <input size="16" type="text" value="" placeholder="Seleccione fecha" id="fecha_detalle_input" class="form-control input-sm"/>
                    <span class="input-group-addon btn btn-primary"><i class="icon-th mdi mdi-calendar"></i></span>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-5">

            <div class="form-field">
                <label class="form-label">TERCERO A PAGAR <span class="text-danger">(*)</span></label>
                {!! Form::select('tercero_id_detalle_input', $combo_empresa, array($empresa_id), ['class' => 'select2 form-control', 'id' => 'tercero_id_detalle_input']) !!}
            </div>


        </div>
        <div class="col-xs-12 col-sm-2">
            <div class="form-field">
                <label class="form-label">IMPORTE</label>
                <div class="input-group">
                    <span class="input-group-addon"><b>S/</b></span>
                    <input type="text" id="importe_detalle_input" class="form-control input-sm importe_mask" placeholder="0.00">
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-2" style="display: flex; align-items: flex-end; padding-bottom: 20px;margin-top: 24px;">
            <button type="button" class="btn btn-success btn-block btn-agregar-detalle" style="height: 38px; font-weight: bold;">
                <i class="mdi mdi-plus-circle"></i> AGREGAR
            </button>
        </div>
    </div>

    <div class="row" style="margin-bottom: 25px;">
        <div class="col-xs-12">
            <div class="table-responsive">
                <table id="tabla-proyeccion" class="table table-bordered custom-table" style="background:#fff; border: 1px solid #cbd5e0;">
                    <thead style="background: #f7fafc; color: #4a5568;">
                        <tr>
                            <th style="width: 20%; font-weight: 600;">FECHA</th>
                            <th style="width: 50%; font-weight: 600;">TERCERO A PAGAR</th>
                            <th style="width: 20%; font-weight: 600;">IMPORTE</th>
                            <th style="width: 10%; font-weight: 600; text-align: center;">ACCIÓN</th>
                        </tr>
                    </thead>
                    <tbody id="tbody-proyeccion">
                        <!-- Filas dinámicas aquí -->
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="2" class="text-right" style="background-color: #2c3e50; color: white; font-weight: bold; font-size: 14px; text-align: right; vertical-align: middle;">TOTAL S/</th>
                            <th colspan="2" style="background-color: #2c3e50; color: white; font-size: 15px; font-weight: bold; vertical-align: middle;" id="footer-total">0.00</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div class="form-field">
                <label class="form-label">OBSERVACIÓN / GLOSA</label>
                <textarea name="glosa" id="glosa" class="form-control" rows="3" style="resize: none; height: auto !important;" placeholder="Ingrese alguna observación o detalle adicional aquí..."></textarea>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <h4 class="section-title"><i class="mdi mdi-cloud-upload"></i> Documentación Adjunta</h4>
            <hr class="section-divider">
        </div>
    </div>

    <div class="row">
        @foreach($tarchivos as $index => $item) 
            <div class="col-xs-12 col-md-6">
                <div class="form-field sectioncargarimagen mb-3">
                    <label class="form-label">{{$item->NOM_CATEGORIA}} ({{$item->COD_CTBLE}})</label>
                    <div class="file-loading">
                        <input id="file-{{$item->COD_CATEGORIA}}" name="{{$item->COD_CATEGORIA}}[]" class="file-es" type="file" multiple data-max-file-count="1" required>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>






