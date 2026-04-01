
<div class="container-fluid ordenpedido">
    <input type="hidden" id="tipo_cambio_actual" value="{{ $valor_tipo_cambio }}">
    <input type="hidden" id="id_cotizacion_edit" value="">

    <!-- HEADER PRINCIPAL -->
    <div class="panel panel-default shadow-premium">
        <div class="panel-heading header-principal">
            <i class="mdi mdi-receipt" style="margin-right: 8px;"></i> COTIZACIÓN ORDEN PEDIDO
        </div>

        <div class="panel-body">
            
            <!-- ALERTA TIPO DE CAMBIO -->
            @if($valor_tipo_cambio <= 0)
                <div class="alert alert-warning alert-dismissible shadow-soft" role="alert" style="border-radius: 8px; border-left: 5px solid #f39c12;">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <i class="mdi mdi-information-outline" style="font-size: 20px; vertical-align: middle; margin-right: 10px;"></i>
                    <strong>Nota:</strong> No se ha registrado el tipo de cambio para hoy ({{ date('d-m-Y') }}). El sistema no podrá realizar la conversión a dólares automáticamente.
                </div>
            @endif

            <!-- SECCIÓN: DATOS DE CABECERA -->
            <div class="panel panel-default box-seccion">
                <div class="panel-heading subheader-seccion">
                    <i class="mdi mdi-file-document"></i> Datos Generales
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>N° Cotización</label>
                                <input type="text" class="form-control premium-input text-center" id="nro_cotizacion" value="{{ $nro_cotizacion }}" readonly>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-group">
                                <label>Serie</label>
                                <input type="text" class="form-control premium-input text-center" id="serie" placeholder="S001" maxlength="4" oninput="this.value = this.value.toUpperCase().replace(/[^0-9A-Z]/g, '')">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Número</label>
                                <input type="text" class="form-control premium-input" id="numero" placeholder="Escriba el número...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Fecha</label>
                                <div class="input-group">
                                    <input type="date" class="form-control premium-input" id="fecha_cotizacion" value="{{ date('Y-m-d') }}">
                                    <span class="input-group-addon addon-premium"><i class="mdi mdi-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- SECCIÓN: PROVEEDOR -->
            <div class="panel panel-default box-seccion">
                <div class="panel-heading subheader-seccion">
                    <i class="mdi mdi-account-box"></i> Información del Proveedor
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>RUC / Documento</label>
                                <div class="input-group">
                                    <input type="text" class="form-control premium-input" id="ruc_proveedor" placeholder="Buscar RUC...">
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary btn-search-premium" type="button">
                                            <i class="mdi mdi-search"></i>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>Razón Social / Nombre</label>
                                <input type="text" class="form-control premium-input" id="nombre_proveedor" placeholder="Nombre completo del proveedor...">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" class="form-control premium-input" id="direccion" placeholder="Calle, Av, Jr...">
                            </div>
                        </div>
                    </div>
                    <div class="row" style="margin-top: 10px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" class="form-control premium-input" id="telefono" placeholder="+51 ...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tipo de Crédito</label>
                                {!! Form::select( 'tipo_pago_id', $combo_tipo_pago, null,
                                    ['class' => 'form-control select2 premium-input' , 'id' => 'tipo_pago_id', 'required' => 'required']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Validez Cotización</label>
                                <input type="text" class="form-control premium-input" id="validez" placeholder="Ej: 15 días...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Tiempo de Entrega</label>
                                <input type="text" class="form-control premium-input" id="entrega" placeholder="Ej: 3 días hábiles...">
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 15px;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Moneda</label>
                                {!! Form::select( 'moneda_id', $combo_moneda, null,
                                    ['class' => 'form-control select2 premium-input' , 'id' => 'moneda_id', 'required' => 'required']) 
                                !!}
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Observación</label>
                                <input type="text" class="form-control premium-input" id="observacion" placeholder="Notas adicionales...">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label>Total Estimado</label>
                                <div class="input-group">
                                    <span class="input-group-addon addon-premium moneda-simbolo">S/</span>
                                    <input type="number" class="form-control premium-input text-right font-bold" id="total" value="0.00" step="0.01" readonly style="background-color: #f8f9fa; cursor: not-allowed; color: #1d3a6d;">
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-center" style="margin-top: 25px;">
                            <button class="btn btn-info btn-block btn-seleccionar-consolidados shadow-soft">
                                <i class="mdi mdi-layers" style="margin-right: 5px;"></i> Seleccionar Consolidados
                            </button>
                        </div>
                    </div>
                </div>
            </div>

           

            <!-- TABLA DE PRODUCTOS -->
            <div id="lista-productos-cotizacion" class="mt-4">
                <div class="text-center p-5 message-empty">
                    <i class="mdi mdi-cart-outline icon-large"></i>
                    <p>Seleccione los consolidados para cargar los productos a cotizar.</p>
                </div>
            </div>

             <!-- SECCIÓN: ARCHIVO ADJUNTO (PDF) -->
            <div class="panel panel-default box-seccion shadow-soft" style="border-left: 5px solid #3498db;">
                <div class="panel-heading subheader-seccion">
                    <i class="mdi mdi-upload"></i> Archivo
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group mb-0">
                                <label class="text-primary"><i class="fa fa-file-pdf-o"></i> Seleccionar Cotización Firmada / PDF</label>
                                <input type="file" id="archivo_cotizacion_crear" class="form-control premium-input" accept=".pdf" style="padding: 7px;">
                                <p class="help-block" style="font-size: 12px; margin-top: 5px; color: #777;">
                                    <i class="fa fa-info-circle"></i> El archivo se subirá automáticamente al servidor remoto al momento de "Generar Cotización".
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- BOTONES DE ACCIÓN FINAL -->
            <div class="row" style="margin-top: 30px;">
                <div class="col-md-12 text-right">
                    <hr class="hr-premium">
                    <button class="btn btn-default btn-cancelar btn-lg shadow-soft">
                        <i class="mdi mdi-close"></i> Cancelar
                    </button>
                    <button class="btn btn-success btn-guardar-cotizacion btn-lg shadow-success" style="min-width: 180px;">
                        <i class="mdi mdi-content-save"></i> Generar Cotización
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<style>
    /* VARIABLES DE COLOR CUSTOM */
    :root {
        --primary-blue: #1d3a6d;
        --secondary-blue: #34495e;
        --border-color: #e1e6ef;
        --soft-bg: #f9fbfd;
        --header-gradient: linear-gradient(135deg, #1d3a6d 0%, #2980b9 100%);
    }

    /* CONTENEDOR PRINCIPAL */
    .ordenpedido {
        padding: 20px;
        background: #f4f7fa;
    }

    /* PANEL PRINCIPAL CON SOMBRA PREMIUM */
    .shadow-premium {
        box-shadow: 0 10px 25px rgba(29, 58, 109, 0.1);
        border: none;
        border-radius: 12px !important;
        overflow: hidden;
    }

    /* HEADER */
    .header-principal {
        background: var(--header-gradient) !important;
        color: #fff !important;
        font-size: 20px !important;
        font-weight: 700 !important;
        padding: 15px 20px !important;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* BOX SECCIONES */
    .box-seccion {
        background: #fff;
        border: 1px solid var(--border-color);
        border-radius: 10px !important;
        margin-bottom: 25px;
        transition: transform 0.3s ease;
    }

    .box-seccion:hover {
        border-color: #34aadc;
    }

    .subheader-seccion {
        background: var(--soft-bg) !important;
        font-weight: 600 !important;
        color: var(--secondary-blue) !important;
        font-size: 16px !important;
        border-bottom: 1px solid var(--border-color) !important;
        padding: 10px 15px !important;
        border-radius: 10px 10px 0 0 !important;
    }

    /* INPUTS PREMIUM */
    .premium-input {
        border-radius: 6px !important;
        border: 1px solid #ced4da;
        height: 40px !important;
        font-size: 15px;
        transition: all 0.3s;
    }

    .premium-input:focus {
        border-color: #2980b9;
        box-shadow: 0 0 0 3px rgba(41, 128, 185, 0.1);
        outline: none;
    }

    .addon-premium {
        background: #fdfdfd;
        border-radius: 6px 0 0 6px !important;
        color: var(--secondary-blue);
        font-weight: bold;
    }

    /* LABELS */
    .box-seccion label {
        font-size: 14px;
        font-weight: 700;
        color: #333;
        margin-bottom: 8px;
        display: block;
    }

    /* BOTONES */
    .btn-search-premium {
        height: 40px;
        border-radius: 0 6px 6px 0 !important;
    }

    .btn-seleccionar-consolidados {
        background: #17a2b8;
        border: none;
        font-weight: 700;
        border-radius: 8px;
        transition: all 0.3s;
        text-transform: uppercase;
        font-size: 13px;
        padding: 12px;
    }

    .btn-seleccionar-consolidados:hover {
        background: #138496;
        transform: translateY(-2px);
    }

    .shadow-soft {
        box-shadow: 0 4px 6px rgba(0,0,0,0.05);
    }

    .shadow-success {
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.2);
    }

    /* HR PREMIUM */
    .hr-premium {
        border-top: 2px solid #eee;
        margin: 20px 0;
    }

    /* MESSAGE EMPTY */
    .message-empty {
        background: #fcfcfc;
        border: 2px dashed #ddd;
        border-radius: 10px;
        color: #999;
    }

    .icon-large {
        font-size: 48px;
        display: block;
        margin-bottom: 10px;
    }

    .font-bold { font-weight: 700; }
    .mt-4 { margin-top: 20px; }

    @keyframes success-pulse {
        0% { border-color: #2980b9; box-shadow: 0 0 0 0px rgba(40, 167, 69, 0.4); }
        100% { border-color: #28a745; box-shadow: 0 0 0 10px rgba(40, 167, 69, 0); }
    }
    .success-pulse {
        animation: success-pulse 1s ease-out;
        border-color: #28a745 !important;
    }

</style>
