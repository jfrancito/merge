@extends('layouts.app')

@section('title', 'Importador Consolidado Multi-Empresa')

@section('breadcrumb')
    <div class="breadcrumb-card mb-25 d-md-flex align-items-center justify-content-between">
        <h5 class="mb-0">
            Importador Consolidado Multi-Empresa 
            <button type="button" class="btn btn-sm btn-info text-white ms-2 rounded-pill" data-bs-toggle="modal" data-bs-target="#modalManualUsuario" title="Ver manual y reglas del módulo">
                <i class="material-symbols-outlined fs-16 align-middle">help</i> ¿Cómo funciona?
            </button>
        </h5>
        <ol class="breadcrumb list-unstyled mt-0 mb-0 p-0">
            <li class="breadcrumb-item d-inline-block position-relative">
                <a href="{{ url('/bienvenido') }}" class="d-inline-block position-relative">
                    <i class="material-symbols-outlined">home</i> Inicio
                </a>
            </li>
            <li class="breadcrumb-item d-inline-block position-relative">Importador Consolidado</li>
        </ol>
    </div>
@endsection

@push('styles')
    <style>
        .holding-badge {
            background: linear-gradient(135deg, #1e3c72 0%, #2a5298 100%);
            color: #ffffff;
            font-weight: 700;
            font-size: 11px;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .upload-zone {
            border: 2.5px dashed #b8c8e8;
            border-radius: 16px;
            background: linear-gradient(135deg, #f0f4fa 0%, #e8edf6 100%);
            padding: 40px 30px;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            position: relative;
        }

        .upload-zone:hover,
        .upload-zone.dragover {
            border-color: #4a6fa5;
            background: linear-gradient(135deg, #e3ebf6 0%, #dce3ed 100%);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(74, 111, 165, 0.15);
        }

        .upload-zone .upload-icon {
            font-size: 56px;
            color: #4a6fa5;
            margin-bottom: 12px;
            display: block;
        }

        .upload-zone .upload-text {
            font-size: 16px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 6px;
        }

        .upload-zone .upload-hint {
            font-size: 13px;
            color: #6b7b8d;
        }

        .file-selected {
            background: #e8f5e9 !important;
            border-color: #66bb6a !important;
        }

        .file-selected .upload-icon {
            color: #43a047 !important;
        }

        .step-badge {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: 16px;
            color: #fff;
            flex-shrink: 0;
        }

        .prefix-pill {
            background-color: #e3ebf6;
            color: #1e3c72;
            padding: 2px 8px;
            font-size: 11px;
            font-weight: 700;
            border-radius: 4px;
            margin-right: 4px;
        }
    </style>
@endpush

@section('content')
    @if($holding)
        <div class="row mb-4">
            <div class="col-12">
                <div class="card bg-white border-0 rounded-3 shadow-sm">
                    <div class="card-body p-4">
                        <div class="d-md-flex align-items-center justify-content-between">
                            <div>
                                <h4 class="fw-bold mb-1">Estructura del Holding (Grupo de Empresas Relacionadas)</h4>
                                <p class="text-secondary mb-0">Los artículos se asignan automáticamente según el catálogo existente o sus prefijos de código.</p>
                            </div>
                            <div class="text-end mt-3 mt-md-0">
                                <span class="holding-badge d-inline-block mb-2">
                                    <i class="material-symbols-outlined fs-14 align-middle me-1">settings_input_composite</i> Holding Activo
                                </span><br>
                                <button type="button" class="btn btn-sm btn-success fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#modalAgregarEmpresa">
                                    <i class="material-symbols-outlined fs-18 align-middle">add_circle</i> Añadir Empresa Asociada
                                </button>
                                <button type="button" class="btn btn-sm btn-outline-danger fw-bold rounded-pill ms-2" id="btnDesactivarHolding">
                                    <i class="material-symbols-outlined fs-18 align-middle">power_settings_new</i> Desactivar
                                </button>
                            </div>
                        </div>

                        <hr class="my-3">

                        <div class="row">
                            @foreach($holding['empresas_asociadas'] as $asoc)
                                <div class="col-lg-4 col-md-6 mb-3">
                                    <div class="p-3 border rounded-3 bg-light bg-opacity-50">
                                        <div class="d-flex align-items-center gap-2 mb-2">
                                            <i class="material-symbols-outlined text-primary">domain</i>
                                            <h6 class="mb-0 fw-bold text-truncate" title="{{ $asoc['nombre_corto'] ?? $asoc['nombre'] ?? 'Empresa Asociada' }}">{{ $asoc['nombre_corto'] ?? $asoc['nombre'] ?? 'Empresa Asociada' }}</h6>
                                            <div class="ms-auto d-flex">
                                                <button type="button" class="btn btn-sm btn-outline-primary border-0 btn-editar-prefijos p-1 d-flex align-items-center justify-content-center" data-id="{{ $asoc['empresa_id'] }}" data-nombre="{{ $asoc['nombre_corto'] ?? $asoc['nombre'] ?? 'Empresa Asociada' }}" data-prefijos="{{ implode(', ', $asoc['prefijos']) }}" title="Editar Prefijos">
                                                    <i class="material-symbols-outlined" style="font-size: 18px;">edit</i>
                                                </button>
                                                @if($asoc['empresa_id'] !== $empresaActual->id)
                                                    <button type="button" class="btn btn-sm btn-outline-danger border-0 btn-quitar-empresa p-1 d-flex align-items-center justify-content-center" data-id="{{ $asoc['empresa_id'] }}" data-nombre="{{ $asoc['nombre_corto'] ?? $asoc['nombre'] ?? 'Empresa Asociada' }}" title="Quitar del Holding">
                                                        <i class="material-symbols-outlined" style="font-size: 18px;">delete</i>
                                                    </button>
                                                @endif
                                            </div>
                                        </div>
                                        <small class="text-muted d-block mb-2">RUC: <strong>{{ $asoc['ruc'] }}</strong></small>
                                        <div>
                                            <span class="text-secondary" style="font-size: 12px;">Prefijos de Artículo:</span>
                                            <div class="mt-1">
                                                @foreach($asoc['prefijos'] as $pref)
                                                    <span class="prefix-pill">{{ $pref }}</span>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            {{-- PASO 1: Subir Excel --}}
            <div class="col-lg-5 mb-4">
                <div class="card bg-white border-0 rounded-3 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <span class="step-badge bg-primary">1</span>
                            <div>
                                <h5 class="mb-0 fw-bold">Cargar Excel Consolidado</h5>
                                <small class="text-secondary">Suba la bitácora consolidada diaria</small>
                            </div>
                        </div>

                        {{-- Zona de carga --}}
                        <div class="upload-zone" id="uploadZone" onclick="document.getElementById('archivoExcel').click()">
                            <i class="material-symbols-outlined upload-icon" id="uploadIcon">cloud_upload</i>
                            <div class="upload-text" id="uploadText">Arrastre su archivo aquí o haga clic para seleccionar</div>
                            <div class="upload-hint" id="uploadHint">Solo archivos .xlsx o .xls. RUCs de 11 dígitos emiten Facturas, DNI emiten Boletas.</div>
                            <input type="file" id="archivoExcel" accept=".xlsx,.xls" style="display: none;">
                        </div>

                        {{-- Botón procesar --}}
                        <button
                            class="btn btn-primary w-100 mt-4 py-2 fw-bold d-flex align-items-center justify-content-center gap-2"
                            id="btnProcesar" disabled style="border-radius: 10px; font-size: 15px;">
                            <i class="material-symbols-outlined">upload_file</i> Importar y Enrutar Masivo
                        </button>

                        <div id="resultadoProceso" class="mt-3 d-none"></div>
                    </div>
                </div>
            </div>

            {{-- PASO 2: Bandeja de Pendientes consolidados por holding --}}
            <div class="col-lg-7 mb-4">
                <div class="card bg-white border-0 rounded-3 shadow-sm h-100">
                    <div class="card-body p-4">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div class="d-flex align-items-center gap-3">
                                <span class="step-badge bg-warning text-dark">2</span>
                                <div>
                                    <h5 class="mb-0 fw-bold">Comprobantes Pendientes</h5>
                                    <small class="text-secondary">
                                        <span id="contadorPendientes">{{ $pendientes->count() }}</span> documento(s) pendiente(s) en el holding
                                    </small>
                                </div>
                            </div>
                            @if($pendientes->count() > 0)
                                <div class="d-flex gap-2">
                                    <button class="btn btn-outline-danger d-flex align-items-center gap-2 fw-bold rounded-pill px-3"
                                        id="btnLimpiarPendientes" title="Deshacer carga y limpiar pendientes">
                                        <i class="material-symbols-outlined">delete_sweep</i>
                                    </button>
                                    <button class="btn btn-success d-flex align-items-center gap-2 fw-bold rounded-pill px-4"
                                        id="btnEmitirFacturas">
                                        <i class="material-symbols-outlined">send</i> Emitir a SUNAT
                                    </button>
                                </div>
                            @endif
                        </div>

                        @if($pendientes->count() > 0)
                            <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-hover align-middle mb-0" id="tablaPendientes" style="font-size: 13px;">
                                    <thead class="bg-light" style="position: sticky; top: 0; z-index: 1;">
                                        <tr>
                                            <th class="border-0 text-secondary" style="font-size: 11px;">EMPRESA</th>
                                            <th class="border-0 text-secondary" style="font-size: 11px;">TIPO</th>
                                            <th class="border-0 text-secondary" style="font-size: 11px;">COMPROBANTE</th>
                                            <th class="border-0 text-secondary" style="font-size: 11px;">CLIENTE</th>
                                            <th class="border-0 text-secondary text-end" style="font-size: 11px;">TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($pendientes as $p)
                                            <tr>
                                                <td class="fw-bold text-primary">
                                                    {{ collect($holding['empresas_asociadas'])->where('empresa_id', $p->empresa_id)->first()['nombre_corto'] ?? collect($holding['empresas_asociadas'])->where('empresa_id', $p->empresa_id)->first()['nombre'] ?? 'Asociada' }}
                                                </td>
                                                <td>
                                                    @if($p->tipo_comprobante === '01')
                                                        <span class="badge bg-info text-white">FACTURA</span>
                                                    @else
                                                        <span class="badge bg-secondary text-white">BOLETA</span>
                                                    @endif
                                                </td>
                                                <td class="fw-bold">{{ $p->serie }}-{{ str_pad($p->correlativo, 8, '0', STR_PAD_LEFT) }}</td>
                                                <td>
                                                    <div class="text-truncate" style="max-width: 150px;">
                                                        {{ $p->cliente ? $p->cliente->razon_social : 'CLIENTE VARIOS' }}
                                                    </div>
                                                    <small class="text-secondary">{{ $p->cliente ? $p->cliente->numero_documento : '-' }}</small>
                                                </td>
                                                <td class="text-end fw-bold text-success">S/ {{ number_format($p->total, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="material-symbols-outlined" style="font-size: 64px; color: #dce3ed;">inbox</i>
                                <p class="text-secondary mt-2">No hay comprobantes pendientes en el holding.<br>Suba un archivo consolidado para comenzar.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row justify-content-center mt-5">
            <div class="col-lg-6 col-md-8 text-center">
                <i class="material-symbols-outlined text-muted" style="font-size: 100px;">domain_disabled</i>
                <h3 class="fw-bold mt-4">Módulo Consolidado Inactivo</h3>
                <p class="text-secondary fs-5 mt-3 mb-5">
                    Actualmente, esta empresa funciona de manera individual y no actúa como un Holding. Si manejas ventas de múltiples razones sociales en un solo archivo de Excel, puedes activar el <strong>Importador Consolidado</strong>.
                </p>
                <button class="btn btn-success btn-lg px-5 py-3 fw-bold rounded-pill shadow-sm d-inline-flex align-items-center gap-2" id="btnActivarHolding">
                    <i class="material-symbols-outlined">power_settings_new</i> Activar Holding
                </button>
            </div>
        </div>
    @endif
@endsection

@section('modals')
    <!-- Modal Manual de Usuario -->
    <div class="modal fade" id="modalManualUsuario" tabindex="-1" aria-labelledby="modalManualUsuarioLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header bg-info text-white">
                    <h5 class="modal-title fw-bold" id="modalManualUsuarioLabel">
                        <i class="material-symbols-outlined align-middle me-1">menu_book</i> Manual de Usuario: Importador Consolidado
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body p-4 text-start">
                    
                    <h6 class="fw-bold text-primary mb-3">1. ¿Qué hace este módulo?</h6>
                    <p class="text-secondary" style="font-size: 14px;">
                        Este módulo te permite cargar un <strong>único archivo Excel</strong> que contiene las ventas diarias de múltiples empresas de tu grupo (Holding). El sistema es inteligente y se encarga de:
                    </p>
                    <ul class="text-secondary" style="font-size: 14px;">
                        <li><strong>Leer el Excel:</strong> Busca automáticamente las cabeceras (hasta en las primeras 10 filas) y extrae la información.</li>
                        <li><strong>Identificar a qué Empresa pertenece la venta:</strong> Usa el "Cód" (Prefijo del Artículo) o lo compara con tu catálogo existente.</li>
                        <li><strong>Identificar si es Factura o Boleta:</strong> Si detecta un RUC de 11 dígitos que empiece con 10 o 20, generará una <strong>Factura</strong>. De lo contrario, generará una <strong>Boleta</strong>.</li>
                        <li><strong>Agrupar por Documento (OS):</strong> Agrupa todas las filas que tengan el mismo "Documento de Origen" en un solo comprobante de SUNAT, sumando sus montos.</li>
                        <li><strong>Crear Clientes y Productos:</strong> Si el Cliente o el Producto no existe en la Base de Datos de la empresa destino, lo crea automáticamente.</li>
                    </ul>

                    <hr class="my-4">

                    <h6 class="fw-bold text-primary mb-3">2. Columnas obligatorias en el Excel</h6>
                    <p class="text-secondary" style="font-size: 14px;">
                        El sistema buscará palabras clave en las columnas de tu Excel. Los nombres no tienen que ser exactos, pero deben contener lo siguiente:
                    </p>
                    <div class="table-responsive">
                        <table class="table table-bordered table-sm" style="font-size: 13px;">
                            <thead class="table-light">
                                <tr>
                                    <th>Columna a detectar</th>
                                    <th>Palabras Clave (Cabeceras)</th>
                                    <th>¿Para qué sirve?</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr><td>Fecha de Emisión</td><td>Día / Fecha</td><td>La fecha del comprobante.</td></tr>
                                <tr><td>Documento de Origen</td><td>Documento</td><td>Ej: <code>OS/.0001-00001982</code>. Usado para agrupar ítems en 1 sola Boleta/Factura.</td></tr>
                                <tr><td>Razón Social</td><td>Cliente / Razón</td><td>Nombre o Razón social del cliente.</td></tr>
                                <tr><td>Nro. de Documento</td><td>DNI / RUC</td><td>DNI (8 dígitos) o RUC (11 dígitos). Si no hay, asignará 'CLIENTE VARIOS'.</td></tr>
                                <tr><td>Código de Producto</td><td>Cód / Codigo</td><td><strong>¡Obligatorio!</strong> Sus 2 primeras letras dictan a qué empresa va la venta (Ej: IN = Induamérica).</td></tr>
                                <tr><td>Descripción (Producto)</td><td>Artículo</td><td>El nombre del producto a vender.</td></tr>
                                <tr><td>Unidad de Medida</td><td>U. Med / Medida</td><td>Ej: <code>KGM</code>, <code>NIU</code>. Si está vacío, usa NIU por defecto.</td></tr>
                                <tr><td>Moneda</td><td>Moneda</td><td>Si dice <code>USD</code> o <code>$</code> será Dólares. Todo lo demás será Soles (PEN).</td></tr>
                                <tr><td>Cantidad</td><td>Cantidad</td><td>La cantidad a vender.</td></tr>
                                <tr><td>Precio con IGV</td><td>Precio</td><td>El precio final de venta por unidad. El sistema desglosará el IGV automáticamente.</td></tr>
                            </tbody>
                        </table>
                    </div>

                    <hr class="my-4">

                    <h6 class="fw-bold text-danger mb-3">3. Restricciones y Reglas Estrictas</h6>
                    <div class="alert alert-warning" style="font-size: 13px;">
                        <ul class="mb-0">
                            <li class="mb-2"><strong>El "Cód." es obligatorio:</strong> Si una fila del Excel no tiene Código de producto, será ignorada por completo.</li>
                            <li class="mb-2"><strong>La empresa destino debe existir en el Holding:</strong> Si subes un artículo con el prefijo "ZZ" y no hay ninguna empresa asociada que maneje el prefijo "ZZ", esa fila dará error.</li>
                            <li class="mb-2"><strong>Solo un comprobante de SUNAT por OS:</strong> Si en un mismo "Documento OS" pones artículos que pertenecen a <strong>diferentes empresas</strong>, el sistema se guiará por el primer artículo que lea y meterá todo a esa empresa. Cada OS debe ser exclusivo de una empresa.</li>
                            <li class="mb-2"><strong>Deshacer Carga:</strong> Si notas que cometiste un error, usa el botón rojo de la papelera para <strong>Limpiar Pendientes</strong> ANTES de presionar el botón verde. Esta acción borrará todo lo subido y evitará que la numeración (Correlativos) de SUNAT se dañe.</li>
                            <li><strong>Precios incluyen IGV:</strong> Asegúrate de que el "Precio" en tu Excel siempre sea el precio final (con IGV incluido). El sistema extraerá el Subtotal y el IGV matemáticamente.</li>
                        </ul>
                    </div>

                </div>
                <div class="modal-footer bg-light">
                    <button type="button" class="btn btn-secondary fw-bold rounded-pill px-4" data-bs-dismiss="modal">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    @if($holding)
        <!-- Modal Agregar Empresa -->
        <div class="modal fade" id="modalAgregarEmpresa" tabindex="-1" aria-labelledby="modalAgregarEmpresaLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-success text-white">
                        <h5 class="modal-title fw-bold" id="modalAgregarEmpresaLabel">Añadir Empresa al Holding</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formAgregarEmpresa">
                            <div class="mb-3">
                                <label for="addEmpresaId" class="form-label fw-bold">Seleccionar Empresa:</label>
                                <select class="form-select" id="addEmpresaId">
                                    <option value="">-- Seleccione una empresa disponible --</option>
                                    @foreach($empresasDisponibles as $ed)
                                        <option value="{{ $ed->id }}">{{ $ed->nombre }} (RUC: {{ $ed->ruc }})</option>
                                    @endforeach
                                </select>
                                @if($empresasDisponibles->isEmpty())
                                    <div class="form-text text-danger mt-1">No hay empresas adicionales disponibles en el sistema.</div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <label for="addPrefijos" class="form-label fw-bold">Prefijos de Artículo Iniciales:</label>
                                <input type="text" class="form-control" id="addPrefijos" placeholder="Ejemplo: XX, YY">
                                <div class="form-text">Separe los múltiples prefijos con comas (,).</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-success text-white fw-bold" id="btnGuardarNuevaEmpresa" {{ $empresasDisponibles->isEmpty() ? 'disabled' : '' }}>Añadir Empresa</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Editar Prefijos -->
        <div class="modal fade" id="modalEditarPrefijos" tabindex="-1" aria-labelledby="modalEditarPrefijosLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title fw-bold" id="modalEditarPrefijosLabel">Editar Prefijos</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="formEditarPrefijos">
                            <input type="hidden" id="editEmpresaId">
                            <div class="mb-3">
                                <label class="form-label fw-bold">Empresa:</label>
                                <input type="text" class="form-control bg-light" id="editEmpresaNombre" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="editPrefijos" class="form-label fw-bold">Prefijos de Artículo:</label>
                                <input type="text" class="form-control" id="editPrefijos" placeholder="Ejemplo: CA, CB, CD">
                                <div class="form-text">Separe los múltiples prefijos con comas (,). Estos prefijos definirán a qué empresa se asignan las ventas.</div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary text-white" data-bs-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-primary text-white fw-bold" id="btnGuardarPrefijos">Guardar Prefijos</button>
                    </div>
                </div>
            </div>
        </div>
    @endif
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const uploadZone = document.getElementById('uploadZone');
            const fileInput = document.getElementById('archivoExcel');
            const btnProcesar = document.getElementById('btnProcesar');
            const btnEmitirFacturas = document.getElementById('btnEmitirFacturas');
            const resultadoProceso = document.getElementById('resultadoProceso');
            const uploadIcon = document.getElementById('uploadIcon');
            const uploadText = document.getElementById('uploadText');

            let selectedFile = null;

            // Drag and Drop
            if (uploadZone) {
                uploadZone.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    uploadZone.classList.add('dragover');
                });

                uploadZone.addEventListener('dragleave', () => {
                    uploadZone.classList.remove('dragover');
                });

                uploadZone.addEventListener('drop', (e) => {
                    e.preventDefault();
                    uploadZone.classList.remove('dragover');
                    if (e.dataTransfer.files.length > 0) {
                        handleFileSelect(e.dataTransfer.files[0]);
                    }
                });
            }

            if (fileInput) {
                fileInput.addEventListener('change', (e) => {
                    if (e.target.files.length > 0) {
                        handleFileSelect(e.target.files[0]);
                    }
                });
            }

            function handleFileSelect(file) {
                const ext = file.name.split('.').pop().toLowerCase();
                if (ext !== 'xlsx' && ext !== 'xls') {
                    Swal.fire('Formato Inválido', 'Por favor, seleccione un archivo de tipo Excel (.xlsx o .xls)', 'error');
                    return;
                }

                selectedFile = file;
                uploadZone.classList.add('file-selected');
                uploadIcon.innerText = 'check_circle';
                uploadText.innerText = `Archivo cargado: ${file.name}`;
                btnProcesar.disabled = false;
            }

            // Procesar Excel
            if (btnProcesar) {
                btnProcesar.addEventListener('click', function() {
                    if (!selectedFile) return;

                    const formData = new FormData();
                    formData.append('archivo_excel', selectedFile);
                    formData.append('_token', '{{ csrf_token() }}');

                    btnProcesar.disabled = true;
                    btnProcesar.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Procesando...`;

                    fetch("{{ route('importador.procesar') }}", {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnProcesar.disabled = false;
                        btnProcesar.innerHTML = `<i class="material-symbols-outlined">upload_file</i> Importar y Enrutar Masivo`;

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Importación Exitosa!',
                                text: data.message,
                                confirmButtonText: 'Continuar'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            if (resultadoProceso) {
                                resultadoProceso.classList.remove('d-none');
                                let errHtml = `<div class="alert alert-danger"><h6 class="alert-heading fw-bold">${data.message}</h6>`;
                                if (data.errores && data.errores.length > 0) {
                                    errHtml += `<ul class="mb-0 mt-2" style="font-size:12px; max-height:150px; overflow-y:auto;">`;
                                    data.errores.forEach(err => {
                                        errHtml += `<li>${err}</li>`;
                                    });
                                    errHtml += `</ul>`;
                                }
                                errHtml += `</div>`;
                                resultadoProceso.innerHTML = errHtml;
                            } else {
                                Swal.fire('Error', data.message, 'error');
                            }
                        }
                    })
                    .catch(err => {
                        btnProcesar.disabled = false;
                        btnProcesar.innerHTML = `<i class="material-symbols-outlined">upload_file</i> Importar y Enrutar Masivo`;
                        Swal.fire('Error', 'Ocurrió un error inesperado al procesar el archivo.', 'error');
                    });
                });
            }

            // Emitir Facturas Masivamente a SUNAT
            if (btnEmitirFacturas) {
                btnEmitirFacturas.addEventListener('click', function() {
                    btnEmitirFacturas.disabled = true;
                    btnEmitirFacturas.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Emitiendo...`;

                    fetch("{{ route('importador.emitir_facturas') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        btnEmitirFacturas.disabled = false;
                        btnEmitirFacturas.innerHTML = `<i class="material-symbols-outlined">send</i> Emitir a SUNAT`;

                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Emisión Completa',
                                text: data.message,
                                confirmButtonText: 'OK'
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire('Error de Emisión', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        btnEmitirFacturas.disabled = false;
                        btnEmitirFacturas.innerHTML = `<i class="material-symbols-outlined">send</i> Emitir a SUNAT`;
                        Swal.fire('Error', 'Ocurrió un error inesperado al emitir las facturas.', 'error');
                    });
                });
            }

            // Limpiar Pendientes
            const btnLimpiarPendientes = document.getElementById('btnLimpiarPendientes');
            if (btnLimpiarPendientes) {
                btnLimpiarPendientes.addEventListener('click', function() {
                    Swal.fire({
                        title: '¿Deshacer carga y limpiar pendientes?',
                        text: "Se eliminarán TODOS los comprobantes pendientes actuales en el holding y se restaurarán los correlativos. Esta acción no se puede deshacer.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, limpiar todo',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            btnLimpiarPendientes.disabled = true;
                            btnLimpiarPendientes.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>`;
                            
                            fetch("{{ route('importador.limpiar_pendientes') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Limpieza Completa',
                                        text: data.message,
                                        confirmButtonText: 'OK'
                                    }).then(() => {
                                        window.location.reload();
                                    });
                                } else {
                                    btnLimpiarPendientes.disabled = false;
                                    btnLimpiarPendientes.innerHTML = `<i class="material-symbols-outlined">delete_sweep</i>`;
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(err => {
                                btnLimpiarPendientes.disabled = false;
                                btnLimpiarPendientes.innerHTML = `<i class="material-symbols-outlined">delete_sweep</i>`;
                                Swal.fire('Error', 'Ocurrió un error al limpiar los pendientes.', 'error');
                            });
                        }
                    });
                });
            }

            // Agregar Empresa al Holding
            const btnGuardarNuevaEmpresa = document.getElementById('btnGuardarNuevaEmpresa');
            if(btnGuardarNuevaEmpresa) {
                btnGuardarNuevaEmpresa.addEventListener('click', function() {
                    const empresaId = document.getElementById('addEmpresaId').value;
                    const prefijos = document.getElementById('addPrefijos').value;

                    if (!empresaId) {
                        Swal.fire('Advertencia', 'Por favor, seleccione una empresa.', 'warning');
                        return;
                    }

                    if (!prefijos.trim()) {
                        Swal.fire('Advertencia', 'Debe especificar al menos un prefijo inicial.', 'warning');
                        return;
                    }

                    this.disabled = true;
                    this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Añadiendo...`;

                    const formData = new FormData();
                    formData.append('empresa_id', empresaId);
                    formData.append('prefijos', prefijos);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch("{{ route('importador.agregar_empresa') }}", {
                        method: 'POST',
                        body: formData
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            this.disabled = false;
                            this.innerHTML = `Añadir Empresa`;
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.innerHTML = `Añadir Empresa`;
                        Swal.fire('Error', 'Ocurrió un error al intentar añadir la empresa.', 'error');
                    });
                });
            }

            // Modal Editar Prefijos
            const modalEl = document.getElementById('modalEditarPrefijos');
            if (modalEl) {
                const modalEditarPrefijos = new bootstrap.Modal(modalEl);
                
                document.querySelectorAll('.btn-editar-prefijos').forEach(btn => {
                    btn.addEventListener('click', function() {
                        document.getElementById('editEmpresaId').value = this.getAttribute('data-id');
                        document.getElementById('editEmpresaNombre').value = this.getAttribute('data-nombre');
                        document.getElementById('editPrefijos').value = this.getAttribute('data-prefijos');
                        modalEditarPrefijos.show();
                    });
                });

                const btnGuardarPrefijos = document.getElementById('btnGuardarPrefijos');
                if (btnGuardarPrefijos) {
                    btnGuardarPrefijos.addEventListener('click', function() {
                        const empresaId = document.getElementById('editEmpresaId').value;
                        const prefijos = document.getElementById('editPrefijos').value;

                        if (!prefijos.trim()) {
                            Swal.fire('Advertencia', 'Debe especificar al menos un prefijo.', 'warning');
                            return;
                        }

                        this.disabled = true;
                        this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Guardando...`;

                        const formData = new FormData();
                        formData.append('empresa_id', empresaId);
                        formData.append('prefijos', prefijos);
                        formData.append('_token', '{{ csrf_token() }}');

                        fetch("{{ route('importador.actualizar_prefijos') }}", {
                            method: 'POST',
                            body: formData
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                window.location.reload();
                            } else {
                                this.disabled = false;
                                this.innerHTML = `Guardar Prefijos`;
                                Swal.fire('Error', data.message, 'error');
                            }
                        })
                        .catch(err => {
                            this.disabled = false;
                            this.innerHTML = `Guardar Prefijos`;
                            Swal.fire('Error', 'Ocurrió un error al intentar actualizar.', 'error');
                        });
                    });
                }
            }

            // Quitar Empresa del Holding con SweetAlert2
            document.querySelectorAll('.btn-quitar-empresa').forEach(btn => {
                btn.addEventListener('click', function() {
                    const empresaId = this.getAttribute('data-id');
                    const empresaNombre = this.getAttribute('data-nombre');

                    Swal.fire({
                        title: '¿Estás seguro?',
                        text: `Deseas remover a "${empresaNombre}" del Holding. Los comprobantes con sus prefijos ya no serán procesados.`,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, remover',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            const formData = new FormData();
                            formData.append('empresa_id', empresaId);
                            formData.append('_token', '{{ csrf_token() }}');

                            fetch("{{ route('importador.quitar_empresa') }}", {
                                method: 'POST',
                                body: formData
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(err => {
                                Swal.fire('Error', 'Ocurrió un error inesperado al intentar quitar la empresa.', 'error');
                            });
                        }
                    });
                });
            });

            // Activar Holding
            const btnActivarHolding = document.getElementById('btnActivarHolding');
            if (btnActivarHolding) {
                btnActivarHolding.addEventListener('click', function() {
                    this.disabled = true;
                    this.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Activando...`;

                    fetch("{{ route('importador.activar') }}", {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            window.location.reload();
                        } else {
                            this.disabled = false;
                            this.innerHTML = `<i class="material-symbols-outlined">power_settings_new</i> Activar Holding`;
                            Swal.fire('Error', data.message, 'error');
                        }
                    })
                    .catch(err => {
                        this.disabled = false;
                        this.innerHTML = `<i class="material-symbols-outlined">power_settings_new</i> Activar Holding`;
                        Swal.fire('Error', 'Ocurrió un error al activar.', 'error');
                    });
                });
            }

            // Desactivar Holding
            const btnDesactivarHolding = document.getElementById('btnDesactivarHolding');
            if (btnDesactivarHolding) {
                btnDesactivarHolding.addEventListener('click', function() {
                    Swal.fire({
                        title: '¿Desactivar Holding?',
                        text: "Esta empresa pasará a modo individual. Se ocultará la estructura del holding.",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Sí, Desactivar',
                        cancelButtonText: 'Cancelar'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            this.disabled = true;
                            fetch("{{ route('importador.desactivar') }}", {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    window.location.reload();
                                } else {
                                    this.disabled = false;
                                    Swal.fire('Error', data.message, 'error');
                                }
                            })
                            .catch(err => {
                                this.disabled = false;
                                Swal.fire('Error', 'Ocurrió un error al desactivar.', 'error');
                            });
                        }
                    });
                });
            }
        });
    </script>
@endpush
