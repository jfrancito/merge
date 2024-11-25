<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Response;

use App\Modelos\WEBGrupoopcion;
use App\Modelos\WEBOpcion;
use App\Modelos\WEBRol;
use App\Modelos\WEBRolOpcion;
use App\Modelos\STDEmpresaDireccion;
use App\Modelos\TESCuentaBancaria;
use App\Modelos\CMPCategoria;
use App\Modelos\STDEmpresa;
use App\Modelos\WEBUserEmpresaCentro;
use App\User;


use App\Modelos\VMergeOC;
use App\Modelos\FeFormaPago;
use App\Modelos\FeDetalleDocumento;
use App\Modelos\FeDocumento;
use App\Modelos\Estado;
use App\Modelos\CMPOrden;


use App\Modelos\FeDocumentoHistorial;
use App\Modelos\SGDUsuario;

use App\Modelos\STDTrabajador;
use App\Modelos\Archivo;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\CMPDetalleProducto;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Session;
use View;
use Stdclass;
use App\Traits\UserTraits;
use App\Traits\GeneralesTraits;
use App\Traits\ComprobanteProvisionTraits;
use App\Traits\ComprobanteTraits;


class UserController extends Controller {

    use UserTraits;
    use GeneralesTraits;
    use ComprobanteProvisionTraits;
    use ComprobanteTraits;


	public function actionDescargarManual(Request $request)
	{
	    $filePath = public_path('manual-proveedor.pdf');
	    return Response::download($filePath);
	}
	public function actionManualProveedor() {
		return View::make('revistadigital/revistadigital');
	}


	public function actionAjaxModalConfiguracionCuentaBancariaContrato(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idopcion               =   $request['idopcion'];

        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($orden_id,$prefijo_id);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);


		$usuario    			=   User::where('id','=',Session::get('usuario')->id)->first();
		$combo_banco 			= 	$this->gn_generacion_combo_categoria('BANCOS_MERGE','Seleccione banco','');
		$defecto_banco			= 	'';
		$combo_tipocuenta 		= 	$this->gn_generacion_combo_categoria('CUENTA_MERGE','Seleccione tipo cuenta','');
		$defecto_tipocuenta		= 	'';
		$combo_moneda 			= 	$this->gn_generacion_combo_categoria('MONEDA_MERGE','Seleccione moneda','');
		$defecto_moneda			= 	'';

		return View::make('usuario/modal/ajax/mdatoscuentabancariacontrato',
						 [		 	
						 	'usuario' 						=> $usuario,
						 	'idoc' 							=> $idoc,
						 	'prefijo_id' 					=> $prefijo_id,
						 	'orden_id' 						=> $orden_id,
						 	'idopcion' 						=> $idopcion,


						 	'combo_banco' 					=> $combo_banco,
						 	'defecto_banco' 				=> $defecto_banco,
						 	'combo_tipocuenta' 				=> $combo_tipocuenta,
						 	'defecto_tipocuenta' 			=> $defecto_tipocuenta,
						 	'combo_moneda' 					=> $combo_moneda,
						 	'defecto_moneda' 				=> $defecto_moneda,						 	
						 	'ajax' 							=> true,						 	
						 ]);
	}

	public function actionAjaxModalConfiguracionCuentaBancariaOC(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idopcion               =   $request['idopcion'];

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);


		$usuario    			=   User::where('id','=',Session::get('usuario')->id)->first();
		$combo_banco 			= 	$this->gn_generacion_combo_categoria('BANCOS_MERGE','Seleccione banco','');
		$defecto_banco			= 	'';
		$combo_tipocuenta 		= 	$this->gn_generacion_combo_categoria('CUENTA_MERGE','Seleccione tipo cuenta','');
		$defecto_tipocuenta		= 	'';
		$combo_moneda 			= 	$this->gn_generacion_combo_categoria('MONEDA_MERGE','Seleccione moneda','');
		$defecto_moneda			= 	'';

		return View::make('usuario/modal/ajax/mdatoscuentabancariaoc',
						 [		 	
						 	'usuario' 						=> $usuario,
						 	'idoc' 							=> $idoc,
						 	'prefijo_id' 					=> $prefijo_id,
						 	'orden_id' 						=> $orden_id,
						 	'idopcion' 						=> $idopcion,


						 	'combo_banco' 					=> $combo_banco,
						 	'defecto_banco' 				=> $defecto_banco,
						 	'combo_tipocuenta' 				=> $combo_tipocuenta,
						 	'defecto_tipocuenta' 			=> $defecto_tipocuenta,
						 	'combo_moneda' 					=> $combo_moneda,
						 	'defecto_moneda' 				=> $defecto_moneda,						 	
						 	'ajax' 							=> true,						 	
						 ]);
	}



	public function actionAjaxModalVerCuentaBancariaOC(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);
        $ordencompra          	=   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc($idoc);

		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_CLIENTE)
									->where('COD_ESTADO','=',1)
									->orderby('TXT_EMPR_BANCO','ASC')
								  	->get();

		return View::make('usuario/modal/ajax/mvercuentabancaria',
						 [		 	

						 	'cuentabancarias' 				=> $cuentabancarias,					 	
						 	'ajax' 							=> true,						 	
						 ]);
	}


	public function actionAjaxModalVerCuentaBancariaContrato(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($orden_id,$prefijo_id);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_EMISOR)
									->where('COD_ESTADO','=',1)
									->orderby('TXT_EMPR_BANCO','ASC')
								  	->get();

		return View::make('usuario/modal/ajax/mvercuentabancaria',
						 [		 	

						 	'cuentabancarias' 				=> $cuentabancarias,					 	
						 	'ajax' 							=> true,						 	
						 ]);
	}

	public function actionConfigurarDatosCuentaBancariaContrato($prefijo_id,$orden_id,$idopcion,Request $request)
	{


        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($orden_id,$prefijo_id);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_contrato_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_contrato_comprobante_idoc($idoc);

		$banco_id 	 		 	 					= 	$request['banco_id'];
		$tipocuenta_id 	 		 					= 	$request['tipocuenta_id'];
		$moneda_id 	 		 						= 	$request['moneda_id'];
		$numerocuenta 	 		 					= 	$request['numerocuenta'];
		$numerocuentacci 	 		 				= 	$request['numerocuentacci'];
		$banco 										=	CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
		$tipocuenta 								=	CMPCategoria::where('COD_CATEGORIA','=',$tipocuenta_id)->first();
		$moneda 									=	CMPCategoria::where('COD_CATEGORIA','=',$moneda_id)->first();
		$empresa 									=	STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_EMISOR)->first();

		$tescuentabb    							=   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
														->where('COD_EMPR_BANCO','=',$banco->COD_CATEGORIA)
														->where('COD_CATEGORIA_MONEDA','=',$moneda->COD_CATEGORIA)
														->where('TXT_TIPO_REFERENCIA','=',$tipocuenta->COD_CATEGORIA)
														->where('TXT_NRO_CUENTA_BANCARIA','=',$numerocuenta)
														->where('COD_ESTADO','=',1)
														->first();

		if(count($tescuentabb) > 0){
				return Redirect::back()->withInput()->with('errorurl', 'La cuenta ya se cuenta registrado');
		}


		$cuentabancaria 							=	New TESCuentaBancaria();
		$cuentabancaria->COD_EMPR_TITULAR 			=   $empresa->COD_EMPR;
		$cuentabancaria->COD_EMPR_BANCO 			=   $banco->COD_CATEGORIA;
		$cuentabancaria->TXT_NRO_CUENTA_BANCARIA	=   $numerocuenta;
		$cuentabancaria->TXT_EMPR_TITULAR 			=   $empresa->NOM_EMPR;
		$cuentabancaria->TXT_EMPR_BANCO 			=   $banco->NOM_CATEGORIA;
		$cuentabancaria->COD_CATEGORIA_MONEDA 		=   $moneda->COD_CATEGORIA;
		$cuentabancaria->TXT_CATEGORIA_MONEDA 		=   $moneda->NOM_CATEGORIA;
		$cuentabancaria->TXT_NRO_CCI 				=   $numerocuentacci;
		$cuentabancaria->TXT_GLOSA 					=   '';
		$cuentabancaria->TXT_TIPO_REFERENCIA 		=   $tipocuenta->COD_CATEGORIA;
		$cuentabancaria->TXT_REFERENCIA 			=   $tipocuenta->NOM_CATEGORIA;
		$cuentabancaria->COD_USUARIO_CREA_AUD 		=   Session::get('usuario')->id;
		$cuentabancaria->FEC_USUARIO_CREA_AUD 		=   $this->fechaactual;
		$cuentabancaria->COD_ESTADO 				=   1;
		$cuentabancaria->COD_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->TXT_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->save();

		return Redirect::back()->withInput()->with('bienhecho', 'Cuenta Bancaria '.$numerocuenta.' registrada con éxito');


	}

	public function actionConfigurarDatosCuentaBancariaOC($prefijo_id,$orden_id,$idopcion,Request $request)
	{


        $idoc                   					=   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);

            $ordencompra          =   CMPOrden::where('COD_ORDEN','=',$idoc)->first();
        $detalleordencompra     =   $this->con_lista_detalle_comprobante_idoc_actual($idoc);

		//dd($ordencompra);

		$banco_id 	 		 	 					= 	$request['banco_id'];
		$tipocuenta_id 	 		 					= 	$request['tipocuenta_id'];
		$moneda_id 	 		 						= 	$request['moneda_id'];
		$numerocuenta 	 		 					= 	$request['numerocuenta'];
		$numerocuentacci 	 		 				= 	$request['numerocuentacci'];
		$banco 										=	CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
		$tipocuenta 								=	CMPCategoria::where('COD_CATEGORIA','=',$tipocuenta_id)->first();
		$moneda 									=	CMPCategoria::where('COD_CATEGORIA','=',$moneda_id)->first();
		$empresa 									=	STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPR_CLIENTE)->first();



		$tescuentabb    							=   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
														->where('COD_EMPR_BANCO','=',$banco->COD_CATEGORIA)
														->where('COD_CATEGORIA_MONEDA','=',$moneda->COD_CATEGORIA)
														->where('TXT_TIPO_REFERENCIA','=',$tipocuenta->COD_CATEGORIA)
														->where('TXT_NRO_CUENTA_BANCARIA','=',$numerocuenta)
														->where('COD_ESTADO','=',1)
														->first();

		if(count($tescuentabb) > 0){
				return Redirect::back()->withInput()->with('errorurl', 'La cuenta ya se cuenta registrado');
		}


		$cuentabancaria 							=	New TESCuentaBancaria();
		$cuentabancaria->COD_EMPR_TITULAR 			=   $empresa->COD_EMPR;
		$cuentabancaria->COD_EMPR_BANCO 			=   $banco->COD_CATEGORIA;
		$cuentabancaria->TXT_NRO_CUENTA_BANCARIA	=   $numerocuenta;
		$cuentabancaria->TXT_EMPR_TITULAR 			=   $empresa->NOM_EMPR;
		$cuentabancaria->TXT_EMPR_BANCO 			=   $banco->NOM_CATEGORIA;
		$cuentabancaria->COD_CATEGORIA_MONEDA 		=   $moneda->COD_CATEGORIA;
		$cuentabancaria->TXT_CATEGORIA_MONEDA 		=   $moneda->NOM_CATEGORIA;
		$cuentabancaria->TXT_NRO_CCI 				=   $numerocuentacci;
		$cuentabancaria->TXT_GLOSA 					=   '';
		$cuentabancaria->TXT_TIPO_REFERENCIA 		=   $tipocuenta->COD_CATEGORIA;
		$cuentabancaria->TXT_REFERENCIA 			=   $tipocuenta->NOM_CATEGORIA;
		$cuentabancaria->COD_USUARIO_CREA_AUD 		=   Session::get('usuario')->id;
		$cuentabancaria->FEC_USUARIO_CREA_AUD 		=   $this->fechaactual;
		$cuentabancaria->COD_ESTADO 				=   1;
		$cuentabancaria->COD_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->TXT_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->save();

		return Redirect::back()->withInput()->with('bienhecho', 'Cuenta Bancaria '.$numerocuenta.' registrada con éxito');


	}



	public function actionEliminarCuentaBancaria(Request $request)
	{

		$banco_id 	 		 	 					= 	$request['data_COD_EMPR_BANCO'];
		$tipocuenta_id 	 		 					= 	$request['data_TXT_TIPO_REFERENCIA'];
		$moneda_id 	 		 						= 	$request['data_COD_CATEGORIA_MONEDA'];
		$numerocuenta 	 		 					= 	$request['data_TXT_NRO_CUENTA_BANCARIA'];
		$numerocuentacci 	 		 				= 	$request['data_TXT_NRO_CUENTA_BANCARIA'];
		$banco 										=	CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
		$tipocuenta 								=	CMPCategoria::where('COD_CATEGORIA','=',$tipocuenta_id)->first();
		$moneda 									=	CMPCategoria::where('COD_CATEGORIA','=',$moneda_id)->first();
		$empresa 									=	STDEmpresa::where('COD_EMPR','=',Session::get('usuario')->usuarioosiris_id)->first();


		$tescuentabb    							=   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
														->where('COD_EMPR_BANCO','=',$banco->COD_CATEGORIA)
														->where('COD_CATEGORIA_MONEDA','=',$moneda->COD_CATEGORIA)
														->where('TXT_TIPO_REFERENCIA','=',$tipocuenta->COD_CATEGORIA)
														->where('TXT_NRO_CUENTA_BANCARIA','=',$numerocuenta)
														->where('COD_ESTADO','=',1)
														->first();



		$tescuentabb->COD_USUARIO_MODIF_AUD 		=   Session::get('usuario')->id;
		$tescuentabb->FEC_USUARIO_MODIF_AUD 		=   $this->fechaactual;
		$tescuentabb->TXT_NRO_CUENTA_BANCARIA 		=   $tescuentabb->TXT_NRO_CUENTA_BANCARIA.'-E';

		$tescuentabb->COD_ESTADO 					=   0;
		$tescuentabb->save();

		print_r('Elimincion exitosa');

	}




	public function actionConfigurarDatosCuentaBancaria($idusuario,Request $request)
	{

	    $idusuario = $this->funciones->decodificarmaestra($idusuario);

		$banco_id 	 		 	 					= 	$request['banco_id'];
		$tipocuenta_id 	 		 					= 	$request['tipocuenta_id'];
		$moneda_id 	 		 						= 	$request['moneda_id'];
		$numerocuenta 	 		 					= 	$request['numerocuenta'];
		$numerocuentacci 	 		 				= 	$request['numerocuentacci'];
		$usuario 									= 	User::where('id', $idusuario)->first();
		$banco 										=	CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
		$tipocuenta 								=	CMPCategoria::where('COD_CATEGORIA','=',$tipocuenta_id)->first();
		$moneda 									=	CMPCategoria::where('COD_CATEGORIA','=',$moneda_id)->first();
		$empresa 									=	STDEmpresa::where('COD_EMPR','=',Session::get('usuario')->usuarioosiris_id)->first();


		$tescuentabb    							=   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
														->where('COD_EMPR_BANCO','=',$banco->COD_CATEGORIA)
														->where('COD_CATEGORIA_MONEDA','=',$moneda->COD_CATEGORIA)
														->where('TXT_TIPO_REFERENCIA','=',$tipocuenta->COD_CATEGORIA)
														->where('TXT_NRO_CUENTA_BANCARIA','=',$numerocuenta)
														->where('COD_ESTADO','=',1)
														->first();

		if(count($tescuentabb) > 0){
				return Redirect::back()->withInput()->with('errorurl', 'La cuenta ya se cuenta registrado');
		}


		$cuentabancaria 							=	New TESCuentaBancaria();
		$cuentabancaria->COD_EMPR_TITULAR 			=   $empresa->COD_EMPR;
		$cuentabancaria->COD_EMPR_BANCO 			=   $banco->COD_CATEGORIA;
		$cuentabancaria->TXT_NRO_CUENTA_BANCARIA	=   $numerocuenta;
		$cuentabancaria->TXT_EMPR_TITULAR 			=   $empresa->NOM_EMPR;
		$cuentabancaria->TXT_EMPR_BANCO 			=   $banco->NOM_CATEGORIA;
		$cuentabancaria->COD_CATEGORIA_MONEDA 		=   $moneda->COD_CATEGORIA;
		$cuentabancaria->TXT_CATEGORIA_MONEDA 		=   $moneda->NOM_CATEGORIA;
		$cuentabancaria->TXT_NRO_CCI 				=   $numerocuentacci;
		$cuentabancaria->TXT_GLOSA 					=   '';
		$cuentabancaria->TXT_TIPO_REFERENCIA 		=   $tipocuenta->COD_CATEGORIA;
		$cuentabancaria->TXT_REFERENCIA 			=   $tipocuenta->NOM_CATEGORIA;
		$cuentabancaria->COD_USUARIO_CREA_AUD 		=   Session::get('usuario')->id;
		$cuentabancaria->FEC_USUARIO_CREA_AUD 		=   $this->fechaactual;
		$cuentabancaria->COD_ESTADO 				=   1;
		$cuentabancaria->COD_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->TXT_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->save();

 		return Redirect::to('/bienvenido')->with('bienhecho', 'Cuenta Bancaria '.$numerocuenta.' registrada con éxito');

	}





	public function actionConfigurarDatosProveedor($idusuario,Request $request)
	{

	    $idusuario = $this->funciones->decodificarmaestra($idusuario);
		$direccion 	 		 	 			= 	$request['direccion'];
		$cuenta_detraccion 	 		 		= 	$request['cuenta_detraccion'];

		$usuario 							= 	User::where('id', $idusuario)->first();
		$usuario->direccion_fiscal 	   		=   $direccion;
		$usuario->cuenta_detraccion 		=   $cuenta_detraccion;
		$usuario->fecha_mod 	 			=   $this->fechaactual;
		$usuario->save();
 		return Redirect::to('/bienvenido')->with('bienhecho', 'Usuario '.$usuario->nombre.' modificado con éxito');

	}


	public function actionConfigurarDatosContacto($idusuario,Request $request)
	{

	    $idusuario = $this->funciones->decodificarmaestra($idusuario);
		$nombre 	 		 	 			= 	$request['nombre'];
		$lblcelular 	 		 			= 	$request['lblcelular'];
		$lblemail 	 		 				= 	$request['lblemail'];

		$usuario 							= 	User::where('id', $idusuario)->first();
		$usuario->nombre_contacto 	   		=   $nombre;
		$usuario->celular_contacto 			=   $lblcelular;
		$usuario->email 					=   $lblemail;
		$usuario->fecha_mod 	 			=   $this->fechaactual;
		$usuario->save();
 		return Redirect::to('/bienvenido')->with('bienhecho', 'Usuario '.$usuario->nombre.' modificado con éxito');

	}




	public function actionAjaxModalConfiguracionDatosProveedor(Request $request)
	{
		$usuario    =   User::where('id','=',Session::get('usuario')->id)->first();

		return View::make('usuario/modal/ajax/mdatospersonales',
						 [		 	
						 	'usuario' 				=> $usuario,
						 	'ajax' 					=> true,						 	
						 ]);
	}

	public function actionAjaxModalConfiguracionDatosContacto(Request $request)
	{
		$usuario    =   User::where('id','=',Session::get('usuario')->id)->first();

		return View::make('usuario/modal/ajax/mdatoscontacto',
						 [		 	
						 	'usuario' 				=> $usuario,
						 	'ajax' 					=> true,						 	
						 ]);
	}


	public function actionAjaxModalConfiguracionCuentaBancaria(Request $request)
	{

		$usuario    			=   User::where('id','=',Session::get('usuario')->id)->first();
		$combo_banco 			= 	$this->gn_generacion_combo_categoria('BANCOS_MERGE','Seleccione banco','');
		$defecto_banco			= 	'';
		$combo_tipocuenta 		= 	$this->gn_generacion_combo_categoria('CUENTA_MERGE','Seleccione tipo cuenta','');
		$defecto_tipocuenta		= 	'';
		$combo_moneda 			= 	$this->gn_generacion_combo_categoria('MONEDA_MERGE','Seleccione moneda','');
		$defecto_moneda			= 	'';

		return View::make('usuario/modal/ajax/mdatoscuentabancaria',
						 [		 	
						 	'usuario' 						=> $usuario,
						 	'combo_banco' 					=> $combo_banco,
						 	'defecto_banco' 				=> $defecto_banco,
						 	'combo_tipocuenta' 				=> $combo_tipocuenta,
						 	'defecto_tipocuenta' 			=> $defecto_tipocuenta,
						 	'combo_moneda' 					=> $combo_moneda,
						 	'defecto_moneda' 				=> $defecto_moneda,						 	
						 	'ajax' 							=> true,						 	
						 ]);
	}








    public function actionActivarRegistro($token)
	{
		$idusuario  =   $this->funciones->decodificarmaestra($token);
		$usuario    =   User::where('id','=',$idusuario)->first();


		$mensaje    =   'Cuenta Activada Satisfactoriamente';
		if(count($usuario)>0){
			
			$usuario->ind_confirmacion = 1;
			$usuario->save();

			$mensaje    =   'Cuenta Activada Satisfactoriamente';
		}else{
			$mensaje    =   'Link de activacion no encontrada';
		}

		return View::make('usuario.activar',
						 [
						 	'usuario' => $usuario,
						 	'mensaje' => $mensaje,
						 ]);
	}

    public function actionCorreoConfirmacion()
	{
		$this->envio_correo_confirmacion();
	}
    public function actionCorreoUC()
	{
		$this->envio_correo_uc();
	}
    public function actionCorreoCO()
	{
		$this->envio_correo_co();
	}
    public function actionCorreoADM()
	{
		$this->envio_correo_adm();
	}


    public function actionCorreoBaja()
	{
		$this->envio_correo_baja();
	}
    public function actionCorreoAPCLI()
	{
		$this->envio_correo_apcli();
	}


    public function actionRegistrate(Request $request)
	{


		if($_POST)
		{

            try{    
                


            DB::beginTransaction();


			$ruc 	 		 			= 	$request['ruc'];
			$razonsocial 	 		 	= 	$request['razonsocial'];
			$direccion 	 		 		= 	$request['direccion'];
			$cuenta_detraccion 	 		= 	$request['cuenta_detraccion'];
			$lblcontrasena 	 		 	= 	$request['lblcontrasena'];
			$lblcontrasenaconfirmar 	= 	$request['lblcontrasenaconfirmar'];
			$nombre 	 		 		= 	$request['nombre'];
			$lblcelular 	 			= 	$request['lblcelular'];
			$lblemail 	 		 		= 	$request['lblemail'];
			$lblconfirmaremail 			= 	$request['lblconfirmaremail'];
			$cod_empresa 				= 	$request['cod_empresa'];
			$usuario    				=   User::where('usuarioosiris_id','=',$cod_empresa)->first();

			if(count($usuario) > 0){
					return Redirect::back()->withInput()->with('errorurl', 'El usuario ya se cuenta registrado');
			}

			$idusers 				 	=   $this->funciones->getCreateIdMaestra('users');
			$cabecera            	 	=	new User;
			$cabecera->id 	     	 	=   $idusers;
			$cabecera->nombre 	     	=   $razonsocial;
			$cabecera->name  		 	=	$ruc;
			$cabecera->passwordmobil  	=	$lblcontrasena;
			$cabecera->fecha_crea 	   	=  	$this->fechaactual;
			$cabecera->password 	 	= 	Crypt::encrypt($lblcontrasena);
			$cabecera->rol_id 	 		= 	'1CIX00000024';
			$cabecera->usuarioosiris_id	= 	$cod_empresa;
			$cabecera->email			= 	$lblemail;
			$cabecera->direccion_fiscal		= 	$direccion;
			$cabecera->cuenta_detraccion	= 	$cuenta_detraccion;
			$cabecera->nombre_contacto		= 	$nombre;
			$cabecera->celular_contacto		= 	$lblcelular;
			$cabecera->email_confirmacion	= 	0;
			$cabecera->ind_confirmacion		= 	0;
			$cabecera->save();
 

			$id 						= 	$this->funciones->getCreateIdMaestra('WEB.userempresacentros');
		    $detalle            		=	new WEBUserEmpresaCentro;
		    $detalle->id 	    		=  	$id;
			$detalle->empresa_id 		= 	'IACHEM0000010394';
			$detalle->centro_id    		=  	'CEN0000000000001';
			$detalle->fecha_crea 	 	= 	$this->fechaactual;
			$detalle->usuario_id    	=  	$idusers;
			$detalle->save();

			$id 						= 	$this->funciones->getCreateIdMaestra('WEB.userempresacentros');
		    $detalle            		=	new WEBUserEmpresaCentro;
		    $detalle->id 	    		=  	$id;
			$detalle->empresa_id 		= 	'IACHEM0000007086';
			$detalle->centro_id    		=  	'CEN0000000000001';
			$detalle->fecha_crea 	 	= 	$this->fechaactual;
			$detalle->usuario_id    	=  	$idusers;
			$detalle->save();

			Session::forget('usuario');
			Session::forget('listamenu');
			Session::forget('listaopciones');
            DB::commit();

            }catch(\Exception $ex){
                DB::rollback(); 
                return Redirect::to('registrate')->with('errorbd', $ex.' Ocurrio un error inesperado');
            }

 			return Redirect::to('/login')->with('bienhecho', 'Proveedor '.$razonsocial.' registrado con exito (Se le a enviado un email para que pueda confirmar su acceso al sitema)');



		}else{


			$listapersonal 				= 	DB::table('STD.EMPRESA')
	    									->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
	    									->whereNull('users.usuarioosiris_id')
	    									->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
	    									->where('STD.EMPRESA.COD_ESTADO','=',1)
	    									->select('STD.EMPRESA.COD_EMPR','STD.EMPRESA.NOM_EMPR')
											->select(DB::raw("
											  STD.EMPRESA.COD_EMPR,
											  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
											)
											->pluck('NOMBRE','NOMBRE')
											->take(10)
											->toArray();
			$combolistaclientes  		= 	array('' => "Seleccione clientes") + $listapersonal;
			$mensaje    = '';
			$idactivo   = 1;

			return View::make('usuario.registrate',
							 [
							 	'combolistaclientes' => $combolistaclientes,
							 	'mensaje' => $mensaje,
							 	'idactivo' => $idactivo,
							 ]);
		}	

	}

	public function actionAjaxBuscarProveedor(Request $request) {

		$ruc 						=   $request['ruc'];
		$empresa 					= 	DB::table('STD.EMPRESA')
    									->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
    									->where('STD.EMPRESA.COD_ESTADO','=',1)
    									->where('NRO_DOCUMENTO','=',$ruc)
										->first();
		$direccion  = '';	
		$mensaje    = 'Proveedor encontrado';
		$idactivo   = 1;

		if(count($empresa)>0){
			$tdireccion 				=	STDEmpresaDireccion::where('COD_EMPR','=',$empresa->COD_EMPR)
											->where('IND_DIRECCION_FISCAL','=',1)
											->where('COD_ESTADO','=',1)
											->first();
			if(count($tdireccion)>0){
				$direccion = $tdireccion->NOM_DIRECCION;
			}	
			$usuario    =   User::where('usuarioosiris_id','=',$empresa->COD_EMPR)->first();
			if(count($usuario)>0){
				if($usuario->ind_confirmacion==0){
					$idactivo   = 0;
					$mensaje = 'Proveedor ya cuenta con un registro (pero aun no confirma su registro)';
				}
				if($usuario->ind_confirmacion==1){
					$idactivo   = 0;
					$mensaje = 'Proveedor ya cuenta con un registro';
				}
			}
		}else{
			$idactivo   = 0;
			$mensaje = 'Proveedor no encontrado';
		}

		return View::make('usuario/form/formproveedor',
			[
				'empresa' => $empresa,
				'idactivo' => $idactivo,
				'mensaje' => $mensaje,
				'direccion' => $direccion,
			]);
	}


		
	public function actionCambiarPerfil()
	{
		Session::forget('empresas');
		return Redirect::to('/acceso');
	}


    // public function actionAcceso()
	// {

	// 	$accesos  	= 	Permisouserempresa::where('activo','=',1)
	// 					->where('user_id','=',Session::get('usuario')->id)->get();


	// 	return View::make('acceso',
	// 					 [
	// 					 	'accesos' => $accesos,
	// 					 ]);
	// }
	
	public function actionLogin(Request $request) {

		if ($_POST) {
			/**** Validaciones laravel ****/
			$this->validate($request, [
				'name' => 'required',
				'password' => 'required',

			], [
				'name.required' => 'El campo Usuario es obligatorio',
				'password.required' => 'El campo Clave es obligatorio',
			]);

			/**********************************************************/

			$usuario = strtoupper($request['name']);
			$clave = strtoupper($request['password']);
			$local_id = $request['local_id'];

			$tusuario = User::whereRaw('UPPER(name)=?', [$usuario])
				->where('activo', '=', 1)
				->first();

			if (count($tusuario) > 0) {

				if($tusuario->ind_confirmacion == 0){
					return Redirect::back()->withInput()->with('errorbd', 'El usuario aun no confirmo su registro');
				}
				$clavedesifrada = strtoupper(Crypt::decrypt($tusuario->password));
				if ($clavedesifrada == $clave) {

					$listamenu    		 = 	WEBGrupoopcion::join('web.opciones', 'web.opciones.grupoopcion_id', '=', 'web.grupoopciones.id')
											->join('web.rolopciones', 'web.rolopciones.opcion_id', '=', 'web.opciones.id')
											->where('web.grupoopciones.activo', '=', 1)
											->where('web.rolopciones.rol_id', '=', $tusuario->rol_id)
											->where('web.rolopciones.ver', '=', 1)
											->where('web.opciones.ind_merge', '=', 1)
											->groupBy('web.grupoopciones.id')
											->groupBy('web.grupoopciones.nombre')
											->groupBy('web.grupoopciones.icono')
											->groupBy('web.grupoopciones.orden')
											->select('web.grupoopciones.id','web.grupoopciones.nombre','web.grupoopciones.icono','web.grupoopciones.orden')
											->orderBy('web.grupoopciones.orden', 'asc')
											->get();

					$listaopciones    	= 	WEBRolOpcion::join('web.opciones', 'web.rolopciones.opcion_id', '=', 'web.opciones.id')
											->where('web.opciones.ind_merge', '=', 1)
											->where('rol_id', '=', $tusuario->rol_id)
											->where('ver', '=', 1)
											->orderBy('orden', 'asc')
											->pluck('opcion_id')
											->toArray();

					Session::put('usuario', $tusuario);
					Session::put('listamenu', $listamenu);
					Session::put('listaopciones', $listaopciones);

					//return Redirect::to('bienvenido');
					return Redirect::to('acceso');



				} else {
					return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
				}
			} else {
				return Redirect::back()->withInput()->with('errorbd', 'Usuario o clave incorrecto');
			}

		} else {
			return view('usuario.login');
		}
	}

	public function actionAcceso()
	{

		$accesos  	= 	WEBUserEmpresaCentro::where('activo','=',1)
						->where('usuario_id','=',Session::get('usuario')->id)
						->select(DB::raw('empresa_id'))
						->groupBy('empresa_id')
						->get();

		//dd($this->funciones->prefijomaestra());

		$funcion 	=   $this;

		return View::make('acceso',
						 [
						 	'accesos' => $accesos,
						 	'funcion' => $funcion,
						 ]);

	}

	public function actionAccesoBienvenido($idempresa)
	{
		
		$empresas 	= 	STDEmpresa::where('COD_EMPR','=',$idempresa)
						->where('COD_ESTADO','=','1')->where('IND_SISTEMA','=','1')->first(); 
		$color 		=   $this->funciones->color_empresa($empresas->COD_EMPR);

		Session::put('color', $color);
		Session::put('empresas', $empresas);


		$funcion 	=   $this;
		return Redirect::to('bienvenido');

	}

	public function actionCerrarSesion() {
		Session::forget('usuario');
		Session::forget('listamenu');
		Session::forget('listaopciones');
		Session::forget('empresas');
		return Redirect::to('/login');	
	}

	public function actionBienvenido() {

		View::share('titulo','Bienvenido Sistema Administrativo MERGE');
		$fecha = date('Y-m-d');
		$usuario = User::where('id','=',Session::get('usuario')->id)->first();

		$cuentabancarias = 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',Session::get('usuario')->usuarioosiris_id)
							->where('COD_ESTADO','=',1)
						  	->get();

		$count_x_aprobar 			= 	0;
        $cod_empresa    			=   Session::get('usuario')->usuarioosiris_id;
        $url 						=	'';
        $urlcontrato 				=	'';

        $url_obs 					=	'';
		$count_observados 			= 	0;

        $url_rep 					=	'';
        $url_rep_contrato 			=	'';

        $url_rep_revisar 			=	'';
        $url_rep_contrato_revisar 	=	'';

		$count_reparables 			= 	0;
		$count_reparables_con 		= 	0;

		$count_reparables_rev 		= 	0;
		$count_reparables__revcon 	= 	0;

		$count_x_aprobar_gestion 	= 	0;
        $url_gestion 				=	'';

		$count_observados_con 		= 	0;
        $url_obs_con 				=	'';

       
		$trol 						=	WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

		$count_x_aprobar_con 				= 	0;

		$count_x_aprobar_gestion_con 		= 	0;
		
		//1CIX00000019 COMPRAS
        //1CIX00000015 1CIX00000016 //Contabilidad
		if($trol->ind_uc == 1){

			$listadatos      		=   $this->con_lista_cabecera_comprobante_total_uc($cod_empresa);
			$count_x_aprobar 		= 	 count($listadatos);
        	$url 			 		=	'/gestion-de-comprobante-us/wjR';
        	//contrato
			$count_x_aprobar_con 	= 	 count($listadatos);

        	$listadatosre    		=   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,'TODO','TODO');
			$count_reparables 		= 	 count($listadatosre);
        	$url_rep 		 		=	'/gestion-de-comprobantes-reparable/Elk';

        	$listadatosre_con    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,'TODO','TODO');
			$count_reparables_con 	= 	 count($listadatosre_con);

        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_gestion_observados($cod_empresa);
			$count_observados 		= 	count($listadatosob);
        	$url_obs 		 		=	'/gestion-de-comprobantes-observados/lO6';


        	$listadatosobcon    	=   $this->con_lista_cabecera_comprobante_total_gestion_observados_contrato($cod_empresa);
			$count_observados_con 	= 	count($listadatosobcon);
        	$url_obs_con 		 	=	'/gestion-de-comprobantes-observados/lO6';


			$listadatosg      		=   $this->con_lista_cabecera_comprobante_administrativo($cod_empresa);
			$count_x_aprobar_gestion= 	 count($listadatosg);
        	$url_gestion 	  		=	'/gestion-de-orden-compra/k5X';

        	//contrato
			$listadatosg      		=   $this->con_lista_cabecera_contrato_administrativo($cod_empresa);
			$count_x_aprobar_gestion_con= 	 count($listadatosg);

		}
		else{
			//CONTABILIDAD
			if(Session::get('usuario')->rol_id == '1CIX00000015' || Session::get('usuario')->rol_id == '1CIX00000016'){


        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont($cod_empresa);
				$count_x_aprobar 		= 	 count($listadatos);

	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_obs($cod_empresa);
				$count_observados 		= 	count($listadatosob);


    			$url 					=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=ORDEN_COMPRA';
    			$urlcontrato 			=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=CONTRATO';


        		$url_rep 		 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=ORDEN_COMPRA';
        		$url_rep_contrato 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=CONTRATO';

        		$url_rep_revisar 		 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=ORDEN_COMPRA&estado_id=2';
        		$url_rep_contrato_revisar 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=CONTRATO&estado_id=2';


        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont_contrato($cod_empresa);
				$count_x_aprobar_con 	= 	 count($listadatos);

	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_contrato_obs($cod_empresa);
				$count_observados_con 	= 	count($listadatosob);



	        	$listadatosre    		=   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,'TODO','TODO');
				$count_reparables 		= 	 count($listadatosre);

	        	$listadatosre_con    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,'TODO','TODO');
				$count_reparables_con 	= 	 count($listadatosre_con);


	        	$listadatosrerev    		=   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,'TODO','2');
				$count_reparables_rev 		= 	 count($listadatosrerev);

	        	$listadatosre_con_rev    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,'TODO','2');
				$count_reparables__revcon 	= 	 count($listadatosre_con_rev);



			}
			//ADMINISTRACION
			else{
				if(Session::get('usuario')->rol_id == '1CIX00000020'){
        			$listadatos     =   $this->con_lista_cabecera_comprobante_total_adm($cod_empresa);
					$count_x_aprobar = 	 count($listadatos);


		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_obs($cod_empresa);
					$count_observados 		= 	count($listadatosob);


	        		$listadatos     =   $this->con_lista_cabecera_comprobante_total_adm_contrato($cod_empresa);
					$count_x_aprobar_con 	= 	 count($listadatos);


		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs($cod_empresa);
					$count_observados_con 	= 	count($listadatosob);


        			$url 					=	'/gestion-de-administracion-aprobar/j25?operacion_id=ORDEN_COMPRA';
        			$urlcontrato 			=	'/gestion-de-administracion-aprobar/j25?operacion_id=CONTRATO';

				}
			}
		}

		$listaocpendientes  =	array();
		$listadocestados    =	array();
		$listaobservados    =	array();
		$listaocpendientes_con    =	array();
		$listadocestados_con    =	array();	

		if(Session::get('usuario')->rol_id != '1CIX00000024'){

			$listaocpendientes     	   =   $this->con_lista_cabecera_comprobante_administrativo_total();
			$listaocpendientes_con     =   $this->con_lista_cabecera_comprobante_administrativo_total_contrato();

        	$listadocestados       	   =   $this->con_lista_cabecera_comprobante_total_gestion_agrupado($cod_empresa);
        	$listadocestados_con       =   $this->con_lista_cabecera_comprobante_total_gestion_agrupado_con($cod_empresa);


        	$listaobservados       =   FeDocumento::where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)->where('TXT_PROCEDENCIA','<>','SUE')->where('ind_observacion','=','1')->first();
		}



		//dd($listaocpendientes);

		return View::make('bienvenido',
						 [
						 	'usuario' 			=> $usuario,
						 	'cuentabancarias' 	=> $cuentabancarias,
						 	'fecha' 			=> $fecha,
						 	'count_x_aprobar' 	=> $count_x_aprobar,

						 	'url' 				=> $url,
						 	'urlcontrato' 		=> $urlcontrato,


						 	'count_observados' 	=> $count_observados,
						 	'url_obs' 			=> $url_obs,

						 	'count_reparables' 	=> $count_reparables,
						 	'count_reparables_con' 	=> $count_reparables_con,
						 	'url_rep' 			=> $url_rep,
						 	'url_rep_contrato' 	=> $url_rep_contrato,

						 	'url_rep_revisar' 	=> $url_rep_revisar,
						 	'url_rep_contrato_revisar' 	=> $url_rep_contrato_revisar,
						 	'count_reparables_rev' 			=> $count_reparables_rev,
						 	'count_reparables__revcon' 	=> $count_reparables__revcon,





						 	'count_x_aprobar_gestion' 	=> $count_x_aprobar_gestion,
						 	'url_gestion' 			=> $url_gestion,
						 	'trol' 					=> $trol,


						 	'listaocpendientes' 	=> $listaocpendientes,
						 	'listaocpendientes_con' => $listaocpendientes_con,

						 	'listadocestados'   	=> $listadocestados,
						 	'listadocestados_con'   => $listadocestados_con,

						 	'listaobservados'   => $listaobservados,

						 	'count_x_aprobar_con' => $count_x_aprobar_con,
						 	'count_observados_con'   => $count_observados_con,
						 	'url_obs_con'   => $url_obs_con,



						 	'count_x_aprobar_gestion_con'   => $count_x_aprobar_gestion_con,


						 ]);

	}

	public function actionObtenerTipoCambio()
	{

		$fecha   = date_format(date_create(date('Y-m-d')), 'Y-m-d');
        // URL del servicio web de SUNAT para obtener el tipo de cambio
        $url = 'https://www.sunat.gob.pe/a/txt/tipoCambio.txt';
        // Realizar la solicitud HTTP para obtener el contenido del archivo de tipo de cambio
        $response = file_get_contents($url);
        // Verificar si la solicitud fue exitosa
        if ($response !== false) {
            // Dividir el contenido en líneas
            $datos = explode('|',$response);
            // dd('sss');
            $tipocambio           =   new TipoCambio();
            $tipocambio->compra   =   (float)$datos[1];
            $tipocambio->venta    =   (float)$datos[2];
            $tipocambio->fecha    =   $fecha;
            $tipocambio->save();

        }
        else{
            $registro               =   new Ilog();
            $registro->descripcion  =   'NO SE REGISTRO TIPO DE CAMBIO PARA LA FECHA '.date('Y-m-d');
            $registro->save();
        }
		return Redirect::to('bienvenido');
	}


	public function actionListarUsuarios($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
        $array_rols    = WEBRol::where('ind_merge','=',1)
                         ->pluck('id')
                         ->toArray();
	    $listausuarios = User::where('id','<>',$this->prefijomaestro.'00000001')
	    				->whereIn('rol_id',$array_rols)->orderBy('id', 'asc')->get();

		return View::make('usuario/listausuarios',
						 [
						 	'listausuarios' => $listausuarios,
						 	'idopcion' => $idopcion,
						 ]);
	}


	public function actionAgregarUsuario($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{


			$personal_id 	 		 	= 	$request['cliente_select'];
			$arraypersonal 				=	explode("-", $personal_id);
			$ruc 						=	$arraypersonal[0];

			$personal     				=   DB::table('STD.EMPRESA')
											->where('NRO_DOCUMENTO', '=', $ruc)
											->where('COD_ESTADO', '=', 1)
											->where('IND_PROVEEDOR', '=', 1)
											->first();
			$idusers 				 	=   $this->funciones->getCreateIdMaestra('users');
			
			$cabecera            	 	=	new User;
			$cabecera->id 	     	 	=   $idusers;
			$cabecera->nombre 	     	=   $personal->NOM_EMPR;
			$cabecera->name  		 	=	$request['name'];
			$cabecera->passwordmobil  	=	$request['password'];
			$cabecera->fecha_crea 	   	=  	$this->fechaactual;
			$cabecera->password 	 	= 	Crypt::encrypt($request['password']);
			$cabecera->rol_id 	 		= 	$request['rol_id'];
			$cabecera->usuarioosiris_id	= 	$personal->COD_EMPR;
			$cabecera->save();
 

 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$personal->COD_EMPR.' registrado con exito');

		}else{


			$listapersonal 				= 	DB::table('STD.EMPRESA')
	    									->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
	    									->whereNull('users.usuarioosiris_id')
	    									->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
	    									->where('STD.EMPRESA.COD_ESTADO','=',1)
	    									->select('STD.EMPRESA.COD_EMPR','STD.EMPRESA.NOM_EMPR')
											->select(DB::raw("
											  STD.EMPRESA.COD_EMPR,
											  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
											)
											->pluck('NOMBRE','NOMBRE')
											->take(10)
											->toArray();


			$combolistaclientes  		= 	array('' => "Seleccione clientes") + $listapersonal;


			$rol 						= 	DB::table('WEB.Rols')->where('ind_merge','=',1)->where('id','<>',$this->prefijomaestro.'00000001')->pluck('nombre','id')->toArray();
			$comborol  					= 	array('' => "Seleccione Rol") + $rol;
		
			return View::make('usuario/agregarusuario',
						[
							'comborol'  		=> $comborol,
							'listapersonal'  	=> $listapersonal,
							'combolistaclientes'  	=> $combolistaclientes,				
						  	'idopcion'  		=> $idopcion
						]);
		}
	}


	public function actionModificarUsuario($idopcion,$idusuario,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idusuario = $this->funciones->decodificarmaestra($idusuario);

		if($_POST)
		{

			$cabecera            	 =	User::find($idusuario);			
			$cabecera->name  		 =	$request['name'];
			$cabecera->passwordmobil =	$request['password'];
			$cabecera->fecha_mod 	 =  $this->fechaactual;
			$cabecera->password 	 = 	Crypt::encrypt($request['password']);
			$cabecera->activo 	 	 =  $request['activo'];			
			$cabecera->rol_id 	 	 = 	$request['rol_id']; 
			$cabecera->save();


 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$request['nombre'].' modificado con exito');


		}else{


				$usuario 	= 	User::where('id', $idusuario)->first();  
				$rol 		= 	DB::table('WEB.Rols')->where('id','<>',$this->prefijomaestro.'00000001')->pluck('nombre','id')->toArray();
				$comborol  	= 	array($usuario->rol_id => $usuario->rol->nombre) + $rol;
				$funcion 	= 	$this;	

		        return View::make('usuario/modificarusuario', 
		        				[
		        					'usuario'  		=> $usuario,
									'comborol' 		=> $comborol,
						  			'idopcion' 		=> $idopcion,
									'funcion' 		=> $funcion,
		        				]);
		}
	}

	public function actionListarRoles($idopcion) {

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Ver');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/
	    View::share('titulo','Lista de Roles');
		$listaroles = WEBRol::where('id', '<>', $this->prefijomaestro . '00000001')->where('ind_merge','=',1)->orderBy('id', 'asc')->get();

		return View::make('usuario/listaroles',
			[
				'listaroles' => $listaroles,
				'idopcion' => $idopcion,
			]);

	}

	public function actionAgregarRol($idopcion, Request $request) {
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Anadir');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/
	    View::share('titulo','Agregar Rol');
		if ($_POST) {

			/**** Validaciones laravel ****/

			$this->validate($request, [
				'nombre' => 'unico:dbo,rols',
			], [
				'nombre.unico' => 'Rol ya registrado',
			]);

			/******************************/
			$idrol = $this->funciones->getCreateIdMaestra('WEB.rols');

			$cabecera = new WEBRol;
			$cabecera->id = $idrol;
			$cabecera->fecha_crea = $this->fechaactual;
			$cabecera->nombre = $request['nombre'];
			$cabecera->ind_merge = 1;
			$cabecera->save();

			$listaopcion = WEBOpcion::orderBy('id', 'asc')->get();

			$count = 1;
			foreach ($listaopcion as $item) {

				$idrolopciones = $this->funciones->getCreateIdMaestra('WEB.rolopciones');

				$detalle = new WEBRolOpcion;
				$detalle->id = $idrolopciones;
				$detalle->opcion_id = $item->id;
				$detalle->fecha_crea = $this->fechaactual;
				$detalle->rol_id = $idrol;
				$detalle->orden = $count;
				$detalle->ver = 0;
				$detalle->anadir = 0;
				$detalle->modificar = 0;
				$detalle->eliminar = 0;
				$detalle->todas = 0;
				$detalle->fecha_crea = $this->fechaactual;
				$detalle->save();
				$count = $count + 1;
			}

			return Redirect::to('/gestion-de-roles/' . $idopcion)->with('bienhecho', 'Rol ' . $request['nombre'] . ' registrado con exito');
		} else {

			return View::make('usuario/agregarrol',
				[
					'idopcion' => $idopcion,
				]);

		}
	}

	public function actionModificarRol($idopcion, $idrol, Request $request) {

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Modificar');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/
		$idrol = $this->funciones->decodificarmaestra($idrol);
	    View::share('titulo','Modificar Rol');
		if ($_POST) {

			/**** Validaciones laravel ****/
			$this->validate($request, [
				'nombre' => 'unico_menos:dbo,rols,id,' . $idrol,
			], [
				'nombre.unico_menos' => 'Rol ya registrado',
			]);
			/******************************/

			$cabecera = WEBRol::find($idrol);
			$cabecera->nombre = $request['nombre'];
			$cabecera->fecha_mod = $this->fechaactual;
			$cabecera->activo = $request['activo'];
			$cabecera->save();

			return Redirect::to('/gestion-de-roles/' . $idopcion)->with('bienhecho', 'Rol ' . $request['nombre'] . ' modificado con éxito');

		} else {
			$rol = WEBRol::where('id', $idrol)->first();

			return View::make('usuario/modificarrol',
				[
					'rol' => $rol,
					'idopcion' => $idopcion,
				]);
		}
	}

	public function actionListarPermisos($idopcion) {

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion, 'Ver');
		if ($validarurl != 'true') {return $validarurl;}
		/******************************************************/
	     View::share('titulo','Lista Permisos');
		$listaroles = WEBRol::where('id', '<>', $this->prefijomaestro . '00000001')->where('ind_merge','=',1)->orderBy('id', 'asc')->get();

		return View::make('usuario/listapermisos',
			[
				'listaroles' => $listaroles,
				'idopcion' => $idopcion,
			]);
	}

	public function actionAjaxListarOpciones(Request $request) {
		$idrol = $request['idrol'];
		$idrol = $this->funciones->decodificarmaestra($idrol);
        $array_rols    = WEBRol::where('ind_merge','=',1)
                         ->pluck('id')
                         ->toArray();


		$listaopciones = WEBRolOpcion::where('rol_id', '=', $idrol)->whereIn('rol_id',$array_rols)->get();

		return View::make('usuario/ajax/listaopciones',
			[
				'listaopciones' => $listaopciones,
			]);
	}

	public function actionAjaxActivarPermisos(Request $request) {

		$idrolopcion = $request['idrolopcion'];
		$idrolopcion = $this->funciones->decodificarmaestra($idrolopcion);

		$cabecera = WEBRolOpcion::find($idrolopcion);
		$cabecera->ver = $request['ver'];
		$cabecera->anadir = $request['anadir'];
		$cabecera->fecha_mod = $this->fechaactual;
		$cabecera->modificar = $request['modificar'];
		$cabecera->todas = $request['todas'];
		$cabecera->save();

		echo ("gmail");

	}

}
