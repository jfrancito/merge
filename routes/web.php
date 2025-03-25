<?php


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

/********************** USUARIOS *************************/
// header('Access-Control-Allow-Origin:  *');
// header('Access-Control-Allow-Methods:  POST, GET, OPTIONS, PUT, DELETE');
// header('Access-Control-Allow-Headers: *');

Route::group(['middleware' => ['guestaw']], function () {
	Route::any('/', 'UserController@actionLogin');
	Route::any('/login', 'UserController@actionLogin');
	Route::any('/acceso', 'UserController@actionAcceso');
	Route::any('/accesobienvenido/{idempresa}', 'UserController@actionAccesoBienvenido');
	
});

Route::get('/serve-file', 'FileController@serveFile')->name('serve-file');
Route::get('/serve-filecontrato', 'FileController@serveFileContrato')->name('serve-filecontrato');
Route::get('/serve-fileestiba', 'FileController@serveFileEstiba')->name('serve-fileestiba');


Route::get('/serve-filecontrato-sg', 'FileController@serveFileContratoSG')->name('serve-filecontrato-sg');
Route::get('/serve-filepago', 'FileController@serveFilePago')->name('serve-filepago');
Route::get('/serve-file-modelo', 'FileController@serveFileModelo')->name('serve-file-modelo');
Route::any('/registrate', 'UserController@actionRegistrate');
Route::any('/ajax-buscar-proveedor', 'UserController@actionAjaxBuscarProveedor');
Route::get('/cerrarsession', 'UserController@actionCerrarSesion');
Route::any('/enviocorreoconfirmaciones', 'UserController@actionCorreoConfirmacion');
Route::any('/activar-registro/{token}', 'UserController@actionActivarRegistro');
Route::any('/enviocorreouc', 'UserController@actionCorreoUC');//correo para usuario contacto
Route::any('/enviocorreoconta', 'UserController@actionCorreoCO');//correo para contabilidad
Route::any('/enviocorreoadmin', 'UserController@actionCorreoADM');//correo para administracion
Route::any('/enviocorreoapcli', 'UserController@actionCorreoAPCLI');//correo para cliente cuando se aprueba
Route::get('/cambiarperfil', 'UserController@actionCambiarPerfil');
Route::any('/enviocorreobaja', 'UserController@actionCorreoBaja');//correo para cliente cuando se aprueba
Route::any('/validarsunatcdr', 'GestionOCController@actionSunatCDR');//vALIDAR CDR Y SUNAT
Route::any('/manual-proveedor', 'UserController@actionManualProveedor');//vALIDAR CDR Y SUNAT
Route::any('/descargar-manual', 'UserController@actionDescargarManual');//vALIDAR CDR Y SUNAT
Route::any('/generar-token-sunat', 'UserController@actionGenerarTokenSunat');//vALIDAR CDR Y SUNAT
Route::any('/generar-token-sunat-curl', 'UserController@actionGenerarTokenSunat_cur');//vALIDAR CDR Y SUNAT
Route::any('/leerdocumentos-sunat-compras', 'CpeController@actionGestionCpeCompra');//vALIDAR CDR Y SUNAT

Route::any('/leerpreciocompetencia', 'PrecioCompetenciaController@actionScrapearPrecios');//vALIDAR CDR Y SUNAT



Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');
	Route::any('/ajax-modal-configuracion-datos-proveedor-detalle', 'UserController@actionAjaxModalConfiguracionDatosProveedor');
	Route::any('/configurar-datos-proveedor/{idusuario}', 'UserController@actionConfigurarDatosProveedor');
	Route::any('/ajax-modal-configuracion-datos-contacto-detalle', 'UserController@actionAjaxModalConfiguracionDatosContacto');
	Route::any('/configurar-datos-contacto/{idusuario}', 'UserController@actionConfigurarDatosContacto');
	Route::any('/ajax-modal-configuracion-cuenta-bancaria', 'UserController@actionAjaxModalConfiguracionCuentaBancaria');
	Route::any('/configurar-datos-cuenta-bancaria/{idusuario}', 'UserController@actionConfigurarDatosCuentaBancaria');
	Route::any('/ajax-eliminar-cb', 'UserController@actionEliminarCuentaBancaria');

	Route::any('/ajax-modal-ver-cuenta-bancaria-contrato', 'UserController@actionAjaxModalVerCuentaBancariaContrato');
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-contrato', 'UserController@actionAjaxModalConfiguracionCuentaBancariaContrato');
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-oc', 'UserController@actionAjaxModalConfiguracionCuentaBancariaOC');
	Route::any('/ajax-modal-configuracion-cuenta-bancaria-estiba', 'UserController@actionAjaxModalConfiguracionCuentaBancariaEstiba');
	Route::any('/configurar-datos-cuenta-bancaria-estiba/{empresa_id}/{orden_id}/{idopcion}', 'UserController@actionConfigurarDatosCuentaBancariaEstiba');
	Route::any('/ajax-modal-ver-cuenta-bancaria-estiba', 'UserController@actionAjaxModalVerCuentaBancariaEstiba');

	Route::any('/configurar-datos-cuenta-bancaria-contrato/{prefijo_id}/{orden_id}/{idopcion}', 'UserController@actionConfigurarDatosCuentaBancariaContrato');
	Route::any('/configurar-datos-cuenta-bancaria-oc/{prefijo_id}/{orden_id}/{idopcion}', 'UserController@actionConfigurarDatosCuentaBancariaOC');

	Route::any('/ajax-modal-ver-cuenta-bancaria-oc', 'UserController@actionAjaxModalVerCuentaBancariaOC');
	Route::any('/cambiar-cuenta-corriente/{empresa_id}/{banco_id}/{nro_cuenta}/{moneda_id}/{idoc}/{idopcion}', 'UserController@actionCambiarCuentaCorriente');


	Route::any('/gestion-de-cpe/{idopcion}', 'CpeController@actionGestionCpe');
	Route::any('/descargar-archivo/{archivonombre}', 'CpeController@actionDescargarArchivo');


	Route::any('/gestion-de-sunat-cpe-local/{idopcion}', 'CpeController@actionGestionCpeLocal');
	Route::any('/descargar-archivo-local/{tipo}', 'CpeController@descargarArchivoLocal');


	//GESTION DE USUARIOS
	Route::any('/gestion-de-usuarios/{idopcion}', 'UserController@actionListarUsuarios');
	Route::any('/agregar-usuario/{idopcion}', 'UserController@actionAgregarUsuario');
	Route::any('/modificar-usuario/{idopcion}/{idusuario}', 'UserController@actionModificarUsuario');
	Route::any('/ajax-activar-perfiles', 'UserController@actionAjaxActivarPerfiles');

	Route::any('/gestion-de-roles/{idopcion}', 'UserController@actionListarRoles');
	Route::any('/agregar-rol/{idopcion}', 'UserController@actionAgregarRol');
	Route::any('/modificar-rol/{idopcion}/{idrol}', 'UserController@actionModificarRol');

	Route::any('/gestion-de-permisos/{idopcion}', 'UserController@actionListarPermisos');
	Route::any('/ajax-listado-de-opciones', 'UserController@actionAjaxListarOpciones');
	Route::any('/ajax-activar-permisos', 'UserController@actionAjaxActivarPermisos');

	Route::any('/leerxmlsinvoice', 'GestionOCController@actionApiLeerXmlSap');
	Route::any('/leerrhsinvoice', 'GestionOCController@actionApiLeerRHSap');
	Route::any('/leerrhsinvoicereten', 'GestionOCController@actionApiLeerRetencionSap');


	Route::any('/leercdr', 'GestionOCController@actionApiLeerCDR');

	Route::any('/gestion-de-mis-documentos-contrato/{idopcion}', 'GestionDocumentoController@actionListarDOC');
	Route::any('/detalle-documentos/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionDetalleDocumentos');
	Route::any('/subir-xml-cargar-datos-documento/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionCargarXMLDocumento');
	Route::any('/validar-xml-documento/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionValidarXMLDocumento');
	Route::any('/detalle-documentos-subidos/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionDetalleDocumentoSubidos');


	Route::any('/gestion-de-mis-canjes-documentos/{idopcion}', 'GestionDocumentoCanjesController@actionListarCanjesDOC');
	Route::any('/canjear-documentos/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoCanjesController@actionCanjearDocumentos');
	Route::any('/ajax-modal-lista-documento-osiris', 'GestionDocumentoCanjesController@actionAjaxModalListaDocumentoOsiris');
	Route::any('/ajax-modal-agregar-documento-osiris', 'GestionDocumentoCanjesController@actionAjaxModalAgregarDocumentoOsiris');

	Route::any('/ajax-modal-lista-documento-merge', 'GestionDocumentoCanjesController@actionAjaxModalListaDocumentoMerge');
	Route::any('/ajax-modal-agregar-documento-merge', 'GestionDocumentoCanjesController@actionAjaxModalAgregarDocumentoMerge');


	Route::any('/comprobante-masivo-excel/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{idopcion}', 'ReporteComprobanteController@actionComprobanteMasivoExcel');
	Route::any('/comprobante-masivo-tesoreria-excel/{fecha_inicio}/{fecha_fin}/{proveedor_id}/{estado_id}/{operacion_id}/{idopcion}', 'ReporteComprobanteController@actionComprobanteMasivoTesoreriaExcel');

	// Route::any('/subir-xml-cargar-datos-documento/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionCargarXMLDocumento');
	// Route::any('/validar-xml-documento/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionValidarXMLDocumento');
	// Route::any('/detalle-documentos-subidos/{idopcion}/{prefijo}/{idordencompra}', 'GestionDocumentoController@actionDetalleDocumentoSubidos');


	Route::any('/gestion-de-oc-proveedores/{idopcion}', 'GestionOCController@actionListarOC');
	Route::any('/gestion-de-orden-compra/{idopcion}', 'GestionOCController@actionListarOCAdmin');
	Route::any('/detalle-comprobante-oc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionDetalleComprobanteOC');
	Route::any('/subir-xml-cargar-datos/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionCargarXML');
	Route::any('/validar-xml-oc/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionValidarXML');

	Route::any('/ajax-buscar-documento-gestion-admin', 'GestionOCController@actionListarAjaxBuscarDocumentoAdmin');
	Route::any('/migracion-rioja/{idopcion}', 'GestionOCController@actionListarOCAdminMR');
	Route::any('/migracion-bellavista/{idopcion}', 'GestionOCController@actionListarOCAdminMB');

	Route::any('/ajax-estiba-proveedor-estiba', 'GestionOCController@actionEstibaProveedorEstiba');




	//PROVEEDOR CONTRATO
	Route::any('/gestion-de-transporte-carga/{idopcion}', 'GestionTCController@actionListarOC');
	Route::any('/detalle-comprobante-contrato-proveedor/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionTCController@actionDetalleComprobanteOCProveedor');
	Route::any('/subir-xml-cargar-datos-contrato-proveedor/{idopcion}/{prefijo}/{idordencompra}', 'GestionTCController@actionCargarXMLProveedor');
	Route::any('/validar-xml-contrato-proveedor/{idopcion}/{prefijo}/{idordencompra}', 'GestionTCController@actionValidarXMLProveedor');
	Route::any('/descargar-comprobante-contrato-proveedor/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionTCController@actionDescargarComprobanteOCProveedor');


	Route::any('/gestion-de-filtro-comprobante/{idopcion}', 'GestionOCController@actionListarOCFiltro');
	Route::any('/ajax-filtro-guardar', 'GestionOCController@actionGuardarOCFiltro');


	//PROVEEDOR
	Route::any('/detalle-comprobante-oc-proveedor/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionDetalleComprobanteOCProveedor');
	Route::any('/subir-xml-cargar-datos-proveedor/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionCargarXMLProveedor');
	Route::any('/validar-xml-oc-proveedor/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionValidarXMLProveedor');


	//ADMINISTRATOR
	Route::any('/detalle-comprobante-oc-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionDetalleComprobanteOCAdministrator');
	Route::any('/subir-xml-cargar-datos-administrator/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionCargarXMLAdministrator');
	Route::any('/validar-xml-oc-administrator/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionValidarXMLAdministrator');
	Route::any('/validar-xml-oc-administrator-sx/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCSXController@actionValidarXMLAdministratorSX');


	Route::any('/agregar-archivo-uc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionAgregarArchivoUC');
	Route::any('/quitar-archivo-uc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionQuitarArchivoUC');

	Route::any('/detalle-comprobante-oc-administrator-sin-xml/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCSXController@actionDetalleComprobanteOCAdministratorSinXML');
	Route::any('/agregar-archivo-uc-contrato/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionAgregarArchivoUCContrato');


	Route::any('/ajax-cuenta-bancaria-proveedor-contrato', 'GestionOCController@actionAjaxBuscarCuentaBancariaContrato');
	Route::any('/ajax-cuenta-bancaria-proveedor-oc', 'GestionOCController@actionAjaxBuscarCuentaBancariaOC');
	Route::any('/ajax-cuenta-bancaria-proveedor-estiba', 'GestionOCController@actionAjaxBuscarCuentaBancariaEstiba');

	//ADMINISTRATOR CONTRATO
	Route::any('/detalle-comprobante-contrato-administrator/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionDetalleComprobantecontratoAdministrator');
	Route::any('/subir-xml-cargar-datos-contrato-administrator/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionCargarXMLContratoAdministrator');
	Route::any('/validar-xml-oc-contrato-administrator/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionValidarXMLContratoAdministrator');


	//ADMINISTRATOR ESTIBA
	Route::any('/select-xml-estiba/{idopcion}', 'GestionEstibaController@actionDetalleSelectEstiba');
	Route::any('/detalle-comprobante-estiba-administrator/{idopcion}/{lote}', 'GestionEstibaController@actionDetalleComprobanteestibaAdministrator');
	Route::any('/subir-xml-cargar-datos-estiba-administrator/{idopcion}/{lote}', 'GestionEstibaController@actionCargarXMLEstibaAdministrator');
	Route::any('/validar-xml-oc-estiba-administrator/{idopcion}/{lote}', 'GestionEstibaController@actionValidarXMLEstibaAdministrator');
	Route::any('/ajax-modal-detalle-lotes', 'GestionEstibaController@actionCargarModalDetalleLotes');
	Route::any('/ajax-eliminar-lote-estiba', 'GestionEstibaController@actionEliminacionLoteEstiba');
	Route::any('/ajax-modal-detalle-estibas', 'GestionEstibaController@actionCargarModalDetalleEstibas');

	Route::any('/agregar-suspension/{idopcion}/{lote}', 'GestionEstibaController@actionAgregarSuspensionEstibas');


	Route::any('/gestion-de-oc-validado-proveedores/{idopcion}', 'GestionOCValidadoController@actionListarOCValidado');
	Route::any('/detalle-comprobante-oc-validado/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDetalleComprobanteOCValidado');
	Route::any('/gestion-de-historial-comprobantes/{idopcion}', 'GestionOCValidadoController@actionListarOCHistorial');
	Route::any('/ajax-buscar-documento-fe', 'GestionOCValidadoController@actionListarAjaxBuscarDocumento');
	Route::any('/ajax-buscar-documento-fe-historial', 'GestionOCValidadoController@actionListarAjaxBuscarDocumentoHistorial');

	//PLANILLA MOVILIDAD
	Route::any('/gestion-de-planilla-movilidad/{idopcion}', 'GestionPlanillaMovilidadController@actionListarPlanillaMovilidad');
	Route::any('/agregar-planilla-movilidad/{idopcion}', 'GestionPlanillaMovilidadController@actionAgregarPlanillaMovilidad');
	Route::any('/modificar-planilla-movilidad/{idopcion}/{iddocumento}', 'GestionPlanillaMovilidadController@actionModificarPlanillaMovilidad');
	Route::any('/ajax-modal-detalle-planilla-movilidad', 'GestionPlanillaMovilidadController@actionDetallePlanillaMovilidad');
	Route::any('/guardar-detalle-planilla-movilidad/{idopcion}/{iddocumento}', 'GestionPlanillaMovilidadController@actionGuardarDetallePlanillaMovilidad');
	Route::any('/ajax-modal-modificar-detalle-planilla-movilidad', 'GestionPlanillaMovilidadController@actionModificarDetallePlanillaMovilidad');
	Route::any('/modificar-detalle-planilla-movilidad/{idopcion}/{iddocumento}/{item}', 'GestionPlanillaMovilidadController@actionGuardarModificarDetallePlanillaMovilidad');


	Route::any('/detalle-comprobante-oc-validado-historial/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDetalleComprobanteOCValidadoHitorial');
	Route::any('/detalle-comprobante-oc-validado-contrato-historial/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDetalleComprobanteOCValidadoContratoHistorial');
	//ENTREGA DE DOCUMENTOS
	Route::any('/gestion-de-entrega-documentos/{idopcion}', 'GestionEntregaDocumentoController@actionListarEntregaDocumento');
	Route::any('/ajax-buscar-documento-fe-entregable', 'GestionEntregaDocumentoController@actionListarAjaxBuscarDocumentoEntregable');
	Route::any('/ajax-modal-masivo-entregable', 'GestionEntregaDocumentoController@actionListarAjaxModalMasivoEntregable');
	Route::any('/ajax-guardar-masivo-entregable', 'GestionEntregaDocumentoController@actionGuardarMavisoEntregable');
	Route::any('/ajax-buscar-documento-fe-entregable-folio', 'GestionEntregaDocumentoController@actionListarAjaxBuscarDocumentoEntregableFolio');
	Route::any('/gestion-de-entrega-folios/{idopcion}', 'GestionEntregaDocumentoController@actionListarEntregaDocumentoFolio');
	Route::any('/ajax-modal-detalle-entregable', 'GestionEntregaDocumentoController@actionModalEntregaDocumentoFolio');
	Route::any('/descargar-folio-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarDocumentoFolio');
	Route::any('/ajax-modal-detalle-deuda-contrato', 'GestionEntregaDocumentoController@actionModaDetalleDeudaContrato');
	Route::any('/entrega-masivo-excel/{operacion_id}/{idopcion}', 'GestionEntregaDocumentoController@actionEntregableMasivoExcel');
	Route::any('/ajax-crear-folio-pagos', 'GestionEntregaDocumentoController@actionEntregableCrearFolio');
	Route::any('/ajax-modal-detalle-folios', 'GestionEntregaDocumentoController@actionEntregableModalDetalleFolio');
	Route::any('/ajax-detalle-documento-pagos', 'GestionEntregaDocumentoController@actionModalDetalleDocumentoPagos');
	Route::any('/crear-folio-entregable/{idopcion}', 'GestionEntregaDocumentoController@actionEntregableCrearFolioEntregable');
	Route::any('/ajax-select-folio-pagos', 'GestionEntregaDocumentoController@actionEntregableSelectFolioPago');
	Route::any('/ajax-extornar-folio-pagos', 'GestionEntregaDocumentoController@actionEntregableExtornoFolioPago');
	Route::any('/ajax-detalle-folio-pagos', 'GestionEntregaDocumentoController@actionEntregableDetalleFolioPago');
	Route::any('/validar-retencion-folio-pagos', 'GestionEntregaDocumentoController@actionValidarDetalleFolioPago');
	Route::any('/guardar-folio-entregable/{idopcion}', 'GestionEntregaDocumentoController@actionEntregableGuardarFolioEntregable');
	Route::any('/descargar-pago-proveedor-bcp-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoFolioBcp');
	Route::any('/descargar-pago-proveedor-bcp-estiba-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoFolioEstibaBcp');


	Route::any('/descargar-pago-proveedor-macro-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoFolioMacro');
	Route::any('/descargar-pago-proveedor-macro-bbva-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacroBbva');
	Route::any('/descargar-pago-proveedor-macro-sbk-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacroSBK');
	Route::any('/descargar-pago-proveedor-macro-interbank-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacrosInterbank');


	Route::any('/descargar-pago-proveedor-macro-excel-oc/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoFolioMacroOC');
	Route::any('/descargar-pago-proveedor-macro-bbva-excel-oc/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacroBbvaOC');
	Route::any('/descargar-pago-proveedor-macro-sbk-excel-oc/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacroSBKOC');
	Route::any('/descargar-pago-proveedor-macro-interbank-excel-oc/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacrosInterbankOC');


	Route::any('/descargar-pago-proveedor-macro-estiba-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoFolioMacroEstiba');
	Route::any('/descargar-pago-proveedor-macro-bbva-estiba-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacroEstibaBbva');
	Route::any('/descargar-pago-proveedor-macro-sbk-estiba-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacroEstibaSBK');
	Route::any('/descargar-pago-proveedor-macro-interbank-estiba-excel/{folio}', 'GestionEntregaDocumentoController@actionDescargarPagoMacrosEstibaInterbank');




	Route::any('/ajax-modal-historial-extorno', 'GestionOCController@actionModalHistorialExtorno');
	Route::any('/detalle-comprobante-oc-validado-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDetalleComprobanteOCValidadoContrato');
	Route::any('/gestion-de-comprobante-us/{idopcion}', 'GestionUsuarioContactoController@actionListarComprobanteUsuarioContacto');
	Route::any('/pre-aprobar-documentos/{idopcion}', 'GestionUsuarioContactoController@actionListarPreAprobarUsuarioContacto');
	Route::any('/extornar-pre-aprobar-comprobante/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionExtornarPreAprobar');

	Route::any('/aprobar-comprobante-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionAprobarUC');
	Route::any('/aprobar-comprobante-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionAprobarUCContrato');

	Route::any('/detalle-comprobante-oc-validado-estiba/{idopcion}/{lote}', 'GestionOCValidadoController@actionDetalleComprobanteOCValidadoEstiba');

	Route::any('/gestion-de-comprobantes-observados/{idopcion}', 'GestionUsuarioContactoController@actionListarComprobantesObservados');
	Route::any('/gestion-de-comprobantes-reparable/{idopcion}', 'GestionUsuarioContactoController@actionListarComprobantesReparable');

	Route::any('/ajax-buscar-documento-gestion-observados', 'GestionUsuarioContactoController@actionListarAjaxBuscarDocumentoObservados');
	Route::any('/ajax-buscar-documento-gestion-reparable', 'GestionUsuarioContactoController@actionListarAjaxBuscarDocumentoReparable');


	Route::any('/gestion-observados-contrato-provedores/{idopcion}', 'GestionUsuarioContactoController@actionListarComprobantesObservadosProveedores');
	Route::any('/gestion-observados-oc-provedores/{idopcion}', 'GestionUsuarioContactoController@actionListarComprobantesObservadosOCProveedores');

	Route::any('/observacion-comprobante-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionObservarUC');
	Route::any('/observacion-comprobante-uc-proveedor/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionObservarUCProvedor');

	Route::any('/reparable-comprobante-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionReparableUC');
	Route::any('/reparable-comprobante-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionReparableUCContrato');
	Route::any('/reparable-comprobante-uc-estiba/{idopcion}/{lote}', 'GestionUsuarioContactoController@actionReparableUCEstiba');


	Route::any('/observacion-comprobante-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionObservarUCContrato');
	Route::any('/observacion-comprobante-uc-contrato-proveedor/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionObservarUCContratoProveedor');


	Route::any('/observacion-comprobante-uc-estiba/{idopcion}/{lote}', 'GestionUsuarioContactoController@actionObservarUCEstiba');


	Route::any('/gestion-de-contabilidad-aprobar/{idopcion}', 'GestionOCContabilidadController@actionListarComprobanteContabilidad');
	Route::any('/aprobar-documentos/{idopcion}', 'GestionOCContabilidadController@actionListarAprobarUsuarioContacto');
	Route::any('/extornar-aprobar-comprobante/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionExtornarAprobar');

	
	Route::any('/aprobar-comprobante-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAprobarContabilidad');
	Route::any('/aprobar-comprobante-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAprobarContabilidadContrato');
	Route::any('/aprobar-comprobante-contabilidad-estiba/{idopcion}/{lote}', 'GestionOCContabilidadController@actionAprobarContabilidadEstiba');



	Route::any('/aprobar-comprobante-contabilidad-reparable/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAprobarContabilidadReparable');
	//Route::any('/aprobar-comprobante-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAprobarContabilidadContrato');

	Route::any('/agregar-observacion-contabilidad-reparable/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarObservacionContabilidadReparable');
	//Route::any('/agregar-observacion-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarObservacionContabilidadContrato');


	Route::any('/agregar-observacion-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarObservacionContabilidad');
	Route::any('/agregar-observacion-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarObservacionContabilidadContrato');
	Route::any('/agregar-observacion-contabilidad-estiba/{idopcion}/{lote}', 'GestionOCContabilidadController@actionAgregarObservacionContabilidadEstiba');


	Route::any('/agregar-reparable-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarReparableContabilidad');
	Route::any('/agregar-reparable-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarReparableContabilidadContrato');
	Route::any('/agregar-reparable-contabilidad-estiba/{idopcion}/{lote}', 'GestionOCContabilidadController@actionAgregarReparableContabilidadEstiba');





	Route::any('/agregar-extorno-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarExtornoContabilidad');
	Route::any('/agregar-extorno-contrato-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarExtornoContratoContabilidad');
	Route::any('/agregar-extorno-estiba-contabilidad/{idopcion}/{lote}', 'GestionOCContabilidadController@actionAgregarExtornoEstibaContabilidad');





	Route::any('/agregar-recomendacion-contabilidad/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarRecomendacionContabilidad');
	Route::any('/agregar-recomendacion-contabilidad-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAgregarRecomendacionContabilidadContrato');
	

	Route::any('/aprobar-comprobante-administracion/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAprobarAdministracion');
	Route::any('/agregar-observacion-administracion/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAgregarObservacionAdministracion');
	Route::any('/agregar-observacion-uc/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionAgregarObservacionUC');
	Route::any('/ajax-detalle-documento', 'GestionOCAdministracionController@actionModalDetalleDocumento');


	Route::any('/aprobar-comprobante-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAprobarAdministracionContrato');
	Route::any('/agregar-observacion-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAgregarObservacionAdministracionContrato');
	Route::any('/agregar-observacion-uc-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionAgregarObservacionUCContrato');


	Route::any('/ajax-buscar-documento-gestion-contabilidad', 'GestionOCContabilidadController@actionListarAjaxBuscarDocumentoContabilidad');
	Route::any('/gestion-de-administracion-aprobar/{idopcion}', 'GestionOCAdministracionController@actionListarComprobanteAdministracion');
	Route::any('/aprobar-documentos-administracion/{idopcion}', 'GestionOCAdministracionController@actionListarAprobarAdministracion');
	Route::any('/extornar-aprobar-comprobante-administrador/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionExtornarAprobar');
	Route::any('/agregar-recomendacion-administracion/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAgregarRecomendacionAdministracion');
	Route::any('/agregar-recomendacion-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAgregarRecomendacionAdministracionContrato');
	Route::any('/modificar-pdf-guias/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionModificarContratos');

	Route::any('/aprobar-comprobante-administracion-estiba/{idopcion}/{lote}', 'GestionOCAdministracionController@actionAprobarAdministracionEstiba');
	Route::any('/agregar-observacion-administracion-estiba/{idopcion}/{lote}', 'GestionOCAdministracionController@actionAgregarObservacionAdministracionEstiba');


	Route::any('/ajax-buscar-documento-gestion-administracion', 'GestionOCAdministracionController@actionListarAjaxBuscarDocumentoAdministracion');
	Route::any('/aprobar-comprobante-administracion-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAprobarAdministracionContrato');
	Route::any('/gestion-de-tesoreria-aprobar/{idopcion}', 'GestionOCTesoreriaController@actionListarComprobanteTesoreria');
	Route::any('/pago-comprobante-tesoreria/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCTesoreriaController@actionAprobarTesoreria');
	Route::any('/ajax-buscar-documento-gestion-tesoreria', 'GestionOCTesoreriaController@actionListarAjaxBuscarDocumentoTesoreria');
	Route::any('/ajax-modal-tesoreria-pago', 'GestionOCTesoreriaController@actionListarAjaxModalTesoreriaPago');
	Route::any('/ajax-modal-tesoreria-pago-masivo', 'GestionOCTesoreriaController@actionListarAjaxModalTesoreriaPagoMasivo');
	Route::any('/pago-comprobante-tesoreria-masivo/{idopcion}', 'GestionOCTesoreriaController@actionAprobarTesoreriaMasivo');
	Route::any('/ajax-modal-tesoreria-pago-contrato', 'GestionOCTesoreriaController@actionListarAjaxModalTesoreriaPagoContrato');
	Route::any('/pago-comprobante-tesoreria-contrato/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCTesoreriaController@actionAprobarTesoreriaContrato');


	Route::any('/gestion-de-comprobante-pago-tesoreria/{idopcion}', 'GestionOCTesoreriaController@actionListarComprobanteTesoreriaPago');
	Route::any('/ajax-buscar-documento-gestion-tesoreria-pagado', 'GestionOCTesoreriaController@actionListarAjaxBuscarDocumentoTesoreriaPago');
	Route::any('/ajax-modal-tesoreria-pago-pagado', 'GestionOCTesoreriaController@actionListarAjaxModalTesoreriaPagoPagado');
	Route::any('/pago-comprobante-tesoreria-pagado/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCTesoreriaController@actionAprobarTesoreriaPagado');
	Route::any('/extornar-pago-item/{idordencompra}/{idopcion}', 'GestionOCTesoreriaController@actionExtornoTesoreriaPagado');


	Route::any('/gestion-de-provision-comprobante/{idopcion}', 'GestionOCProvisionController@actionListarComprobanteProvision');
	Route::any('/provisionar-documentos/{idopcion}', 'GestionOCProvisionController@actionListarProvisionarComprobante');
	Route::any('/descargar-archivo-requerimiento-xml/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarXML');
	Route::any('/descargar-archivo-requerimiento-cdr/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarCDR');
	Route::any('/descargar-archivo-requerimiento-pdf/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarPDF');
	Route::any('/descargar-archivo-requerimiento/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargar');
	Route::any('/descargar-archivo-requerimiento-contrato/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarContrato');
	Route::any('/descargar-archivo-requerimiento-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarAnulado');
	Route::any('/descargar-archivo-requerimiento-contrato-anulado/{tipo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarContratoAnulado');
	Route::any('/eliminar-archivo-item/{tipo}/{nombrearchivo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionEliminarItem');
	Route::any('/eliminar-archivo-item-contrato/{tipo}/{nombrearchivo}/{idopcion}/{linea}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionEliminarItemContrato');

	Route::any('/descargar-archivo-requerimiento-estiba/{tipo}/{idopcion}/{lote}', 'GestionOCValidadoController@actionDescargarEstiba');


	Route::any('/gestion-de-modelos-comprobantes/{idopcion}', 'GestionOCValidadoController@actionModelosComprobantes');


});

Route::get('/pruebaemail/{emailfrom}/{nombreusuario}', 'PruebasController@actionPruebaEmail');


Route::get('buscarcliente', function (Illuminate\Http\Request  $request) {
    $term = $request->term ?: '';
    $tags = DB::table('STD.EMPRESA')
    		->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
    		->where('NOM_EMPR', 'like', '%'.$term.'%')
			->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
			->where('STD.EMPRESA.COD_ESTADO','=',1)
			->whereNull('users.usuarioosiris_id')
			->take(100)
			->select(DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
			)
    		->pluck('NOMBRE', 'NOMBRE');
    $valid_tags = [];
    foreach ($tags as $id => $tag) {
        $valid_tags[] = ['id' => $id, 'text' => $tag];
    }
    return \Response::json($valid_tags);
});


Route::get('buscarempresa', function (Illuminate\Http\Request  $request) {
    $term = $request->term ?: '';
    $tags = DB::table('STD.EMPRESA')
    		->where('NOM_EMPR', 'like', '%'.$term.'%')
			//->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
			->where('STD.EMPRESA.COD_ESTADO','=',1)
			->take(100)
			->select(DB::raw("
			  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
			)
    		->pluck('NOMBRE', 'NOMBRE');
    $valid_tags = [];
    foreach ($tags as $id => $tag) {
        $valid_tags[] = ['id' => $id, 'text' => $tag];
    }
    return \Response::json($valid_tags);
});






Route::get('buscarclientey', function (Illuminate\Http\Request  $request) {


    $term = $request->term ?: '';

	print_r("1");

	$tags 				= 	DB::table('STD.EMPRESA')
									->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
									->whereNull('users.usuarioosiris_id')
									->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
									->where('STD.EMPRESA.NOM_EMPR', 'like', '%'.$term.'%')
									->where('STD.EMPRESA.COD_ESTADO','=',1)
									->select('STD.EMPRESA.COD_EMPR','STD.EMPRESA.NOM_EMPR')
									->select(DB::raw("
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



