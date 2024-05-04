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


Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');
	Route::any('/ajax-modal-configuracion-datos-proveedor-detalle', 'UserController@actionAjaxModalConfiguracionDatosProveedor');
	Route::any('/configurar-datos-proveedor/{idusuario}', 'UserController@actionConfigurarDatosProveedor');
	Route::any('/ajax-modal-configuracion-datos-contacto-detalle', 'UserController@actionAjaxModalConfiguracionDatosContacto');
	Route::any('/configurar-datos-contacto/{idusuario}', 'UserController@actionConfigurarDatosContacto');
	Route::any('/ajax-modal-configuracion-cuenta-bancaria', 'UserController@actionAjaxModalConfiguracionCuentaBancaria');
	Route::any('/configurar-datos-cuenta-bancaria/{idusuario}', 'UserController@actionConfigurarDatosCuentaBancaria');
	Route::any('/ajax-eliminar-cb', 'UserController@actionEliminarCuentaBancaria');


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

	Route::any('/gestion-de-oc-proveedores/{idopcion}', 'GestionOCController@actionListarOC');
	Route::any('/gestion-de-orden-compra/{idopcion}', 'GestionOCController@actionListarOCAdmin');

	Route::any('/detalle-comprobante-oc/{procedencia}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionDetalleComprobanteOC');
	Route::any('/subir-xml-cargar-datos/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionCargarXML');
	Route::any('/validar-xml-oc/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCController@actionValidarXML');


	Route::any('/gestion-de-oc-validado-proveedores/{idopcion}', 'GestionOCValidadoController@actionListarOCValidado');
	Route::any('/detalle-comprobante-oc-validado/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDetalleComprobanteOCValidado');
	Route::any('/gestion-de-historial-comprobantes/{idopcion}', 'GestionOCValidadoController@actionListarOCHistorial');




	Route::any('/gestion-de-comprobante-us/{idopcion}', 'GestionUsuarioContactoController@actionListarComprobanteUsuarioContacto');
	Route::any('/pre-aprobar-documentos/{idopcion}', 'GestionUsuarioContactoController@actionListarPreAprobarUsuarioContacto');
	Route::any('/extornar-pre-aprobar-comprobante/{idopcion}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionExtornarPreAprobar');
	Route::any('/aprobar-comprobante-uc/{idopcion}/{prefijo}/{idordencompra}', 'GestionUsuarioContactoController@actionAprobarUC');


	Route::any('/gestion-de-contabilidad-aprobar/{idopcion}', 'GestionOCContabilidadController@actionListarComprobanteContabilidad');
	Route::any('/aprobar-documentos/{idopcion}', 'GestionOCContabilidadController@actionListarAprobarUsuarioContacto');
	Route::any('/extornar-aprobar-comprobante/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionExtornarAprobar');
	Route::any('/aprobar-comprobante-contabilidad/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCContabilidadController@actionAprobarContabilidad');



	Route::any('/gestion-de-administracion-aprobar/{idopcion}', 'GestionOCAdministracionController@actionListarComprobanteAdministracion');
	Route::any('/aprobar-documentos-administracion/{idopcion}', 'GestionOCAdministracionController@actionListarAprobarAdministracion');
	Route::any('/extornar-aprobar-comprobante-administrador/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionExtornarAprobar');
	Route::any('/aprobar-comprobante-administracion/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCAdministracionController@actionAprobarAdministracion');



	Route::any('/gestion-de-provision-comprobante/{idopcion}', 'GestionOCProvisionController@actionListarComprobanteProvision');
	Route::any('/provisionar-documentos/{idopcion}', 'GestionOCProvisionController@actionListarProvisionarComprobante');



	Route::any('/descargar-archivo-requerimiento-xml/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarXML');
	Route::any('/descargar-archivo-requerimiento-cdr/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarCDR');
	Route::any('/descargar-archivo-requerimiento-pdf/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargarPDF');
	Route::any('/descargar-archivo-requerimiento/{tipo}/{idopcion}/{prefijo}/{idordencompra}', 'GestionOCValidadoController@actionDescargar');




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



