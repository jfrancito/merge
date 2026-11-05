<?php


/* |-------------------------------------------------------------------------- | Web Routes |-------------------------------------------------------------------------- | | Here is where you can register web routes for your application. These | routes are loaded by the RouteServiceProvider within a group which | contains the "web" middleware group. Now create something great! |
 */

/********************** USUARIOS *************************/
// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers: *');

Route::middleware(['guestaw'])->group(function () {
	Route::any('/', [\App\Http\Controllers\UserController::class, 'actionLogin']);
	Route::any('/login', [\App\Http\Controllers\UserController::class, 'actionLogin'])->name('login');
	Route::any('/acceso', [\App\Http\Controllers\UserController::class, 'actionAcceso']);
	Route::any('/accesobienvenido/{idempresa}', [\App\Http\Controllers\UserController::class, 'actionAccesoBienvenido']);

});

Route::any('/detalle-contrato-acopio/{nrocontrato}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionDetalleContratoAcopio']);

Route::get('/traer-compras-sunat', [\App\Http\Controllers\SunatController::class, 'actionComprasSunat']);


Route::get('/serve-file', [\App\Http\Controllers\FileController::class, 'serveFile'])->name('serve-file');
Route::get('/serve-filecontrato', [\App\Http\Controllers\FileController::class, 'serveFileContrato'])->name('serve-filecontrato');
Route::get('/serve-filenotacredito', [\App\Http\Controllers\FileController::class, 'serveFileNotaCredito'])->name('serve-filenotacredito');
Route::get('/serve-filenotadebito', [\App\Http\Controllers\FileController::class, 'serveFileNotaDebito'])->name('serve-filenotadebito');
Route::get('/serve-fileliquidacioncompraanticipo', [\App\Http\Controllers\FileController::class, 'serveFileLiquidacionCompraAnticipo'])->name('serve-fileliquidacioncompraanticipo');
Route::get('/serve-fileestiba', [\App\Http\Controllers\FileController::class, 'serveFileEstiba'])->name('serve-fileestiba');
Route::get('/serve-filelg', [\App\Http\Controllers\FileController::class, 'serveFileLG'])->name('serve-filelg');
Route::get('/serve-filepla', [\App\Http\Controllers\FileController::class, 'serveFilePlaC'])->name('serve-filepla');
Route::get('/serve-filerc', [\App\Http\Controllers\FileController::class, 'serveFileRC'])->name('serve-filerc');
Route::get('/serve-fileac', [\App\Http\Controllers\FileController::class, 'serveFileAC'])->name('serve-fileac');

Route::get('/serve-filefirma', [\App\Http\Controllers\FileController::class, 'serveFileFirma'])->name('serve-filefirma');
Route::get('/serve-fileordencompraanticipo', [\App\Http\Controllers\FileController::class, 'serveFileOrdenCompraAnticipo'])->name('serve-fileordencompraanticipo');

Route::get('/serve-filecontrato-sg', [\App\Http\Controllers\FileController::class, 'serveFileContratoSG'])->name('serve-filecontrato-sg');
Route::get('/serve-filepago', [\App\Http\Controllers\FileController::class, 'serveFilePago'])->name('serve-filepago');
Route::get('/serve-file-modelo', [\App\Http\Controllers\FileController::class, 'serveFileModelo'])->name('serve-file-modelo');
Route::any('/registrate', [\App\Http\Controllers\UserController::class, 'actionRegistrate']);
Route::any('/ajax-buscar-proveedor', [\App\Http\Controllers\UserController::class, 'actionAjaxBuscarProveedor']);
Route::get('/cerrarsession', [\App\Http\Controllers\UserController::class, 'actionCerrarSesion']);
Route::any('/enviocorreoconfirmaciones', [\App\Http\Controllers\UserController::class, 'actionCorreoConfirmacion']);
Route::any('/activar-registro/{token}', [\App\Http\Controllers\UserController::class, 'actionActivarRegistro']);
Route::any('/enviocorreouc', [\App\Http\Controllers\UserController::class, 'actionCorreoUC']); //correo para usuario contacto
Route::any('/enviocorreoconta', [\App\Http\Controllers\UserController::class, 'actionCorreoCO']); //correo para contabilidad
Route::any('/enviocorreoadmin', [\App\Http\Controllers\UserController::class, 'actionCorreoADM']); //correo para administracion
Route::any('/enviocorreoapcli', [\App\Http\Controllers\UserController::class, 'actionCorreoAPCLI']); //correo para cliente cuando se aprueba
Route::get('/cambiarperfil', [\App\Http\Controllers\UserController::class, 'actionCambiarPerfil']);
Route::any('/enviocorreobaja', [\App\Http\Controllers\UserController::class, 'actionCorreoBaja']); //correo para cliente cuando se aprueba
Route::any('/validarsunatcdr', [\App\Http\Controllers\GestionOCController::class, 'actionSunatCDR']); //vALIDAR CDR Y SUNAT
Route::any('/manual-proveedor', [\App\Http\Controllers\UserController::class, 'actionManualProveedor']); //vALIDAR CDR Y SUNAT
Route::any('/descargar-manual', [\App\Http\Controllers\UserController::class, 'actionDescargarManual']); //vALIDAR CDR Y SUNAT
Route::any('/generar-token-sunat', [\App\Http\Controllers\UserController::class, 'actionGenerarTokenSunat']); //vALIDAR CDR Y SUNAT
Route::any('/generar-token-sunat-curl', [\App\Http\Controllers\UserController::class, 'actionGenerarTokenSunat_cur']); //vALIDAR CDR Y SUNAT
Route::any('/leerdocumentos-sunat-compras', [\App\Http\Controllers\CpeController::class, 'actionGestionCpeCompra']); //vALIDAR CDR Y SUNAT
Route::any('/leerpreciocompetencia', [\App\Http\Controllers\PrecioCompetenciaController::class, 'actionScrapearPrecios']); //vALIDAR CDR Y SUNAT
Route::any('/transferirdataventas', [\App\Http\Controllers\TransferirDataController::class, 'actionTransferirVentasAtendidas']); //TRANSFERIR DATA AGENTE IA
Route::any('/documentolgautomatico', [\App\Http\Controllers\PrecioCompetenciaController::class, 'actionDocumentoLGAutomatico']); //TRANSFERIR DATA AGENTE IA
Route::any('/enviocorreotesorerialg', [\App\Http\Controllers\UserController::class, 'actionCorreoTesoreriaLg']); //correo para usuario contacto
Route::any('/detraccionsunat', [\App\Http\Controllers\UserController::class, 'actionDetraccionSunat']); //correo para usuario contacto


Route::any('/guardardocumentacionlq', [\App\Http\Controllers\PrecioCompetenciaController::class, 'actionDocumentoLGAutomaticoNuevo']); //correo para usuario contacto
Route::any('/enviocorreoreparacionlevantada', [\App\Http\Controllers\UserController::class, 'actionCorreoReparacionLevantada']); //correo para usuario contacto
Route::any('/guardarpdfoi', [\App\Http\Controllers\PrecioCompetenciaController::class, 'actionGuardarPdfOi']); //correo para usuario contacto
Route::any('/cambiarglosadehabilitacion', [\App\Http\Controllers\PrecioCompetenciaController::class, 'actionModificarGlosaLiquidacion']); //correo para usuario contacto

Route::any('/enviocorreojefeacopiodic', [\App\Http\Controllers\UserController::class, 'actionCorreoJefeAcopioDic']); //correo para jefe acopio liuidacion compra
Route::any('/enviocorreojefeacopiolqc', [\App\Http\Controllers\UserController::class, 'actionCorreoJefeAcopioLqc']); //correo para jefe acopio liuidacion compra
Route::any('/enviocorreoadmindic', [\App\Http\Controllers\UserController::class, 'actionCorreoAdminDic']); //correo para jefe acopio liuidacion compra
Route::any('/enviocorreoadminlqc', [\App\Http\Controllers\UserController::class, 'actionCorreoAdminLqc']); //correo para jefe acopio liuidacion compra
Route::any('/enviocorreoaprobado', [\App\Http\Controllers\UserController::class, 'actionCorreoAprobado']); //correo para jefe acopio liuidacion compra

Route::any('/enviocorreoaprobadoadmin', [\App\Http\Controllers\UserController::class, 'actionCorreoAprobadoAdmin']); //correo para jefe acopio liuidacion compra
Route::any('/crearexceladminaprobado', [\App\Http\Controllers\UserController::class, 'actionCrearExcelAprobadoAdmin']); //correo para jefe acopio liuidacion compra

Route::any('/enviocorreoconsolidadoplanilla', [\App\Http\Controllers\UserController::class, 'actionEnviarCorreoConsolidado']); //correo para jefe acopio liuidacion compra
Route::any('/enviocorreoconsolidadoplanilladet', [\App\Http\Controllers\UserController::class, 'actionEnviarCorreoConsolidadoDet']); //correo para jefe acopio liuidacion compra

Route::any('/updateseriecorrelativocpe', [\App\Http\Controllers\UserController::class, 'actionUpdateSerieCorrelativoCpe']); //correo para jefe acopio liuidacion compra


Route::middleware(['authaw'])->group(function () {

	Route::get('/bienvenido', [\App\Http\Controllers\UserController::class, 'actionBienvenido']);
	Route::any('/ajax-modal-configuracion-datos-proveedor-detalle', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionDatosProveedor']);
	Route::any('/configurar-datos-proveedor/{idusuario}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosProveedor']);
	Route::any('/ajax-modal-configuracion-datos-contacto-detalle', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionDatosContacto']);
	Route::any('/configurar-datos-contacto/{idusuario}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosContacto']);
	Route::any('/ajax-modal-configuracion-cuenta-bancaria', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancaria']);
	Route::any('/configurar-datos-cuenta-bancaria/{idusuario}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancaria']);
	Route::any('/ajax-eliminar-cb', [\App\Http\Controllers\UserController::class, 'actionEliminarCuentaBancaria']);

	Route::any('/pdf-sunat-personal', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionPdfSunatPersonal']);

	Route::any('/ajax-modal-ver-cuenta-bancaria-contrato', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaContrato']);
	Route::any('/ajax-modal-ver-cuenta-bancaria-pg', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaPG']);
	Route::any('/actualizar-data/{zona}', [\App\Http\Controllers\UserController::class, 'actionActualizarData']);
	Route::any('/ajax-modal-cambiar-clave', [\App\Http\Controllers\UserController::class, 'actionAjaxModalCambiarClave']);
	Route::any('/ajax-cambiar-clave', [\App\Http\Controllers\UserController::class, 'actionAjaxCambiarClave']);
	Route::any('/impostar-usuario/{idusuario}', [\App\Http\Controllers\UserController::class, 'actionImpostarUsuario']);


	Route::any('/ajax-modal-configuracion-cuenta-bancaria-contrato', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancariaContrato']);
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-oc', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancariaOC']);
	Route::any('/ajax-modal-configuracion-grupo-oc', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionGrupoOC']);


	Route::any('/ajax-modal-configuracion-cuenta-bancaria-estiba', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancariaEstiba']);
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-liq-com-an', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancariaLiqComAn']);
	Route::any('/configurar-datos-cuenta-bancaria-estiba/{empresa_id}/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancariaEstiba']);
	Route::any('/ajax-modal-ver-cuenta-bancaria-estiba', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaEstiba']);
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-pg', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancariaPG']);


	Route::any('/configurar-datos-cuenta-bancaria-contrato/{prefijo_id}/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancariaContrato']);
	Route::any('/configurar-datos-cuenta-bancaria-pg/{prefijo_id}/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancariaPg']);

	Route::any('/configurar-datos-cuenta-bancaria-liquidacion-compra-anticipo/{prefijo_id}/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancariaLiquidacionCompraAnticipo']);
	Route::any('/configurar-grupo-marketing/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosGrupoMarketing']);
	Route::post('/ajax-guardar-clasificacion', [\App\Http\Controllers\UserController::class, 'actionAjaxGuardarClasificacion']);
	Route::post('/ajax-guardar-sede', [\App\Http\Controllers\UserController::class, 'actionAjaxGuardarSede']);
	Route::any('/ajax-obtener-detalle-grupo-marketing', [\App\Http\Controllers\UserController::class, 'actionAjaxObtenerDetalleGrupoMarketing']);

	Route::any('/configurar-datos-cuenta-bancaria-oc/{prefijo_id}/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancariaOC']);

	Route::any('/ajax-modal-ver-cuenta-bancaria-oc', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaOC']);

	Route::any('/ajax-modal-ver-cuenta-bancaria-oc-individual', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaOCIndividual']);
	Route::any('/ajax-modal-cambiar-reparable', [\App\Http\Controllers\UserController::class, 'actionAjaxModalCambiarReparable']);
	Route::any('/guardar-cambio-reparable/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionGuardarCambiarReparable']);


    Route::any('/gestion-de-reporte-saldo-div/{idopcion}', [\App\Http\Controllers\ReporteDIVSaldosController::class, 'actionListarDivSaldos']);
    Route::any('/ajax-reporte-div-saldos', [\App\Http\Controllers\ReporteDIVSaldosController::class, 'actionAjaxListarDivSaldos']);
    Route::any('/descargar-archivo-reporte-div-saldos', [\App\Http\Controllers\ReporteDIVSaldosController::class, 'actionAjaxListarDivSaldosExcel']);

	// GESTION ACTIVOS FIJOS (VALE A RENDIR)
	Route::any('/gestion-de-obras/{idopcion}', [\App\Http\Controllers\ValeRendirAdministracionController::class, 'actionListar']);
	Route::any('/ajax-listar-activos-fijos', [\App\Http\Controllers\ValeRendirAdministracionController::class, 'actionAjaxListar']);
	Route::any('/agregar-modificar-activo-fijo', [\App\Http\Controllers\ValeRendirAdministracionController::class, 'actionAgregarModificar']);
	Route::any('/eliminar-activo-fijo', [\App\Http\Controllers\ValeRendirAdministracionController::class, 'actionEliminar']);

	Route::any('/ajax-modal-ver-cuenta-bancaria-lq', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaLQ']);
	Route::any('/ajax-modal-ver-cuenta-bancaria-liq-com-an', [\App\Http\Controllers\UserController::class, 'actionAjaxModalVerCuentaBancariaLiqComAn']);
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-lq', [\App\Http\Controllers\UserController::class, 'actionAjaxModalConfiguracionCuentaBancariaLQ']);
	Route::any('/configurar-datos-cuenta-bancaria-lq/{orden_id}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionConfigurarDatosCuentaBancariaLQ']);


	Route::any('/cambiar-cuenta-corriente/{empresa_id}/{banco_id}/{nro_cuenta}/{moneda_id}/{idoc}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionCambiarCuentaCorriente']);
	Route::any('/cambiar-banco-sin-cuenta/{codbanco}/{idoc}/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionCambiarBancoSinCuenta']);
	Route::any('/gestion-de-cpe/{idopcion}', [\App\Http\Controllers\CpeController::class, 'actionGestionCpe']);
	Route::any('/descargar-archivo/{archivonombre}', [\App\Http\Controllers\CpeController::class, 'actionDescargarArchivo']);
	Route::any('/gestion-de-sunat-cpe-local/{idopcion}', [\App\Http\Controllers\CpeController::class, 'actionGestionCpeLocal']);
	Route::any('/descargar-archivo-local/{tipo}', [\App\Http\Controllers\CpeController::class, 'descargarArchivoLocal']);
	Route::any('/descargar-archivo-lq/{id}/{nombre_archivo}/{tipo}', [\App\Http\Controllers\CpeController::class, 'descargarArchivoLocalLQ']);
	Route::any('/descargar-archivos-sunat-lg', [\App\Http\Controllers\CpeController::class, 'descargarArchivoSunatLG']);


	//LIQUIDACION DE GASTOS
	Route::any('/gestion-de-liquidacion-gastos/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionListarLiquidacionGastos']);
	Route::any('/agregar-liquidacion-gastos/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAgregarLiquidacionGastos']);
	Route::any('/ajax-combo-cuenta', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxComboCuenta']);
	Route::any('/modificar-liquidacion-gastos/{idopcion}/{iddocumento}/{valor}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionModificarLiquidacionGastos']);
	Route::any('/exportar-excel-detalle-liquidacion-gastos/{idopcion}/{iddocumento?}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionExportarExcelDetalleLiquidacionGastos']);
	Route::any('/exportar-excel-detalle-liquidacion/{iddocumento}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionExportarExcelDetalleLiquidacionGastos']);
	Route::any('/ajax-combo-subcuenta', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxComboSubCuenta']);
	Route::any('/ajax-combo-item', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxComboItem']);
	Route::any('/ajax-combo-autoriza', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxComboAutoriza']);
	Route::any('/ajax-combo-arendir', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxComboArendir']);

	Route::any('/ajax-modal-lista-comparativa', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxModalComparativa']);

	Route::any('/regularizar-vacios-lq', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionRegularizarVacios']);


	Route::any('/extonar-liquidacion-gastos/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionExtornarLiquidacionGastos']);
	Route::any('/extonar-liquidacion-gastos-detalle/{idopcion}/{item}/{iddocumento}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionExtornarLiquidacionGastosDetalle']);
	Route::any('/tutorial/{nombre}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionTutorialLiquidacionGastos']);
	Route::any('/gestion-de-archivos-liquidacion-faltantes/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionListarLiquidacionGastosFaltante']);



	Route::any('/ajax-buscar-documento-uc-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxUCListarLiquidacionGastos']);
	Route::any('/ajax-combo-cuenta-xmoneda', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxComboCuentaXMoneda']);
	Route::any('/guardar-detalle-liquidacion-gastos/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionGuardarDetalleLiquidacionGastos']);
	Route::any('/ajax-modal-detalle-documento-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionDetalleDocumentoLG']);
	Route::any('/guardar-detalle-documento-lg/{idopcion}/{iddocumento}/{item}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionGuardarDetalleDocumentoLG']);
	Route::any('/ajax-modal-modificar-detalle-documento-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionModificarDetalleDocumentoLG']);
	Route::any('/ajax-modal-relacionar-detalle-documento-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionRelacionarDetalleDocumentoLG']);
	Route::any('/modificar-detalle-documento-lg/{idopcion}/{iddocumento}/{item}/{itemdocumento}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionGuardarModificarDetalleDocumentoLG']);
	Route::any('/emitir-liquidacion-gastos/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionEmitirLiquidacionGasto']);
	Route::any('/gestion-de-aprobacion-liquidacion-gasto-jefe/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarLiquidacionGastoJefe']);
	Route::any('/aprobar-liquidacion-gasto-jefe/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarJefeLG']);
	Route::any('/agregar-observar-jefe/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionObservarJefeLG']);
	Route::any('/agregar-nuevo-formato', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAgregarNuevoFormato']);
	Route::any('/gestion-de-aprobacion-liquidacion-gastos-contabilidad/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarLiquidacionGastoContabilidad']);
	Route::any('/gestion-de-aprobacion-liquidacion-gastos-administracion/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarLiquidacionGastoAdministracion']);
	Route::any('/aprobar-liquidacion-gasto-administracion/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarAdministracionLG']);
	Route::any('/liquidacion-viaje-pdf/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionLiquidacionViajePdf']);
	Route::any('/aprobar-liquidacion-gasto-contabilidad/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarContabilidadLG']);
	Route::any('/ajax-modal-buscar-planilla-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionModalBuscarPlanillaLG']);
	Route::any('/ajax-select-documento-planilla', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionModalSelectDocumentoPlanillaLG']);
	Route::any('/ajax-leer-xml-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxLeerXmlLG']);
	Route::any('/ajax-leer-xml-lg-sunat', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxLeerXmlLGSunat']);
	Route::any('/agregar-extorno-jefe/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAgregarExtornoJefe']);
	Route::any('/agregar-extorno-administracion/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAgregarExtornoAdministracion']);
	Route::any('/agregar-extorno-contabilidad-lg/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAgregarExtornoContabilidadLG']);
	Route::any('/ajax-leer-xml-lg-validar', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxLeerXmlLGValidar']);
	Route::any('/validez-comprobante-pdf', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionLiquidacionValidezComprobantePdf']);
	Route::post('/buscar-proveedor', [\App\Http\Controllers\GestionOCContabilidadController::class, 'buscarProveedor']);

	Route::any('/aprobar-liquidacion-gasto-jefe-historial/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAprobarJefeLGHistorial']);

	Route::post('/gestion-asiento', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxGestionAsiento']);
	Route::post('/crear-asiento-reparable', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxCrearAsientoReparable']);

	Route::any('/gestion-de-liquidacion-gastos-adm/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionListarLGValidado']);
	Route::any('/ajax-buscar-documento-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionListarAjaxBuscarDocumentoLG']);
	Route::any('/detalle-comprobante-lg-validado/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionDetallaComprobanteLGValidado']);
	Route::any('/ajax-modal-buscar-factura-sunat', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionModalBuscarFacturaSunat']);
	Route::any('/buscar-de-cpe-sunat-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionBuscarCpeSunatLg']);
	Route::any('/buscar-de-cpe-sunat-lg-personal', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionBuscarCpeSunatLgPersonal']);
	Route::any('/eliminar-de-cpe-sunat-lg-personal', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionElimnarCpeSunatLgPersonal']);
	Route::any('/guardar-numero-de-whatsapp', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionGuardarNumeroWhatsapp']);
	Route::any('/comprobante-masivo-excel-lg/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionComprobanteMasivoExcelLg']);
	Route::any('/comprobante-masivo-excel-lg-cuenta/{fecha_inicio?}/{fecha_fin?}/{proveedor_id?}/{estado_id?}/{idopcion?}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionComprobanteMasivoExcelLgCuenta']);

	Route::any('/ajax-modal-buscar-factura-sunat-tareas', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionModalBuscarFacturaSunatTarea']);

	Route::any('/gestion-de-empresa-proveedor/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionGestionEmpresaProveedor']);
	Route::any('/buscar-sunat-ruc/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionBuscarSunatRuc']);
	Route::any('/agregar-observar-administrador/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionObservarAdministradorLG']);
	Route::any('/agregar-observar-contabilidad/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionObservarContabilidadLG']);
	Route::any('/tareas-de-cpe-sunat-lg', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionTareasCpeSunatLg']);

	Route::any('/guardar-empresa-proveedor/{idopcion}', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionGuardarEmpresaProveedor']);

	Route::any('/ajax-cuenta-bancaria-proveedor-lq', [\App\Http\Controllers\GestionLiquidacionGastosController::class, 'actionAjaxBuscarCuentaBancariaLQ']);

	//ANALISIS DE LIQUIDACION DE COMPRA
	Route::any('/gestion-de-analisis-liquidacion-compra/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionGestionAnalisisaLiquidacionCompra']);
	Route::post('/actionAjaxDashboards', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionAjaxDashboards']);
	Route::any('/gestion-de-asistente-liquidacion-compra/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionGestionAsistenteLiquidacionCompra']);
	Route::post('/api/asistente-analitico/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionApiAsistenteAnalitico']);
	Route::get('/api/asistente-analitico/conversacion/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionCargarConversacion']);
	Route::delete('/api/asistente-analitico/conversacion/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionLimpiarConversacion']);

	// Preguntas Frecuentes
	Route::get('/api/asistente-analitico/preguntas-frecuentes/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionGetPreguntasFrecuentes']);
	Route::post('/api/asistente-analitico/preguntas-frecuentes/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionGuardarPreguntaFrecuente']);
	Route::delete('/api/asistente-analitico/preguntas-frecuentes/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionEliminarPreguntaFrecuente']);

	// Insights Automáticos ("Sorpréndeme")
	Route::get('/api/asistente-analitico/insights/{idopcion}', [\App\Http\Controllers\GestionAnalisisLiquidacionGastosController::class, 'actionGenerarInsights']);


	//REPORTE DE CONCILIACON DE LIQUIDACION GASTOS Y VALES
	Route::any(
		'/gestion-de-conciliacion-liquidacion-vale/{idopcion}',
		[\App\Http\Controllers\GestionConciliacionLiquidacionGastosController::class, 'actionGestionConciliacionLiquidacionCompra']
	);
	Route::post(
		'/buscar-reporte-conciliacion',
		[\App\Http\Controllers\GestionConciliacionLiquidacionGastosController::class, 'buscarReporteConciliacion']
	);
	Route::any(
		'/exportar-excel-conciliacion-detalle',
		[\App\Http\Controllers\GestionConciliacionLiquidacionGastosController::class, 'exportarExcelDetalle']
	);


	//CONTRATO ACOPIO
	Route::any('/gestion-de-contrato-acopio/{idopcion}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionListarContratoAcopio']);
	Route::any('/agregar-contrato-acopio/{idopcion}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionAgregarContratoAcopio']);
	Route::any('/ajax-combo-cuenta-anti', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionAjaxComboCuentaAnti']);
	Route::any('/ajax-combo-subcuenta-anti', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionAjaxComboSubCuentaAnti']);
	Route::any('/gestion-revisar-acopio-contrato/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionGestionRevisarAcopioContrato']);

	Route::any('/gestion-de-aprobar-contrato-acopio/{idopcion}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionAprobarContratoAcopio']);
	Route::any('/aprobar-contrato-acopio-acopio/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionAprobarAcopioCA']);

	Route::post('/modificar-archivo-pdf/{idopcion}/{linea}/{idoc_prefijo}/{idoc_encoded}', [\App\Http\Controllers\ModificarArchivoController::class, 'actionModificarArchivoPDF']);
	Route::any('/agregar-extorno-acopio-ca/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionAgregarExtornoAcopioCA']);

	Route::any('/gestion-de-listar-contrato-acopio/{idopcion}', [\App\Http\Controllers\GestionContratoAcopioController::class, 'actionListarGestionContratoAcopio']);



	//SUSPENSION DE 4TA CATEGORIA
	Route::any('/gestion-de-suspension-ta-categoria/{idopcion}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionListarSuspensionCuarta']);
	Route::any('/agregar-cuarta-categoria/{idopcion}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionAgregarCuartaCategoria']);
	Route::any('/descargar-documento-cuarta-categoria/{id}', [\App\Http\Controllers\CpeController::class, 'descargarArchivoLocalCuartaCategoria']);

	Route::any('/gestion-de-aprobar-cuarta-categoria/{idopcion}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionAprobarRentaCuartaContabilidad']);
	Route::any('/aprobar-renta-cuarta-contabilidad/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionAprobarContabilidadRC']);
	Route::any('/agregar-extorno-contabilidad-rc/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionAgregarExtornoContabilidadRC']);
	Route::any('/gestion-de-cuarta-categoria/{idopcion}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionRentaCuartaContabilidad']);
	Route::any('/gestion-renta-cuarta-contabilidad/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionCuartaCategoriaController::class, 'actionGestionContabilidadRC']);


	//MOVILIDAD IMPULSO
	Route::any('/gestion-movilidad-impulso/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionListarPlanillaMovilidadImpulso']);
	Route::any('/agregar-movilidad-impulso/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAgregarMovilidadImpulso']);
	Route::any('/modificar-movilidad-impulso/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionModificarMovilidadImpulso']);
	Route::any('/guardar-movilidad-detalle/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionGuardarDetalleMovilidadImpulso']);
	Route::any('/emitir-movilidad-impulso/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionEmitirDetalleMovilidadImpulso']);
	Route::any('/gestion-de-aprobacion-movilidad-impulso-jefe/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAprobarMovilidadImpulsoJefe']);
	Route::any('/aprobar-movilidad-impulso-jefe/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAprobarJefeMV']);
	Route::any('/agregar-extorno-jefe-mv/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAgregarExtornoJefe']);

	Route::any('/seguimiento-movilidad-impulso/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionSeguimientoMovilidadImpulso']);


	Route::any('/gestion-movilidad-impulso-masivo/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionListarPlanillaMovilidadImpulsoMasivo']);
	Route::any('/agregar-movilidad-impulso-masivo/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAgregarMovilidadImpulsoMasivo']);
	Route::any('/modificar-movilidad-impulso-masivo/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionModificarMovilidadImpulsoMasivo']);
	Route::any('/ajax-modal-detalle-planilla-movilidad-impulso', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionDetallePlanillaMovilidadImpulso']);
	Route::any('/guardar-detalle-movilidad-impulso-trabajador/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionGuardarMovilidadTrabajador']);
	Route::any('/guardar-movilidad-detalle-masivo/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionGuardarDetalleMovilidadImpulsoMasivo']);

	Route::any('/extonar-planilla-movilidad-masivo/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionExtornarPlanillaMovilidadMasivo']);
	Route::any('/ajax-buscar-documento-fe-entregable-pla-mob-masivo', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionListarPlanillaMovilidadMobilMasivo']);
	Route::any('/emitir-movilidad-impulso-masivo/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionEmitirDetalleMovilidadImpulsoMasivo']);
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-impulso', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAjaxModalConfiguracionCuentaBancariaImpulso']);
	Route::any('/configurar-datos-cuenta-bancaria-impulso/{orden_id}/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionConfigurarDatosCuentaBancariaImpulso']);
	Route::any('/ajax-modal-ver-cuenta-bancaria-impulso', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAjaxModalVerCuentaBancariaImpulso']);
	Route::any('/cambiar-cuenta-corriente-impulso/{empresa_id}/{banco_id}/{nro_cuenta}/{moneda_id}/{idoc}/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionCambiarCuentaCorrienteImpulso']);
	Route::any('/extonar-planilla-movilidad-impulso/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionExtornarPlanillaMovilidadImpulso']);

	//MOVILIDAD VENTAS
	Route::any('/gestion-movilidad-venta-masivo/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionListarPlanillaMovilidadVentaMasivo']);
	Route::any('/agregar-movilidad-venta-masivo/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionAgregarMovilidadVentaMasivo']);
	Route::any('/modificar-movilidad-venta-masivo/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionModificarMovilidadVenta']);
	Route::any('/ajax-modal-detalle-planilla-movilidad-venta', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionDetallePlanillaMovilidadVenta']);
	Route::any('/guardar-detalle-movilidad-venta-trabajador/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionGuardarMovilidadTrabajadorVenta']);
	Route::any('/guardar-movilidad-detalle-masivo-venta/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionGuardarDetalleMovilidadVentaMasivo']);
	Route::any('/emitir-movilidad-venta-masivo/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionEmitirDetalleMovilidadVentaMasivo']);
	Route::any('/extonar-planilla-movilidad-masivo-venta/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionExtornarPlanillaMovilidadMasivoVenta']);
	Route::any('/seguimiento-movilidad-venta/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadImpulsoController::class, 'actionSeguimientoMovilidadVenta']);




	//PLANILLA MOVILIDAD

	Route::any('/gestion-de-aprobacion-firma-administracion/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarFirma']);
	Route::any('/aprobar-firma-administracion/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarAdministracionFirma']);
	Route::any('/agregar-extorno-administracion-firma/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAgregarExtornoFirma']);
	Route::any('/gestion-de-planilla-movilidad/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListarPlanillaMovilidad']);
	Route::any('/ajax-buscar-documento-fe-entregable-pla-mob', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListarPlanillaMovilidadMobil']);
	Route::any('/agregar-planilla-movilidad/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAgregarPlanillaMovilidad']);
	Route::any('/modificar-planilla-movilidad/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionModificarPlanillaMovilidad']);
	Route::any('/extonar-planilla-movilidad/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionExtornarPlanillaMovilidad']);

	Route::any('/subir-firma/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionSubirFirma']);

	Route::any('/ajax-modal-detalle-planilla-movilidad', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionDetallePlanillaMovilidad']);
	Route::any('/guardar-detalle-planilla-movilidad/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionGuardarDetallePlanillaMovilidad']);
	Route::any('/ajax-modal-modificar-detalle-planilla-movilidad', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionModificarDetallePlanillaMovilidad']);
	Route::any('/modificar-detalle-planilla-movilidad/{idopcion}/{iddocumento}/{item}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionGuardarModificarDetallePlanillaMovilidad']);
	Route::any('/emitir-planilla-movilidad/{idopcion}/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEmitirDetallePlanillaMovilidad']);
	Route::any('/gestion-de-aprobacion-planilla-movilidad-jefe/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarPlanillaMovilidadJefe']);
	Route::any('/aprobar-planilla-movilidad-jefe/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarJefe']);
	Route::any('/gestion-de-aprobacion-planilla-movilidad-administracion/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarPlanillaMovilidadAdministracion']);
	Route::any('/aprobar-planilla-movilidad-administracion/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarAdministracion']);
	Route::any('/pdf-planilla-movilidad/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionPDFPlanillaMovilidad']);
	Route::any('/ajax-modal-lista-acumulado-dias', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListaAcumuladoDias']);


	Route::any('/ajax-select-combo-provincia-partida', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionSelectComboProvinciaPartida']);
	Route::any('/ajax-select-combo-distrito-partida', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionSelectComboDistritoPartida']);

	Route::any('/ajax-select-combo-provincia-llegada', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionSelectComboProvinciaLlegada']);
	Route::any('/ajax-select-combo-distrito-llegada', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionSelectComboDistritoLlegada']);




	//GESTION DE USUARIOS
	Route::any('/gestion-de-usuarios/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionListarUsuarios']);
	Route::any('/agregar-usuario/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionAgregarUsuario']);
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', [\App\Http\Controllers\UserController::class, 'actionModificarUsuario']);



	Route::any('/gestion-de-registros-terceros/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionListarTerceros']);
	Route::any('/agregar-tercero/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionAgregarTercero']);
	Route::any('/modificar-tercero/{idopcion}/{idusuario}', [\App\Http\Controllers\UserController::class, 'actionModificarTercero']);



	Route::any('/ajax-activar-perfiles', [\App\Http\Controllers\UserController::class, 'actionAjaxActivarPerfiles']);

	Route::any('/gestion-de-roles/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionListarRoles']);
	Route::any('/agregar-rol/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionAgregarRol']);
	Route::any('/modificar-rol/{idopcion}/{idrol}', [\App\Http\Controllers\UserController::class, 'actionModificarRol']);

	Route::any('/gestion-de-permisos/{idopcion}', [\App\Http\Controllers\UserController::class, 'actionListarPermisos']);
	Route::any('/ajax-listado-de-opciones', [\App\Http\Controllers\UserController::class, 'actionAjaxListarOpciones']);
	Route::any('/ajax-activar-permisos', [\App\Http\Controllers\UserController::class, 'actionAjaxActivarPermisos']);

	//REPORTES
	Route::any('/gestion-saldos-cobrar-pagar/{idopcion}', [\App\Http\Controllers\ReporteCuentaSaldoController::class, 'actionReporteCuentaSaldo']);
	Route::post('/obtener_tipo_cambio', [\App\Http\Controllers\ReporteCuentaSaldoController::class, 'actionObtenerTipoCambio']);
	Route::post('/obtener-reporte-cuentas-saldo', [\App\Http\Controllers\ReporteCuentaSaldoController::class, 'actionAjaxListarReporteCuentasSaldo']);
	Route::post('/obtener-reporte-cuentas-saldo-excel', [\App\Http\Controllers\ReporteCuentaSaldoController::class, 'actionAjaxListarReporteCuentasSaldoExcel']);

	Route::any('/gestion-compras-envases-periodo/{idopcion}', [\App\Http\Controllers\ReporteComprasEnvasesSedeController::class, 'actionReporteComprasEnvasesSede']);
	Route::post('/obtener-reporte-compras-envases-sede', [\App\Http\Controllers\ReporteComprasEnvasesSedeController::class, 'actionAjaxListarReporteComprasEnvasesSede']);
	Route::post('/obtener-reporte-compras-envases-sede-excel', [\App\Http\Controllers\ReporteComprasEnvasesSedeController::class, 'actionAjaxListarReporteComprasEnvasesSedeExcel']);

	//LIQUIDACIONES
	Route::any('/gestion-liquidaciones-trabajador/{idopcion}', [\App\Http\Controllers\ReporteLiquidacionesTrabajadorController::class, 'actionReporteLiquidacionesTrabajador']);
	Route::post('/buscar-trabajador-liquidaciones', [\App\Http\Controllers\ReporteLiquidacionesTrabajadorController::class, 'buscarTrabajadorLiquidaciones']);
	Route::post('/obtener-reporte-liquidaciones-trabajador', [\App\Http\Controllers\ReporteLiquidacionesTrabajadorController::class, 'actionAjaxListarReporteLiquidacionesTrabajador']);
	Route::post('/obtener-reporte-liquidaciones-trabajador-excel', [\App\Http\Controllers\ReporteLiquidacionesTrabajadorController::class, 'actionAjaxListarReporteLiquidacionesTrabajadorExcel']);

	Route::any('/gestion-ingresos-salidas-envases/{idopcion}', [\App\Http\Controllers\IngresosSalidasEnvasesController::class, 'actionListarIngresosSalidasEnvases']);
	Route::any('/obtener-combo-familia', [\App\Http\Controllers\IngresosSalidasEnvasesController::class, 'actionAjaxListarFamilia']);
	Route::any('/obtener-combo-subfamilia', [\App\Http\Controllers\IngresosSalidasEnvasesController::class, 'actionAjaxListarSubFamilia']);
	Route::any('/obtener-combo-producto', [\App\Http\Controllers\IngresosSalidasEnvasesController::class, 'actionAjaxListarProducto']);
	Route::any('/obtener-ingresos-salidas-envases', [\App\Http\Controllers\IngresosSalidasEnvasesController::class, 'actionAjaxListarIngresosSalidasEnvases']);
	Route::any('/obtener-reporte-ingresos-salidas-envases-excel', [\App\Http\Controllers\IngresosSalidasEnvasesController::class, 'actionAjaxListarIngresosSalidasEnvasesExcel']);

	Route::any('/leerxmlsinvoice', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerXmlSap']);
	Route::any('/leerxmlsinvoiceliqui', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerXmlSapLiqui']);

	Route::any('/leerxmlsinvoiceguia', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerXmlSapGuia']);
	Route::any('/leerxmlsinvoicenc', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerXmlSapNC']);


	Route::any('/leerrhsinvoice', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerRHSap']);
	Route::any('/leerrhsinvoicereten', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerRetencionSap']);

	Route::any('/leercdr', [\App\Http\Controllers\GestionOCController::class, 'actionApiLeerCDR']);

	Route::any('/gestion-de-mis-documentos-contrato/{idopcion}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionListarDOC']);
	Route::any('/detalle-documentos/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionDetalleDocumentos']);
	Route::any('/subir-xml-cargar-datos-documento/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionCargarXMLDocumento']);
	Route::any('/validar-xml-documento/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionValidarXMLDocumento']);
	Route::any('/detalle-documentos-subidos/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionDetalleDocumentoSubidos']);


	Route::any('/gestion-de-mis-canjes-documentos/{idopcion}', [\App\Http\Controllers\GestionDocumentoCanjesController::class, 'actionListarCanjesDOC']);
	Route::any('/canjear-documentos/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoCanjesController::class, 'actionCanjearDocumentos']);
	Route::any('/ajax-modal-lista-documento-osiris', [\App\Http\Controllers\GestionDocumentoCanjesController::class, 'actionAjaxModalListaDocumentoOsiris']);
	Route::any('/ajax-modal-agregar-documento-osiris', [\App\Http\Controllers\GestionDocumentoCanjesController::class, 'actionAjaxModalAgregarDocumentoOsiris']);

	Route::any('/ajax-modal-lista-documento-merge', [\App\Http\Controllers\GestionDocumentoCanjesController::class, 'actionAjaxModalListaDocumentoMerge']);
	Route::any('/ajax-modal-agregar-documento-merge', [\App\Http\Controllers\GestionDocumentoCanjesController::class, 'actionAjaxModalAgregarDocumentoMerge']);
	Route::any('/comprobante-masivo-excel/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{idopcion}', [\App\Http\Controllers\ReporteComprobanteController::class, 'actionComprobanteMasivoExcel']);
	Route::any('/comprobante-masivo-tesoreria-excel/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{idopcion}', [\App\Http\Controllers\ReporteComprobanteController::class, 'actionComprobanteMasivoTesoreriaExcel']);
	Route::any('/comprobante-masivo-mkt-excel/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{idopcion}', [\App\Http\Controllers\ReporteComprobanteController::class, 'actionComprobanteMasivoMarketingExcel']);
	Route::any('/comprobante-masivo-administracion-excel/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{idopcion}', [\App\Http\Controllers\ReporteComprobanteController::class, 'actionComprobanteMasivoAdministracionExcel']);


	Route::any('/comprobante-masivo-reparable-excel/{tipoarchivo_id}/{estado_id}/{operacion_id}/{idopcion}/{anio_id}', [\App\Http\Controllers\ReporteComprobanteController::class, 'actionComprobanteMasivoReparableExcel']);

	// Route::any('/subir-xml-cargar-datos-documento/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionCargarXMLDocumento']);
	// Route::any('/validar-xml-documento/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionValidarXMLDocumento']);
	// Route::any('/detalle-documentos-subidos/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionDocumentoController::class, 'actionDetalleDocumentoSubidos']);


	Route::any('/gestion-de-oc-proveedores/{idopcion}', [\App\Http\Controllers\GestionOCController::class, 'actionListarOC']);
	Route::any('/gestion-de-orden-compra/{idopcion}', [\App\Http\Controllers\GestionOCController::class, 'actionListarOCAdmin']);
	Route::get('/ver-contrato-pdf/{cod_contrato}', [\App\Http\Controllers\GestionOCController::class, 'actionPDFContrato'])->name('contrato.pdf');
	Route::post('/verificar-firma-contrato', [\App\Http\Controllers\GestionOCController::class, 'actionVerificarFirmaContrato'])->name('verificar.firma.contrato');





	Route::any('/detalle-comprobante-oc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobanteOC']);
	Route::any('/subir-xml-cargar-datos/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXML']);
	Route::any('/validar-xml-oc/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXML']);

	Route::any('/ajax-buscar-documento-gestion-admin', [\App\Http\Controllers\GestionOCController::class, 'actionListarAjaxBuscarDocumentoAdmin']);
	Route::any('/ajax-buscar-documento-gestion-admin-contrato-intermedio', [\App\Http\Controllers\GestionOCController::class, 'actionListarAjaxBuscarDocumentoAdminContratoIntermedio']);
	Route::any('/migracion-rioja/{idopcion}', [\App\Http\Controllers\GestionOCController::class, 'actionListarOCAdminMR']);
	Route::any('/migracion-bellavista/{idopcion}', [\App\Http\Controllers\GestionOCController::class, 'actionListarOCAdminMB']);
	Route::any('/ajax-estiba-proveedor-estiba', [\App\Http\Controllers\GestionOCController::class, 'actionEstibaProveedorEstiba']);

	Route::any('/gestion-de-integracion-comisiones/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarComisionAdmin']);
	Route::any('/ajax-buscar-documento-comision-admin', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAjaxListarComisionAdmin']);
	Route::any('/ajax-modal-detalle-comision', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionCargarModalDetalleComision']);
	Route::any('/comprobante-masivo-tesoreria-comision-excel/{fecha_inicio}/{fecha_fin}/{banco_id}/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionComprobanteMasivoTesoreriaComisionExcel']);



	Route::any('/ajax-modal-detalle-lotes-comision', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionCargarModalDetalleLotesComision']);
	Route::any('/select-xml-comision/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionDetalleSelectComision']);
	Route::any('/detalle-comprobante-comision-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionDetalleComprobanteComisionAdministrator']);
	Route::any('/detalle-comprobante-comision-administrator-masivo/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionDetalleComprobanteComisionAdministratorMasivo']);
	Route::any('/subir-xml-cargar-datos-comision-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionCargarXMLComisionAdministrator']);
	Route::any('/subir-xml-cargar-datos-comision-administrator-masivo/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionCargarXMLComisionAdministratorMasivo']);
	Route::any('/subir-pdf-masivo-comision-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionSubirPDFMasivoComisionAdministrator']);
	Route::post('/guardar-comision-masivo-documentos/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionGuardarComisionMasivo']);
	Route::any('/validar-xml-oc-comision-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionValidarXMLComisionAdministrator']);



	//PROVEEDOR CONTRATO
	Route::any('/gestion-de-transporte-carga/{idopcion}', [\App\Http\Controllers\GestionTCController::class, 'actionListarOC']);
	Route::any('/detalle-comprobante-contrato-proveedor/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionTCController::class, 'actionDetalleComprobanteOCProveedor']);
	Route::any('/subir-xml-cargar-datos-contrato-proveedor/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionTCController::class, 'actionCargarXMLProveedor']);
	Route::any('/validar-xml-contrato-proveedor/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionTCController::class, 'actionValidarXMLProveedor']);
	Route::any('/descargar-comprobante-contrato-proveedor/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionTCController::class, 'actionDescargarComprobanteOCProveedor']);


	Route::any('/gestion-de-filtro-comprobante/{idopcion}', [\App\Http\Controllers\GestionOCController::class, 'actionListarOCFiltro']);
	Route::any('/ajax-filtro-guardar', [\App\Http\Controllers\GestionOCController::class, 'actionGuardarOCFiltro']);


	//PROVEEDOR
	Route::any('/detalle-comprobante-oc-proveedor/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobanteOCProveedor']);
	Route::any('/subir-xml-cargar-datos-proveedor/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXMLProveedor']);
	Route::any('/validar-xml-oc-proveedor/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXMLProveedor']);


	//ADMINISTRATOR
	Route::any('/detalle-comprobante-oc-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobanteOCAdministrator']);
	Route::any('/subir-xml-cargar-datos-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXMLAdministrator']);
	Route::any('/validar-xml-oc-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXMLAdministrator']);
	Route::any('/validar-xml-oc-administrator-sx/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCSXController::class, 'actionValidarXMLAdministratorSX']);


	Route::any('/agregar-archivo-uc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionAgregarArchivoUC']);
	Route::any('/quitar-archivo-uc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionQuitarArchivoUC']);
	Route::any('/cambiar-orden-compra-anticipo/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionAgregarOCA']);

	Route::any('/detalle-comprobante-oc-administrator-sin-xml/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCSXController::class, 'actionDetalleComprobanteOCAdministratorSinXML']);
	Route::any('/agregar-archivo-uc-contrato/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionAgregarArchivoUCContrato']);




	Route::any('/ajax-cuenta-bancaria-proveedor-contrato', [\App\Http\Controllers\GestionOCController::class, 'actionAjaxBuscarCuentaBancariaContrato']);
	Route::any('/ajax-cuenta-bancaria-proveedor-pg', [\App\Http\Controllers\GestionOCController::class, 'actionAjaxBuscarCuentaBancariaPg']);

	Route::any('/ajax-cuenta-bancaria-proveedor-oc', [\App\Http\Controllers\GestionOCController::class, 'actionAjaxBuscarCuentaBancariaOC']);
	Route::any('/ajax-cuenta-bancaria-proveedor-liquidacioncompraanticipo', [\App\Http\Controllers\GestionOCController::class, 'actionAjaxBuscarCuentaBancariaLiquidacionCompraAnticipo']);
	Route::any('/ajax-cuenta-bancaria-proveedor-estiba', [\App\Http\Controllers\GestionOCController::class, 'actionAjaxBuscarCuentaBancariaEstiba']);

	Route::any('/ajax-moneda-ajax-cuenta', [\App\Http\Controllers\GestionOCController::class, 'actionAjaxMonedaAjaxCuenta']);

	//PROVISION DE GASTOS
	Route::any('/detalle-comprobante-provision-gasto-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCSXController::class, 'actionDetalleComprobantePGAdministratorSinXML']);
	Route::any('/validar-xml-oc-administrator-sx-pg/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCSXController::class, 'actionValidarXMLAdministratorSXPG']);


	//ADMINISTRATOR CONTRATO
	Route::any('/detalle-comprobante-contrato-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobantecontratoAdministrator']);
	Route::any('/subir-xml-cargar-datos-contrato-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXMLContratoAdministrator']);
	Route::any('/validar-xml-oc-contrato-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXMLContratoAdministrator']);

	//ADMINISTRATOR NOTA CREDITO
	Route::any('/detalle-comprobante-nota-credito-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobanteNotaCreditoAdministrator']);
	Route::any('/subir-xml-cargar-datos-nota-credito-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXMLNotaCreditoAdministrator']);
	Route::any('/validar-xml-nota-credito-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXMLNotaCreditoAdministrator']);

	//ADMINISTRATOR NOTA DEBITO
	Route::any('/detalle-comprobante-nota-debito-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobanteNotaDebitoAdministrator']);
	Route::any('/subir-xml-cargar-datos-nota-debito-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXMLNotaDebitoAdministrator']);
	Route::any('/validar-xml-nota-debito-administrator/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXMLNotaDebitoAdministrator']);

	//ADMINISTRATOR LIQUIDACION COMPRA ANTICIPO
	Route::any('/detalle-comprobante-liquidacion-compra-anticipo-administrator/{procedencia}/{idopcion}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCController::class, 'actionDetalleComprobanteLiquidacionCompraAnticipoAdministrator']);
	Route::any('/subir-xml-cargar-datos-liquidacion-compra-anticipo-administrator/{idopcion}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCController::class, 'actionCargarXMLLiquidacionCompraAnticipoAdministrator']);
	Route::any('/validar-xml-oc-liquidacion-compra-anticipo-administrator/{idopcion}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCController::class, 'actionValidarXMLLiquidacionCompraAnticipoAdministrator']);

	//ADMINISTRATOR CONTRATO INTERMEDIO
	Route::any('/select-xml-contrato-intermedio/{idopcion}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleSelectContratoIntermedio']);
	Route::any('/detalle-comprobante-contrato-intermedio-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleComprobanteContratoIntermedioAdministrator']);
	Route::any('/subir-xml-cargar-datos-contrato-intermedio-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionCargarXMLContratoIntermedioAdministrator']);
	Route::any('/validar-xml-oc-contrato-intermedio-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionValidarXMLContratoIntermedioAdministrator']);
	Route::any('/agregar-suspension-contrato-intermedio/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionAgregarSuspensionContratoIntermedio']);

	//ADMINISTRATOR ESTIBA
	Route::any('/select-xml-estiba/{idopcion}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleSelectEstiba']);
	Route::any('/select-xml-estiba-documento-interno-compra/{idopcion}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleSelectEstibaDocumentoInternoCompra']);
	Route::any('/select-xml-estiba-orden-compra-anticipo/{idopcion}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleSelectEstibaOrdenCompraAnticipo']);

	Route::any('/select-xml-estiba-contrato-anticipo/{idopcion}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleSelectEstibaContratoAnticipo']);


	Route::any('/detalle-comprobante-estiba-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleComprobanteestibaAdministrator']);
	Route::any('/detalle-comprobante-estiba-administrator-compra-anticipo/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleComprobanteestibaAdministratorCompraAnticipo']);

	Route::any('/detalle-comprobante-estiba-administrator-contrato-anticipo/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionDetalleComprobanteestibaAdministratorContratoAnticipo']);

	Route::any('/subir-xml-cargar-datos-estiba-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionCargarXMLEstibaAdministrator']);
	Route::any('/subir-xml-cargar-datos-estiba-administrator-orden-compra-anticipo/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionCargarXMLEstibaAdministratorOrdenCompraAnticipo']);
	Route::any('/validar-xml-oc-estiba-administrator/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionValidarXMLEstibaAdministrator']);
	Route::any('/validar-xml-oc-estiba-administrator-oca/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionValidarXMLEstibaAdministratorOCA']);
	Route::any('/validar-xml-oc-estiba-administrator-contratoa/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionValidarXMLEstibaAdministratorCONTRATOA']);	



	Route::any('/subir-xml-cargar-datos-estiba-administrator-contrato-anticipo/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionCargarXMLEstibaAdministratorContratoAnticipo']);

	Route::any('/ajax-modal-detalle-lotes', [\App\Http\Controllers\GestionEstibaController::class, 'actionCargarModalDetalleLotes']);
	Route::any('/ajax-eliminar-lote-estiba', [\App\Http\Controllers\GestionEstibaController::class, 'actionEliminacionLoteEstiba']);
	Route::any('/ajax-modal-detalle-estibas', [\App\Http\Controllers\GestionEstibaController::class, 'actionCargarModalDetalleEstibas']);
	Route::any('/agregar-suspension/{idopcion}/{lote}', [\App\Http\Controllers\GestionEstibaController::class, 'actionAgregarSuspensionEstibas']);
	Route::any('/ajax-eliminar-lote-comision', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionEliminacionLoteComision']);
	Route::any('/gestion-de-oc-validado-proveedores/{idopcion}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionListarOCValidado']);
	Route::any('/gestion-de-oc-validado-excel-detallado/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{filtrofecha_id}/{idopcion}/{sede_id?}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionGestionOCValidadoExcelDetallado']);
	Route::any('/detalle-comprobante-oc-validado/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidado']);
	Route::any('/gestion-de-historial-comprobantes/{idopcion}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionListarOCHistorial']);
	Route::any('/ajax-buscar-documento-fe', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionListarAjaxBuscarDocumento']);
	Route::any('/ajax-buscar-documento-fe-historial', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionListarAjaxBuscarDocumentoHistorial']);
	Route::any('/gestion-compra-sire/{idopcion}', [\App\Http\Controllers\CpeController::class, 'actionGestionSireCompra']);
	Route::any('/ajax-buscar-sire-compra', [\App\Http\Controllers\CpeController::class, 'actionAjaxBuscarSireCompra']);
	Route::any('/gestion-vaidar-rr/{idopcion}', [\App\Http\Controllers\RRController::class, 'actionGestionValidarRR']);
	Route::any('/ajax-vaidar-rr', [\App\Http\Controllers\RRController::class, 'actionAjaxValidarRR']);
	Route::any('/ajax-modal-vaidar-rr-is', [\App\Http\Controllers\RRController::class, 'actionAjaxModalValidarRRIs']);

	Route::any('/gestion-comprobantes-contabilidad/{idopcion}', [\App\Http\Controllers\GestionComprobantesContabilidadController::class, 'actionGestionComprobantesContabilidad']);
	Route::post('/listar-comprobantes-contabilidad', [\App\Http\Controllers\GestionComprobantesContabilidadController::class, 'actionListarComprobantesContabilidad']);

	Route::any('/detalle-comprobante-oc-validado-historial/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoHitorial']);
	Route::any('/detalle-comprobante-oc-validado-contrato-historial/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoContratoHistorial']);

	//CONSOLIDAR DOCUMENTOS DE PLANILLA DE MOVILIDADD
	Route::any('/gestion-de-consolidar-planilla/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListarConsolidarPlanilla']);
	Route::any('/ajax-modal-detalle-folios-pla', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableModalDetalleFolioPla']);
	Route::any('/crear-folio-entregable-pla/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableCrearFolioEntregablePla']);
	Route::any('/ajax-select-folio-pagos-lg', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableSelectFolioPagoLg']);
	Route::any('/ajax-extornar-folio-pagos-lg', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableExtornoFolioPagoPla']);
	Route::any('/ajax-crear-folio-pagos-pla', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableCrearFolioPla']);
	Route::any('/ajax-detalle-folio-pagos-ple', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableDetalleFolioPagoPla']);
	Route::any('/guardar-folio-entregable-pla/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionEntregableGuardarFolioEntregablePla']);
	Route::any('/ajax-buscar-documento-fe-entregable-pla', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListarAjaxBuscarDocumentoEntregablePla']);

	Route::any('/gestion-de-planilla-consolidada/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListarEntregaDocumentoFolioPla']);
	Route::any('/pdf-planilla-movilidad-consolidada/{iddocumento}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionPDFPlanillaMovilidadConsolidada']);
	Route::any('/ajax-modal-planilla-consolidado-subir', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionListarAjaxModalPLanillaConsolidadoSubir']);
	Route::any('/guardar-comprobante-consolidado/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionGuardarComprobanteconsolidado']);


	Route::any('/gestion-de-aprobar-planilla-consolidada/{idopcion}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarPlanillaMovilidadContabilidad']);
	Route::any('/aprobar-planilla-movilidad-contabilidad/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarContabilidadPLA']);
	Route::any('/agregar-extorno-contabilidad-pla/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAgregarExtornoContabilidadPLA']);
	Route::any('/aprobar-planilla-movilidad-contabilidad-revisadas/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionPlanillaMovilidadController::class, 'actionAprobarContabilidadPLARevisada']);

	Route::post('/obtener-periodo-tipo-cambio', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionObtenerPeriodoTipoCambio']);

	//ENTREGA DE DOCUMENTOS
	Route::any('/gestion-de-entrega-documentos/{idopcion}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionListarEntregaDocumento']);
	Route::any('/ajax-buscar-documento-fe-entregable', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionListarAjaxBuscarDocumentoEntregable']);
	Route::any('/ajax-modal-masivo-entregable', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionListarAjaxModalMasivoEntregable']);
	Route::any('/ajax-guardar-masivo-entregable', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionGuardarMavisoEntregable']);
	Route::any('/ajax-buscar-documento-fe-entregable-folio', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionListarAjaxBuscarDocumentoEntregableFolio']);
	Route::any('/gestion-de-entrega-folios/{idopcion}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionListarEntregaDocumentoFolio']);
	Route::any('/ajax-modal-detalle-entregable', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionModalEntregaDocumentoFolio']);
	Route::any('/descargar-folio-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarDocumentoFolio']);
	Route::any('/descargar-folio-dic-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarDocumentoDICFolio']);
	Route::any('/descargar-folio-lca-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarDocumentoLCAFolio']);
	Route::any('/descargar-folio-dic-consolidado-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarDocumentoDICConsolidadoFolio']);

	Route::any('/descargar-folio-anticipo-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarDocumentoFolioAnticipo']);



	Route::any('/ajax-modal-detalle-deuda-contrato', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionModaDetalleDeudaContrato']);
	Route::any('/entrega-masivo-excel/{operacion_id}/{idopcion}/{fecha_inicio}/{fecha_fin}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableMasivoExcel']);
	Route::any('/ajax-crear-folio-pagos', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableCrearFolio']);
	Route::any('/ajax-modal-detalle-folios', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableModalDetalleFolio']);
	Route::any('/ajax-detalle-documento-pagos', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionModalDetalleDocumentoPagos']);
	Route::any('/crear-folio-entregable/{idopcion}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableCrearFolioEntregable']);
	Route::any('/ajax-select-folio-pagos', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableSelectFolioPago']);
	Route::any('/ajax-extornar-folio-pagos', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableExtornoFolioPago']);
	Route::any('/ajax-detalle-folio-pagos', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableDetalleFolioPago']);
	Route::any('/validar-retencion-folio-pagos', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionValidarDetalleFolioPago']);
	Route::any('/guardar-folio-entregable/{idopcion}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionEntregableGuardarFolioEntregable']);
	Route::any('/descargar-pago-proveedor-bcp-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioBcp']);
	Route::any('/descargar-pago-proveedor-bcp-estiba-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioEstibaBcp']);


	Route::any('/descargar-pago-proveedor-macro-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioMacro']);
	Route::any('/descargar-pago-proveedor-macro-bbva-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroBbva']);
	Route::any('/descargar-pago-proveedor-macro-sbk-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroSBK']);
	Route::any('/descargar-pago-proveedor-macro-interbank-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacrosInterbank']);


	Route::any('/descargar-pago-proveedor-macro-excel-oc/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioMacroOC']);
	Route::any('/descargar-pago-proveedor-macro-bbva-excel-oc/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroBbvaOC']);
	Route::any('/descargar-pago-proveedor-macro-sbk-excel-oc/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroSBKOC']);
	Route::any('/descargar-pago-proveedor-macro-interbank-excel-oc/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacrosInterbankOC']);
	Route::any('/descargar-pago-proveedor-macro-excel-cheque/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioMacroCheque']);

	Route::any('/descargar-pago-proveedor-macro-estiba-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioMacroEstiba']);
	Route::any('/descargar-pago-proveedor-macro-bbva-estiba-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroEstibaBbva']);
	Route::any('/descargar-pago-proveedor-macro-sbk-estiba-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroEstibaSBK']);
	Route::any('/descargar-pago-proveedor-macro-interbank-estiba-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacrosEstibaInterbank']);

	Route::any('/descargar-pago-proveedor-macro-bbva-balanza-excel/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroBalanzaBbva']);

	Route::any('/descargar-pago-proveedor-macro-excel-oca/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoFolioMacroOCA']);
	Route::any('/descargar-pago-proveedor-macro-bbva-excel-oca/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroBbvaOCA']);
	Route::any('/descargar-pago-proveedor-macro-sbk-excel-oca/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacroSBKOCA']);
	Route::any('/descargar-pago-proveedor-macro-interbank-excel-oca/{folio}', [\App\Http\Controllers\GestionEntregaDocumentoController::class, 'actionDescargarPagoMacrosInterbankOCA']);


	Route::any('/ajax-modal-historial-extorno', [\App\Http\Controllers\GestionOCController::class, 'actionModalHistorialExtorno']);
	Route::any('/detalle-comprobante-oc-validado-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoContrato']);
	Route::any('/gestion-de-comprobante-us/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobanteUsuarioContacto']);
	Route::any('/pre-aprobar-documentos/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarPreAprobarUsuarioContacto']);
	Route::any('/extornar-pre-aprobar-comprobante/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionExtornarPreAprobar']);

	Route::any('/aprobar-comprobante-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionAprobarUC']);
	Route::any('/aprobar-comprobante-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionAprobarUCContrato']);

	Route::any('/detalle-comprobante-oc-validado-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoEstiba']);
	Route::any('/detalle-comprobante-oc-validado-contrato-intermedio/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoContratoIntermedio']);

	Route::any('/detalle-comprobante-oc-validado-comision/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoComision']);

	Route::any('/detalle-comprobante-oc-validado-estiba-oca/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoEstibaOCA']);


	Route::any('/detalle-comprobante-oc-validado-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoLiquidacionCompraAnticipo']);

	Route::any('/detalle-comprobante-oc-validado-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoNotaCredito']);

	Route::any('/detalle-comprobante-oc-validado-nota-debito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoNotaDebito']);

	Route::any('/detalle-comprobante-oc-validado-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDetalleComprobanteOCValidadoPg']);


	Route::any('/ajax-combo-periodo-xanio-xempresa', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAjaxComboPeriodoAnioEmpresa']);
	Route::any('/ajax-combo-periodo-xanio-xempresareparable', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAjaxComboPeriodoAnioEmpresaReparable']);
	Route::post('/ajax-validar-asiento-duplicado', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionAjaxValidarAsientoDuplicado']);
	Route::any('/gestion-de-comprobantes-observados/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobantesObservados']);
	Route::any('/gestion-de-comprobantes-reparable/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobantesReparable']);


	Route::any('/gestion-de-comprobantes-en-reparacion/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobantesEnReparacion']);
	Route::any('/ajax-buscar-documento-gestion-reparable-reporte', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarAjaxBuscarDocumentoReparableReporte']);
	Route::any('/comprobante-reparacion-excel/{anio_id}/{idopcion}', [\App\Http\Controllers\ReporteComprobanteController::class, 'actionComprobanteEnReparacionExcel']);





	Route::any('/gestion-de-reparable-admin/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobantesReparableAdmin']);
	Route::any('/reparable-comprobante-uc-admin/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionReparableUCAdmin']);
	Route::any('/ajax-buscar-documento-gestion-reparable-admin', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarAjaxBuscarDocumentoReparableAdmin']);
	Route::any('/reparable-comprobante-uc-contrato-admin/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionReparableUCContratoAdmin']);
	Route::any('/reparable-comprobante-uc-estiba-admin/{idopcion}/{lote}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionReparableUCEstibaAdmin']);


	Route::any('/ajax-modal-reparable-masivo', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarAjaxModalReparableMasivo']);


	Route::any('/ajax-buscar-documento-gestion-observados', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarAjaxBuscarDocumentoObservados']);
	Route::any('/ajax-buscar-documento-gestion-reparable', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarAjaxBuscarDocumentoReparable']);


	Route::any('/gestion-observados-contrato-provedores/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobantesObservadosProveedores']);
	Route::any('/gestion-observados-oc-provedores/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarComprobantesObservadosOCProveedores']);

	Route::any('/observacion-comprobante-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUC']);
	Route::any('/observacion-comprobante-uc-proveedor/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCProvedor']);

	Route::any('/reparable-comprobante-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionReparableUC']);
	Route::any('/reparable-comprobante-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionReparableUCContrato']);
	Route::any('/reparable-comprobante-uc-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionReparableUCEstiba']);


	Route::any('/pago-comprobante-reparable-masivo/{idopcion}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionAprobarReparableMasivo']);


	Route::any('/observacion-comprobante-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCContrato']);
	Route::any('/observacion-comprobante-uc-contrato-proveedor/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCContratoProveedor']);
	Route::any('/observacion-comprobante-uc-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCLiquidacionCompraAnticipo']);
	Route::any('/observacion-comprobante-uc-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCNotaCredito']);
	Route::any('/observacion-comprobante-uc-nota-debito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCNotaDebito']);
	Route::any('/observacion-comprobante-uc-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCEstiba']);
	Route::any('/observacion-comprobante-uc-contrato-intermedio/{idopcion}/{lote}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCContratoIntermedio']);
	Route::any('/observacion-comprobante-uc-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCPG']);



	//	PAGOS DETRACCIONES
	Route::any('/gestion-de-pago-detracciones/{idopcion}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionListarPagoDetraccion']);
	Route::any('/ajax-buscar-documento-fe-entregable-detraccion', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionListarAjaxBuscarDocumentoDetraccion']);
	Route::any('/ajax-modal-detalle-folios-detraccion', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableModalDetalleFolioDetraccion']);
	Route::any('/crear-folio-entregable-detraccion/{idopcion}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableCrearFolioEntregableDetraccion']);
	Route::any('/ajax-select-folio-pagos-detracion', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableSelectFolioPagoDetraccion']);
	Route::any('/ajax-crear-folio-pagos-detracion', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableCrearFolioDetraccion']);
	Route::any('/ajax-detalle-folio-pagos-detraccion', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableDetalleFolioPagoDetraccion']);
	Route::any('/guardar-folio-entregable-detraccion/{idopcion}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableGuardarFolioEntregableDetraccion']);
	Route::any('/ajax-extornar-folio-pagos-detraccion', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEntregableExtornoFolioPagoDetraccion']);
	Route::any('/gestion-de-macro-detracciones/{idopcion}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionListarEntregaDocumentoFolioDetraccion']);
	Route::any('/descargar-folio-excel-detraccion/{folio}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionDescargarDocumentoFolioDetraccion']);
	Route::any('/descargar-folio-excel-detraccion-macro/{folio}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionDescargarDocumentoFolioDetraccionMacro']);

	Route::any('/descargar-folio-excel-detraccion-reserva/{folio}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionDescargarDocumentoFolioDetraccionReserva']);



	Route::any('/gestion-de-contabilidad-aprobar/{idopcion}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionListarComprobanteContabilidad']);
	Route::any('/aprobar-documentos/{idopcion}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionListarAprobarUsuarioContacto']);
	Route::any('/extornar-aprobar-comprobante/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionExtornarAprobar']);


	Route::any('/aprobar-comprobante-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidad']);
	Route::any('/aprobar-comprobante-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadContrato']);
	Route::any('/aprobar-comprobante-contabilidad-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadNotaCredito']);
	Route::any('/aprobar-comprobante-contabilidad-nota-debito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadNotaDebito']);
	Route::any('/aprobar-comprobante-contabilidad-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadEstiba']);
	Route::any('/aprobar-comprobante-contabilidad-estiba-conint/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadContratoIntermedio']);

	Route::any('/aprobar-comprobante-contabilidad-estiba-dic/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadEstibaDIC']);

	Route::any('/aprobar-comprobante-contabilidad-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadPG']);
	Route::any('/aprobar-comprobante-contabilidad-estiba-oca/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadEstibaOca']);
	Route::any('/aprobar-comprobante-contabilidad-estiba-contratoa/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadEstibaContratoa']);

	Route::any('/aprobar-comprobante-contabilidad-estiba-contratoa/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadEstibaContratoa']);


	Route::any('/ajax-modal-activo-fijo-categoria', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAjaxModalActivoFijoCategoria']);
	Route::any('/registrar-activo-fijo-categoria/{idopcion}/{idoc}/{codprod}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionRegistrarActivoFijoCategoria']);
	Route::any('/eliminar-activo-fijo-categoria/{idopcion}/{idoc}/{codprod}/{codlote}/{nrolinea}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionEliminarActivoFijoCategoria']);

	Route::any('/aprobar-comprobante-contabilidad-estiba-comision/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadEstibaComision']);

	Route::any('/aprobar-comprobante-contabilidad-reparable/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadReparable']);
	//Route::any('/aprobar-comprobante-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadContrato']);

	Route::any('/agregar-observacion-contabilidad-reparable/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadReparable']);
	//Route::any('/agregar-observacion-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadContrato']);

	Route::any('/refrescar-sunat-oc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionRefrescarSunatOc']);
	Route::any('/refrescar-sunat-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionRefrescarSunatContrato']);
	Route::any('/refrescar-sunat-comision/{idopcion}/{linea}/{idcomision}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionRefrescarSunatComision']);



	Route::any('/extornar-obs-oc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionExtornarObsOc']);
	Route::any('/extornar-obs-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionExtornarObsContrato']);


	Route::any('/extornar-obs-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionExtornarObsNotaCredito']);



	Route::any('/agregar-observacion-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidad']);
	Route::any('/agregar-observacion-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadContrato']);
	Route::any('/agregar-observacion-contabilidad-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadNotaCredito']);
	Route::any('/agregar-observacion-contabilidad-nota-debito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadNotaDebito']);
	Route::any('/agregar-observacion-contabilidad-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadEstiba']);
	Route::any('/agregar-observacion-contabilidad-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadPG']);

	Route::any('/agregar-reparable-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidad']);
	Route::any('/agregar-reparable-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidadContrato']);
	Route::any('/agregar-reparable-contabilidad-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidadPg']);
	Route::any('/agregar-reparable-contabilidad-nc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidadNC']);
	Route::any('/agregar-reparable-contabilidad-nd/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidadND']);


	Route::any('/agregar-reparable-contabilidad-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidadEstiba']);
	Route::any('/agregar-reparable-contabilidad-estiba-dic/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarReparableContabilidadEstibaDIC']);


	Route::any('/agregar-extorno-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarExtornoContabilidad']);
	Route::any('/agregar-extorno-contrato-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarExtornoContratoContabilidad']);
	Route::any('/agregar-extorno-nota-credito-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarExtornoNotaCreditoContabilidad']);
	Route::any('/agregar-extorno-nota-debito-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarExtornoNotaDebitoContabilidad']);
	Route::any('/agregar-extorno-estiba-contabilidad/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarExtornoEstibaContabilidad']);
	Route::any('/agregar-extorno-pg-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarExtornoPGContabilidad']);


	Route::any('/agregar-recomendacion-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarRecomendacionContabilidad']);
	Route::any('/agregar-recomendacion-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarRecomendacionContabilidadContrato']);

	Route::any('/aprobar-comprobante-administracion/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracion']);
	Route::any('/agregar-extorno-administracion-oc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoAdministracionOC']);
	Route::any('/agregar-extorno-estiba-administracion/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoEstibaAdministracion']);

	Route::any('/agregar-extorno-estiba-acopio/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoEstibaAcopio']);

	Route::any('/aprobar-comprobante-administracion-oca/{idopcion}/{linea}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionOCA']);
	Route::any('/aprobar-comprobante-administracion-contratoa/{idopcion}/{linea}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionCONTRATOA']);


	Route::any('/agregar-extorno-administracion-oc-moca/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoAdministracionOCMoca']);
	Route::any('/agregar-observacion-administracion-moca/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionMoca']);
	Route::any('/observacion-comprobante-uc-estiba-oca/{idopcion}/{lote}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionObservarUCEstibaMoca']);

	Route::any('/agregar-observacion-administracion-mcontratoa/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionMContratoa']);
	Route::any('/agregar-extorno-administracion-oc-mcontratoa/{idopcion}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoAdministracionContratooca']);


	Route::any('/agregar-observacion-administracion/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracion']);
	Route::any('/agregar-observacion-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionAgregarObservacionUC']);
	Route::any('/ajax-detalle-documento', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionModalDetalleDocumento']);

	Route::any('/ajax-buscar-documento-gestion-uc', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionListarAjaxBuscarDocumentoUC']);


	Route::any('/agregar-extorno-contrato-admin/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoContratoAdmin']);

	Route::any('/aprobar-comprobante-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionContrato']);
	Route::any('/agregar-observacion-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionContrato']);
	Route::any('/agregar-observacion-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionUsuarioContactoController::class, 'actionAgregarObservacionUCContrato']);

	Route::any('/aprobar-comprobante-administracion-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionLiquidacionCompraAnticipo']);
	Route::any('/agregar-observacion-administracion-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionLiquidacionCompraAnticipo']);
	Route::any('/descargar-archivo-requerimiento-liquidacion-compra-anticipo/{tipo}/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarLiquidacionCompraAnticipo']);
	Route::any('/descargar-archivo-requerimiento-liquidacion-compra-anticipo-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarLiquidacionCompraAnticipoAnulado']);

	Route::any('/aprobar-comprobante-administracion-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionNotaCredito']);
	Route::any('/agregar-observacion-administracion-nota-credito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionNotaCredito']);

	Route::any('/aprobar-comprobante-administracion-nota-debito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionNotaDebito']);
	Route::any('/agregar-observacion-administracion-nota-debito/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionNotaDebito']);

	Route::any('/aprobar-comprobante-contabilidad-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAprobarContabilidadLiquidacionCompraAnticipo']);
	Route::any('/agregar-observacion-contabilidad-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionAgregarObservacionContabilidadLiquidacionCompraAnticipo']);



	Route::any('/aprobar-comprobante-administracion-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionPG']);
	Route::any('/agregar-observacion-administracion-pg/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionPG']);

	Route::any('/ajax-buscar-documento-gestion-contabilidad', [\App\Http\Controllers\GestionOCContabilidadController::class, 'actionListarAjaxBuscarDocumentoContabilidad']);
	Route::any('/gestion-de-administracion-aprobar/{idopcion}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionListarComprobanteAdministracion']);
	Route::any('/aprobar-documentos-administracion/{idopcion}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionListarAprobarAdministracion']);
	Route::any('/extornar-aprobar-comprobante-administrador/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionExtornarAprobar']);
	Route::any('/agregar-recomendacion-administracion/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarRecomendacionAdministracion']);
	Route::any('/agregar-recomendacion-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarRecomendacionAdministracionContrato']);
	Route::any('/modificar-pdf-guias/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionModificarContratos']);

	Route::any('/aprobar-comprobante-administracion-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionEstiba']);
	Route::any('/agregar-observacion-administracion-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionEstiba']);

	Route::any('/aprobar-comprobante-administracion-contrato-intermedio/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionContratoIntermedio']);
	Route::any('/agregar-observacion-administracion-contrato-intermedio/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarObservacionAdministracionContratoIntermedio']);
	Route::any('/agregar-extorno-contrato-intermedio-administracion/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAgregarExtornoContratoIntermedioAdministracion']);


	//ACOPIO
	Route::any('/gestion-de-acopio-liquidacion-compra/{idopcion}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionListarComprobanteAcopio']);
	Route::any('/ajax-buscar-documento-gestion-acopio', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionListarAjaxBuscarDocumentoAcopio']);
	Route::any('/aprobar-comprobante-acopio-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionAprobarAcopioLiquidacionCompraAnticipo']);
	Route::any('/agregar-observacion-acopio-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionAgregarObservacionAcopioLiquidacionCompraAnticipo']);
	Route::any('/aprobar-comprobante-acopio-liquidacion-compra-anticipo/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionAprobarAcopioLiquidacionCompraAnticipo']);
	Route::any('/aprobar-comprobante-acopio-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionAprobarAcopioEstiba']);
	Route::any('/agregar-observacion-acopio-estiba/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionAgregarObservacionAcopioEstiba']);

	Route::any('/agregar-extorno-estiba-acopio-lca/{idopcion}/{linea}/{prefijo}/{idordenpago}', [\App\Http\Controllers\GestionOCAcopioController::class, 'actionAgregarExtornoEstibaAcopioLc']);



	Route::any('/ajax-buscar-documento-gestion-administracion', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionListarAjaxBuscarDocumentoAdministracion']);
	Route::any('/aprobar-comprobante-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCAdministracionController::class, 'actionAprobarAdministracionContrato']);
	Route::any('/gestion-de-tesoreria-aprobar/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarComprobanteTesoreria']);
	Route::any('/pago-comprobante-tesoreria/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreria']);
	Route::any('/ajax-buscar-documento-gestion-tesoreria', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxBuscarDocumentoTesoreria']);
	Route::any('/ajax-modal-tesoreria-pago', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPago']);
	Route::any('/ajax-modal-tesoreria-pago-masivo', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPagoMasivo']);
	Route::any('/pago-comprobante-tesoreria-masivo/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreriaMasivo']);
	Route::any('/ajax-modal-tesoreria-pago-contrato', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPagoContrato']);
	Route::any('/pago-comprobante-tesoreria-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreriaContrato']);


	Route::any('/ajax-modal-tesoreria-pago-estiba', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPagoEstiba']);
	Route::any('/pago-comprobante-tesoreria-estiba/{idopcion}/{linea}/{idordencompra}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreriaEstiba']);


	Route::any('/gestion-de-comprobante-pago-tesoreria/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarComprobanteTesoreriaPago']);
	Route::any('/ajax-buscar-documento-gestion-tesoreria-pagado', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxBuscarDocumentoTesoreriaPago']);
	Route::any('/ajax-modal-tesoreria-pago-pagado', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPagoPagado']);
	Route::any('/pago-comprobante-tesoreria-pagado/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreriaPagado']);
	Route::any('/pago-comprobante-tesoreria-pagado-contrato/{idopcion}/{linea}/{idordencompra}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreriaPagadoContrato']);
	Route::any('/pago-comprobante-tesoreria-pagado-comision/{idopcion}/{linea}/{idordencompra}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionAprobarTesoreriaPagadoComision']);



	Route::any('/extornar-pago-item/{idordencompra}/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionExtornoTesoreriaPagado']);

	Route::any('/ajax-modal-tesoreria-pago-pagado-contrato', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPagoPagadoContrato']);
	Route::any('/ajax-modal-tesoreria-pago-pagado-comision', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionListarAjaxModalTesoreriaPagoPagadoComision']);


	Route::any('/extornar-pago-item-contrato/{idordencompra}/{idopcion}', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionExtornoTesoreriaPagadoContrato']);



	Route::any('/gestion-de-provision-comprobante/{idopcion}', [\App\Http\Controllers\GestionOCProvisionController::class, 'actionListarComprobanteProvision']);
	Route::any('/provisionar-documentos/{idopcion}', [\App\Http\Controllers\GestionOCProvisionController::class, 'actionListarProvisionarComprobante']);



	Route::any('/descargar-archivo-requerimiento-xml/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarXML']);
	Route::any('/descargar-archivo-requerimiento-cdr/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarCDR']);
	Route::any('/descargar-archivo-requerimiento-pdf/{idopcion}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarPDF']);
	Route::any('/descargar-archivo-requerimiento/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargar']);
	Route::any('/descargar-archivo-requerimiento-contrato/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarContrato']);
	Route::any('/descargar-archivo-requerimiento-nota-credito/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarNotaCredito']);
	Route::any('/descargar-archivo-requerimiento-nota-debito/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarNotaDebito']);
	Route::any('/descargar-archivo-requerimiento-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarAnulado']);
	Route::any('/descargar-archivo-requerimiento-contrato-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarContratoAnulado']);
	Route::any('/descargar-archivo-requerimiento-nota-credito-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarNotaCreditoAnulado']);
	Route::any('/descargar-archivo-requerimiento-nota-debito-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarNotaDebitoAnulado']);
	Route::any('/eliminar-archivo-item/{tipo}/{nombrearchivo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionEliminarItem']);
	Route::any('/eliminar-archivo-item-contrato/{tipo}/{nombrearchivo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionEliminarItemContrato']);
	Route::any('/eliminar-archivo-item-nota-credito/{tipo}/{nombrearchivo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionEliminarItemNotaCredito']);
	Route::any('/eliminar-archivo-item-nota-debito/{tipo}/{nombrearchivo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionEliminarItemNotaDebito']);

	Route::any('/ajax-eliminar-archivo-item-pp', [\App\Http\Controllers\GestionOCTesoreriaController::class, 'actionEliminarItemPP']);
	Route::any('/descargar-archivo-requerimiento-pg/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarPG']);

	Route::any('/descargar-archivo-requerimiento-estiba/{tipo}/{idopcion}/{lote}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarEstiba']);

	Route::any('/descargar-archivo-requerimiento-lg/{tipo}/{idopcion}/{linea}/{idordencompra}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionDescargarLG']);

	Route::any('/gestion-de-modelos-comprobantes/{idopcion}', [\App\Http\Controllers\GestionOCValidadoController::class, 'actionModelosComprobantes']);

	Route::any('/gestion-reporte-inventario/{idopcion}', [\App\Http\Controllers\ReporteInventarioController::class, 'actionListarReporteInventario']);
	Route::any('/ajax-reporte-inventario', [\App\Http\Controllers\ReporteInventarioController::class, 'actionAjaxListarReporteInventario']);
	Route::any('/descargar-archivo-inventario-consolidado', [\App\Http\Controllers\ReporteInventarioController::class, 'actionAjaxListarReporteInventarioExcel']);

	//VALE A RENDIR
	Route::get('/gestionar-vale-rendir/{idopcion}', [\App\Http\Controllers\ValeRendirController::class, 'actionValeRendir']);
	Route::post('/registrar_vale_rendir', [\App\Http\Controllers\ValeRendirController::class, 'insertValeRendirAction']);
	Route::post('/data_vale_rendir', [\App\Http\Controllers\ValeRendirController::class, 'traerdataValeRendirAction']);
	Route::post('/ver_detalle_importe_vale', [\App\Http\Controllers\ValeRendirController::class, 'actionDetalleImporteVale']);
	Route::post('/ver_mensaje_vale_rendir', [\App\Http\Controllers\ValeRendirController::class, 'actionMensajeValeRendir']);

	Route::get('/gestion-autoriza-rendir/{idopcion}', [\App\Http\Controllers\ValeRendirAutorizaController::class, 'actionValeRendirAutoriza']);
	Route::post('/autorizar_vale_rendir', [\App\Http\Controllers\ValeRendirAutorizaController::class, 'actionAutorizarValeRendir']);
	Route::post('/rechazar_vale_rendir', [\App\Http\Controllers\ValeRendirAutorizaController::class, 'actionRechazarValeRendir']);
	Route::post('/ver_detalle_importe_autoriza', [\App\Http\Controllers\ValeRendirAutorizaController::class, 'actionDetalleImporte']);

	Route::get('/gestion-aprueba-rendir/{idopcion}', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionValeRendirAprueba']);
	Route::post('/aprobar_vale_rendir', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionApruebaValeRendir']);
	Route::post('/rechazar_vale_rendir_aprueba', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionRechazarValeRendir']);
	Route::post('/aprobarRegistro_vale_rendir', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionApruebaRegistroValeRendir']);
	Route::post('/verRegistro_vale_rendir', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionVerRegistroValeRendir']);
	Route::post('/obtener_correlativo', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionObtenerCorrelativoValeRendir']);
	Route::post('/insertar-osiris', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionInsertValeRendirOsiris']);
	Route::post('/ver_detalle_importe', [\App\Http\Controllers\ValeRendirApruebaController::class, 'actionVerDetalleImporte']);

	//DETALLE A RENDIR
	Route::post('/data_vale_rendir_detalle', [\App\Http\Controllers\ValeRendirController::class, 'traerdataValeRendirActionDetalle']);
	Route::post('/eliminar_vale_rendir', [\App\Http\Controllers\ValeRendirController::class, 'actionEliminarValeRendir']);
	Route::post('/eliminar_vale_rendir_detalle', [\App\Http\Controllers\ValeRendirController::class, 'actionEliminarValeRendirDetalle']);



	//REGISTRO-IMPORTE-GASTOS
	Route::get('/gestionar-importe-gastos/{idopcion}', [\App\Http\Controllers\RegistroImporteGastosController::class, 'actionRegistroImporteGastos']);
	Route::post('/registrar_importe_gastos', [\App\Http\Controllers\RegistroImporteGastosController::class, 'insertImporteGastosAction']);
	Route::post('/data_importe_gastos', [\App\Http\Controllers\RegistroImporteGastosController::class, 'traerdataImporteGastosAction']);
	Route::post('/eliminar_importe_gastos', [\App\Http\Controllers\RegistroImporteGastosController::class, 'actionEliminarRegistroImporteGastos']);

	Route::post('/obtener_provincia_por_departamento', [\App\Http\Controllers\RegistroImporteGastosController::class, 'listarProvinciasPorDepartamento']);
	Route::post('/obtener_distrito_por_provincia', [\App\Http\Controllers\RegistroImporteGastosController::class, 'listarDistritosPorProvincias']);

	Route::post('/validar_destino_distrito', [\App\Http\Controllers\RegistroImporteGastosController::class, 'validarDestinoPorDistrito']);

	Route::any('/ajax-buscar-documento-rg', [\App\Http\Controllers\RegistroImporteGastosController::class, 'actionListarAjaxBuscarDocumentoRG']);

	//REGISTRO-IMPORTE-RUTAS
	Route::get('/gestion-de-importe-rutas/{idopcion}', [\App\Http\Controllers\RegistroImporteRutasController::class, 'actionRegistroImporteRutas']);
	Route::post('/guardar_matriz_viaticos', [\App\Http\Controllers\RegistroImporteRutasController::class, 'actionGuardarRegistroImporteRutas']);

	//PATANLLA 1

	Route::get('/gestionar-personal-autoriza/{idopcion}', [\App\Http\Controllers\RegistroPersonalAutorizaController::class, 'actionRegistroPersonalAutoriza']);
	Route::post('/filtro_personal_autoriza', [\App\Http\Controllers\RegistroPersonalAutorizaController::class, 'actionfiltrarPersonalAutoriza']);
	Route::post('/guardar_personal_autoriza', [\App\Http\Controllers\RegistroPersonalAutorizaController::class, 'guardarPersonalAutoriza']);



	//PATANLLA  2
	Route::get('/gestion-de-personal-aprueba-vale/{idopcion}', [\App\Http\Controllers\RegistroPersonalApruebaController::class, 'actionRegistroPersonalAprueba']);
	Route::post('/registrar_personal_aprueba', [\App\Http\Controllers\RegistroPersonalApruebaController::class, 'insertPersonalAprueba']);
	Route::post('/obtener_area_cargo', [\App\Http\Controllers\RegistroPersonalApruebaController::class, 'obtenerAreaYCargo']);

	Route::post('/data_personal_aprueba', [\App\Http\Controllers\RegistroPersonalApruebaController::class, 'traerdataPersonalApruebaAction']);
	Route::post('/eliminar_personal_aprueba', [\App\Http\Controllers\RegistroPersonalApruebaController::class, 'actionEliminarRegistroPersonalAprueba']);

	//CORREO VALE RENDIR

	Route::get('/enviar_correo_generado', [\App\Http\Controllers\EnviarCorreoValeRendirGeneradoController::class, 'actionEnviarCorreoVRGenerado']);
	Route::get('/enviar_correo_autoriza', [\App\Http\Controllers\EnviarCorreoValeRendirAutorizaController::class, 'actionEnviarCorreoVRAutoriza']);
	Route::get('/enviar_correo_aprueba', [\App\Http\Controllers\EnviarCorreoValeRendirApruebaController::class, 'actionEnviarCorreoVRAprueba']);

	Route::get('/rechazar_correo_generado', [\App\Http\Controllers\RechazarCorreoValeRendirGeneradoController::class, 'actionRechazarCorreoVRGenerado']);
	Route::get('/rechazar_correo_autoriza', [\App\Http\Controllers\RechazarCorreoValeRendirAutorizaController::class, 'actionRechazarCorreoVRAutoriza']);

	//FIRMA VALE A RENDIR

	Route::get('/firma-de-vale/{idopcion}', [\App\Http\Controllers\FirmaValeRendirController::class, 'actionRegistroPersonalFirma']);
	Route::get('/exportar_pdf/{id}', [\App\Http\Controllers\FirmaValeRendirController::class, 'actionexportarpdf'])->name('exportar_pdf');

	//VALE A RENDIR REEMBOLSO
	Route::get('/gestion-de-vale-rendir-reembolso/{idopcion}', [\App\Http\Controllers\ValeRendirControllerReembolso::class, 'actionValeRendirReembolso']);
	Route::post('/registrar_vale_rendir_reembolso', [\App\Http\Controllers\ValeRendirControllerReembolso::class, 'insertValeRendirActionReembolso']);
	Route::post('/data_vale_rendir_reembolso', [\App\Http\Controllers\ValeRendirControllerReembolso::class, 'traerdataValeRendirActionReembolso']);
	Route::post('/ver_detalle_importe_vale_reembolso', [\App\Http\Controllers\ValeRendirControllerReembolso::class, 'actionDetalleImporteValeReembolso']);

	Route::get('/gestion-autoriza-rendir-reembolso/{idopcion}', [\App\Http\Controllers\ValeRendirAutorizaControllerReembolso::class, 'actionValeRendirAutorizaReembolso']);
	Route::post('/autorizar_vale_rendir_reembolso', [\App\Http\Controllers\ValeRendirAutorizaControllerReembolso::class, 'actionAutorizarValeRendirReembolso']);
	Route::post('/rechazar_vale_rendir_reembolso', [\App\Http\Controllers\ValeRendirAutorizaControllerReembolso::class, 'actionRechazarValeRendirReembolso']);
	Route::post('/ver_detalle_importe_autoriza_reembolso', [\App\Http\Controllers\ValeRendirAutorizaControllerReembolso::class, 'actionDetalleImporteReembolso']);

	//GESTION LISTA VALE A RENDIR ADMINISTRACION
	Route::any('/gestion-de-vale-rendir-administracion/{idopcion}', [\App\Http\Controllers\GestionValeRendirController::class, 'actionListarValeRendir']);
	Route::any('/ajax-buscar-documento-vl', [\App\Http\Controllers\GestionValeRendirController::class, 'actionListarAjaxBuscarDocumentoVL']);
	Route::any('/descargar-excel-vl/{fecha_inicio}/{fecha_fin}/{estado_id}/{tipo_vale}/{idopcion}', [\App\Http\Controllers\GestionValeRendirController::class, 'actionExportarExcelVL']);
	Route::any('/descargar-excel-vl', [\App\Http\Controllers\GestionValeRendirController::class, 'actionExportarExcelVL']);

	Route::post('/ver_detalle_importe_vale_gestion', [\App\Http\Controllers\GestionValeRendirController::class, 'actionVerDetalleValeImporte']);
	Route::post('/ver_detalle_vale_gestion', [\App\Http\Controllers\GestionValeRendirController::class, 'actionVerDetalleVale']);
	Route::post('/aum_detalle_importe_vale_gestion', [\App\Http\Controllers\GestionValeRendirController::class, 'actionVAumDetalleValeImporte']);
	Route::post('/actualizar_dias_vale', [\App\Http\Controllers\GestionValeRendirController::class, 'actionActualizarDiasVale']);
	Route::post('/actualizar_importe_vale', [\App\Http\Controllers\GestionValeRendirController::class, 'actionActualizarImporteVale']);

	Route::get('/enviar_correo_detalle_dias', [\App\Http\Controllers\EnviarCorreoValeRendirDetalleDiasController::class, 'actionEnviarCorreoVRDetalleDias']);
	Route::get('/enviar_correo_detalle_importe', [\App\Http\Controllers\EnviarCorreoValeRendirDetalleImporteController::class, 'actionEnviarCorreoVRDetalleImporte']);

	//ORDEN PEDIDO

	Route::get('/gestion-de-orden-pedido-compras/{idopcion}', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionOrdenPedido']);
	Route::post('/registrar_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'insertOrdenPedidoAction']);
	Route::post('/emitir_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'insertEmitirOrdenPedido']);
	Route::post('/anular_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'insertAnularOrdenPedido']);
	Route::post('/obtener-meses', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'obtenerMeses']);
	Route::post('/ver_detalle_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionDetallePedido']);
	Route::post('/ajax_editar_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionAjaxEditarPedido']);
	Route::post('/ajax-pedido-editar', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionAjaxPedidoEditar']);
	Route::post('/ajax-obtener-correlativo-pedido', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionAjaxObtenerCorrelativoPedido']);
	Route::post('/ajax-buscar-producto', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionAjaxBuscarProducto']);
	Route::post('/ajax-verificar-almacen-producto', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionAjaxVerificarAlmacenProducto']);
	Route::post('/ajax-obtener-periodos-empresa', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionAjaxObtenerPeriodosEmpresa']);
	Route::get('/buscarproductocompra', [\App\Http\Controllers\GestionOrdenPedidoController::class, 'actionBuscarProductoCompra']);

	Route::get('/reporte-orden-pedido/{idopcion}', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionReporteOrdenPedido']);
	Route::any('/ajax-buscar-documento-op', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionListarAjaxBuscarDocumentoOP']);
	Route::any('/comprobante-masivo-excel-op/{fecha_inicio}/{fecha_fin}/{empresa_id}/{centro_pedido}/{idopcion}', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionComprobanteMasivoExcelOp']);
	Route::any('/pedido-masivo-excel-op/{fecha_inicio}/{fecha_fin}/{empresa_id}/{centro_pedido}/{idopcion}', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionDiseñoMasivoExcelOp']);

	Route::get('/resumen-orden-pedido/{idopcion}', [\App\Http\Controllers\ResumenOrdenPedidoController::class, 'actionResumenOrdenPedido']);
	Route::any('/ajax-buscar-resumen-op', [\App\Http\Controllers\ResumenOrdenPedidoController::class, 'actionListarAjaxBuscarResumenOP']);
	Route::any('/resumen-masivo-excel-op/{fecha_inicio}/{fecha_fin}/{empresa_id}/{centro_pedido}/{area}/{idopcion}', [\App\Http\Controllers\ResumenOrdenPedidoController::class, 'actionResumenMasivoExcelOp']);

	// RUTA PARA TERMINAR PEDIDO EN REPORTE RESUMEN
	Route::post('/ajax-terminar-resumen-op', [\App\Http\Controllers\ResumenOrdenPedidoController::class, 'actionTerminarResumenOp']);
	Route::post('/ver-detalle-pedido-resumen', [\App\Http\Controllers\ResumenOrdenPedidoController::class, 'actionDetallePedidoResumen']);

	Route::get('/gestion-de-autorizacion-orden-pedido/{idopcion}', [\App\Http\Controllers\GestionOrdenPedidoAutorizaController::class, 'actionOrdenPedidoAutoriza']);
	Route::post('/autorizar_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoAutorizaController::class, 'insertAutorizaOrdenPedido']);
	Route::post('/rechazar_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoAutorizaController::class, 'insertRechazarOrdenPedido']);
	Route::post('/ver_detalle_orden_pedido_aut', [\App\Http\Controllers\GestionOrdenPedidoAutorizaController::class, 'actionDetallePedidoAut']);
	Route::post('/guardar_editar_detalle_pedido_aut', [\App\Http\Controllers\GestionOrdenPedidoAutorizaController::class, 'actionGuardarEditarDetalleAut']);

	Route::get('/gestion-de-autorizacion-orden-pedido-man/{idopcion}', [\App\Http\Controllers\GestionOrdenPedidoAutorizaManController::class, 'actionOrdenPedidoAutorizaMan']);
	Route::post('/autorizar_orden_pedido_man', [\App\Http\Controllers\GestionOrdenPedidoAutorizaManController::class, 'insertAutorizaOrdenPedidoMan']);
	Route::post('/rechazar_orden_pedido_man', [\App\Http\Controllers\GestionOrdenPedidoAutorizaManController::class, 'insertRechazarOrdenPedidoMan']);
	Route::post('/ver_detalle_orden_pedido_man', [\App\Http\Controllers\GestionOrdenPedidoAutorizaManController::class, 'actionDetallePedidoMan']);
	Route::post('/guardar_editar_detalle_pedido_man', [\App\Http\Controllers\GestionOrdenPedidoAutorizaManController::class, 'actionGuardarEditarDetalleMan']);

	Route::get('/gestion-de-aprobacion-orden-pedido-ger/{idopcion}', [\App\Http\Controllers\GestionOrdenPedidoApruebaGerController::class, 'actionOrdenPedidoApruebaGer']);
	Route::post('/ap_ger_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoApruebaGerController::class, 'insertApruebaOrdenPedidoGer']);
	Route::post('/rechazar_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoApruebaGerController::class, 'insertRechazarOrdenPedidoGer']);
	Route::post('/ver_detalle_orden_pedido_ger', [\App\Http\Controllers\GestionOrdenPedidoApruebaGerController::class, 'actionDetallePedidoGer']);
	Route::post('/guardar_editar_detalle_pedido_ger', [\App\Http\Controllers\GestionOrdenPedidoApruebaGerController::class, 'actionGuardarEditarDetalleGer']);

	Route::get('/gestion-de-aprobacion-orden-pedido-adm/{idopcion}', [\App\Http\Controllers\GestionOrdenPedidoApruebaAdmController::class, 'actionOrdenPedidoApruebaAdm']);
	Route::post('/ap_adm_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoApruebaAdmController::class, 'insertApruebaOrdenPedidoAdm']);
	Route::post('/rechazar_orden_pedido', [\App\Http\Controllers\GestionOrdenPedidoApruebaAdmController::class, 'insertRechazarOrdenPedidoAdm']);
	Route::post('/ver_detalle_orden_pedido_adm', [\App\Http\Controllers\GestionOrdenPedidoApruebaAdmController::class, 'actionDetallePedidoAdm']);
	Route::post('/guardar_editar_detalle_pedido_adm', [\App\Http\Controllers\GestionOrdenPedidoApruebaAdmController::class, 'actionGuardarEditarDetalleAdm']);

	Route::get('/consolidado-orden-pedido/{idopcion}', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionConsolidadoOrdenPedido']);
	Route::post('/cargar-periodo-consolidado', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionAjaxPeriodoConsolidado']);
	Route::any('/ajax-buscar-consolidado-op', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionListarAjaxBuscarConsolidadoOP']);
	Route::post('/guardar_consolidado_pedido', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionGuardarConsolidado']);
	Route::any('/ajax-listar-detalle-consolidado-op', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionListarAjaxDetalleConsolidadoOP']);
	Route::any('/ajax-detalle-producto-consolidado-generado', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionAjaxDetalleProductoConsolidadoGenerado']);
	Route::post('/ajax-aprobar-consolidado-op', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionAjaxAprobarConsolidado']);
	Route::post('/ajax-eliminar-consolidado-op', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionAjaxEliminarConsolidado']);
	Route::post('/ajax-guardar-cantidad-comprada-op', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionAjaxGuardarCantidadComprada']);
	Route::get('/exportar-excel-consolidado/{id_consolidado}', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionExportarExcelConsolidado']);
	Route::get('/exportar-excel-masivo-consolidado', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionExportarExcelMasivoConsolidado']);
	Route::post('/ajax-guardar-cantidad-comprada-general-op', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionAjaxGuardarCantidadCompradaGeneral']);

	Route::get('/consolidado-general-orden-pedido/{idopcion}', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionConsolidadoGeneralOrdenPedido']);
	Route::post('/guardar_consolidado_general', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionGuardarConsolidadoGeneral']);
	Route::post('/ajax-listar-detalle-consolidado-general-op', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionListarAjaxDetalleConsolidadoGeneralOP']);
	Route::any('/ajax-buscar-consolidado-general-op', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionAjaxBuscarConsolidadoGeneralOP']);
	Route::post('/ajax-aprobar-consolidado-general-op', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionAjaxAprobarConsolidadoGeneral']);
	Route::get('/descargar-excel-detalle-consolidado-general/{id_consolidado_general}/{familia_id}', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionDescargarExcelDetalleConsolidadoGeneral']);
	Route::get('/descargar-excel-detalle-consolidado-general-area/{id_consolidado_general}/{familia_id}', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionDescargarExcelDetalleConsolidadoGeneralArea']);
	Route::post('/ajax-eliminar-consolidado-general-op', [\App\Http\Controllers\ConsolidadoGeneralOrdenPedidoController::class, 'actionAjaxEliminarConsolidadoGeneral']);

	Route::get('/gestion-monto-orden-pedido/{idopcion}', [\App\Http\Controllers\MontoOrdenPedidoController::class, 'actionMontoOrdenPedido']);
	Route::any('/modificar-monto-orden-pedido', [\App\Http\Controllers\MontoOrdenPedidoController::class, 'actionModificarMontoOrdenPedido']);

	Route::get('/aprobar-consolidado-pedidos/{idopcion}', [\App\Http\Controllers\ConsolidadoPedidoAprobadoController::class, 'actionConsolidadoPedidoAprobar']);
	Route::any('/ajax-buscar-consolidado-pedidos-aprobar', [\App\Http\Controllers\ConsolidadoPedidoAprobadoController::class, 'actionListarAjaxBuscarConsolidadoPedidoAprobar']);
	Route::post('/ajax-listar-detalle-consolidado-aprobado', [\App\Http\Controllers\ConsolidadoPedidoAprobadoController::class, 'actionListarAjaxDetalleConsolidadoPedidoAprobar']);
	Route::post('/ajax-guardar-cambios-consolidado-aprobar', [\App\Http\Controllers\ConsolidadoPedidoAprobadoController::class, 'actionAjaxGuardarCantidadCompradaAprobar']);
	Route::post('/ajax-aprobar-consolidado-aprobar', [\App\Http\Controllers\ConsolidadoPedidoAprobadoController::class, 'actionAjaxAprobarConsolidadoPedido']);


	Route::get('/cotizacion-orden-pedido/{idopcion}', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionCotizacionOrdenPedido']);
	Route::post('/ajax-buscar-proveedor-ruc', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxBuscarProveedorRuc']);
	Route::post('/ajax-listar-consolidado-general-aprobado', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxListarConsolidadoGeneralAprobado']);
	Route::post('/ajax-productos-consolidado-sin-cotizar', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxProductosConsolidadoSinCotizar']);
	Route::post('/ajax-deshabilitar-productos-consolidado', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxDeshabilitarProductosConsolidado']);
	Route::post('/ajax-listar-pedidos-aprobados-servicio', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxListarPedidosAprobadosServicio']);
	Route::post('/ajax-listar-detalle-consolidado-general-seleccionado', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxListarDetalleConsolidadoGeneralSeleccionado']);
	Route::post('/ajax-listar-detalle-pedidos-aprobados-seleccionados', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxListarDetallePedidosAprobadosSeleccionados']);
	Route::post('/ajax-guardar-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionGuardarCotizacion']);
	Route::post('/ajax-listar-detalle-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxListarDetalleCotizacion']);
	Route::post('/ajax-editar-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxEditarCotizacion']);
	Route::post('/ajax-subir-archivo-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxSubirArchivoCotizacion']);
	Route::post('/ajax-aprobar-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxAprobarCotizacion']);
	Route::post('/ajax-eliminar-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxEliminarCotizacion']);
	Route::post('/ajax-get-correlativo-sin-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxGetCorrelativoSinCotizacion']);
	Route::post('/ajax-obtener-correlativo-cotizacion', [\App\Http\Controllers\CotizacionOrdenPedidoController::class, 'actionAjaxObtenerCorrelativoCotizacion']);


	//COTIZACION APRUEBA GERENCIA ADM
	Route::get('/gestion-aprueba-cot-ger-administracion/{idopcion}', [\App\Http\Controllers\GestionApruebaCotGerenciaAdmController::class, 'actionGestionApruebaCotGerenciaAdm']);
	Route::post('/ajax-buscar-resumen-cotizacion', [\App\Http\Controllers\GestionApruebaCotGerenciaAdmController::class, 'actionAjaxBuscarResumenCotizacion']);

	//APROBAR OC

	Route::get('/gestion-de-aprobar-orden-compras/{idopcion}', [\App\Http\Controllers\GestionAprobarOCController::class, 'actionAporbarOc']);
	Route::post('/ajax-listar-orden-compras', [\App\Http\Controllers\GestionAprobarOCController::class, 'actionAjaxListarOrdenCompras']);
	Route::post('/ajax-cargar-detalle-orden-compra', [\App\Http\Controllers\GestionAprobarOCController::class, 'actionAjaxCargarDetalleOrdenCompra']);
	Route::post('/ajax-aprobar-orden-compra', [\App\Http\Controllers\GestionAprobarOCController::class, 'actionAjaxAprobarOrdenCompra']);
	Route::post('/ajax-rechazar-orden-compra', [\App\Http\Controllers\GestionAprobarOCController::class, 'actionAjaxRechazarOrdenCompra']);

	Route::get('/reporte-orden-pedido-estado/{idopcion}', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionReporteOrdenPedidoEstado']);
	Route::any('/cargar-periodo-orden-pedido', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionListarPeriodo']);
	Route::any('/listar-reporte-orden-pedido-estado', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionListarAjaxReporte']);
	Route::any('/descargar-orden-pedido-estado', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionListarAjaxReporteExcel']);
	Route::get(
		'/descargar-archivo-informe/{archivo}',
		[\App\Http\Controllers\ReporteOrdenPedidoController::class, 'actionDescargarArchivo']
	)->where('archivo', '.*');
	Route::post('/subir-archivo-pedido', [\App\Http\Controllers\ReporteOrdenPedidoController::class, 'subirArchivo']);
});

// Route::get('/pruebaemail/{emailfrom}/{nombreusuario}', [\App\Http\Controllers\PruebasController::class, 'actionPruebaEmail']);


Route::get('buscarcliente', function (Illuminate\Http\Request $request) {
	$term = $request->term ?: '';
	$tags = DB::table('STD.EMPRESA')
		->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
		->where('NOM_EMPR', 'like', '%' . $term . '%')
		->where('STD.EMPRESA.IND_PROVEEDOR', '=', 1)
		->where('STD.EMPRESA.COD_ESTADO', '=', 1)
		->whereNull('users.usuarioosiris_id')
		->take(100)
		->select(
			DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
		)
		->pluck('NOMBRE', 'NOMBRE');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {
		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}
	return \Response::json($valid_tags);
});


Route::get('buscarempresa', function (Illuminate\Http\Request $request) {
	$term = $request->term ?: '';
	$tags = DB::table('STD.EMPRESA')
		->where('NOM_EMPR', 'like', '%' . $term . '%')
		//->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
		->where('STD.EMPRESA.COD_ESTADO', '=', 1)
		->where('COD_TIPO_DOCUMENTO', '=', 'TDI0000000000006')
		->take(100)
		->select(
			DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
		)
		->pluck('NOMBRE', 'NOMBRE');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {
		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}
	return \Response::json($valid_tags);
});

Route::get('buscarempresalg', function (Illuminate\Http\Request $request) {
	$term = $request->term ?: '';
	$tags = DB::table('STD.EMPRESA')
		->where(
			function ($query) use ($term) {
				$query->where('STD.EMPRESA.NOM_EMPR', 'like', '%' . $term . '%')
					->orWhere('STD.EMPRESA.NRO_DOCUMENTO', 'like', '%' . $term . '%');
			}
		)
		->where('STD.EMPRESA.COD_ESTADO', '=', 1)
		->where('COD_TIPO_DOCUMENTO', '=', 'TDI0000000000006')
		->take(100)
		->select(
			DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
		)
		->pluck('NOMBRE', 'NOMBRE');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {
		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}
	return \Response::json($valid_tags);
});

Route::get('buscarempresarenta', function (Illuminate\Http\Request $request) {
	$term = $request->term ?: '';
	$tags = DB::table('STD.EMPRESA')
		->where(
			function ($query) use ($term) {
				$query->where('STD.EMPRESA.NOM_EMPR', 'like', '%' . $term . '%')
					->orWhere('STD.EMPRESA.NRO_DOCUMENTO', 'like', '%' . $term . '%');
			}
		)
		->where('COD_TIPO_DOCUMENTO', '=', 'TDI0000000000006')
		->where('STD.EMPRESA.COD_ESTADO', '=', 1)
		->where('STD.EMPRESA.NRO_DOCUMENTO', 'like', '1%')
		->take(100)
		->select(
			DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
		)
		->pluck('NOMBRE', 'NOMBRE');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {
		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}
	return \Response::json($valid_tags);
});


Route::get('buscarempresacontrato', function (Illuminate\Http\Request $request) {
	$term = $request->term ?: '';
	$tags = DB::table('STD.EMPRESA')
		->where(
			function ($query) use ($term) {
				$query->where('STD.EMPRESA.NOM_EMPR', 'like', '%' . $term . '%')
					->orWhere('STD.EMPRESA.NRO_DOCUMENTO', 'like', '%' . $term . '%');
			}
		)
		->where('STD.EMPRESA.COD_ESTADO', '=', 1)
		->take(100)
		->select(
			DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
		)
		->pluck('NOMBRE', 'NOMBRE');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {
		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}
	return \Response::json($valid_tags);
});


Route::get('buscarproducto', function (Illuminate\Http\Request $request) {
	$term = $request->term ?: '';
	$tags = DB::table('ALM.PRODUCTO')
		->where('NOM_PRODUCTO', 'like', '%' . $term . '%')
		->where('ALM.PRODUCTO.COD_ESTADO', '=', 1)
		->where('ALM.PRODUCTO.IND_DISPONIBLE', '=', 1)
		->where('ALM.PRODUCTO.IND_MATERIAL_SERVICIO', '=', 'S')
		->where('COD_CATEGORIA_CLASE', '=', '1')
		->take(100)
		->select(
			DB::raw("
			  ALM.PRODUCTO.NOM_PRODUCTO")
		)
		->pluck('NOM_PRODUCTO', 'NOM_PRODUCTO');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {
		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}
	return \Response::json($valid_tags);
});




Route::get('buscarclientey', function (Illuminate\Http\Request $request) {


	$term = $request->term ?: '';

	print_r("1");

	$tags = DB::table('STD.EMPRESA')
		->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
		->whereNull('users.usuarioosiris_id')
		->where('STD.EMPRESA.IND_PROVEEDOR', '=', 1)
		->where('STD.EMPRESA.NOM_EMPR', 'like', '%' . $term . '%')
		->where('STD.EMPRESA.COD_ESTADO', '=', 1)
		->select('STD.EMPRESA.COD_EMPR', 'STD.EMPRESA.NOM_EMPR')
		->select(
			DB::raw("
									  STD.EMPRESA.COD_EMPR,
									  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
		)
		->take(10)
		->pluck('NOMBRE', 'NOMBRE');
	$valid_tags = [];
	foreach ($tags as $id => $tag) {

		$valid_tags[] = ['id' => $id, 'text' => $tag];
	}


	return \Response::json($valid_tags);
});
	Route::post('/eliminar_matriz_viaticos', [\App\Http\Controllers\RegistroImporteRutasController::class, 'actionEliminarRegistroImporteRutas']);

Route::post('/ajax-obtener-almacenes-producto-centro', [\App\Http\Controllers\ConsolidadoOrdenPedidoController::class, 'actionAjaxObtenerAlmacenesProductoCentro']);
