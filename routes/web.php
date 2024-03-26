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

});

Route::get('/cerrarsession', 'UserController@actionCerrarSesion');

Route::group(['middleware' => ['authaw']], function () {

	Route::get('/bienvenido', 'UserController@actionBienvenido');
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



});

Route::get('/pruebaemail/{emailfrom}/{nombreusuario}', 'PruebasController@actionPruebaEmail');
