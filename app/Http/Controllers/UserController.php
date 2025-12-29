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
use App\Modelos\ALMCentro;
use App\Modelos\WEBListaPersonal;
use App\Modelos\LqgLiquidacionGasto;

use App\Modelos\Tercero;



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
use App\Modelos\CMPDocumentoCtble;


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
use App\Traits\LiquidacionGastoTraits;
use App\Traits\ValeRendirTraits;
use App\Traits\CuartaCategoriaTraits;



class UserController extends Controller {

    use UserTraits;
    use GeneralesTraits;
    use ComprobanteProvisionTraits;
    use ComprobanteTraits;
    use LiquidacionGastoTraits;
    use ValeRendirTraits;
    use CuartaCategoriaTraits;
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

	public function actionAjaxModalConfiguracionCuentaBancariaEstiba(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idopcion               =   $request['idopcion'];
        $empresa_id             =   $request['empresa_id'];
        $idoc                   =   $orden_id;

		$usuario    			=   User::where('id','=',Session::get('usuario')->id)->first();
		$combo_banco 			= 	$this->gn_generacion_combo_categoria('BANCOS_MERGE','Seleccione banco','');
		$defecto_banco			= 	'';
		$combo_tipocuenta 		= 	$this->gn_generacion_combo_categoria('CUENTA_MERGE','Seleccione tipo cuenta','');
		$defecto_tipocuenta		= 	'';
		$combo_moneda 			= 	$this->gn_generacion_combo_categoria('MONEDA_MERGE','Seleccione moneda','');
		$defecto_moneda			= 	'';

		return View::make('usuario/modal/ajax/mdatoscuentabancariaestiba',
						 [		 	
						 	'usuario' 						=> $usuario,
						 	'idoc' 							=> $idoc,
						 	'empresa_id' 					=> $empresa_id,
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

	public function actionAjaxModalConfiguracionCuentaBancariaLiqComAn(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idopcion               =   $request['idopcion'];
        $empresa_id             =   $request['empresa_id'];
        $idoc                   =   $orden_id;

		$usuario    			=   User::where('id','=',Session::get('usuario')->id)->first();
		$combo_banco 			= 	$this->gn_generacion_combo_categoria('BANCOS_MERGE','Seleccione banco','');
		$defecto_banco			= 	'';
		$combo_tipocuenta 		= 	$this->gn_generacion_combo_categoria('CUENTA_MERGE','Seleccione tipo cuenta','');
		$defecto_tipocuenta		= 	'';
		$combo_moneda 			= 	$this->gn_generacion_combo_categoria('MONEDA_MERGE','Seleccione moneda','');
		$defecto_moneda			= 	'';

		return View::make('usuario/modal/ajax/mdatoscuentabancarialiqcoman',
						 [		 	
						 	'usuario' 						=> $usuario,
						 	'idoc' 							=> $idoc,
						 	'empresa_id' 					=> $empresa_id,
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


	public function actionAjaxModalConfiguracionCuentaBancariaLQ(Request $request)
	{

        $ID_DOCUMENTO           =   $request['ID_DOCUMENTO'];
        $idopcion               =   $request['idopcion'];

        $idoc                   =   $ID_DOCUMENTO;
        $ordencompra          	=   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$idoc)->first();



		$usuario    			=   User::where('id','=',Session::get('usuario')->id)->first();
		$combo_banco 			= 	$this->gn_generacion_combo_categoria('BANCOS_MERGE','Seleccione banco','');
		$defecto_banco			= 	'';
		$combo_tipocuenta 		= 	$this->gn_generacion_combo_categoria('CUENTA_MERGE','Seleccione tipo cuenta','');
		$defecto_tipocuenta		= 	'';
		$combo_moneda 			= 	$this->gn_generacion_combo_categoria('MONEDA_MERGE','Seleccione moneda','');
		$defecto_moneda			= 	'';

		return View::make('usuario/modal/ajax/mdatoscuentabancarialg',
						 [		 	
						 	'usuario' 						=> $usuario,
						 	'idoc' 							=> $idoc,
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


	public function actionAjaxModalVerCuentaBancariaLQ(Request $request)
	{


        $ID_DOCUMENTO          	=   $request['ID_DOCUMENTO'];
        $idopcion               =   $request['idopcion'];

        $idoc                   =   $ID_DOCUMENTO;
        $ordencompra          	=   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$idoc)->first();
		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPRESA_TRABAJADOR)
									->where('COD_ESTADO','=',1)
									->orderby('TXT_EMPR_BANCO','ASC')
								  	->get();

		return View::make('usuario/modal/ajax/mvercuentabancaria',
						 [		 	

						 	'cuentabancarias' 				=> $cuentabancarias,
						 	'idoc' 							=> $idoc,
						 	'idopcion' 						=> $idopcion,
						 	'ajax' 							=> true,						 	
						 ]);
	}


	public function actionAjaxModalVerCuentaBancariaOCIndividual(Request $request)
	{

        $orden_id               =   $request['orden_id'];
        $data_banco_codigo      =   $request['data_banco_codigo'];
        $data_numero_cuenta     =   $request['data_numero_cuenta'];

        $idopcion               =   $request['idopcion'];
        $fedocumento          	=   FeDocumento::where('ID_DOCUMENTO','=',$orden_id)->first();
		$empresa 				=	STDEmpresa::where('NRO_DOCUMENTO','=',$fedocumento->RUC_PROVEEDOR)->first();

		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
									->where('COD_ESTADO','=',1)
									->where('TXT_NRO_CUENTA_BANCARIA','=',$data_numero_cuenta)
									->where('COD_EMPR_BANCO','=',$data_banco_codigo)
									->orderby('TXT_EMPR_BANCO','ASC')
								  	->get();

		return View::make('usuario/modal/ajax/mvercuentabancariaindividual',
						 [		 	

						 	'cuentabancarias' 				=> $cuentabancarias,
						 	'idopcion' 						=> $idopcion,
						 	'ajax' 							=> true,						 	
						 ]);
	}



	public function actionAjaxModalVerCuentaBancariaOC(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idopcion               =   $request['idopcion'];

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
						 	'idoc' 							=> $idoc,
						 	'idopcion' 						=> $idopcion,
						 	'ajax' 							=> true,						 	
						 ]);
	}

	public function actionAjaxModalVerCuentaBancariaLiqComAn(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idopcion               =   $request['idopcion'];

        $idoc                   =   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);
        $ordencompra          	=   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();        

		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$ordencompra->COD_EMPR_EMISOR)
									->where('COD_ESTADO','=',1)
									->orderby('TXT_EMPR_BANCO','ASC')
								  	->get();



		return View::make('usuario/modal/ajax/mvercuentabancaria',
						 [		 	

						 	'cuentabancarias' 				=> $cuentabancarias,
						 	'idoc' 							=> $idoc,
						 	'idopcion' 						=> $idopcion,
						 	'ajax' 							=> true,						 	
						 ]);
	}



	public function actionCambiarCuentaCorriente($empresa_id,$banco_id,$nro_cuenta,$moneda_id,$idoc,$idopcion)
	{
		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa_id)
									->where('COD_EMPR_BANCO','=',$banco_id)
									->where('TXT_NRO_CUENTA_BANCARIA','=',$nro_cuenta)
									->where('COD_CATEGORIA_MONEDA','=',$moneda_id)
								  	->first();

		if(count($cuentabancarias)>0){


				$fe_documento   =    FeDocumento::where('ID_DOCUMENTO','=',$idoc)->first();


                FeDocumento::where('ID_DOCUMENTO',$idoc)
                            ->update(
                                [
                                    'COD_CATEGORIA_BANCO'=>$cuentabancarias->COD_EMPR_BANCO,
                                    'TXT_CATEGORIA_BANCO'=>$cuentabancarias->TXT_EMPR_BANCO,
                                    'TXT_NRO_CUENTA_BANCARIA'=>$cuentabancarias->TXT_NRO_CUENTA_BANCARIA,
                                    'CARNET_EXTRANJERIA'=>$cuentabancarias->CARNET_EXTRANJERIA
                                ]
                            );

                $documento                              =   new FeDocumentoHistorial;
                $documento->ID_DOCUMENTO                =   $fe_documento->ID_DOCUMENTO;
                $documento->DOCUMENTO_ITEM              =   $fe_documento->DOCUMENTO_ITEM;
                $documento->FECHA                       =   $this->fechaactual;
                $documento->USUARIO_ID                  =   Session::get('usuario')->id;
                $documento->USUARIO_NOMBRE              =   Session::get('usuario')->nombre;
                $documento->TIPO                        =   'CAMBIO DE CUENTA BANCARIA '.$fe_documento->TXT_NRO_CUENTA_BANCARIA.' POR '.$cuentabancarias->TXT_NRO_CUENTA_BANCARIA;
                $documento->MENSAJE                     =   '';
                $documento->save();


		}						  	



		return Redirect::to('gestion-de-entrega-documentos/'.$idopcion)->with('bienhecho', 'Se realizo la modificacion de la cuenta bancaria '.$idoc);


	}



	public function actionAjaxModalVerCuentaBancariaEstiba(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $empresa_id             =   $request['empresa_id'];
        $idoc                   =   $orden_id;

		$documento = DB::table('FE_DOCUMENTO')
		    ->where('ID_DOCUMENTO', $idoc)
		    ->first();

		$empresa = DB::table('STD.EMPRESA')
		    ->where('NRO_DOCUMENTO', $documento->RUC_PROVEEDOR)
		    ->where('COD_ESTADO', 1)
		    ->first();

		$cuentabancarias 		= 	TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresa->COD_EMPR)
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


	public function actionAjaxModalVerCuentaBancariaPG(Request $request)
	{

        $prefijo_id             =   $request['prefijo_id'];
        $orden_id               =   $request['orden_id'];
        $idoc                   =   $this->funciones->decodificarmaestraprefijo_contrato($idordencompra,$prefijo);
        $ordencompra            =   $this->con_lista_cabecera_comprobante_pg_idoc($idoc);
        $detalleordencompra     =   $this->con_lista_detalle_pg_comprobante_idoc($idoc);

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


	public function actionConfigurarDatosCuentaBancariaEstiba($empresa_id,$orden_id,$idopcion,Request $request)
	{

        $idoc                   					=   $orden_id;
		$banco_id 	 		 	 					= 	$request['banco_id'];
		$tipocuenta_id 	 		 					= 	$request['tipocuenta_id'];
		$moneda_id 	 		 						= 	$request['moneda_id'];
		$numerocuenta 	 		 					= 	$request['numerocuenta'];
		$numerocuentacci 	 		 				= 	$request['numerocuentacci'];
		$banco 										=	CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
		$tipocuenta 								=	CMPCategoria::where('COD_CATEGORIA','=',$tipocuenta_id)->first();
		$moneda 									=	CMPCategoria::where('COD_CATEGORIA','=',$moneda_id)->first();
		$empresa 									=	STDEmpresa::where('COD_EMPR','=',$empresa_id)->first();

		$documento = DB::table('FE_DOCUMENTO')
		    ->where('ID_DOCUMENTO', $idoc)
		    ->first();

		$empresaclie = DB::table('STD.EMPRESA')
		    ->where('NRO_DOCUMENTO', $documento->RUC_PROVEEDOR)
		    ->where('COD_ESTADO', 1)
		    ->first();


		$tescuentabb    							=   TESCuentaBancaria::where('COD_EMPR_TITULAR','=',$empresaclie->COD_EMPR)
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
		$cuentabancaria->COD_EMPR_TITULAR 			=   $empresaclie->COD_EMPR;
		$cuentabancaria->COD_EMPR_BANCO 			=   $banco->COD_CATEGORIA;
		$cuentabancaria->TXT_NRO_CUENTA_BANCARIA	=   $numerocuenta;
		$cuentabancaria->TXT_EMPR_TITULAR 			=   $empresaclie->NOM_EMPR;
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

	public function actionConfigurarDatosCuentaBancariaLiquidacionCompraAnticipo($prefijo_id,$orden_id,$idopcion,Request $request)
	{


        $idoc                   =   $this->funciones->decodificarmaestraprefijo($orden_id,$prefijo_id);        
        $ordencompra          	=   CMPDocumentoCtble::where('COD_DOCUMENTO_CTBLE','=',$idoc)->first();        

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
		$carnetextranjeria 	 		 				= 	$request['carnetextranjeria'];

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
		$cuentabancaria->CARNET_EXTRANJERIA 		=   $carnetextranjeria;
		$cuentabancaria->COD_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->TXT_CUENTA_CONTABLE 		=   '';
		$cuentabancaria->save();

		return Redirect::back()->withInput()->with('bienhecho', 'Cuenta Bancaria '.$numerocuenta.' registrada con éxito');


	}


	public function actionConfigurarDatosCuentaBancariaLQ($ID_DOCUMENTO,$idopcion,Request $request)
	{

        $idoc                   					=   $ID_DOCUMENTO;
        $ordencompra          						=   LqgLiquidacionGasto::where('ID_DOCUMENTO','=',$idoc)->first();

		$banco_id 	 		 	 					= 	$request['banco_id'];
		$tipocuenta_id 	 		 					= 	$request['tipocuenta_id'];
		$moneda_id 	 		 						= 	$request['moneda_id'];
		$numerocuenta 	 		 					= 	$request['numerocuenta'];
		$numerocuentacci 	 		 				= 	$request['numerocuentacci'];


		$banco 										=	CMPCategoria::where('COD_CATEGORIA','=',$banco_id)->first();
		$tipocuenta 								=	CMPCategoria::where('COD_CATEGORIA','=',$tipocuenta_id)->first();
		$moneda 									=	CMPCategoria::where('COD_CATEGORIA','=',$moneda_id)->first();
		$empresa 									=	STDEmpresa::where('COD_EMPR','=',$ordencompra->COD_EMPRESA_TRABAJADOR)->first();


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

    public function actionCorreoReparacionLevantada()
	{
		$this->envio_correo_reparacion_levantada();
	}


    public function actionCorreoAdminDic()
	{
		$this->envio_correo_admindic();
	}

    public function actionCorreoJefeAcopioDic()
	{
		$this->envio_correo_jefeacopiodic();
	}


    public function actionCorreoJefeAcopioLqc()
	{
		$this->envio_correo_jefeacopiolqc();
	}

    public function actionCorreoAdminLqc()
	{
		$this->envio_correo_adminlqc();
	}
    public function actionCorreoAprobado()
	{
		$this->envio_correo_aprobado();
	}
    public function actionCorreoAprobadoAdmin()
	{
		$this->envio_correo_aprobado_admin();
	}

    public function actionCrearExcelAprobadoAdmin()
	{
		$this->crear_excel_aporbado_admin();
	}


    public function actionCorreoTesoreriaLg()
	{
		$this->envio_correo_tesoreria_lq();
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




		//dd($listanegra);

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


		$listanegra = DB::table('LQG_DETLIQUIDACIONGASTO')
		    ->select([
		        'COD_USUARIO_AUTORIZA',
		        'TXT_USUARIO_AUTORIZA', 
		        'LQG_DETLIQUIDACIONGASTO.TXT_EMPRESA_PROVEEDOR'
		    ])
		    ->join('LQG_LIQUIDACION_GASTO', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO', '=', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO')
		    ->whereRaw('ISNULL(LQG_DETLIQUIDACIONGASTO.IND_TOTAL, 0) = 0')
		    ->where('LQG_DETLIQUIDACIONGASTO.COD_TIPODOCUMENTO', 'TDO0000000000001')
		    ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
		    ->whereNotIn('LQG_LIQUIDACION_GASTO.COD_ESTADO', ['ETM0000000000006', 'ETM0000000000001'])
		    ->where('LQG_DETLIQUIDACIONGASTO.BUSQUEDAD', '>=', 10)
		    ->where('LQG_DETLIQUIDACIONGASTO.USUARIO_CREA','=',Session::get('usuario')->id)
		    ->groupBy('COD_USUARIO_AUTORIZA')
		    ->groupBy('TXT_USUARIO_AUTORIZA')
		    ->groupBy('LQG_DETLIQUIDACIONGASTO.TXT_EMPRESA_PROVEEDOR')
		    ->orderBy('LQG_DETLIQUIDACIONGASTO.TXT_EMPRESA_PROVEEDOR', 'ASC')
		    ->get();

		if(count($listanegra)){
			Session::flash('listanegra', $listanegra);
		}

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
		$count_reparables_est 		= 	0;


		$count_reparables_rev 		= 	0;
		$count_reparables__revcon 	= 	0;

		$count_x_aprobar_gestion 	= 	0;
        $url_gestion 				=	'';

		$count_observados_con 		= 	0;
		$count_observados_est 		= 	0;
		$count_observados_dip 		= 	0;

        $url_obs_con 				=	'';


		$count_observadosoc_le 		= 	0;
		$count_observadosct_le 		= 	0;

       
		$trol 						=	WEBRol::where('id','=',Session::get('usuario')->rol_id)->first();

		$count_x_aprobar_con 				= 	0;
		$count_x_aprobar_gestion_con 		= 	0;
		$count_x_aprobar_gestion_est 		= 	0;


		//estibas
		$urlestiba 							=	'';
		$count_x_aprobar_est 				= 	0;
		$count_x_aprobar_gestion_est 		= 	0;
		$count_reparables_est 				= 	0;
        $url_rep_estiba 					=	'';
		$count_reparables__revest 			= 	0;
        $url_rep_estiba_revisar 			=	'';
		$count_observados_est 				= 	0;
		$count_observadosest_le 			= 	0;

		//dip
		$urldip 							=	'';
		$count_x_aprobar_dip 				= 	0;
		// $count_x_aprobar_gestion_est 		= 	0;
		$count_reparables_dip 				= 	0;
        $url_rep_dip 						=	'';
		$count_reparables__revdip 			= 	0;
        $url_rep_dip_revisar 				=	'';
		$count_observados_dip 				= 	0;
		$count_observadosdip_le 			= 	0;


		//dis
		$urldis 							=	'';
		$count_x_aprobar_dis 				= 	0;
		$count_reparables_dis 				= 	0;
        $url_rep_dis 						=	'';
		$count_reparables__revdis 			= 	0;
        $url_rep_dis_revisar 				=	'';
		$count_observados_dis 				= 	0;
		$count_observadosdis_le 			= 	0;


		//dib
		$urldib 							=	'';
		$count_x_aprobar_dib 				= 	0;
		$count_reparables_dib 				= 	0;
        $url_rep_dib 						=	'';
		$count_reparables__revdib 			= 	0;
        $url_rep_dib_revisar 				=	'';
		$count_observados_dib 				= 	0;
		$count_observadosdib_le 			= 	0;


		//lg
        $url_obs_lg 					    =	'';
		$urllg 								=	'';
		$count_x_aprobar_lg 				= 	0;
		$count_observados_lg 				= 	0;
		$count_observadoslg_le 				= 	0;

		//vl
		$urlvl 								=	'';
		$count_x_aprobar_vl				    = 	0;


		//renta
		$urlrenta 							=	'';
		$count_x_aprobar_renta 				= 	0;

		//documento interno compra
        $url_obs_dic 					    =	'';
		$urldic 							=	'';
		$count_x_aprobar_dic 				= 	0;
		$count_observados_dic				= 	0;
		$count_observadosdic_le 			= 	0;

		//liquidacion compra anticipo
        $url_obs_lqa 					    =	'';
		$urllqa 							=	'';
		$count_x_aprobar_lqa 				= 	0;
		$count_observados_lqa				= 	0;
		$count_observadoslqa_le 			= 	0;



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
			$operacion_id 			=	'ESTIBA';
        	$listadatosobest    	=   $this->con_lista_cabecera_comprobante_total_gestion_observados_estibas($cod_empresa,$operacion_id);
			$count_observados_est 	= 	count($listadatosobest);

        	$listadatosre_est    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
			$count_reparables_est 	= 	 count($listadatosre_est);


			$operacion_id 			=	'DOCUMENTO_INTERNO_PRODUCCION';
        	$listadatosre_dip    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
			$count_reparables_dip 	= 	 count($listadatosre_dip);

        	$listadatosobdip    	=   $this->con_lista_cabecera_comprobante_total_gestion_observados_estibas($cod_empresa,$operacion_id);
			$count_observados_dip 	= 	count($listadatosobdip);


			$operacion_id 			=	'DOCUMENTO_INTERNO_SECADO';
        	$listadatosre_dis    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
			$count_reparables_dis 	= 	 count($listadatosre_dis);

        	$listadatosobdis    	=   $this->con_lista_cabecera_comprobante_total_gestion_observados_estibas($cod_empresa,$operacion_id);
			$count_observados_dis 	= 	count($listadatosobdis);


			$operacion_id 			=	'DOCUMENTO_SERVICIO_BALANZA';
        	$listadatosre_dib    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
			$count_reparables_dib 	= 	 count($listadatosre_dib);

        	$listadatosobdib    	=   $this->con_lista_cabecera_comprobante_total_gestion_observados_estibas($cod_empresa,$operacion_id);
			$count_observados_dib 	= 	count($listadatosobdib);


			//LIQUIDACION DE GASTOS
        	$url_obs_lg 		 	=	'/gestion-de-liquidacion-gastos/oQK';
        	$listadatosoblg    		=    LqgLiquidacionGasto::where('ACTIVO','=','1')
		                                ->where('USUARIO_CREA','=',Session::get('usuario')->id)
		                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
		                                ->where('IND_OBSERVACION','=',1)
		                                ->get();
			$count_observados_lg 	= 	count($listadatosoblg);




		}
		else{
			//CONTABILIDAD
			if(Session::get('usuario')->rol_id == '1CIX00000015' || Session::get('usuario')->rol_id == '1CIX00000016'){


        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont($cod_empresa);
				$count_x_aprobar 		= 	 count($listadatos);

	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_obs($cod_empresa);
				$count_observados 		= 	count($listadatosob);

	        	$listadatosoble    		=   $this->con_lista_cabecera_comprobante_total_cont_obs_levantadas($cod_empresa);
				$count_observadosoc_le 	= 	count($listadatosoble);

    			$url 					=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=ORDEN_COMPRA';
    			$urlcontrato 			=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=CONTRATO';
    			$urlestiba 				=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=ESTIBA';
    			$urldip 				=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=DOCUMENTO_INTERNO_PRODUCCION';
    			$urldis 				=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=DOCUMENTO_INTERNO_SECADO';
    			$urldib 				=	'/gestion-de-contabilidad-aprobar/g56?operacion_id=DOCUMENTO_SERVICIO_BALANZA';



        		$url_rep 		 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=ORDEN_COMPRA';
        		$url_rep_contrato 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=CONTRATO';
        		$url_rep_estiba 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=ESTIBA';
        		$url_rep_dip 			=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=DOCUMENTO_INTERNO_PRODUCCION';
        		$url_rep_dis 			=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=DOCUMENTO_INTERNO_SECADO';
        		$url_rep_dib 			=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=DOCUMENTO_SERVICIO_BALANZA';



        		$url_rep_revisar 		 	=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=ORDEN_COMPRA&estado_id=2';
        		$url_rep_contrato_revisar 	=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=CONTRATO&estado_id=2';
        		$url_rep_estiba_revisar 	=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=ESTIBA&estado_id=2';
        		$url_rep_dip_revisar 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=DOCUMENTO_INTERNO_PRODUCCION&estado_id=2';
        		$url_rep_dis_revisar 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=DOCUMENTO_INTERNO_SECADO&estado_id=2';
        		$url_rep_dib_revisar 		=	'/gestion-de-comprobantes-reparable/Elk?operacion_id=DOCUMENTO_SERVICIO_BALANZA&estado_id=2';



    			$urllg 					=	'/gestion-de-aprobacion-liquidacion-gastos-contabilidad/xvr';
    			$urlrenta				=	'/gestion-de-aprobar-cuarta-categoria/YWp';
				$listadatos  			= 	$this->pla_lista_renta_cuarta_categoria_contabilidad();
				$count_x_aprobar_renta 	= 	 count($listadatos);

        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont_contrato($cod_empresa);
				$count_x_aprobar_con 	= 	 count($listadatos);

	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_contrato_obs($cod_empresa);
				$count_observados_con 	= 	count($listadatosob);

	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_contrato_levantadas($cod_empresa);
				$count_observadosct_le 	= 	count($listadatosob);


	        	$listadatosre    		=   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,'TODO','TODO');
				$count_reparables 		= 	 count($listadatosre);

	        	$listadatosre_con    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,'TODO','TODO');
				$count_reparables_con 	= 	 count($listadatosre_con);


	        	$listadatosrerev    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable($cod_empresa,'TODO','2');
				$count_reparables_rev 	= 	 count($listadatosrerev);

	        	$listadatosre_con_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_contrato($cod_empresa,'TODO','2');
				$count_reparables__revcon = 	 count($listadatosre_con_rev);

				//estibas
				$operacion_id 			=	'ESTIBA';
        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa,$operacion_id);
				$count_x_aprobar_est 	= 	 count($listadatos);
	        	$listadatosre_est    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
				$count_reparables_est 	= 	 count($listadatosre_est);
	        	$listadatosre_est_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
				$count_reparables__revest = 	 count($listadatosre_est_rev);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa,$operacion_id);
				$count_observados_est 	= 	count($listadatosob);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa,$operacion_id);
				$count_observadosest_le 	= 	count($listadatosob);

				//DOCUMENTO_INTERNO_PRODUCCION
				$operacion_id 			=	'DOCUMENTO_INTERNO_PRODUCCION';
        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa,$operacion_id);
				$count_x_aprobar_dip 	= 	 count($listadatos);
	        	$listadatosre_dip    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
				$count_reparables_dip 	= 	 count($listadatosre_dip);
	        	$listadatosre_dip_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
				$count_reparables__revdip = 	 count($listadatosre_dip_rev);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa,$operacion_id);
				$count_observados_dip 	= 	count($listadatosob);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa,$operacion_id);
				$count_observadosdip_le	= 	count($listadatosob);


				//DOCUMENTO_INTERNO_SECADO
				$operacion_id 			=	'DOCUMENTO_INTERNO_SECADO';
        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa,$operacion_id);
				$count_x_aprobar_dis 	= 	 count($listadatos);
	        	$listadatosre_dis    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
				$count_reparables_dis 	= 	 count($listadatosre_dis);
	        	$listadatosre_dis_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
				$count_reparables__revdis = 	 count($listadatosre_dis_rev);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa,$operacion_id);
				$count_observados_dis 	= 	count($listadatosob);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa,$operacion_id);
				$count_observadosdis_le	= 	count($listadatosob);

				//DOCUMENTO_INTERNO_SECADO
				$operacion_id 			=	'DOCUMENTO_SERVICIO_BALANZA';
        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_cont_estiba($cod_empresa,$operacion_id);
				$count_x_aprobar_dib 	= 	 count($listadatos);
	        	$listadatosre_dib    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
				$count_reparables_dib 	= 	 count($listadatosre_dib);
	        	$listadatosre_dib_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
				$count_reparables__revdib = 	 count($listadatosre_dib_rev);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_obs($cod_empresa,$operacion_id);
				$count_observados_dib 	= 	count($listadatosob);
	        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_cont_estiba_levantadas($cod_empresa,$operacion_id);
				$count_observadosdib_le	= 	count($listadatosob);


				//LIQUIDACION DE GASTOS
        		$listadatos     		=   $this->lg_lista_cabecera_comprobante_total_contabilidad();
				$count_x_aprobar_lg 	= 	count($listadatos);
	        	$listadatosob    		=   $this->lg_lista_cabecera_comprobante_total_obs_contabilidad();
				$count_observados_lg 	= 	count($listadatosob);
	        	$listadatosob    		=   $this->lg_lista_cabecera_comprobante_total_obs_le_contabilidad();
				$count_observadoslg_le	= 	count($listadatosob);

			}
			//ADMINISTRACION
			else{
				if (in_array(Session::get('usuario')->rol_id, ['1CIX00000020', '1CIX00000033', '1CIX00000035'])) {

        			$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm($cod_empresa);
					$count_x_aprobar 		= 	count($listadatos);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_obs($cod_empresa);
					$count_observados 		= 	count($listadatosob);

	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_contrato($cod_empresa);
					$count_x_aprobar_con 	= 	 count($listadatos);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs($cod_empresa);
					$count_observados_con 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_contrato_obs_levantadas($cod_empresa);
					$count_observadosct_le 	= 	count($listadatosob);

        			$url 					=	'/gestion-de-administracion-aprobar/j25?operacion_id=ORDEN_COMPRA';
        			$urlcontrato 			=	'/gestion-de-administracion-aprobar/j25?operacion_id=CONTRATO';
        			$urlestiba 				=	'/gestion-de-administracion-aprobar/j25?operacion_id=ESTIBA';
    				$urldip 				=	'/gestion-de-administracion-aprobar/j25?operacion_id=DOCUMENTO_INTERNO_PRODUCCION';
    				$urldis 				=	'/gestion-de-administracion-aprobar/j25?operacion_id=DOCUMENTO_INTERNO_SECADO';
    				$urldib 				=	'/gestion-de-administracion-aprobar/j25?operacion_id=DOCUMENTO_SERVICIO_BALANZA';
    				$urllg 					=	'/gestion-de-aprobacion-liquidacion-gastos-administracion/rR6';
    				$urlvl					=	'/gestion-aprueba-rendir/APz';

    				//documento interno compra
    				$urldic 				=	'/gestion-de-administracion-aprobar/j25?operacion_id=DOCUMENTO_INTERNO_COMPRA';

    				//documento interno compra
    				$urllqa 				=	'/gestion-de-administracion-aprobar/j25?operacion_id=LIQUIDACION_COMPRA_ANTICIPO';

					//ESTIBA
					$operacion_id 			=	'ESTIBA';
	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
					$count_x_aprobar_est 	= 	 count($listadatos);

		        	$listadatosre_est    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
					$count_reparables_est 	= 	 count($listadatosre_est);

		        	$listadatosre_est_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
					$count_reparables__revest = 	 count($listadatosre_est_rev);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
					$count_observados_est 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
					$count_observadosest_le 	= 	count($listadatosob);


					$operacion_id 			=	'DOCUMENTO_INTERNO_PRODUCCION';
	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
					$count_x_aprobar_dip 	= 	 count($listadatos);

		        	$listadatosre_dip    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
					$count_reparables_dip 	= 	 count($listadatosre_dip);

		        	$listadatosre_dip_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
					$count_reparables__revdip = 	 count($listadatosre_dip_rev);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
					$count_observados_dip 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
					$count_observadosdip_le 	= 	count($listadatosob);


					$operacion_id 			=	'DOCUMENTO_INTERNO_SECADO';
	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
					$count_x_aprobar_dis 	= 	 count($listadatos);

		        	$listadatosre_dis    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
					$count_reparables_dis 	= 	 count($listadatosre_dis);

		        	$listadatosre_dis_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
					$count_reparables__revdis = 	 count($listadatosre_dis_rev);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
					$count_observados_dis 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
					$count_observadosdis_le 	= 	count($listadatosob);


					$operacion_id 			=	'DOCUMENTO_SERVICIO_BALANZA';
	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
					$count_x_aprobar_dib 	= 	 count($listadatos);

		        	$listadatosre_dib    	=   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','TODO',$operacion_id);
					$count_reparables_dib 	= 	 count($listadatosre_dib);

		        	$listadatosre_dib_rev   =   $this->con_lista_cabecera_comprobante_total_gestion_reparable_estiba($cod_empresa,'TODO','2',$operacion_id);
					$count_reparables__revdib = 	 count($listadatosre_dib_rev);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
					$count_observados_dib 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
					$count_observadosdib_le 	= 	count($listadatosob);

					//LIQUIDACION DE GASTOS
	        		$listadatos     		=   $this->lg_lista_cabecera_comprobante_total_administracion();
					$count_x_aprobar_lg 	= 	count($listadatos);
		        	$listadatosob    		=   $this->lg_lista_cabecera_comprobante_total_obs_administracion();
					$count_observados_lg 	= 	count($listadatosob);
		        	$listadatosob    		=   $this->lg_lista_cabecera_comprobante_total_obs_le_administracion();
					$count_observadoslg_le	= 	count($listadatosob);


					//DOCUMENTO INTERNO COMPRA
					$operacion_id 			=	'DOCUMENTO_INTERNO_COMPRA';
	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
					$count_x_aprobar_dic 	= 	 count($listadatos);

		        	$lisadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
					$count_observados_dic 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
					$count_observadosdic_le 	= 	count($listadatosob);


					//LIQUIDACION DE OMPRA ANTIPIO
					$operacion_id 			=	'LIQUIDACION_COMPRA_ANTICIPO';
	        		$listadatos     		=   $this->con_lista_cabecera_comprobante_total_adm_estiba($cod_empresa,$operacion_id);
					$count_x_aprobar_lqa 	= 	 count($listadatos);

		        	$lisadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs($cod_empresa,$operacion_id);
					$count_observados_lqa 	= 	count($listadatosob);

		        	$listadatosob    		=   $this->con_lista_cabecera_comprobante_total_adm_estiba_obs_levantadas($cod_empresa,$operacion_id);
					$count_observadoslqa_le 	= 	count($listadatosob);


					//VALE
					$listadatos             = $this->listaValeRendirAprueba(
												    'GEN',   
												    '',      
												    '',      
												    '',      
												    '',      
												    '',      
												    '',      
												    '',      
												    0,       
												    0,       
												    ''       
												);

												$listadatos = array_filter($listadatos, function ($vale) {
											    $estado = is_array($vale)
											        ? trim($vale['COD_CATEGORIA_ESTADO_VALE'] ?? '')
											        : trim($vale->COD_CATEGORIA_ESTADO_VALE ?? '');

											    return $estado === 'ETM0000000000005';
												});
					$listadatos 			= array_values($listadatos);
					$count_x_aprobar_vl		= count($listadatos);





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


		return View::make('bienvenido',
						 [
						 	'usuario' 					=> $usuario,

						 	'count_observados_est' 		=> $count_observados_est,
						 	'count_x_aprobar_est' 		=> $count_x_aprobar_est,
						 	'count_x_aprobar_dip' 		=> $count_x_aprobar_dip,

						 	'count_x_aprobar_dic' 		=> $count_x_aprobar_dic,
						 	'count_observados_dic' 		=> $count_observados_dic,
						 	'count_observadosdic_le' 	=> $count_observadosdic_le,
						 	'urldic' 					=> $urldic,


						 	'count_x_aprobar_lqa' 		=> $count_x_aprobar_lqa,
						 	'count_observados_lqa' 		=> $count_observados_lqa,
						 	'count_observadoslqa_le' 	=> $count_observadoslqa_le,
						 	'urllqa' 					=> $urllqa,



						 	'urlestiba' 				=> $urlestiba,
						 	'count_reparables_est' 		=> $count_reparables_est,
						 	'url_rep_estiba' 			=> $url_rep_estiba,
						 	'count_reparables__revest' 	=> $count_reparables__revest,
						 	'url_rep_estiba_revisar' 	=> $url_rep_estiba_revisar,
						 	'count_observados_est' 		=> $count_observados_est,
						 	'count_observadosest_le' 	=> $count_observadosest_le,
						 	'count_reparables_est' 		=> $count_reparables_est,

						 	'url_obs_lg' 				=> $url_obs_lg,
						 	'urllg' 					=> $urllg,
						 	'count_x_aprobar_lg' 		=> $count_x_aprobar_lg,
						 	'count_observados_lg' 		=> $count_observados_lg,
						 	'count_observadoslg_le' 	=> $count_observadoslg_le,

						 	'urlrenta' 					=> $urlrenta,
						 	'count_x_aprobar_renta' 	=> $count_x_aprobar_renta,


						 	'urlvl' 					=> $urlvl,
						 	'count_x_aprobar_vl' 		=> $count_x_aprobar_vl,

						 	

						 	'urldip' 					=> $urldip,
						 	'count_reparables_dip' 		=> $count_reparables_dip,
						 	'url_rep_dip' 				=> $url_rep_dip,
						 	'url_rep_dip_revisar' 		=> $url_rep_dip_revisar,
						 	'count_reparables__revdip' 	=> $count_reparables__revdip,
						 	'count_observados_dip' 		=> $count_observados_dip,
						 	'count_observadosdip_le' 	=> $count_observadosdip_le,



						 	'urldis' 					=> $urldis,
						 	'count_reparables_dis' 		=> $count_reparables_dis,
						 	'url_rep_dis' 				=> $url_rep_dis,
						 	'url_rep_dis_revisar' 		=> $url_rep_dis_revisar,
						 	'count_reparables__revdis' 	=> $count_reparables__revdis,
						 	'count_observados_dis' 		=> $count_observados_dis,
						 	'count_observadosdis_le' 	=> $count_observadosdis_le,
						 	'count_x_aprobar_dis' 		=> $count_x_aprobar_dis,

						 	'urldib' 					=> $urldib,
						 	'count_reparables_dib' 		=> $count_reparables_dib,
						 	'url_rep_dib' 				=> $url_rep_dib,
						 	'url_rep_dib_revisar' 		=> $url_rep_dib_revisar,
						 	'count_reparables__revdib' 	=> $count_reparables__revdib,
						 	'count_observados_dib' 		=> $count_observados_dib,
						 	'count_observadosdib_le' 	=> $count_observadosdib_le,
						 	'count_x_aprobar_dib' 		=> $count_x_aprobar_dib,



						 	'cuentabancarias' 			=> $cuentabancarias,
						 	'fecha' 					=> $fecha,
						 	'count_x_aprobar' 			=> $count_x_aprobar,
						 	'url' 						=> $url,
						 	'urlcontrato' 				=> $urlcontrato,
						 	'count_observados' 			=> $count_observados,
						 	'url_obs' 					=> $url_obs,
						 	'count_observadosoc_le' 	=> $count_observadosoc_le,
						 	'count_observadosct_le' 	=> $count_observadosct_le,
						 	'count_reparables' 			=> $count_reparables,
						 	'count_reparables_con' 		=> $count_reparables_con,
						 	'url_rep' 					=> $url_rep,
						 	'url_rep_contrato' 			=> $url_rep_contrato,
						 	'url_rep_revisar' 			=> $url_rep_revisar,
						 	'url_rep_contrato_revisar' 	=> $url_rep_contrato_revisar,
						 	'count_reparables_rev' 		=> $count_reparables_rev,
						 	'count_reparables__revcon' 	=> $count_reparables__revcon,
						 	'count_x_aprobar_gestion' 	=> $count_x_aprobar_gestion,
						 	'url_gestion' 				=> $url_gestion,
						 	'trol' 						=> $trol,
						 	'listaocpendientes' 		=> $listaocpendientes,
						 	'listaocpendientes_con' 	=> $listaocpendientes_con,
						 	'listadocestados'   		=> $listadocestados,
						 	'listadocestados_con'   	=> $listadocestados_con,
						 	'listaobservados'   		=> $listaobservados,
						 	'count_x_aprobar_con' 		=> $count_x_aprobar_con,
						 	'count_observados_con'   	=> $count_observados_con,
						 	'url_obs_con'   			=> $url_obs_con,
						 	'count_x_aprobar_gestion_con'   => $count_x_aprobar_gestion_con
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

	public function actionListarTerceros($idopcion)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Ver');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
        $array_rols     = 	WEBRol::where('ind_merge','=',1)
                         	->pluck('id')
                         	->toArray();

	    $listaterceros  = 	Tercero::orderBy('FECHA_CREA', 'DESC')
	    					->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
	    					->get();

		return View::make('usuario/listaterceros',
						 [
						 	'listaterceros' => $listaterceros,
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
			$usuario 	= 	User::where('name', $request['name'])->first();  
			if(count($usuario)>0){
				return Redirect::back()->withInput()->with('errorbd', 'Este usuario con ese name ya esta registrado');
			}

			$personal_id 	 		 	= 	$request['personal'];
			$personal     				=   WEBListaPersonal::where('id', '=', $personal_id)->first();
			//dd($personal);

			$idusers 				 	=   $this->funciones->getCreateIdMaestra('users');
			
			$cabecera            	 	=	new User;
			$cabecera->id 	     	 	=   $idusers;
			$cabecera->nombre 	     	=   $personal->nombres;
			$cabecera->name  		 	=	$request['name'];
			$cabecera->passwordmobil  	=	$request['password'];
			$cabecera->fecha_crea 	   	=  	$this->fechaactual;
			$cabecera->password 	 	= 	Crypt::encrypt($request['password']);
			$cabecera->ind_confirmacion	= 	1;
			$cabecera->ind_contacto 	= 	1;	
			$cabecera->email_confirmacion 	= 	1;
			$cabecera->rol_id 	 		= 	$request['rol_id'];
			$cabecera->usuarioosiris_id	= 	$personal->id;
			$cabecera->save();
 
 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$personal->COD_EMPR.' registrado con exito');

		}else{


			// $listapersonal 				= 	DB::table('STD.EMPRESA')
	    	// 								->leftJoin('users', 'STD.EMPRESA.COD_EMPR', '=', 'users.usuarioosiris_id')
	    	// 								->whereNull('users.usuarioosiris_id')
	    	// 								->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
	    	// 								->where('STD.EMPRESA.COD_ESTADO','=',1)
	    	// 								->select('STD.EMPRESA.COD_EMPR','STD.EMPRESA.NOM_EMPR')
			// 								->select(DB::raw("
			// 								  STD.EMPRESA.COD_EMPR,
			// 								  STD.EMPRESA.NRO_DOCUMENTO + ' - '+ STD.EMPRESA.NOM_EMPR AS NOMBRE")
			// 								)
			// 								->pluck('NOMBRE','NOMBRE')
			// 								->take(10)
			// 								->toArray();
			$listapersonal 				= 	DB::table('WEB.LISTAPERSONAL')
	    									->leftJoin('users', 'WEB.LISTAPERSONAL.id', '=', 'users.usuarioosiris_id')
	    									->whereNull('users.usuarioosiris_id')
	    									->select('WEB.LISTAPERSONAL.id','WEB.LISTAPERSONAL.nombres')
	    									->get();

			//$combolistaclientes  		= 	array('' => "Seleccione clientes") + $listapersonal;


			$rol 						= 	DB::table('WEB.Rols')->where('ind_merge','=',1)->where('id','<>',$this->prefijomaestro.'00000001')->pluck('nombre','id')->toArray();
			$comborol  					= 	array('' => "Seleccione Rol") + $rol;
		
			return View::make('usuario/agregarusuario',
						[
							'comborol'  		=> $comborol,
							'listapersonal'  	=> $listapersonal,
							//'combolistaclientes'  	=> $combolistaclientes,				
						  	'idopcion'  		=> $idopcion
						]);
		}
	}
	public function actionAgregarTercero($idopcion,Request $request)
	{
		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Anadir');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/

		if($_POST)
		{

            try {

                DB::beginTransaction();

				$usuario 	= 	User::where('name', $request['name'])->first();  
				if(count($usuario)>0){
					return Redirect::back()->withInput()->with('errorbd', 'Este usuario con ese name ya esta registrado');
				}

				$personal_id 	 		 	= 	$request['personal'];
				$personal     				=   WEBListaPersonal::where('id', '=', $personal_id)->first();
				$trabajador 				= 	DB::table('STD.TRABAJADOR')->where('COD_TRAB','=',$personal->id)->first();
				$idusers 				 	=   $this->funciones->getCreateIdMaestra('users');


		        $area              			=   DB::table('CON.CENTRO_COSTO')
								                ->where('COD_CENTRO_COSTO','=', $request['area_id'])
		                                        ->select(DB::raw("
		                                          	COD_CENTRO_COSTO,
		                                          	TXT_NOMBRE")
		                                        )->first();


		        $empresa              		=   DB::table('STD.EMPRESA')
		                                        ->where('COD_EMPR','=',$request['empresa_id'])
		                                        ->select(DB::raw("
		                                          STD.EMPRESA.COD_EMPR,
		                                          STD.EMPRESA.NOM_EMPR")
		                                        )->first();


		        $centro              		=   DB::table('ALM.CENTRO')
		                                        ->where('COD_CENTRO','=',$request['centro_id'])
		                                        ->select(DB::raw("
		                                          	COD_CENTRO,
		                                          	NOM_CENTRO")
		                                        )->first();
	        	$banco    					=   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->WHERE('COD_CATEGORIA','=',$request['banco_id'])->first();

				$tercero            	 	=	new Tercero;
				$tercero->DNI 	     	 	=   $trabajador->NRO_DOCUMENTO;
				$tercero->USER_ID 	     	=   $idusers;
				$tercero->NOMBRE  		 	=	$personal->nombres;
				$tercero->COD_AREA  		=	$area->COD_CENTRO_COSTO;
				$tercero->TXT_AREA 	   		=  	$area->TXT_NOMBRE;
				$tercero->COD_EMPRESA  		=	$empresa->COD_EMPR;
				$tercero->TXT_EMPRESA 	   	=  	$empresa->NOM_EMPR;
				$tercero->COD_CENTRO  		=	$centro->COD_CENTRO;
				$tercero->TXT_CENTRO 	   	=  	$centro->NOM_CENTRO;
				$tercero->COD_CENTRO  		=	$centro->COD_CENTRO;
				$tercero->COD_BANCO  		=	$banco->COD_CATEGORIA;
				$tercero->TXT_BANCO  		=	$banco->NOM_CATEGORIA;
				$tercero->TXT_CUENTA_CORRIENTE =	$request['cuenta_bancaria'];
	            $tercero->FECHA_CREA 		= 	$this->fechaactual;
	            $tercero->USUARIO_CREA 		= 	Session::get('usuario')->id;
				$tercero->save();


				$cabecera            	 	=	new User;
				$cabecera->id 	     	 	=   $idusers;
				$cabecera->nombre 	     	=   $personal->nombres;
				$cabecera->name  		 	=	$request['name'];
				$cabecera->passwordmobil  	=	$request['password'];
				$cabecera->fecha_crea 	   	=  	$this->fechaactual;
				$cabecera->password 	 	= 	Crypt::encrypt($request['password']);
				$cabecera->ind_confirmacion	= 	1;
				$cabecera->ind_contacto 	= 	1;	
				$cabecera->email_confirmacion 	= 	1;
				$cabecera->rol_id 	 		= 	$request['rol_id'];
				$cabecera->usuarioosiris_id	= 	$personal->id;
				$cabecera->save();



				$id 						= 	$this->funciones->getCreateIdMaestra('WEB.userempresacentros');
			    $detalle            		=	new WEBUserEmpresaCentro;
			    $detalle->id 	    		=  	$id;
				$detalle->empresa_id 		= 	'IACHEM0000010394';
				$detalle->centro_id    		=  	$centro->COD_CENTRO;
				$detalle->fecha_crea 	 	= 	$this->fechaactual;
				$detalle->usuario_id    	=  	$idusers;
				$detalle->save();
				$id 						= 	$this->funciones->getCreateIdMaestra('WEB.userempresacentros');
			    $detalle            		=	new WEBUserEmpresaCentro;
			    $detalle->id 	    		=  	$id;
				$detalle->empresa_id 		= 	'IACHEM0000007086';
				$detalle->centro_id    		=  	$centro->COD_CENTRO;
				$detalle->fecha_crea 	 	= 	$this->fechaactual;
				$detalle->usuario_id    	=  	$idusers;
				$detalle->save();


 
                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-registros-terceros/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }

 			return Redirect::to('/gestion-de-registros-terceros/'.$idopcion)->with('bienhecho', 'Tercero '.$personal->nombres.' registrado con exito');

		}else{


            $arraydni    				=   DB::table('WEB.platrabajadores')
		                                    ->where('situacion_id', 'PRMAECEN000000000002')
		                                    //->where('dni','=','41277717')
	                                        ->pluck('dni')
	                                        ->toArray();

            $arraytrabajadores    		=   DB::table('STD.TRABAJADOR')
		                                    ->whereIn('NRO_DOCUMENTO',$arraydni)
	                                        ->pluck('COD_TRAB')
	                                        ->toArray();


			$listapersonal 				= 	DB::table('WEB.LISTAPERSONAL_TER')
	    									->leftJoin('users', 'WEB.LISTAPERSONAL_TER.id', '=', 'users.usuarioosiris_id')
	    									->whereNull('users.usuarioosiris_id')
	    									->whereNotIn('WEB.LISTAPERSONAL_TER.id',$arraytrabajadores)
	    									->where('WEB.LISTAPERSONAL_TER.id','not like','JVE%')
	    									->select('WEB.LISTAPERSONAL_TER.id','WEB.LISTAPERSONAL_TER.nombres','WEB.LISTAPERSONAL_TER.COD_USUARIO')
	    									->get();

			$rol 						= 	DB::table('WEB.Rols')->where('ind_merge','=',1)->where('id','=','1CIX00000048')->pluck('nombre','id')->toArray();


	        $listaempresa              =   DB::table('STD.EMPRESA')
	                                        ->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
	                                        ->where('STD.EMPRESA.COD_ESTADO','=',1)
	                                        ->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
	                                        ->whereIn('STD.EMPRESA.COD_EMPR',['IACHEM0000010394', 'IACHEM0000007086'])
	                                        ->select(DB::raw("
	                                          STD.EMPRESA.COD_EMPR,
	                                          STD.EMPRESA.NOM_EMPR AS NOMBRE")
	                                        )
	                                        ->pluck('NOMBRE','COD_EMPR')
	                                        ->toArray();

	        $combo_empresa              =   array('' => "Seleccione empresa") + $listaempresa;
	        $empresa_id 				=	'';


	        $listacentro              	=   DB::table('ALM.CENTRO')
	                                        ->where('COD_ESTADO','=',1)
	                                        ->select(DB::raw("
	                                          	COD_CENTRO,
	                                          	NOM_CENTRO AS NOMBRE")
	                                        )
	                                        ->pluck('NOMBRE','COD_CENTRO')
	                                        ->toArray();

	        $combo_centro               =   array('' => "Seleccione centro") + $listacentro;
	        $centro_id 					=	'';


	        $listaarea              	=   DB::table('CON.CENTRO_COSTO')
							                ->where('COD_ESTADO', 1)
							                ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
							                ->where('IND_MOVIMIENTO', 1)
	                                        ->select(DB::raw("
	                                          	COD_CENTRO_COSTO,
	                                          	TXT_NOMBRE AS NOMBRE")
	                                        )
	                                        ->pluck('NOMBRE','COD_CENTRO_COSTO')
	                                        ->toArray();

	        $combo_area               	=   array('' => "Seleccione area") + $listaarea;
	        $area_id 					=	'';

			$comborol  					= 	array('' => "Seleccione Rol") + $rol;


	        $banco_id       			=   'BAM0000000000001';
	        $arraybancos    			=   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
	        $combobancos    			=   array('' => "Seleccione Entidad Bancaria") + $arraybancos;

		
			return View::make('usuario/agregartercero',
						[
							'comborol'  		=> $comborol,
							'combo_empresa'  	=> $combo_empresa,
							'empresa_id'  		=> $empresa_id,
							'banco_id'  		=> $banco_id,
							'combobancos'  		=> $combobancos,

							'combo_centro'  	=> $combo_centro,
							'centro_id'  		=> $centro_id,
							'combo_area'  		=> $combo_area,
							'area_id'  			=> $area_id,
							'listapersonal'  	=> $listapersonal,			
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
			$cabecera->ind_confirmacion	= 	1;
			$cabecera->ind_contacto 	= 	1;
			$cabecera->email_confirmacion 	= 	1;


			$cabecera->save();


 			return Redirect::to('/gestion-de-usuarios/'.$idopcion)->with('bienhecho', 'Usuario '.$request['nombre'].' modificado con exito');


		}else{


				$usuario 	= 	User::where('id', $idusuario)->first();  
				$rol 		= 	DB::table('WEB.Rols')->where('id','<>',$this->prefijomaestro.'00000001')->pluck('nombre','id')->toArray();
				$comborol  	= 	array($usuario->rol_id => $usuario->rol->nombre) + $rol;
				$centros 	= 	ALMCentro::where('COD_ESTADO','=','1')->get(); 
				$empresas 	= 	STDEmpresa::where('COD_ESTADO','=','1')->where('IND_SISTEMA','=','1')->get(); 
				$funcion 	= 	$this;	

		        return View::make('usuario/modificarusuario', 
		        				[
		        					'usuario'  		=> $usuario,
		        					'empresas'  	=> $empresas,
		        					'centros'  		=> $centros,
									'comborol' 		=> $comborol,
						  			'idopcion' 		=> $idopcion,
									'funcion' 		=> $funcion,
		        				]);
		}
	}

	public function actionModificarTercero($idopcion,$idusuario,Request $request)
	{

		/******************* validar url **********************/
		$validarurl = $this->funciones->getUrl($idopcion,'Modificar');
	    if($validarurl <> 'true'){return $validarurl;}
	    /******************************************************/
	    $idusuario = $this->funciones->decodificarmaestratercero($idusuario);

		if($_POST)
		{
            try {

                DB::beginTransaction();


					$tercero 					= 	Tercero::where('DNI', $idusuario)->first();
					$usuario 					= 	User::where('id', $tercero->USER_ID)->first(); 

			        $area              			=   DB::table('CON.CENTRO_COSTO')
									                ->where('COD_CENTRO_COSTO','=', $request['area_id'])
			                                        ->select(DB::raw("
			                                          	COD_CENTRO_COSTO,
			                                          	TXT_NOMBRE")
			                                        )->first();


			        $empresa              		=   DB::table('STD.EMPRESA')
			                                        ->where('COD_EMPR','=',$request['empresa_id'])
			                                        ->select(DB::raw("
			                                          STD.EMPRESA.COD_EMPR,
			                                          STD.EMPRESA.NOM_EMPR")
			                                        )->first();


			        $centro              		=   DB::table('ALM.CENTRO')
			                                        ->where('COD_CENTRO','=',$request['centro_id'])
			                                        ->select(DB::raw("
			                                          	COD_CENTRO,
			                                          	NOM_CENTRO")
			                                        )->first();
	        	$banco    					=   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->WHERE('COD_CATEGORIA','=',$request['banco_id'])->first();


			        Tercero::where('DNI', $idusuario)
			            ->update(
			                [
			                    'ACTIVO' => $request['activo'],
			                    'COD_AREA' => $area->COD_CENTRO_COSTO,
			                    'TXT_AREA' => $area->TXT_NOMBRE,
			                    'COD_EMPRESA' => $empresa->COD_EMPR,
			                    'TXT_EMPRESA' => $empresa->NOM_EMPR,
			                    'COD_CENTRO' => $centro->COD_CENTRO,
			                    'TXT_CENTRO' => $centro->NOM_CENTRO,
			                    'TXT_CUENTA_CORRIENTE' => $request['cuenta_bancaria'],
			                    'TXT_BANCO' => $banco->NOM_CATEGORIA,
			                    'COD_BANCO' => $banco->COD_CATEGORIA,
			                    'FECHA_MOD' => $this->fechaactual,
			                    'USUARIO_MOD' => Session::get('usuario')->id
			                ]
			            );

					$cabecera            	 =	User::find($usuario->id);			
					$cabecera->name  		 =	$request['name'];
					$cabecera->passwordmobil =	$request['password'];
					$cabecera->fecha_mod 	 =  $this->fechaactual;
					$cabecera->password 	 = 	Crypt::encrypt($request['password']);
					$cabecera->activo 	 	 =  $request['activo'];			
					$cabecera->rol_id 	 	 = 	$request['rol_id']; 
					$cabecera->ind_confirmacion	= 	1;
					$cabecera->ind_contacto 	= 	1;
					$cabecera->email_confirmacion 	= 	1;
					$cabecera->save();

                DB::commit();
            } catch (\Exception $ex) {
                DB::rollback();
                return Redirect::to('/gestion-de-registros-terceros/' . $idopcion)->with('errorbd', $ex . ' Ocurrio un error inesperado');
            }
 			return Redirect::to('/gestion-de-registros-terceros/'.$idopcion)->with('bienhecho', 'Tercero '.$request['nombre'].' modificado con exito');


		}else{


				$tercero 					= 	Tercero::where('DNI', $idusuario)->first();
				$usuario 					= 	User::where('id', $tercero->USER_ID)->first();  
				$rol 						= 	DB::table('WEB.Rols')->where('id','=','1CIX00000048')->pluck('nombre','id')->toArray();
				$comborol  					= 	array($usuario->rol_id => $usuario->rol->nombre) + $rol;
				$funcion 					= 	$this;	

		        $listaempresa              =   DB::table('STD.EMPRESA')
		                                        ->where('STD.EMPRESA.IND_PROVEEDOR','=',1)
		                                        ->where('STD.EMPRESA.COD_ESTADO','=',1)
		                                        ->where('COD_EMPR','=',Session::get('empresas')->COD_EMPR)
		                                        ->whereIn('STD.EMPRESA.COD_EMPR',['IACHEM0000010394', 'IACHEM0000007086'])
		                                        ->select(DB::raw("
		                                          STD.EMPRESA.COD_EMPR,
		                                          STD.EMPRESA.NOM_EMPR AS NOMBRE")
		                                        )
		                                        ->pluck('NOMBRE','COD_EMPR')
		                                        ->toArray();

		        $combo_empresa              =   array('' => "Seleccione empresa") + $listaempresa;
		        $empresa_id 				=	$tercero->COD_EMPRESA;


		        $listacentro              	=   DB::table('ALM.CENTRO')
		                                        ->where('COD_ESTADO','=',1)
		                                        ->select(DB::raw("
		                                          	COD_CENTRO,
		                                          	NOM_CENTRO AS NOMBRE")
		                                        )
		                                        ->pluck('NOMBRE','COD_CENTRO')
		                                        ->toArray();

		        $combo_centro               =   array('' => "Seleccione centro") + $listacentro;
		        $centro_id 					=	$tercero->COD_CENTRO;


		        $listaarea              	=   DB::table('CON.CENTRO_COSTO')
								                ->where('COD_ESTADO', 1)
								                ->where('COD_EMPR', Session::get('empresas')->COD_EMPR)
								                ->where('IND_MOVIMIENTO', 1)
		                                        ->select(DB::raw("
		                                          	COD_CENTRO_COSTO,
		                                          	TXT_NOMBRE AS NOMBRE")
		                                        )
		                                        ->pluck('NOMBRE','COD_CENTRO_COSTO')
		                                        ->toArray();

		        $combo_area               	=   array('' => "Seleccione area") + $listaarea;
		        $area_id 					=	$tercero->COD_AREA;


		        $banco_id       			=   $tercero->COD_BANCO;;
		        $arraybancos    			=   DB::table('CMP.CATEGORIA')->where('TXT_GRUPO','=','BANCOS_MERGE')->pluck('NOM_CATEGORIA','COD_CATEGORIA')->toArray();
		        $combobancos    			=   array('' => "Seleccione Entidad Bancaria") + $arraybancos;


		        return View::make('usuario/modificartercero', 
		        				[
		        					'usuario'  		=> $usuario,
		        					'tercero'  		=> $tercero,
									'banco_id'  	=> $banco_id,
									'combobancos'  		=> $combobancos,
		        					
									'combo_empresa'  	=> $combo_empresa,
									'empresa_id'  		=> $empresa_id,
									'combo_centro'  	=> $combo_centro,
									'centro_id'  		=> $centro_id,
									'combo_area'  		=> $combo_area,
									'area_id'  			=> $area_id,
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
				'nombre' => 'unico:WEB,rols',
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

	public function actionAjaxActivarPerfiles(Request $request)
	{

		$idempresa =  $request['idempresa'];
		$idcentro =  $request['idcentro'];
		$idusuario =  $request['idusuario'];
		$check =  $request['check'];	

		$perfiles = WEBUserEmpresaCentro::where('empresa_id','=',$idempresa)
										  ->where('centro_id','=',$idcentro)
										  ->where('usuario_id','=',$idusuario)
										  ->first();

		if(count($perfiles)>0){

			$cabecera            	 =	WEBUserEmpresaCentro::find($perfiles->id);
			$cabecera->fecha_mod 	 = 	$this->fechaactual;
			$cabecera->activo 	     =  $check;	
			$cabecera->save();	
			
		}else{

			$id 					= 	$this->funciones->getCreateIdMaestra('WEB.userempresacentros');
		    $detalle            	=	new WEBUserEmpresaCentro;
		    $detalle->id 	    	=  	$id;
			$detalle->empresa_id 	= 	$idempresa;
			$detalle->centro_id    	=  	$idcentro;
			$detalle->fecha_crea 	 = 	$this->fechaactual;
			$detalle->usuario_id    =  	$idusuario;
			$detalle->save();

		}

		echo("gmail");

	}

}
