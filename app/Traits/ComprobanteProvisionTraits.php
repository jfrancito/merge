<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\VMergeOC;
use App\Modelos\FeDocumento;
use App\Modelos\STDEmpresa;
use App\Modelos\CMPCategoria;
use App\Modelos\STDTipoDocumento;

use SoapClient;

use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use PDO;

trait ComprobanteProvisionTraits
{


	private function actionGuardarOrdenWcf($codOrdenIngreso,$orden) {



        // if($orden->COD_CENTRO == 'CEN0000000000001'){ //chiclayo
	    //     $wsdl = 'http://10.1.0.201/WCF_Orden.svc?wsdl';
	    //     // URL del WSDL del servicio WCF 
	    //     if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
	    //          $wsdl = 'http://10.1.0.201/WCF_Orden.svc?wsdl';
	    //     }else{
	    //         if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
	    //             $wsdl = 'http://10.1.0.201/WCF_Orden.svc?wsdl';
	    //         }
	    //     }
	    //     $mode = array (
	    //         'soap_version'  => 'SOAP_1_2', // use soap 1.2 client
	    //         'keep_alive'    => true,
	    //         'trace'         => 1,
	    //         'encoding'      => 'utf-8',
	    //         'compression'   => SOAP_COMPRESSION_ACCEPT | SOAP_COMPRESSION_GZIP | SOAP_COMPRESSION_DEFLATE,
	    //         'Content-Encoding'=> 'UTF-8',
	    //         'exceptions'    => true,
	    //         'cache_wsdl'    => WSDL_CACHE_NONE,
	    //     );
	    //     $params = [
	    //         'ls_Tipo' => 'I', 
	    //         'codOrdenI' => $codOrdenIngreso
	    //     ];
	    //     $client     = new SoapClient($wsdl, $mode); 
	    //     $res        = $client->EjecutarOIMerge($params);
	    //     $json       = response()->json($res);
	    //     $jsonData   = $json->getContent();
	    //     $dataArray  = json_decode($jsonData, true);
	    //     $message    = $dataArray['EjecutarOIMergeResult'];

	    //     return $mensaje; 
        // }
      	return "OK";
	}




	private function insert_registro_inventario($orden,$detalleproducto,$ordeningreso_id) {


		$COD_EMPR            		=       $orden->COD_EMPR;
		$COD_CENTRO            		=       $orden->COD_CENTRO;
		$idusuario 					=		Session::get('usuario')->name;

		$hoy 						= 		date_format(date_create(date('Ymd h:i:s')), 'Ymd');
		foreach($detalleproducto as $index => $item){

			$IND_TIPO_OPERACION='I';
			$COD_REGISTRO_INVENTARIO='';
			$COD_ALMACEN=$item->COD_ALMACEN;
			$COD_LOTE=$item->COD_LOTE;
			$COD_PRODUCTO=$item->COD_PRODUCTO;

			$COD_TABLA='';
			$DET_COD_PRODUCTO='';
			$DET_COD_LOTE='';
			$COD_EMPR=$orden->COD_EMPR;
			$COD_CENTRO=$orden->COD_CENTRO;

			$COD_CATEG_MOV='MIN0000000000007';
			$COD_ORDEN=$orden->COD_ORDEN;
			$NRO_LINEA=$item->NRO_LINEA;
			$FEC_MOV=$hoy;
			$CAN_MAT=$item->CAN_PRODUCTO;

			$CAN_COSTO=$item->CAN_PRECIO_COSTO;
			$CAN_COSTO_REAL=$item->CAN_PRECIO_COSTO;
			$TXT_GLOSA=$orden->TXT_GLOSA;
			$COD_ESTADO=$item->COD_ESTADO;
			$COD_USUARIO_REGISTRO=$idusuario;

			$COD_ASIENTO_MOVIMIENTO='';
			$IND_MONTO=0;
			$COD_EMPR_PROVEEDOR_SERV=$orden->COD_EMPR;
			$COD_EMPR_PROPIETARIO=$orden->COD_EMPR;

			$stmt 					= 		DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC ALM.REGISTRO_INVENTARIO_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_REGISTRO_INVENTARIO = ?,
												@COD_ALMACEN = ?,
												@COD_LOTE = ?,
												@COD_PRODUCTO = ?,

												@COD_TABLA = ?,
												@DET_COD_PRODUCTO = ?,
												@DET_COD_LOTE = ?,
												@COD_EMPR = ?,
												@COD_CENTRO = ?,

												@COD_CATEG_MOV = ?,
												@COD_ORDEN = ?,
												@NRO_LINEA = ?,
												@FEC_MOV = ?,
												@CAN_MAT = ?,

												@CAN_COSTO = ?,
												@CAN_COSTO_REAL = ?,
												@TXT_GLOSA = ?,
												@COD_ESTADO = ?,
												@COD_USUARIO_REGISTRO = ?,

												@COD_ASIENTO_MOVIMIENTO = ?,
												@IND_MONTO = ?,
												@COD_EMPR_PROVEEDOR_SERV = ?,
												@COD_EMPR_PROPIETARIO = ?

												');

	        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmt->bindParam(2, $COD_REGISTRO_INVENTARIO  ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(5, $COD_PRODUCTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(6, $COD_TABLA ,PDO::PARAM_STR);
	        $stmt->bindParam(7, $DET_COD_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(8, $DET_COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(9, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmt->bindParam(10,$COD_CENTRO  ,PDO::PARAM_STR);

	        $stmt->bindParam(11, $COD_CATEG_MOV ,PDO::PARAM_STR);                   
	        $stmt->bindParam(12, $COD_ORDEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(13, $NRO_LINEA  ,PDO::PARAM_STR);
	        $stmt->bindParam(14, $FEC_MOV  ,PDO::PARAM_STR);
	        $stmt->bindParam(15, $CAN_MAT  ,PDO::PARAM_STR);

	        $stmt->bindParam(16, $CAN_COSTO ,PDO::PARAM_STR);
	        $stmt->bindParam(17, $CAN_COSTO_REAL  ,PDO::PARAM_STR);
	        $stmt->bindParam(18, $TXT_GLOSA  ,PDO::PARAM_STR);
	        $stmt->bindParam(19, $COD_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(20,$COD_USUARIO_REGISTRO  ,PDO::PARAM_STR);

	        $stmt->bindParam(21, $COD_ASIENTO_MOVIMIENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(22, $IND_MONTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(23, $COD_EMPR_PROVEEDOR_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(24, $COD_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
	        $stmt->execute();

			$IND_TIPO_OPERACION='R';
			$COD_ALMACEN=$item->COD_ALMACEN;
			$COD_LOTE=$item->COD_LOTE;
			$COD_PRODUCTO=$item->COD_PRODUCTO;
			$FEC_INV=$hoy;
			
			$COD_EMPR='';
			$COD_CENTRO='';
			$CAN_INI_MAT=0;
			$CAN_INGRESO=0;
			$CAN_SALIDA=0;

			$CAN_FIN_MAT=0;
			$CAN_COSTO=0;
			$IND_STK_ACTUAL=-1;
			$COD_ESTADO=0;
			$COD_USUARIO_REGISTRO='';

			$COD_EMPR_PROVEEDOR_SERV=$orden->COD_EMPR;
			$COD_EMPR_PROPIETARIO=$orden->COD_EMPR;



			$stmt 					= 		DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC ALM.INVENTARIO_ALMACEN_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_ALMACEN = ?,
												@COD_LOTE = ?,
												@COD_PRODUCTO = ?,
												@FEC_INV = ?,

												@COD_EMPR = ?,
												@COD_CENTRO = ?,
												@CAN_INI_MAT = ?,
												@CAN_INGRESO = ?,
												@CAN_SALIDA = ?,

												@CAN_FIN_MAT = ?,
												@CAN_COSTO = ?,
												@IND_STK_ACTUAL = ?,
												@COD_ESTADO = ?,
												@COD_USUARIO_REGISTRO = ?,

												@COD_EMPR_PROVEEDOR_SERV = ?,
												@COD_EMPR_PROPIETARIO = ?

												');

	        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmt->bindParam(2, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $COD_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(5, $FEC_INV  ,PDO::PARAM_STR);

	        $stmt->bindParam(6, $COD_EMPR ,PDO::PARAM_STR);
	        $stmt->bindParam(7, $COD_CENTRO  ,PDO::PARAM_STR);
	        $stmt->bindParam(8, $CAN_INI_MAT  ,PDO::PARAM_STR);
	        $stmt->bindParam(9, $CAN_INGRESO  ,PDO::PARAM_STR);
	        $stmt->bindParam(10,$CAN_SALIDA  ,PDO::PARAM_STR);

	        $stmt->bindParam(11, $CAN_FIN_MAT ,PDO::PARAM_STR);                   
	        $stmt->bindParam(12, $CAN_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(13, $IND_STK_ACTUAL  ,PDO::PARAM_STR);
	        $stmt->bindParam(14, $COD_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(15, $COD_USUARIO_REGISTRO  ,PDO::PARAM_STR);

	        $stmt->bindParam(16, $COD_EMPR_PROVEEDOR_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(17, $COD_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
	        $stmt->execute();


















		}
	}




	private function update_orden_ingreso($orden,$detalleproducto) {


		$COD_EMPR            	=       $orden->COD_EMPR;
		$COD_CENTRO            	=       $orden->COD_CENTRO;
		$empresa 				=		STDEmpresa::where('COD_EMPR','=',$orden->COD_EMPR)->first();
		$tipopago 				=		CMPCategoria::where('COD_CATEGORIA','=',$orden->COD_CATEGORIA_TIPO_PAGO)->first();


		$hoy 					= 		date_format(date_create(date('Ymd h:i:s')), 'Ymd');
		$fechapago 				= 		date('Y-m-j');
		$nuevafecha 			= 		strtotime ( '+'.$tipopago->COD_CTBLE.' day' , strtotime($fechapago));
		$nuevafecha 			= 		date ('Y-m-j' , $nuevafecha);
		$fecha_pago 			= 		date_format(date_create($nuevafecha), 'Ymd');

		$fecha_sin 				=		'1901-01-01 00:00:00';
		$vacio 					=		'';
		$activo 				=		'1';
		$idusuario 				=		Session::get('usuario')->name;

		$IND_TIPO_OPERACION='I';
		$COD_ORDEN=$orden->COD_ORDEN;;
		$COD_EMPR=$orden->COD_EMPR;
		$COD_EMPR_CLIENTE=$orden->COD_EMPR;
		$TXT_EMPR_CLIENTE=$orden->TXT_EMPR_CLIENTE;

		$COD_EMPR_LICITACION=$orden->COD_EMPR_LICITACION;
		$TXT_EMPR_LICITACION=$orden->TXT_EMPR_LICITACION;
		$COD_EMPR_TRANSPORTE=$orden->COD_EMPR_TRANSPORTE;
		$TXT_EMPR_TRANSPORTE=$orden->TXT_EMPR_TRANSPORTE;
		$COD_EMPR_ORIGEN=$orden->COD_EMPR_ORIGEN;

		$TXT_EMPR_ORIGEN=$orden->TXT_EMPR_ORIGEN;
		$COD_CENTRO=$orden->COD_CENTRO;
		$COD_CENTRO_DESTINO=$orden->COD_CENTRO_DESTINO;
		$COD_CENTRO_ORIGEN=$orden->COD_CENTRO_ORIGEN;
		$FEC_ORDEN=$orden->FEC_ORDEN;

		$FEC_RECEPCION=$orden->FEC_RECEPCION;
		$FEC_ENTREGA=$orden->FEC_ENTREGA;
		$FEC_ENTREGA_2=$orden->FEC_ENTREGA_2;
		$FEC_ENTREGA_3=$orden->FEC_ENTREGA_3;
		$FEC_PAGO=$orden->FEC_PAGO;

		$FEC_NOTA_PEDIDO=$orden->FEC_NOTA_PEDIDO;
		$FEC_RECOJO_MERCADERIA=$orden->FEC_RECOJO_MERCADERIA;
		$FEC_ENTREGA_LIMA=$orden->FEC_ENTREGA_LIMA;
		$FEC_GRACIA=$orden->FEC_GRACIA;
		$FEC_EJECUCION=$orden->FEC_EJECUCION;

		$IND_MATERIAL_SERVICIO=$orden->IND_MATERIAL_SERVICIO;
		$COD_CATEGORIA_ESTADO_REQ=$orden->COD_CATEGORIA_ESTADO_REQ;
		$COD_CATEGORIA_TIPO_ORDEN=$orden->COD_CATEGORIA_TIPO_ORDEN;
		$TXT_CATEGORIA_TIPO_ORDEN=$orden->TXT_CATEGORIA_TIPO_ORDEN;
		$COD_CATEGORIA_TIPO_PAGO=$orden->COD_CATEGORIA_TIPO_PAGO;

		$COD_CATEGORIA_MONEDA=$orden->COD_CATEGORIA_MONEDA;
		$TXT_CATEGORIA_MONEDA=$orden->TXT_CATEGORIA_MONEDA;
		$COD_CATEGORIA_ESTADO_ORDEN='EOR0000000000003';
		$TXT_CATEGORIA_ESTADO_ORDEN='TERMINADA';
		$COD_CATEGORIA_MOVIMIENTO_INVENTARIO=$orden->COD_CATEGORIA_MOVIMIENTO_INVENTARIO;

		$TXT_CATEGORIA_MOVIMIENTO_INVENTARIO=$orden->TXT_CATEGORIA_MOVIMIENTO_INVENTARIO;
		$COD_CATEGORIA_PROCESO_SEL=$orden->COD_CATEGORIA_PROCESO_SEL;
		$TXT_CATEGORIA_PROCESO_SEL=$orden->TXT_CATEGORIA_PROCESO_SEL;
		$COD_CATEGORIA_MODALIDAD_SEL=$orden->COD_CATEGORIA_MODALIDAD_SEL;
		$TXT_CATEGORIA_MODALIDAD_SEL=$orden->TXT_CATEGORIA_MODALIDAD_SEL;

		$COD_CATEGORIA_AREA_EMPRESA=$orden->COD_CATEGORIA_AREA_EMPRESA;
		$TXT_CATEGORIA_AREA_EMPRESA=$orden->TXT_CATEGORIA_AREA_EMPRESA;
		$COD_CONCEPTO_CENTRO_COSTO=$orden->COD_CONCEPTO_CENTRO_COSTO;
		$COD_CHOFER=$orden->COD_CHOFER;
		$COD_VEHICULO=$orden->COD_VEHICULO;

		$COD_CARRETA=$orden->COD_CARRETA;
		$TXT_CARRETA=$orden->TXT_CARRETA;
		$COD_CONTRATO_ORIGEN=$orden->COD_CONTRATO_ORIGEN;
		$COD_CULTIVO_ORIGEN=$orden->COD_CULTIVO_ORIGEN;
		$COD_CONTRATO_LICITACION=$orden->COD_CONTRATO_LICITACION;

		$COD_CULTIVO_LICITACION=$orden->COD_CULTIVO_LICITACION;
		$COD_CONTRATO_TRANSPORTE=$orden->COD_CONTRATO_TRANSPORTE;
		$COD_CULTIVO_TRANSPORTE=$orden->COD_CULTIVO_TRANSPORTE;
		$COD_CONTRATO=$orden->COD_CONTRATO;
		$COD_CULTIVO=$orden->COD_CULTIVO;

		$COD_HABILITACION=$orden->COD_HABILITACION;
		$COD_HABILITACION_DCTO=$orden->COD_HABILITACION_DCTO;
		$COD_ALMACEN_ORIGEN=$orden->COD_ALMACEN_ORIGEN;
		$COD_ALMACEN_DESTINO=$orden->COD_ALMACEN_DESTINO;
		$COD_TRABAJADOR_SOLICITA=$orden->COD_TRABAJADOR_SOLICITA;

		$COD_TRABAJADOR_ENCARGADO=$orden->COD_TRABAJADOR_ENCARGADO;
		$COD_TRABAJADOR_COMISIONISTA=$orden->COD_TRABAJADOR_COMISIONISTA;
		$COD_CONTRATO_COMISIONISTA=$orden->COD_CONTRATO_COMISIONISTA;
		$COD_CULTIVO_COMISIONISTA=$orden->COD_CULTIVO_COMISIONISTA;
		$COD_HABILITACION_COMISIONISTA=$orden->COD_HABILITACION_COMISIONISTA;

		$COD_TRABAJADOR_VENDEDOR=$orden->COD_TRABAJADOR_VENDEDOR;
		$COD_ZONA_COMERCIAL=$orden->COD_ZONA_COMERCIAL;
		$TXT_ZONA_COMERCIAL=$orden->TXT_ZONA_COMERCIAL;
		$COD_LOTE_CC=$orden->COD_LOTE_CC;
		$CAN_SUB_TOTAL=$orden->CAN_SUB_TOTAL;

		$CAN_IMPUESTO_VTA=$orden->CAN_IMPUESTO_VTA;
		$CAN_IMPUESTO_RENTA=$orden->CAN_IMPUESTO_RENTA;
		$CAN_TOTAL=$orden->CAN_TOTAL;
		$CAN_DSCTO=$orden->CAN_DSCTO;
		$CAN_TIPO_CAMBIO=$orden->CAN_TIPO_CAMBIO;

		$CAN_PERCEPCION=$orden->CAN_PERCEPCION;
		$CAN_DETRACCION=$orden->CAN_DETRACCION;
		$CAN_RETENCION=$orden->CAN_RETENCION;
		$CAN_NETO_PAGAR=$orden->CAN_NETO_PAGAR;
		$CAN_TOTAL_COMISION=$orden->CAN_TOTAL_COMISION;

		$COD_EMPR_BANCO=$orden->COD_EMPR_BANCO;
		$NRO_CUENTA_BANCARIA=$orden->NRO_CUENTA_BANCARIA;
		$NRO_CARRO=$orden->NRO_CARRO;
		$IND_VARIAS_ENTREGAS=$orden->IND_VARIAS_ENTREGAS;
		$IND_TIPO_COMPRA=$orden->IND_TIPO_COMPRA;

		$NOM_CHOFER_EMPR_TRANSPORTE=$orden->NOM_CHOFER_EMPR_TRANSPORTE;
		$NRO_ORDEN_CEN=$orden->NRO_ORDEN_CEN;
		$NRO_LICITACION=$orden->NRO_LICITACION;
		$NRO_NOTA_PEDIDO=$orden->NRO_NOTA_PEDIDO;
		$NRO_OPERACIONES_CAJA=$orden->NRO_OPERACIONES_CAJA;

		$TXT_NRO_PLACA=$orden->TXT_NRO_PLACA;
		$TXT_CONTACTO=$orden->TXT_CONTACTO;
		$TXT_MOTIVO_ANULACION=$orden->TXT_MOTIVO_ANULACION;
		$TXT_CONFORMIDAD=$orden->TXT_CONFORMIDAD;
		$TXT_A_TIEMPO=$orden->TXT_A_TIEMPO;

		$TXT_DESTINO=$orden->TXT_DESTINO;
		$TXT_TIPO_DOC_ASOC=$orden->TXT_TIPO_DOC_ASOC;
		$TXT_DOC_ASOC=$orden->TXT_DOC_ASOC;
		$TXT_ORDEN_ASOC=$orden->TXT_ORDEN_ASOC;
		$COD_CATEGORIA_MODULO=$orden->COD_CATEGORIA_MODULO;

		$TXT_GLOSA_ATENCION=$orden->TXT_GLOSA_ATENCION;
		$TXT_GLOSA=$orden->TXT_GLOSA;
		$TXT_TIPO_REFERENCIA=$orden->TXT_TIPO_REFERENCIA;
		$TXT_REFERENCIA=$orden->TXT_REFERENCIA;
		$COD_OPERACION=$orden->COD_OPERACION;

		$TXT_GRR=$orden->TXT_GRR;
		$TXT_GRR_TRANSPORTISTA=$orden->TXT_GRR_TRANSPORTISTA;
		$TXT_CTC=$orden->TXT_CTC;
		$IND_ZONA=$orden->IND_ZONA;
		$IND_CERRADO=$orden->IND_CERRADO;

		$COD_EMP_PROV_SERV=$orden->COD_EMP_PROV_SERV;
		$TXT_EMP_PROV_SERV=$orden->TXT_EMP_PROV_SERV;
		$COD_ESTADO=$orden->COD_ESTADO;
		$COD_USUARIO_REGISTRO=$orden->COD_USUARIO_REGISTRO;
		$COD_CTA_GASTO_FUNCION=$orden->COD_CTA_GASTO_FUNCION;

		$NRO_CTA_GASTO_FUNCION=$orden->NRO_CTA_GASTO_FUNCION;
		$COD_CATEGORIA_ACTIVIDAD_NEGOCIO=$orden->COD_CATEGORIA_ACTIVIDAD_NEGOCIO;
		$COD_EMPR_PROPIETARIO=$orden->COD_EMPR_PROPIETARIO;
		$TXT_EMPR_PROPIETARIO=$orden->TXT_EMPR_PROPIETARIO;
		$COD_CATEGORIA_TIPO_COSTEO=$orden->COD_CATEGORIA_TIPO_COSTEO;

		$TXT_CATEGORIA_TIPO_COSTEO=$orden->TXT_CATEGORIA_TIPO_COSTEO;
		$TXT_CORRELATIVO=$orden->TXT_CORRELATIVO;
		$COD_MOVIMIENTO_INVENTARIO_EXTORNADO=$orden->COD_MOVIMIENTO_INVENTARIO_EXTORNADO;
		$COD_ORDEN_EXTORNADA=$orden->COD_ORDEN_EXTORNADA;
		$IND_ENV_CLIENTE=$orden->IND_ENV_CLIENTE;

		$IND_ORDEN=$orden->IND_ORDEN;
		$COD_MOTIVO_EXTORNO=$orden->COD_MOTIVO_EXTORNO;
		$GLOSA_EXTORNO=$orden->GLOSA_EXTORNO;



		$stmt 					= 		DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.ORDEN_IUD 
											@IND_TIPO_OPERACION = ?,
											@COD_ORDEN = ?,
											@COD_EMPR = ?,
											@COD_EMPR_CLIENTE = ?,
											@TXT_EMPR_CLIENTE = ?,

											@COD_EMPR_LICITACION = ?,
											@TXT_EMPR_LICITACION = ?,
											@COD_EMPR_TRANSPORTE = ?,
											@TXT_EMPR_TRANSPORTE = ?,
											@COD_EMPR_ORIGEN = ?,

											@TXT_EMPR_ORIGEN = ?,
											@COD_CENTRO = ?,
											@COD_CENTRO_DESTINO = ?,
											@COD_CENTRO_ORIGEN = ?,
											@FEC_ORDEN = ?,

											@FEC_RECEPCION = ?,
											@FEC_ENTREGA = ?,
											@FEC_ENTREGA_2 = ?,
											@FEC_ENTREGA_3 = ?,
											@FEC_PAGO = ?,

											@FEC_NOTA_PEDIDO = ?,
											@FEC_RECOJO_MERCADERIA = ?,
											@FEC_ENTREGA_LIMA = ?,
											@FEC_GRACIA = ?,
											@FEC_EJECUCION = ?,

											@IND_MATERIAL_SERVICIO = ?,
											@COD_CATEGORIA_ESTADO_REQ = ?,
											@COD_CATEGORIA_TIPO_ORDEN = ?,
											@TXT_CATEGORIA_TIPO_ORDEN = ?,
											@COD_CATEGORIA_TIPO_PAGO = ?,

											@COD_CATEGORIA_MONEDA = ?,
											@TXT_CATEGORIA_MONEDA = ?,
											@COD_CATEGORIA_ESTADO_ORDEN = ?,
											@TXT_CATEGORIA_ESTADO_ORDEN = ?,
											@COD_CATEGORIA_MOVIMIENTO_INVENTARIO = ?,

											@TXT_CATEGORIA_MOVIMIENTO_INVENTARIO = ?,
											@COD_CATEGORIA_PROCESO_SEL = ?,
											@TXT_CATEGORIA_PROCESO_SEL = ?,
											@COD_CATEGORIA_MODALIDAD_SEL = ?,
											@TXT_CATEGORIA_MODALIDAD_SEL = ?,

											@COD_CATEGORIA_AREA_EMPRESA = ?,
											@TXT_CATEGORIA_AREA_EMPRESA = ?,
											@COD_CONCEPTO_CENTRO_COSTO = ?,
											@COD_CHOFER = ?,
											@COD_VEHICULO = ?,

											@COD_CARRETA = ?,
											@TXT_CARRETA = ?,
											@COD_CONTRATO_ORIGEN = ?,
											@COD_CULTIVO_ORIGEN = ?,
											@COD_CONTRATO_LICITACION = ?,


											@COD_CULTIVO_LICITACION = ?,
											@COD_CONTRATO_TRANSPORTE = ?,
											@COD_CULTIVO_TRANSPORTE = ?,
											@COD_CONTRATO = ?,
											@COD_CULTIVO = ?,

											@COD_HABILITACION = ?,
											@COD_HABILITACION_DCTO = ?,
											@COD_ALMACEN_ORIGEN = ?,
											@COD_ALMACEN_DESTINO = ?,
											@COD_TRABAJADOR_SOLICITA = ?,

											@COD_TRABAJADOR_ENCARGADO = ?,
											@COD_TRABAJADOR_COMISIONISTA = ?,
											@COD_CONTRATO_COMISIONISTA = ?,
											@COD_CULTIVO_COMISIONISTA = ?,
											@COD_HABILITACION_COMISIONISTA = ?,

											@COD_TRABAJADOR_VENDEDOR = ?,
											@COD_ZONA_COMERCIAL = ?,
											@TXT_ZONA_COMERCIAL = ?,
											@COD_LOTE_CC = ?,
											@CAN_SUB_TOTAL = ?,

											@CAN_IMPUESTO_VTA = ?,
											@CAN_IMPUESTO_RENTA = ?,
											@CAN_TOTAL = ?,
											@CAN_DSCTO = ?,
											@CAN_TIPO_CAMBIO = ?,

											@CAN_PERCEPCION = ?,
											@CAN_DETRACCION = ?,
											@CAN_RETENCION = ?,
											@CAN_NETO_PAGAR = ?,
											@CAN_TOTAL_COMISION = ?,
											
											@COD_EMPR_BANCO = ?,
											@NRO_CUENTA_BANCARIA = ?,
											@NRO_CARRO = ?,
											@IND_VARIAS_ENTREGAS = ?,
											@IND_TIPO_COMPRA = ?,

											@NOM_CHOFER_EMPR_TRANSPORTE = ?,
											@NRO_ORDEN_CEN = ?,
											@NRO_LICITACION = ?,
											@NRO_NOTA_PEDIDO = ?,
											@NRO_OPERACIONES_CAJA = ?,

											@TXT_NRO_PLACA = ?,
											@TXT_CONTACTO = ?,
											@TXT_MOTIVO_ANULACION = ?,
											@TXT_CONFORMIDAD = ?,
											@TXT_A_TIEMPO = ?,

											@TXT_DESTINO = ?,
											@TXT_TIPO_DOC_ASOC = ?,
											@TXT_DOC_ASOC = ?,
											@TXT_ORDEN_ASOC = ?,
											@COD_CATEGORIA_MODULO = ?,


											@TXT_GLOSA_ATENCION = ?,
											@TXT_GLOSA = ?,
											@TXT_TIPO_REFERENCIA = ?,
											@TXT_REFERENCIA = ?,
											@COD_OPERACION = ?,
											
											@TXT_GRR = ?,
											@TXT_GRR_TRANSPORTISTA = ?,
											@TXT_CTC = ?,
											@IND_ZONA = ?,
											@IND_CERRADO = ?,

											@COD_EMP_PROV_SERV = ?,
											@TXT_EMP_PROV_SERV = ?,
											@COD_ESTADO = ?,
											@COD_USUARIO_REGISTRO = ?,
											@COD_CTA_GASTO_FUNCION = ?,

											@NRO_CTA_GASTO_FUNCION = ?,
											@COD_CATEGORIA_ACTIVIDAD_NEGOCIO = ?,
											@COD_EMPR_PROPIETARIO = ?,
											@TXT_EMPR_PROPIETARIO = ?,
											@COD_CATEGORIA_TIPO_COSTEO = ?,

											@TXT_CATEGORIA_TIPO_COSTEO = ?,
											@TXT_CORRELATIVO = ?,
											@COD_MOVIMIENTO_INVENTARIO_EXTORNADO = ?,
											@COD_ORDEN_EXTORNADA = ?,
											@IND_ENV_CLIENTE = ?,

											@IND_ORDEN = ?,
											@COD_MOTIVO_EXTORNO = ?,
											@GLOSA_EXTORNO = ?

											');

        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(2, $COD_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(3, $COD_EMPR  ,PDO::PARAM_STR);
        $stmt->bindParam(4, $COD_EMPR_CLIENTE  ,PDO::PARAM_STR);
        $stmt->bindParam(5, $TXT_EMPR_CLIENTE  ,PDO::PARAM_STR);

        $stmt->bindParam(6, $COD_EMPR_LICITACION ,PDO::PARAM_STR);
        $stmt->bindParam(7, $TXT_EMPR_LICITACION  ,PDO::PARAM_STR);
        $stmt->bindParam(8, $COD_EMPR_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(9, $TXT_EMPR_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(10,$COD_EMPR_ORIGEN  ,PDO::PARAM_STR);

        $stmt->bindParam(11, $TXT_EMPR_ORIGEN ,PDO::PARAM_STR);                   
        $stmt->bindParam(12, $COD_CENTRO  ,PDO::PARAM_STR);
        $stmt->bindParam(13, $COD_CENTRO_DESTINO  ,PDO::PARAM_STR);
        $stmt->bindParam(14, $COD_CENTRO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(15, $FEC_ORDEN  ,PDO::PARAM_STR);

        $stmt->bindParam(16, $FEC_RECEPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(17, $FEC_ENTREGA  ,PDO::PARAM_STR);
        $stmt->bindParam(18, $FEC_ENTREGA_2  ,PDO::PARAM_STR);
        $stmt->bindParam(19, $FEC_ENTREGA_3  ,PDO::PARAM_STR);
        $stmt->bindParam(20, $FEC_PAGO  ,PDO::PARAM_STR);

        $stmt->bindParam(21, $FEC_NOTA_PEDIDO ,PDO::PARAM_STR);
        $stmt->bindParam(22, $FEC_RECOJO_MERCADERIA  ,PDO::PARAM_STR);
        $stmt->bindParam(23, $FEC_ENTREGA_LIMA  ,PDO::PARAM_STR);
        $stmt->bindParam(24, $FEC_GRACIA  ,PDO::PARAM_STR);
        $stmt->bindParam(25,$FEC_EJECUCION  ,PDO::PARAM_STR);

        $stmt->bindParam(26, $IND_MATERIAL_SERVICIO ,PDO::PARAM_STR);                   
        $stmt->bindParam(27, $COD_CATEGORIA_ESTADO_REQ  ,PDO::PARAM_STR);
        $stmt->bindParam(28, $COD_CATEGORIA_TIPO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(29, $TXT_CATEGORIA_TIPO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(30, $COD_CATEGORIA_TIPO_PAGO  ,PDO::PARAM_STR);

        $stmt->bindParam(31, $COD_CATEGORIA_MONEDA ,PDO::PARAM_STR);                   
        $stmt->bindParam(32, $TXT_CATEGORIA_MONEDA  ,PDO::PARAM_STR);
        $stmt->bindParam(33, $COD_CATEGORIA_ESTADO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(34, $TXT_CATEGORIA_ESTADO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(35, $COD_CATEGORIA_MOVIMIENTO_INVENTARIO  ,PDO::PARAM_STR);

        $stmt->bindParam(36, $TXT_CATEGORIA_MOVIMIENTO_INVENTARIO ,PDO::PARAM_STR);
        $stmt->bindParam(37, $COD_CATEGORIA_PROCESO_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(38, $TXT_CATEGORIA_PROCESO_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(39, $COD_CATEGORIA_MODALIDAD_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(40,$TXT_CATEGORIA_MODALIDAD_SEL  ,PDO::PARAM_STR);

        $stmt->bindParam(41, $COD_CATEGORIA_AREA_EMPRESA ,PDO::PARAM_STR);                   
        $stmt->bindParam(42, $TXT_CATEGORIA_AREA_EMPRESA  ,PDO::PARAM_STR);
        $stmt->bindParam(43, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);
        $stmt->bindParam(44, $COD_CHOFER  ,PDO::PARAM_STR);
        $stmt->bindParam(45, $COD_VEHICULO  ,PDO::PARAM_STR);

        $stmt->bindParam(46, $COD_CARRETA ,PDO::PARAM_STR);                   
        $stmt->bindParam(47, $TXT_CARRETA  ,PDO::PARAM_STR);
        $stmt->bindParam(48, $COD_CONTRATO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(49, $COD_CULTIVO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(50, $COD_CONTRATO_LICITACION  ,PDO::PARAM_STR);

        $stmt->bindParam(51, $COD_CULTIVO_LICITACION ,PDO::PARAM_STR);
        $stmt->bindParam(52, $COD_CONTRATO_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(53, $COD_CULTIVO_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(54, $COD_CONTRATO  ,PDO::PARAM_STR);
        $stmt->bindParam(55,$COD_CULTIVO  ,PDO::PARAM_STR);

        $stmt->bindParam(56, $COD_HABILITACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(57, $COD_HABILITACION_DCTO  ,PDO::PARAM_STR);
        $stmt->bindParam(58, $COD_ALMACEN_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(59, $COD_ALMACEN_DESTINO  ,PDO::PARAM_STR);
        $stmt->bindParam(60, $COD_TRABAJADOR_SOLICITA  ,PDO::PARAM_STR);


        $stmt->bindParam(61, $COD_TRABAJADOR_ENCARGADO ,PDO::PARAM_STR);                   
        $stmt->bindParam(62, $COD_TRABAJADOR_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(63, $COD_CONTRATO_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(64, $COD_CULTIVO_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(65, $COD_HABILITACION_COMISIONISTA  ,PDO::PARAM_STR);

        $stmt->bindParam(66, $COD_TRABAJADOR_VENDEDOR ,PDO::PARAM_STR);
        $stmt->bindParam(67, $COD_ZONA_COMERCIAL  ,PDO::PARAM_STR);
        $stmt->bindParam(68, $TXT_ZONA_COMERCIAL  ,PDO::PARAM_STR);
        $stmt->bindParam(69, $COD_LOTE_CC  ,PDO::PARAM_STR);
        $stmt->bindParam(70,$CAN_SUB_TOTAL  ,PDO::PARAM_STR);

        $stmt->bindParam(71, $CAN_IMPUESTO_VTA ,PDO::PARAM_STR);                   
        $stmt->bindParam(72, $CAN_IMPUESTO_RENTA  ,PDO::PARAM_STR);
        $stmt->bindParam(73, $CAN_TOTAL  ,PDO::PARAM_STR);
        $stmt->bindParam(74, $CAN_DSCTO  ,PDO::PARAM_STR);
        $stmt->bindParam(75, $CAN_TIPO_CAMBIO  ,PDO::PARAM_STR);

        $stmt->bindParam(76, $CAN_PERCEPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(77, $CAN_DETRACCION  ,PDO::PARAM_STR);
        $stmt->bindParam(78, $CAN_RETENCION  ,PDO::PARAM_STR);
        $stmt->bindParam(79, $CAN_NETO_PAGAR  ,PDO::PARAM_STR);
        $stmt->bindParam(80, $CAN_TOTAL_COMISION  ,PDO::PARAM_STR);

        $stmt->bindParam(81, $COD_EMPR_BANCO ,PDO::PARAM_STR);
        $stmt->bindParam(82, $NRO_CUENTA_BANCARIA  ,PDO::PARAM_STR);
        $stmt->bindParam(83, $NRO_CARRO  ,PDO::PARAM_STR);
        $stmt->bindParam(84, $IND_VARIAS_ENTREGAS  ,PDO::PARAM_STR);
        $stmt->bindParam(85,$IND_TIPO_COMPRA  ,PDO::PARAM_STR);

        $stmt->bindParam(86, $NOM_CHOFER_EMPR_TRANSPORTE ,PDO::PARAM_STR);                   
        $stmt->bindParam(87, $NRO_ORDEN_CEN  ,PDO::PARAM_STR);
        $stmt->bindParam(88, $NRO_LICITACION  ,PDO::PARAM_STR);
        $stmt->bindParam(89, $NRO_NOTA_PEDIDO  ,PDO::PARAM_STR);
        $stmt->bindParam(90, $NRO_OPERACIONES_CAJA  ,PDO::PARAM_STR);

        $stmt->bindParam(91, $TXT_NRO_PLACA ,PDO::PARAM_STR);                   
        $stmt->bindParam(92, $TXT_CONTACTO  ,PDO::PARAM_STR);
        $stmt->bindParam(93, $TXT_MOTIVO_ANULACION  ,PDO::PARAM_STR);
        $stmt->bindParam(94, $TXT_CONFORMIDAD  ,PDO::PARAM_STR);
        $stmt->bindParam(95, $TXT_A_TIEMPO  ,PDO::PARAM_STR);

        $stmt->bindParam(96, $TXT_DESTINO ,PDO::PARAM_STR);
        $stmt->bindParam(97, $TXT_TIPO_DOC_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(98, $TXT_DOC_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(99, $TXT_ORDEN_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(100,$COD_CATEGORIA_MODULO  ,PDO::PARAM_STR);

        $stmt->bindParam(101, $TXT_GLOSA_ATENCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(102, $TXT_GLOSA  ,PDO::PARAM_STR);
        $stmt->bindParam(103, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(104, $TXT_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(105, $COD_OPERACION  ,PDO::PARAM_STR);

        $stmt->bindParam(106, $TXT_GRR ,PDO::PARAM_STR);                   
        $stmt->bindParam(107, $TXT_GRR_TRANSPORTISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(108, $TXT_CTC  ,PDO::PARAM_STR);
        $stmt->bindParam(109, $IND_ZONA  ,PDO::PARAM_STR);
        $stmt->bindParam(110, $IND_CERRADO  ,PDO::PARAM_STR);

        $stmt->bindParam(111, $COD_EMP_PROV_SERV ,PDO::PARAM_STR);
        $stmt->bindParam(112, $TXT_EMP_PROV_SERV  ,PDO::PARAM_STR);
        $stmt->bindParam(113, $COD_ESTADO  ,PDO::PARAM_STR);
        $stmt->bindParam(114, $COD_USUARIO_REGISTRO  ,PDO::PARAM_STR);
        $stmt->bindParam(115,$COD_CTA_GASTO_FUNCION  ,PDO::PARAM_STR);

        $stmt->bindParam(116, $NRO_CTA_GASTO_FUNCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(117, $COD_CATEGORIA_ACTIVIDAD_NEGOCIO  ,PDO::PARAM_STR);
        $stmt->bindParam(118, $COD_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
        $stmt->bindParam(119, $TXT_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
        $stmt->bindParam(120, $COD_CATEGORIA_TIPO_COSTEO  ,PDO::PARAM_STR);


        $stmt->bindParam(121, $TXT_CATEGORIA_TIPO_COSTEO ,PDO::PARAM_STR);
        $stmt->bindParam(122, $TXT_CORRELATIVO  ,PDO::PARAM_STR);
        $stmt->bindParam(123, $COD_MOVIMIENTO_INVENTARIO_EXTORNADO  ,PDO::PARAM_STR);
        $stmt->bindParam(124, $COD_ORDEN_EXTORNADA  ,PDO::PARAM_STR);
        $stmt->bindParam(125,$IND_ENV_CLIENTE  ,PDO::PARAM_STR);

        $stmt->bindParam(126, $IND_ORDEN ,PDO::PARAM_STR);                   
        $stmt->bindParam(127, $COD_MOTIVO_EXTORNO  ,PDO::PARAM_STR);
        $stmt->bindParam(128, $GLOSA_EXTORNO  ,PDO::PARAM_STR);

        $stmt->execute();
	}
	private function update_detalle_producto($orden,$detalleproducto) {


		$COD_EMPR            		=       $orden->COD_EMPR;
		$COD_CENTRO            		=       $orden->COD_CENTRO;
		$idusuario 					=		Session::get('usuario')->name;


		foreach($detalleproducto as $index => $item){


			//DOLARES
			$CANPRECIOUNITIGV 			=	$item->CAN_PRECIO_UNIT_IGV;
			$CANPRECIOUNIT 				=	$item->CAN_PRECIO_UNIT;
			$CANPRECIOCOSTO 			=	$item->CAN_PRECIO_COSTO;
			$CANVALORVTA 				=	$item->CAN_VALOR_VTA;
			$CANVALORVENTAIGV 			=	$item->CAN_VALOR_VENTA_IGV;


			if($orden->COD_CATEGORIA_MONEDA=='MON0000000000002'){

				$CANPRECIOUNITIGV 		=	$item->CAN_PRECIO_UNIT_IGV*$orden->CAN_TIPO_CAMBIO;
				$CANPRECIOUNIT 			=	$item->CAN_PRECIO_UNIT*$orden->CAN_TIPO_CAMBIO;
				$CANPRECIOCOSTO 		=	$item->CAN_PRECIO_COSTO*$orden->CAN_TIPO_CAMBIO;
				$CANVALORVTA 			=	$item->CAN_VALOR_VTA*$orden->CAN_TIPO_CAMBIO;
				$CANVALORVENTAIGV 		=	$item->CAN_VALOR_VENTA_IGV*$orden->CAN_TIPO_CAMBIO;

			}



			$IND_TIPO_OPERACION='I';
			$COD_TABLA=$orden->COD_ORDEN;
			$COD_PRODUCTO=$item->COD_PRODUCTO;
			$COD_LOTE=$item->COD_LOTE;
			$NRO_LINEA=$item->NRO_LINEA;

			$TXT_NOMBRE_PRODUCTO=$item->TXT_NOMBRE_PRODUCTO;
			$TXT_DETALLE_PRODUCTO=$item->TXT_DETALLE_PRODUCTO;
			$CAN_PRODUCTO=$item->CAN_PRODUCTO;
			$CAN_PRODUCTO_ENVIADO=$item->CAN_PRODUCTO_ENVIADO;
			$CAN_PESO=$item->CAN_PESO;

			$CAN_PESO_PRODUCTO=$item->CAN_PESO_PRODUCTO;
			$CAN_PESO_ENVIADO=$item->CAN_PESO_ENVIADO;
			$CAN_PESO_INGRESO=$item->CAN_PESO_INGRESO;
			$CAN_PESO_SALIDA=$item->CAN_PESO_SALIDA;
			$CAN_PESO_BRUTO=$item->CAN_PESO_BRUTO;

			$CAM_PESO_TARA=$item->CAM_PESO_TARA;
			$CAN_PESO_NETO=$item->CAN_PESO_NETO;
			$CAN_TASA_IGV=$item->CAN_TASA_IGV;
			$CAN_PRECIO_UNIT_IGV=$CANPRECIOUNITIGV;
			$CAN_PRECIO_UNIT=$CANPRECIOUNIT;

			$CAN_PRECIO_ORIGEN=$item->CAN_PRECIO_ORIGEN;
			$CAN_PRECIO_COSTO=$CANPRECIOCOSTO;
			$CAN_PRECIO_BRUTO=$item->CAN_PRECIO_BRUTO;
			$CAN_PRECIO_KILOS=$item->CAN_PRECIO_KILOS;
			$CAN_PRECIO_SACOS=$item->CAN_PRECIO_SACOS;

			$CAN_VALOR_VTA=$CANVALORVTA;
			$CAN_VALOR_VENTA_IGV=$CANVALORVENTAIGV;
			$CAN_KILOS=$item->CAN_KILOS;
			$CAN_SACOS=$item->CAN_SACOS;
			$CAN_PENDIENTE=0;

			$CAN_PORCENTAJE_DESCUENTO=$item->CAN_PORCENTAJE_DESCUENTO;
			$CAN_DESCUENTO=$item->CAN_DESCUENTO;
			$CAN_ADELANTO=$item->CAN_ADELANTO;
			$TXT_DESCRIPCION=$item->TXT_DESCRIPCION;
			$IND_MATERIAL_SERVICIO=$item->IND_MATERIAL_SERVICIO;

			$IND_IGV=$item->IND_IGV;
			$COD_ALMACEN=$item->COD_ALMACEN;
			$TXT_ALMACEN=$item->TXT_ALMACEN;
			$COD_OPERACION=$item->COD_OPERACION;
			$COD_OPERACION_AUX=$item->COD_OPERACION_AUX;

			$COD_EMPR_SERV=$item->COD_EMPR_SERV;
			$TXT_EMPR_SERV=$item->TXT_EMPR_SERV;
			$NRO_CONTRATO_SERV=$item->NRO_CONTRATO_SERV;
			$NRO_CONTRATO_CULTIVO_SERV=$item->NRO_CONTRATO_CULTIVO_SERV;
			$NRO_HABILITACION_SERV=$item->NRO_HABILITACION_SERV;

			$CAN_PRECIO_EMPR_SERV=$item->CAN_PRECIO_EMPR_SERV;
			$NRO_CONTRATO_GRUPO=$item->NRO_CONTRATO_GRUPO;
			$NRO_CONTRATO_CULTIVO_GRUPO=$item->NRO_CONTRATO_CULTIVO_GRUPO;
			$NRO_HABILITACION_GRUPO=$item->NRO_HABILITACION_GRUPO;
			$COD_CATEGORIA_TIPO_PAGO=$item->COD_CATEGORIA_TIPO_PAGO;

			$COD_USUARIO_INGRESO=$item->COD_USUARIO_INGRESO;
			$COD_USUARIO_SALIDA=$item->COD_USUARIO_SALIDA;
			$TXT_GLOSA_PESO_IN=$item->TXT_GLOSA_PESO_IN;
			$TXT_GLOSA_PESO_OUT=$item->TXT_GLOSA_PESO_OUT;
			$COD_CONCEPTO_CENTRO_COSTO=$item->COD_CONCEPTO_CENTRO_COSTO;

			$TXT_CONCEPTO_CENTRO_COSTO=$item->TXT_CONCEPTO_CENTRO_COSTO;
			$TXT_REFERENCIA=$item->TXT_REFERENCIA;
			$TXT_TIPO_REFERENCIA=$item->TXT_TIPO_REFERENCIA;
			$IND_COSTO_ARBITRARIO=$item->IND_COSTO_ARBITRARIO;
			$COD_ESTADO=$item->COD_ESTADO;

			$COD_USUARIO_REGISTRO=$item->COD_USUARIO_REGISTRO;
			$COD_TIPO_ESTADO=$item->COD_TIPO_ESTADO;
			$TXT_TIPO_ESTADO=$item->TXT_TIPO_ESTADO;
			$TXT_GLOSA_ASIENTO=$item->TXT_GLOSA_ASIENTO;
			$TXT_CUENTA_CONTABLE=$item->TXT_CUENTA_CONTABLE;

			$COD_ASIENTO_PROVISION=$item->COD_ASIENTO_PROVISION;
			$COD_ASIENTO_EXTORNO=$item->COD_ASIENTO_EXTORNO;
			$COD_ASIENTO_CANJE=$item->COD_ASIENTO_CANJE;
			$COD_TIPO_DOCUMENTO=$item->COD_TIPO_DOCUMENTO;
			$COD_DOCUMENTO_CTBLE=$item->COD_DOCUMENTO_CTBLE;

			$TXT_SERIE_DOCUMENTO=$item->TXT_SERIE_DOCUMENTO;
			$TXT_NUMERO_DOCUMENTO=$item->TXT_NUMERO_DOCUMENTO;
			$COD_GASTO_FUNCION=$item->COD_GASTO_FUNCION;
			$COD_CENTRO_COSTO=$item->COD_CENTRO_COSTO;
			$COD_ORDEN_COMPRA=$item->COD_ORDEN_COMPRA;

			$FEC_FECHA_SERV=$item->FEC_FECHA_SERV;
			$COD_CATEGORIA_TIPO_SERV_ORDEN=$item->COD_CATEGORIA_TIPO_SERV_ORDEN;
			$IND_GASTO_COSTO=$item->IND_GASTO_COSTO;
			$CAN_PORCENTAJE_PERCEPCION=$item->CAN_PORCENTAJE_PERCEPCION;
			$CAN_VALOR_PERCEPCION=$item->CAN_VALOR_PERCEPCION;



			$stmt 					= 		DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DETALLE_PRODUCTO_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_TABLA = ?,
												@COD_PRODUCTO = ?,
												@COD_LOTE = ?,
												@NRO_LINEA = ?,

												@TXT_NOMBRE_PRODUCTO = ?,
												@TXT_DETALLE_PRODUCTO = ?,
												@CAN_PRODUCTO = ?,
												@CAN_PRODUCTO_ENVIADO = ?,
												@CAN_PESO = ?,

												@CAN_PESO_PRODUCTO = ?,
												@CAN_PESO_ENVIADO = ?,
												@CAN_PESO_INGRESO = ?,
												@CAN_PESO_SALIDA = ?,
												@CAN_PESO_BRUTO = ?,

												@CAM_PESO_TARA = ?,
												@CAN_PESO_NETO = ?,
												@CAN_TASA_IGV = ?,
												@CAN_PRECIO_UNIT_IGV = ?,
												@CAN_PRECIO_UNIT = ?,

												@CAN_PRECIO_ORIGEN = ?,
												@CAN_PRECIO_COSTO = ?,
												@CAN_PRECIO_BRUTO = ?,
												@CAN_PRECIO_KILOS = ?,
												@CAN_PRECIO_SACOS = ?,

												@CAN_VALOR_VTA = ?,
												@CAN_VALOR_VENTA_IGV = ?,
												@CAN_KILOS = ?,
												@CAN_SACOS = ?,
												@CAN_PENDIENTE = ?,

												@CAN_PORCENTAJE_DESCUENTO = ?,
												@CAN_DESCUENTO = ?,
												@CAN_ADELANTO = ?,
												@TXT_DESCRIPCION = ?,
												@IND_MATERIAL_SERVICIO = ?,

												@IND_IGV = ?,
												@COD_ALMACEN = ?,
												@TXT_ALMACEN = ?,
												@COD_OPERACION = ?,
												@COD_OPERACION_AUX = ?,


												@COD_EMPR_SERV = ?,
												@TXT_EMPR_SERV = ?,
												@NRO_CONTRATO_SERV = ?,
												@NRO_CONTRATO_CULTIVO_SERV = ?,
												@NRO_HABILITACION_SERV = ?,

												@CAN_PRECIO_EMPR_SERV = ?,
												@NRO_CONTRATO_GRUPO = ?,
												@NRO_CONTRATO_CULTIVO_GRUPO = ?,
												@NRO_HABILITACION_GRUPO = ?,
												@COD_CATEGORIA_TIPO_PAGO = ?,

												@COD_USUARIO_INGRESO = ?,
												@COD_USUARIO_SALIDA = ?,
												@TXT_GLOSA_PESO_IN = ?,
												@TXT_GLOSA_PESO_OUT = ?,
												@COD_CONCEPTO_CENTRO_COSTO = ?,

												@TXT_CONCEPTO_CENTRO_COSTO = ?,
												@TXT_REFERENCIA = ?,
												@TXT_TIPO_REFERENCIA = ?,
												@IND_COSTO_ARBITRARIO = ?,
												@COD_ESTADO = ?,

												@COD_USUARIO_REGISTRO = ?,
												@COD_TIPO_ESTADO = ?,
												@TXT_TIPO_ESTADO = ?,
												@TXT_GLOSA_ASIENTO = ?,
												@TXT_CUENTA_CONTABLE = ?,

												@COD_ASIENTO_PROVISION = ?,
												@COD_ASIENTO_EXTORNO = ?,
												@COD_ASIENTO_CANJE = ?,
												@COD_TIPO_DOCUMENTO = ?,
												@COD_DOCUMENTO_CTBLE = ?,

												@TXT_SERIE_DOCUMENTO = ?,
												@TXT_NUMERO_DOCUMENTO = ?,
												@COD_GASTO_FUNCION = ?,
												@COD_CENTRO_COSTO = ?,
												@COD_ORDEN_COMPRA = ?,

												@FEC_FECHA_SERV = ?,
												@COD_CATEGORIA_TIPO_SERV_ORDEN = ?,
												@IND_GASTO_COSTO = ?,
												@CAN_PORCENTAJE_PERCEPCION = ?,
												@CAN_VALOR_PERCEPCION = ?


												');

	        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmt->bindParam(2, $COD_TABLA  ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $COD_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(5, $NRO_LINEA  ,PDO::PARAM_STR);

	        $stmt->bindParam(6, $TXT_NOMBRE_PRODUCTO ,PDO::PARAM_STR);
	        $stmt->bindParam(7, $TXT_DETALLE_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(8, $CAN_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(9, $CAN_PRODUCTO_ENVIADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(10,$CAN_PESO  ,PDO::PARAM_STR);

	        $stmt->bindParam(11, $CAN_PESO_PRODUCTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(12, $CAN_PESO_ENVIADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(13, $CAN_PESO_INGRESO  ,PDO::PARAM_STR);
	        $stmt->bindParam(14, $CAN_PESO_SALIDA  ,PDO::PARAM_STR);
	        $stmt->bindParam(15, $CAN_PESO_BRUTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(16, $CAM_PESO_TARA ,PDO::PARAM_STR);
	        $stmt->bindParam(17, $CAN_PESO_NETO  ,PDO::PARAM_STR);
	        $stmt->bindParam(18, $CAN_TASA_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(19, $CAN_PRECIO_UNIT_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(20,$CAN_PRECIO_UNIT  ,PDO::PARAM_STR);

	        $stmt->bindParam(21, $CAN_PRECIO_ORIGEN ,PDO::PARAM_STR);                   
	        $stmt->bindParam(22, $CAN_PRECIO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(23, $CAN_PRECIO_BRUTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(24, $CAN_PRECIO_KILOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(25, $CAN_PRECIO_SACOS  ,PDO::PARAM_STR);

	        $stmt->bindParam(26, $CAN_VALOR_VTA ,PDO::PARAM_STR);
	        $stmt->bindParam(27, $CAN_VALOR_VENTA_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(28, $CAN_KILOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(29, $CAN_SACOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(30,$CAN_PENDIENTE  ,PDO::PARAM_STR);

	        $stmt->bindParam(31, $CAN_PORCENTAJE_DESCUENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(32, $CAN_DESCUENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(33, $CAN_ADELANTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(34, $TXT_DESCRIPCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(35, $IND_MATERIAL_SERVICIO  ,PDO::PARAM_STR);

	        $stmt->bindParam(36, $IND_IGV ,PDO::PARAM_STR);
	        $stmt->bindParam(37, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(38, $TXT_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(39, $COD_OPERACION  ,PDO::PARAM_STR);
	        $stmt->bindParam(40,$COD_OPERACION_AUX  ,PDO::PARAM_STR);

	        $stmt->bindParam(41, $COD_EMPR_SERV ,PDO::PARAM_STR);                   
	        $stmt->bindParam(42, $TXT_EMPR_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(43, $NRO_CONTRATO_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(44, $NRO_CONTRATO_CULTIVO_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(45, $NRO_HABILITACION_SERV  ,PDO::PARAM_STR);

	        $stmt->bindParam(46, $CAN_PRECIO_EMPR_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(47, $NRO_CONTRATO_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(48, $NRO_CONTRATO_CULTIVO_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(49, $NRO_HABILITACION_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(50,$COD_CATEGORIA_TIPO_PAGO  ,PDO::PARAM_STR);

	        $stmt->bindParam(51, $COD_USUARIO_INGRESO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(52, $COD_USUARIO_SALIDA  ,PDO::PARAM_STR);
	        $stmt->bindParam(53, $TXT_GLOSA_PESO_IN  ,PDO::PARAM_STR);
	        $stmt->bindParam(54, $TXT_GLOSA_PESO_OUT  ,PDO::PARAM_STR);
	        $stmt->bindParam(55, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(56, $TXT_CONCEPTO_CENTRO_COSTO ,PDO::PARAM_STR);
	        $stmt->bindParam(57, $TXT_REFERENCIA  ,PDO::PARAM_STR);
	        $stmt->bindParam(58, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
	        $stmt->bindParam(59, $IND_COSTO_ARBITRARIO  ,PDO::PARAM_STR);
	        $stmt->bindParam(60,$COD_ESTADO  ,PDO::PARAM_STR);

	        $stmt->bindParam(61, $COD_USUARIO_REGISTRO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(62, $COD_TIPO_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(63, $TXT_TIPO_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(64, $TXT_GLOSA_ASIENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(65, $TXT_CUENTA_CONTABLE  ,PDO::PARAM_STR);

	        $stmt->bindParam(66, $COD_ASIENTO_PROVISION ,PDO::PARAM_STR);
	        $stmt->bindParam(67, $COD_ASIENTO_EXTORNO  ,PDO::PARAM_STR);
	        $stmt->bindParam(68, $COD_ASIENTO_CANJE  ,PDO::PARAM_STR);
	        $stmt->bindParam(69, $COD_TIPO_DOCUMENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(70,$COD_DOCUMENTO_CTBLE  ,PDO::PARAM_STR);

	        $stmt->bindParam(71, $TXT_SERIE_DOCUMENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(72, $TXT_NUMERO_DOCUMENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(73, $COD_GASTO_FUNCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(74, $COD_CENTRO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(75, $COD_ORDEN_COMPRA  ,PDO::PARAM_STR);

	        $stmt->bindParam(76, $FEC_FECHA_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(77, $COD_CATEGORIA_TIPO_SERV_ORDEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(78, $IND_GASTO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(79, $CAN_PORCENTAJE_PERCEPCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(80,$CAN_VALOR_PERCEPCION  ,PDO::PARAM_STR);


	        $stmt->execute();

		}
	}
	private function update_orden($orden,$detalleproducto) {


		$COD_EMPR            	=       $orden->COD_EMPR;
		$COD_CENTRO            	=       $orden->COD_CENTRO;
		$empresa 				=		STDEmpresa::where('COD_EMPR','=',$orden->COD_EMPR)->first();
		$tipopago 				=		CMPCategoria::where('COD_CATEGORIA','=',$orden->COD_CATEGORIA_TIPO_PAGO)->first();


		$hoy 					= 		date_format(date_create(date('Ymd h:i:s')), 'Ymd');
		$fechapago 				= 		date('Y-m-j');
		$nuevafecha 			= 		strtotime ( '+'.$tipopago->COD_CTBLE.' day' , strtotime($fechapago));
		$nuevafecha 			= 		date ('Y-m-j' , $nuevafecha);
		$fecha_pago 			= 		date_format(date_create($nuevafecha), 'Ymd');

		$fecha_sin 				=		'1901-01-01 00:00:00';
		$vacio 					=		'';
		$activo 				=		'1';
		$idusuario 				=		Session::get('usuario')->name;

		$IND_TIPO_OPERACION='I';
		$COD_ORDEN=$orden->COD_ORDEN;;
		$COD_EMPR=$orden->COD_EMPR;
		$COD_EMPR_CLIENTE=$orden->COD_EMPR;
		$TXT_EMPR_CLIENTE=$empresa->NOM_EMPR;

		$COD_EMPR_LICITACION='';
		$TXT_EMPR_LICITACION='';
		$COD_EMPR_TRANSPORTE='';
		$TXT_EMPR_TRANSPORTE='';
		$COD_EMPR_ORIGEN='';

		$TXT_EMPR_ORIGEN='';
		$COD_CENTRO=$orden->COD_CENTRO;
		$COD_CENTRO_DESTINO='';
		$COD_CENTRO_ORIGEN='';
		$FEC_ORDEN=$orden->FEC_ORDEN;

		$FEC_RECEPCION='1901-01-01';
		$FEC_ENTREGA=$orden->FEC_ENTREGA;
		$FEC_ENTREGA_2='1901-01-01';
		$FEC_ENTREGA_3='1901-01-01';
		$FEC_PAGO=$orden->FEC_PAGO;

		$FEC_NOTA_PEDIDO='1901-01-01';
		$FEC_RECOJO_MERCADERIA='1901-01-01';
		$FEC_ENTREGA_LIMA='1901-01-01';
		$FEC_GRACIA='1901-01-01';
		$FEC_EJECUCION='1901-01-01';

		$IND_MATERIAL_SERVICIO=$orden->IND_MATERIAL_SERVICIO;
		$COD_CATEGORIA_ESTADO_REQ='';
		$COD_CATEGORIA_TIPO_ORDEN=$orden->COD_CATEGORIA_TIPO_ORDEN;
		$TXT_CATEGORIA_TIPO_ORDEN=$orden->TXT_CATEGORIA_TIPO_ORDEN;
		$COD_CATEGORIA_TIPO_PAGO=$orden->COD_CATEGORIA_TIPO_PAGO;

		$COD_CATEGORIA_MONEDA=$orden->COD_CATEGORIA_MONEDA;
		$TXT_CATEGORIA_MONEDA=$orden->TXT_CATEGORIA_MONEDA;
		$COD_CATEGORIA_ESTADO_ORDEN=$orden->COD_CATEGORIA_ESTADO_ORDEN;
		$TXT_CATEGORIA_ESTADO_ORDEN=$orden->TXT_CATEGORIA_ESTADO_ORDEN;
		$COD_CATEGORIA_MOVIMIENTO_INVENTARIO=$orden->COD_CATEGORIA_MOVIMIENTO_INVENTARIO;

		$TXT_CATEGORIA_MOVIMIENTO_INVENTARIO=$orden->TXT_CATEGORIA_MOVIMIENTO_INVENTARIO;
		$COD_CATEGORIA_PROCESO_SEL='';
		$TXT_CATEGORIA_PROCESO_SEL='';
		$COD_CATEGORIA_MODALIDAD_SEL='';
		$TXT_CATEGORIA_MODALIDAD_SEL='';

		$COD_CATEGORIA_AREA_EMPRESA='';
		$TXT_CATEGORIA_AREA_EMPRESA='';
		$COD_CONCEPTO_CENTRO_COSTO='';
		$COD_CHOFER='';
		$COD_VEHICULO='';

		$COD_CARRETA='';
		$TXT_CARRETA='';
		$COD_CONTRATO_ORIGEN='';
		$COD_CULTIVO_ORIGEN='';
		$COD_CONTRATO_LICITACION='';

		$COD_CULTIVO_LICITACION='';
		$COD_CONTRATO_TRANSPORTE='';
		$COD_CULTIVO_TRANSPORTE='';
		$COD_CONTRATO=$orden->COD_CONTRATO;
		$COD_CULTIVO=$orden->COD_CULTIVO;

		$COD_HABILITACION='';
		$COD_HABILITACION_DCTO='';
		$COD_ALMACEN_ORIGEN='';
		$COD_ALMACEN_DESTINO='';
		$COD_TRABAJADOR_SOLICITA='';

		$COD_TRABAJADOR_ENCARGADO='';
		$COD_TRABAJADOR_COMISIONISTA='';
		$COD_CONTRATO_COMISIONISTA='';
		$COD_CULTIVO_COMISIONISTA='';
		$COD_HABILITACION_COMISIONISTA='';

		$COD_TRABAJADOR_VENDEDOR='';
		$COD_ZONA_COMERCIAL='';
		$TXT_ZONA_COMERCIAL='';
		$COD_LOTE_CC='';
		$CAN_SUB_TOTAL=$orden->CAN_SUB_TOTAL;

		$CAN_IMPUESTO_VTA=$orden->CAN_IMPUESTO_VTA;
		$CAN_IMPUESTO_RENTA=$orden->CAN_IMPUESTO_RENTA;
		$CAN_TOTAL=$orden->CAN_TOTAL;
		$CAN_DSCTO=$orden->CAN_DSCTO;
		$CAN_TIPO_CAMBIO=$orden->CAN_TIPO_CAMBIO;

		$CAN_PERCEPCION=$orden->CAN_PERCEPCION;
		$CAN_DETRACCION=$orden->CAN_DETRACCION;
		$CAN_RETENCION=$orden->CAN_RETENCION;
		$CAN_NETO_PAGAR=$orden->CAN_NETO_PAGAR;
		$CAN_TOTAL_COMISION=$orden->CAN_TOTAL_COMISION;

		$COD_EMPR_BANCO='';
		$NRO_CUENTA_BANCARIA='';
		$NRO_CARRO='';
		$IND_VARIAS_ENTREGAS=$orden->IND_VARIAS_ENTREGAS;
		$IND_TIPO_COMPRA='';

		$NOM_CHOFER_EMPR_TRANSPORTE='';
		$NRO_ORDEN_CEN='';
		$NRO_LICITACION='';
		$NRO_NOTA_PEDIDO='';
		$NRO_OPERACIONES_CAJA='';

		$TXT_NRO_PLACA='';
		$TXT_CONTACTO='';
		$TXT_MOTIVO_ANULACION='';
		$TXT_CONFORMIDAD='';
		$TXT_A_TIEMPO='';

		$TXT_DESTINO='';
		$TXT_TIPO_DOC_ASOC='';
		$TXT_DOC_ASOC='';
		$TXT_ORDEN_ASOC='';
		$COD_CATEGORIA_MODULO=$orden->COD_CATEGORIA_MODULO;

		$TXT_GLOSA_ATENCION='';
		$TXT_GLOSA=$orden->TXT_GLOSA;
		$TXT_TIPO_REFERENCIA='';
		$TXT_REFERENCIA=$orden->TXT_REFERENCIA;
		$COD_OPERACION='';

		$TXT_GRR='';
		$TXT_GRR_TRANSPORTISTA='';
		$TXT_CTC='';
		$IND_ZONA=0;
		$IND_CERRADO=0;

		$COD_EMP_PROV_SERV=$orden->COD_EMPR;
		$TXT_EMP_PROV_SERV='';
		$COD_ESTADO=1;
		$COD_USUARIO_REGISTRO=$orden->COD_USUARIO_REGISTRO;
		$COD_CTA_GASTO_FUNCION='';

		$NRO_CTA_GASTO_FUNCION='';
		$COD_CATEGORIA_ACTIVIDAD_NEGOCIO=$orden->COD_CATEGORIA_ACTIVIDAD_NEGOCIO;
		$COD_EMPR_PROPIETARIO=$orden->COD_EMPR_PROPIETARIO;
		$TXT_EMPR_PROPIETARIO='';
		$COD_CATEGORIA_TIPO_COSTEO='';

		$TXT_CATEGORIA_TIPO_COSTEO='';
		$TXT_CORRELATIVO='';
		$COD_MOVIMIENTO_INVENTARIO_EXTORNADO='';
		$COD_ORDEN_EXTORNADA='';
		$IND_ENV_CLIENTE=0;

		$IND_ORDEN='';
		$COD_MOTIVO_EXTORNO='';
		$GLOSA_EXTORNO='';



		$stmt 					= 		DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.ORDEN_IUD 
											@IND_TIPO_OPERACION = ?,
											@COD_ORDEN = ?,
											@COD_EMPR = ?,
											@COD_EMPR_CLIENTE = ?,
											@TXT_EMPR_CLIENTE = ?,

											@COD_EMPR_LICITACION = ?,
											@TXT_EMPR_LICITACION = ?,
											@COD_EMPR_TRANSPORTE = ?,
											@TXT_EMPR_TRANSPORTE = ?,
											@COD_EMPR_ORIGEN = ?,

											@TXT_EMPR_ORIGEN = ?,
											@COD_CENTRO = ?,
											@COD_CENTRO_DESTINO = ?,
											@COD_CENTRO_ORIGEN = ?,
											@FEC_ORDEN = ?,

											@FEC_RECEPCION = ?,
											@FEC_ENTREGA = ?,
											@FEC_ENTREGA_2 = ?,
											@FEC_ENTREGA_3 = ?,
											@FEC_PAGO = ?,

											@FEC_NOTA_PEDIDO = ?,
											@FEC_RECOJO_MERCADERIA = ?,
											@FEC_ENTREGA_LIMA = ?,
											@FEC_GRACIA = ?,
											@FEC_EJECUCION = ?,

											@IND_MATERIAL_SERVICIO = ?,
											@COD_CATEGORIA_ESTADO_REQ = ?,
											@COD_CATEGORIA_TIPO_ORDEN = ?,
											@TXT_CATEGORIA_TIPO_ORDEN = ?,
											@COD_CATEGORIA_TIPO_PAGO = ?,

											@COD_CATEGORIA_MONEDA = ?,
											@TXT_CATEGORIA_MONEDA = ?,
											@COD_CATEGORIA_ESTADO_ORDEN = ?,
											@TXT_CATEGORIA_ESTADO_ORDEN = ?,
											@COD_CATEGORIA_MOVIMIENTO_INVENTARIO = ?,

											@TXT_CATEGORIA_MOVIMIENTO_INVENTARIO = ?,
											@COD_CATEGORIA_PROCESO_SEL = ?,
											@TXT_CATEGORIA_PROCESO_SEL = ?,
											@COD_CATEGORIA_MODALIDAD_SEL = ?,
											@TXT_CATEGORIA_MODALIDAD_SEL = ?,

											@COD_CATEGORIA_AREA_EMPRESA = ?,
											@TXT_CATEGORIA_AREA_EMPRESA = ?,
											@COD_CONCEPTO_CENTRO_COSTO = ?,
											@COD_CHOFER = ?,
											@COD_VEHICULO = ?,

											@COD_CARRETA = ?,
											@TXT_CARRETA = ?,
											@COD_CONTRATO_ORIGEN = ?,
											@COD_CULTIVO_ORIGEN = ?,
											@COD_CONTRATO_LICITACION = ?,


											@COD_CULTIVO_LICITACION = ?,
											@COD_CONTRATO_TRANSPORTE = ?,
											@COD_CULTIVO_TRANSPORTE = ?,
											@COD_CONTRATO = ?,
											@COD_CULTIVO = ?,

											@COD_HABILITACION = ?,
											@COD_HABILITACION_DCTO = ?,
											@COD_ALMACEN_ORIGEN = ?,
											@COD_ALMACEN_DESTINO = ?,
											@COD_TRABAJADOR_SOLICITA = ?,

											@COD_TRABAJADOR_ENCARGADO = ?,
											@COD_TRABAJADOR_COMISIONISTA = ?,
											@COD_CONTRATO_COMISIONISTA = ?,
											@COD_CULTIVO_COMISIONISTA = ?,
											@COD_HABILITACION_COMISIONISTA = ?,

											@COD_TRABAJADOR_VENDEDOR = ?,
											@COD_ZONA_COMERCIAL = ?,
											@TXT_ZONA_COMERCIAL = ?,
											@COD_LOTE_CC = ?,
											@CAN_SUB_TOTAL = ?,

											@CAN_IMPUESTO_VTA = ?,
											@CAN_IMPUESTO_RENTA = ?,
											@CAN_TOTAL = ?,
											@CAN_DSCTO = ?,
											@CAN_TIPO_CAMBIO = ?,

											@CAN_PERCEPCION = ?,
											@CAN_DETRACCION = ?,
											@CAN_RETENCION = ?,
											@CAN_NETO_PAGAR = ?,
											@CAN_TOTAL_COMISION = ?,
											
											@COD_EMPR_BANCO = ?,
											@NRO_CUENTA_BANCARIA = ?,
											@NRO_CARRO = ?,
											@IND_VARIAS_ENTREGAS = ?,
											@IND_TIPO_COMPRA = ?,

											@NOM_CHOFER_EMPR_TRANSPORTE = ?,
											@NRO_ORDEN_CEN = ?,
											@NRO_LICITACION = ?,
											@NRO_NOTA_PEDIDO = ?,
											@NRO_OPERACIONES_CAJA = ?,

											@TXT_NRO_PLACA = ?,
											@TXT_CONTACTO = ?,
											@TXT_MOTIVO_ANULACION = ?,
											@TXT_CONFORMIDAD = ?,
											@TXT_A_TIEMPO = ?,

											@TXT_DESTINO = ?,
											@TXT_TIPO_DOC_ASOC = ?,
											@TXT_DOC_ASOC = ?,
											@TXT_ORDEN_ASOC = ?,
											@COD_CATEGORIA_MODULO = ?,


											@TXT_GLOSA_ATENCION = ?,
											@TXT_GLOSA = ?,
											@TXT_TIPO_REFERENCIA = ?,
											@TXT_REFERENCIA = ?,
											@COD_OPERACION = ?,
											
											@TXT_GRR = ?,
											@TXT_GRR_TRANSPORTISTA = ?,
											@TXT_CTC = ?,
											@IND_ZONA = ?,
											@IND_CERRADO = ?,

											@COD_EMP_PROV_SERV = ?,
											@TXT_EMP_PROV_SERV = ?,
											@COD_ESTADO = ?,
											@COD_USUARIO_REGISTRO = ?,
											@COD_CTA_GASTO_FUNCION = ?,

											@NRO_CTA_GASTO_FUNCION = ?,
											@COD_CATEGORIA_ACTIVIDAD_NEGOCIO = ?,
											@COD_EMPR_PROPIETARIO = ?,
											@TXT_EMPR_PROPIETARIO = ?,
											@COD_CATEGORIA_TIPO_COSTEO = ?,

											@TXT_CATEGORIA_TIPO_COSTEO = ?,
											@TXT_CORRELATIVO = ?,
											@COD_MOVIMIENTO_INVENTARIO_EXTORNADO = ?,
											@COD_ORDEN_EXTORNADA = ?,
											@IND_ENV_CLIENTE = ?,

											@IND_ORDEN = ?,
											@COD_MOTIVO_EXTORNO = ?,
											@GLOSA_EXTORNO = ?

											');

        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(2, $COD_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(3, $COD_EMPR  ,PDO::PARAM_STR);
        $stmt->bindParam(4, $COD_EMPR_CLIENTE  ,PDO::PARAM_STR);
        $stmt->bindParam(5, $TXT_EMPR_CLIENTE  ,PDO::PARAM_STR);

        $stmt->bindParam(6, $COD_EMPR_LICITACION ,PDO::PARAM_STR);
        $stmt->bindParam(7, $TXT_EMPR_LICITACION  ,PDO::PARAM_STR);
        $stmt->bindParam(8, $COD_EMPR_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(9, $TXT_EMPR_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(10,$COD_EMPR_ORIGEN  ,PDO::PARAM_STR);

        $stmt->bindParam(11, $TXT_EMPR_ORIGEN ,PDO::PARAM_STR);                   
        $stmt->bindParam(12, $COD_CENTRO  ,PDO::PARAM_STR);
        $stmt->bindParam(13, $COD_CENTRO_DESTINO  ,PDO::PARAM_STR);
        $stmt->bindParam(14, $COD_CENTRO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(15, $FEC_ORDEN  ,PDO::PARAM_STR);

        $stmt->bindParam(16, $FEC_RECEPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(17, $FEC_ENTREGA  ,PDO::PARAM_STR);
        $stmt->bindParam(18, $FEC_ENTREGA_2  ,PDO::PARAM_STR);
        $stmt->bindParam(19, $FEC_ENTREGA_3  ,PDO::PARAM_STR);
        $stmt->bindParam(20, $FEC_PAGO  ,PDO::PARAM_STR);

        $stmt->bindParam(21, $FEC_NOTA_PEDIDO ,PDO::PARAM_STR);
        $stmt->bindParam(22, $FEC_RECOJO_MERCADERIA  ,PDO::PARAM_STR);
        $stmt->bindParam(23, $FEC_ENTREGA_LIMA  ,PDO::PARAM_STR);
        $stmt->bindParam(24, $FEC_GRACIA  ,PDO::PARAM_STR);
        $stmt->bindParam(25,$FEC_EJECUCION  ,PDO::PARAM_STR);

        $stmt->bindParam(26, $IND_MATERIAL_SERVICIO ,PDO::PARAM_STR);                   
        $stmt->bindParam(27, $COD_CATEGORIA_ESTADO_REQ  ,PDO::PARAM_STR);
        $stmt->bindParam(28, $COD_CATEGORIA_TIPO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(29, $TXT_CATEGORIA_TIPO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(30, $COD_CATEGORIA_TIPO_PAGO  ,PDO::PARAM_STR);

        $stmt->bindParam(31, $COD_CATEGORIA_MONEDA ,PDO::PARAM_STR);                   
        $stmt->bindParam(32, $TXT_CATEGORIA_MONEDA  ,PDO::PARAM_STR);
        $stmt->bindParam(33, $COD_CATEGORIA_ESTADO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(34, $TXT_CATEGORIA_ESTADO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(35, $COD_CATEGORIA_MOVIMIENTO_INVENTARIO  ,PDO::PARAM_STR);

        $stmt->bindParam(36, $TXT_CATEGORIA_MOVIMIENTO_INVENTARIO ,PDO::PARAM_STR);
        $stmt->bindParam(37, $COD_CATEGORIA_PROCESO_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(38, $TXT_CATEGORIA_PROCESO_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(39, $COD_CATEGORIA_MODALIDAD_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(40,$TXT_CATEGORIA_MODALIDAD_SEL  ,PDO::PARAM_STR);

        $stmt->bindParam(41, $COD_CATEGORIA_AREA_EMPRESA ,PDO::PARAM_STR);                   
        $stmt->bindParam(42, $TXT_CATEGORIA_AREA_EMPRESA  ,PDO::PARAM_STR);
        $stmt->bindParam(43, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);
        $stmt->bindParam(44, $COD_CHOFER  ,PDO::PARAM_STR);
        $stmt->bindParam(45, $COD_VEHICULO  ,PDO::PARAM_STR);

        $stmt->bindParam(46, $COD_CARRETA ,PDO::PARAM_STR);                   
        $stmt->bindParam(47, $TXT_CARRETA  ,PDO::PARAM_STR);
        $stmt->bindParam(48, $COD_CONTRATO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(49, $COD_CULTIVO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(50, $COD_CONTRATO_LICITACION  ,PDO::PARAM_STR);

        $stmt->bindParam(51, $COD_CULTIVO_LICITACION ,PDO::PARAM_STR);
        $stmt->bindParam(52, $COD_CONTRATO_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(53, $COD_CULTIVO_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(54, $COD_CONTRATO  ,PDO::PARAM_STR);
        $stmt->bindParam(55,$COD_CULTIVO  ,PDO::PARAM_STR);

        $stmt->bindParam(56, $COD_HABILITACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(57, $COD_HABILITACION_DCTO  ,PDO::PARAM_STR);
        $stmt->bindParam(58, $COD_ALMACEN_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(59, $COD_ALMACEN_DESTINO  ,PDO::PARAM_STR);
        $stmt->bindParam(60, $COD_TRABAJADOR_SOLICITA  ,PDO::PARAM_STR);


        $stmt->bindParam(61, $COD_TRABAJADOR_ENCARGADO ,PDO::PARAM_STR);                   
        $stmt->bindParam(62, $COD_TRABAJADOR_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(63, $COD_CONTRATO_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(64, $COD_CULTIVO_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(65, $COD_HABILITACION_COMISIONISTA  ,PDO::PARAM_STR);

        $stmt->bindParam(66, $COD_TRABAJADOR_VENDEDOR ,PDO::PARAM_STR);
        $stmt->bindParam(67, $COD_ZONA_COMERCIAL  ,PDO::PARAM_STR);
        $stmt->bindParam(68, $TXT_ZONA_COMERCIAL  ,PDO::PARAM_STR);
        $stmt->bindParam(69, $COD_LOTE_CC  ,PDO::PARAM_STR);
        $stmt->bindParam(70,$CAN_SUB_TOTAL  ,PDO::PARAM_STR);

        $stmt->bindParam(71, $CAN_IMPUESTO_VTA ,PDO::PARAM_STR);                   
        $stmt->bindParam(72, $CAN_IMPUESTO_RENTA  ,PDO::PARAM_STR);
        $stmt->bindParam(73, $CAN_TOTAL  ,PDO::PARAM_STR);
        $stmt->bindParam(74, $CAN_DSCTO  ,PDO::PARAM_STR);
        $stmt->bindParam(75, $CAN_TIPO_CAMBIO  ,PDO::PARAM_STR);

        $stmt->bindParam(76, $CAN_PERCEPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(77, $CAN_DETRACCION  ,PDO::PARAM_STR);
        $stmt->bindParam(78, $CAN_RETENCION  ,PDO::PARAM_STR);
        $stmt->bindParam(79, $CAN_NETO_PAGAR  ,PDO::PARAM_STR);
        $stmt->bindParam(80, $CAN_TOTAL_COMISION  ,PDO::PARAM_STR);

        $stmt->bindParam(81, $COD_EMPR_BANCO ,PDO::PARAM_STR);
        $stmt->bindParam(82, $NRO_CUENTA_BANCARIA  ,PDO::PARAM_STR);
        $stmt->bindParam(83, $NRO_CARRO  ,PDO::PARAM_STR);
        $stmt->bindParam(84, $IND_VARIAS_ENTREGAS  ,PDO::PARAM_STR);
        $stmt->bindParam(85,$IND_TIPO_COMPRA  ,PDO::PARAM_STR);

        $stmt->bindParam(86, $NOM_CHOFER_EMPR_TRANSPORTE ,PDO::PARAM_STR);                   
        $stmt->bindParam(87, $NRO_ORDEN_CEN  ,PDO::PARAM_STR);
        $stmt->bindParam(88, $NRO_LICITACION  ,PDO::PARAM_STR);
        $stmt->bindParam(89, $NRO_NOTA_PEDIDO  ,PDO::PARAM_STR);
        $stmt->bindParam(90, $NRO_OPERACIONES_CAJA  ,PDO::PARAM_STR);

        $stmt->bindParam(91, $TXT_NRO_PLACA ,PDO::PARAM_STR);                   
        $stmt->bindParam(92, $TXT_CONTACTO  ,PDO::PARAM_STR);
        $stmt->bindParam(93, $TXT_MOTIVO_ANULACION  ,PDO::PARAM_STR);
        $stmt->bindParam(94, $TXT_CONFORMIDAD  ,PDO::PARAM_STR);
        $stmt->bindParam(95, $TXT_A_TIEMPO  ,PDO::PARAM_STR);

        $stmt->bindParam(96, $TXT_DESTINO ,PDO::PARAM_STR);
        $stmt->bindParam(97, $TXT_TIPO_DOC_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(98, $TXT_DOC_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(99, $TXT_ORDEN_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(100,$COD_CATEGORIA_MODULO  ,PDO::PARAM_STR);

        $stmt->bindParam(101, $TXT_GLOSA_ATENCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(102, $TXT_GLOSA  ,PDO::PARAM_STR);
        $stmt->bindParam(103, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(104, $TXT_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(105, $COD_OPERACION  ,PDO::PARAM_STR);

        $stmt->bindParam(106, $TXT_GRR ,PDO::PARAM_STR);                   
        $stmt->bindParam(107, $TXT_GRR_TRANSPORTISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(108, $TXT_CTC  ,PDO::PARAM_STR);
        $stmt->bindParam(109, $IND_ZONA  ,PDO::PARAM_STR);
        $stmt->bindParam(110, $IND_CERRADO  ,PDO::PARAM_STR);

        $stmt->bindParam(111, $COD_EMP_PROV_SERV ,PDO::PARAM_STR);
        $stmt->bindParam(112, $TXT_EMP_PROV_SERV  ,PDO::PARAM_STR);
        $stmt->bindParam(113, $COD_ESTADO  ,PDO::PARAM_STR);
        $stmt->bindParam(114, $COD_USUARIO_REGISTRO  ,PDO::PARAM_STR);
        $stmt->bindParam(115,$COD_CTA_GASTO_FUNCION  ,PDO::PARAM_STR);

        $stmt->bindParam(116, $NRO_CTA_GASTO_FUNCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(117, $COD_CATEGORIA_ACTIVIDAD_NEGOCIO  ,PDO::PARAM_STR);
        $stmt->bindParam(118, $COD_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
        $stmt->bindParam(119, $TXT_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
        $stmt->bindParam(120, $COD_CATEGORIA_TIPO_COSTEO  ,PDO::PARAM_STR);


        $stmt->bindParam(121, $TXT_CATEGORIA_TIPO_COSTEO ,PDO::PARAM_STR);
        $stmt->bindParam(122, $TXT_CORRELATIVO  ,PDO::PARAM_STR);
        $stmt->bindParam(123, $COD_MOVIMIENTO_INVENTARIO_EXTORNADO  ,PDO::PARAM_STR);
        $stmt->bindParam(124, $COD_ORDEN_EXTORNADA  ,PDO::PARAM_STR);
        $stmt->bindParam(125,$IND_ENV_CLIENTE  ,PDO::PARAM_STR);

        $stmt->bindParam(126, $IND_ORDEN ,PDO::PARAM_STR);                   
        $stmt->bindParam(127, $COD_MOTIVO_EXTORNO  ,PDO::PARAM_STR);
        $stmt->bindParam(128, $GLOSA_EXTORNO  ,PDO::PARAM_STR);

        $stmt->execute();
	}

	private function insert_detalle_producto_cascara($orden,$detalleproducto,$ordeningreso_id) {


        $conexionbd         = 'sqlsrv';
        if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }


		$COD_EMPR            		=       $orden->COD_EMPR;
		$COD_CENTRO            		=       $orden->COD_CENTRO;
		$idusuario 					=		Session::get('usuario')->name;




		foreach($detalleproducto as $index => $item){


			$IND_TIPO_OPERACION 	=		'I';
			$fecha_sin 				=		'1901-01-01 00:00:00';
			$vacio 					=		'';
			$activo 				=		'1';
			$idusuario 				=		Session::get('usuario')->name;
			$COD_ALMACEN            =       $item->COD_ALMACEN;
			$COD_LOTE            	=       '';

			$stmtlo 					= 		DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC ALM.ALMACEN_LOTE_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_ALMACEN = ?,
												@COD_LOTE = ?,
												@COD_EMPR = ?,
												@COD_CENTRO = ?,

												@TXT_UBICACION = ?,
												@FEC_HORA_IN = ?,
												@FEC_HORA_OUT = ?,
												@COD_EQUIPO = ?,
												@TIPO_LOTE = ?,

												@COD_GRIFO = ?,
												@COD_LUG_GRIFO = ?,
												@COD_EMPR_PROPIETARIO = ?,
												@COD_EMPR_PROVEEDOR_SERV = ?,
												@COD_ESTADO = ?,

												@COD_USUARIO_REGISTRO = ?
												');

	        $stmtlo->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmtlo->bindParam(2, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(3, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(4, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(5, $COD_CENTRO  ,PDO::PARAM_STR);

	        $stmtlo->bindParam(6, $vacio ,PDO::PARAM_STR);
	        $stmtlo->bindParam(7, $fecha_sin  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(8, $fecha_sin  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(9, $vacio  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(10,$vacio  ,PDO::PARAM_STR);

	        $stmtlo->bindParam(11, $vacio ,PDO::PARAM_STR);                   
	        $stmtlo->bindParam(12, $vacio  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(13, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(14, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(15, $activo  ,PDO::PARAM_STR);
	        $stmtlo->bindParam(16, $idusuario  ,PDO::PARAM_STR);
	        $stmtlo->execute();
	        $codlotecito = $stmtlo->fetch();


	        //dd($codlotecito[0]);

			//DOLARES
			$CANPRECIOUNITIGV 			=	$item->CAN_PRECIO_UNIT_IGV;
			$CANPRECIOUNIT 				=	$item->CAN_PRECIO_UNIT;
			$CANPRECIOCOSTO 			=	$item->CAN_PRECIO_COSTO;
			$CANVALORVTA 				=	$item->CAN_VALOR_VTA;
			$CANVALORVENTAIGV 			=	$item->CAN_VALOR_VENTA_IGV;


			if($orden->COD_CATEGORIA_MONEDA=='MON0000000000002'){

				$CANPRECIOUNITIGV 		=	$item->CAN_PRECIO_UNIT_IGV*$orden->CAN_TIPO_CAMBIO;
				$CANPRECIOUNIT 			=	$item->CAN_PRECIO_UNIT*$orden->CAN_TIPO_CAMBIO;
				$CANPRECIOCOSTO 		=	$item->CAN_PRECIO_UNIT*$orden->CAN_TIPO_CAMBIO;
				$CANVALORVTA 			=	$item->CAN_VALOR_VTA*$orden->CAN_TIPO_CAMBIO;
				$CANVALORVENTAIGV 		=	$item->CAN_VALOR_VENTA_IGV*$orden->CAN_TIPO_CAMBIO;

			}


			$IND_TIPO_OPERACION='I';
			$COD_TABLA=$ordeningreso_id;
			$COD_PRODUCTO=$item->COD_PRODUCTO;
			$COD_LOTE=$codlotecito[0];
			$NRO_LINEA=$item->NRO_LINEA;

			$TXT_NOMBRE_PRODUCTO=$item->TXT_NOMBRE_PRODUCTO;
			$TXT_DETALLE_PRODUCTO='';
			$CAN_PRODUCTO=$item->CAN_PRODUCTO;
			$CAN_PRODUCTO_ENVIADO=$item->CAN_PRODUCTO_ENVIADO;
			$CAN_PESO=$item->CAN_PESO;

			$CAN_PESO_PRODUCTO=$item->CAN_PESO_PRODUCTO;
			$CAN_PESO_ENVIADO=$item->CAN_PESO_ENVIADO;
			$CAN_PESO_INGRESO=$item->CAN_PESO_INGRESO;
			$CAN_PESO_SALIDA=$item->CAN_PESO_SALIDA;
			$CAN_PESO_BRUTO=$item->CAN_PESO_BRUTO;

			$CAM_PESO_TARA=$item->CAM_PESO_TARA;
			$CAN_PESO_NETO=$item->CAN_PESO_NETO;
			$CAN_TASA_IGV=0;
			$CAN_PRECIO_UNIT_IGV=$CANPRECIOUNITIGV;
			$CAN_PRECIO_UNIT=$CANPRECIOUNIT;

			$CAN_PRECIO_ORIGEN=$item->CAN_PRECIO_ORIGEN;
			$CAN_PRECIO_COSTO=$CANPRECIOCOSTO;
			$CAN_PRECIO_BRUTO=$item->CAN_PRECIO_BRUTO;
			$CAN_PRECIO_KILOS=$item->CAN_PRECIO_KILOS;
			$CAN_PRECIO_SACOS=$item->CAN_PRECIO_SACOS;

			$CAN_VALOR_VTA=$CANVALORVTA;
			$CAN_VALOR_VENTA_IGV=$CANVALORVENTAIGV;
			$CAN_KILOS=$item->CAN_KILOS;
			$CAN_SACOS=$item->CAN_SACOS;
			$CAN_PENDIENTE=0;

			$CAN_PORCENTAJE_DESCUENTO=$item->CAN_PORCENTAJE_DESCUENTO;
			$CAN_DESCUENTO=$item->CAN_DESCUENTO;
			$CAN_ADELANTO=$item->CAN_ADELANTO;
			$TXT_DESCRIPCION='';
			$IND_MATERIAL_SERVICIO=$item->IND_MATERIAL_SERVICIO;

			$IND_IGV=$item->IND_IGV;
			$COD_ALMACEN=$item->COD_ALMACEN;
			$TXT_ALMACEN=$item->TXT_ALMACEN;
			$COD_OPERACION=$item->COD_OPERACION;
			$COD_OPERACION_AUX=$item->COD_OPERACION_AUX;

			$COD_EMPR_SERV=$item->COD_EMPR_SERV;
			$TXT_EMPR_SERV=$item->TXT_EMPR_SERV;
			$NRO_CONTRATO_SERV=$item->NRO_CONTRATO_SERV;
			$NRO_CONTRATO_CULTIVO_SERV=$item->NRO_CONTRATO_CULTIVO_SERV;
			$NRO_HABILITACION_SERV=$item->NRO_HABILITACION_SERV;

			$CAN_PRECIO_EMPR_SERV=$item->CAN_PRECIO_EMPR_SERV;
			$NRO_CONTRATO_GRUPO=$item->NRO_CONTRATO_GRUPO;
			$NRO_CONTRATO_CULTIVO_GRUPO=$item->NRO_CONTRATO_CULTIVO_GRUPO;
			$NRO_HABILITACION_GRUPO=$item->NRO_HABILITACION_GRUPO;
			$COD_CATEGORIA_TIPO_PAGO=$item->COD_CATEGORIA_TIPO_PAGO;

			$COD_USUARIO_INGRESO=$item->COD_USUARIO_INGRESO;
			$COD_USUARIO_SALIDA=$item->COD_USUARIO_SALIDA;
			$TXT_GLOSA_PESO_IN=$item->TXT_GLOSA_PESO_IN;
			$TXT_GLOSA_PESO_OUT=$item->TXT_GLOSA_PESO_OUT;
			$COD_CONCEPTO_CENTRO_COSTO='';

			$TXT_CONCEPTO_CENTRO_COSTO='';
			$TXT_REFERENCIA=$item->TXT_REFERENCIA;
			$TXT_TIPO_REFERENCIA=$item->TXT_TIPO_REFERENCIA;
			$IND_COSTO_ARBITRARIO=$item->IND_COSTO_ARBITRARIO;
			$COD_ESTADO=$item->COD_ESTADO;

			$COD_USUARIO_REGISTRO=$idusuario;
			$COD_TIPO_ESTADO=$item->COD_TIPO_ESTADO;
			$TXT_TIPO_ESTADO=$item->TXT_TIPO_ESTADO;
			$TXT_GLOSA_ASIENTO=$item->TXT_GLOSA_ASIENTO;
			$TXT_CUENTA_CONTABLE=$item->TXT_CUENTA_CONTABLE;

			$COD_ASIENTO_PROVISION=$item->COD_ASIENTO_PROVISION;
			$COD_ASIENTO_EXTORNO=$item->COD_ASIENTO_EXTORNO;
			$COD_ASIENTO_CANJE=$item->COD_ASIENTO_CANJE;
			$COD_TIPO_DOCUMENTO=$item->COD_TIPO_DOCUMENTO;
			$COD_DOCUMENTO_CTBLE=$item->COD_DOCUMENTO_CTBLE;

			$TXT_SERIE_DOCUMENTO=$item->TXT_SERIE_DOCUMENTO;
			$TXT_NUMERO_DOCUMENTO=$item->TXT_NUMERO_DOCUMENTO;
			$COD_GASTO_FUNCION=$item->COD_GASTO_FUNCION;
			$COD_CENTRO_COSTO=$item->COD_CENTRO_COSTO;
			$COD_ORDEN_COMPRA=$item->COD_ORDEN_COMPRA;

			$FEC_FECHA_SERV=$item->FEC_FECHA_SERV;
			$COD_CATEGORIA_TIPO_SERV_ORDEN=$item->COD_CATEGORIA_TIPO_SERV_ORDEN;
			$IND_GASTO_COSTO=$item->IND_GASTO_COSTO;
			$CAN_PORCENTAJE_PERCEPCION=$item->CAN_PORCENTAJE_PERCEPCION;
			$CAN_VALOR_PERCEPCION=$item->CAN_VALOR_PERCEPCION;



			$stmt 					= 		DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DETALLE_PRODUCTO_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_TABLA = ?,
												@COD_PRODUCTO = ?,
												@COD_LOTE = ?,
												@NRO_LINEA = ?,

												@TXT_NOMBRE_PRODUCTO = ?,
												@TXT_DETALLE_PRODUCTO = ?,
												@CAN_PRODUCTO = ?,
												@CAN_PRODUCTO_ENVIADO = ?,
												@CAN_PESO = ?,

												@CAN_PESO_PRODUCTO = ?,
												@CAN_PESO_ENVIADO = ?,
												@CAN_PESO_INGRESO = ?,
												@CAN_PESO_SALIDA = ?,
												@CAN_PESO_BRUTO = ?,

												@CAM_PESO_TARA = ?,
												@CAN_PESO_NETO = ?,
												@CAN_TASA_IGV = ?,
												@CAN_PRECIO_UNIT_IGV = ?,
												@CAN_PRECIO_UNIT = ?,

												@CAN_PRECIO_ORIGEN = ?,
												@CAN_PRECIO_COSTO = ?,
												@CAN_PRECIO_BRUTO = ?,
												@CAN_PRECIO_KILOS = ?,
												@CAN_PRECIO_SACOS = ?,

												@CAN_VALOR_VTA = ?,
												@CAN_VALOR_VENTA_IGV = ?,
												@CAN_KILOS = ?,
												@CAN_SACOS = ?,
												@CAN_PENDIENTE = ?,

												@CAN_PORCENTAJE_DESCUENTO = ?,
												@CAN_DESCUENTO = ?,
												@CAN_ADELANTO = ?,
												@TXT_DESCRIPCION = ?,
												@IND_MATERIAL_SERVICIO = ?,

												@IND_IGV = ?,
												@COD_ALMACEN = ?,
												@TXT_ALMACEN = ?,
												@COD_OPERACION = ?,
												@COD_OPERACION_AUX = ?,


												@COD_EMPR_SERV = ?,
												@TXT_EMPR_SERV = ?,
												@NRO_CONTRATO_SERV = ?,
												@NRO_CONTRATO_CULTIVO_SERV = ?,
												@NRO_HABILITACION_SERV = ?,

												@CAN_PRECIO_EMPR_SERV = ?,
												@NRO_CONTRATO_GRUPO = ?,
												@NRO_CONTRATO_CULTIVO_GRUPO = ?,
												@NRO_HABILITACION_GRUPO = ?,
												@COD_CATEGORIA_TIPO_PAGO = ?,

												@COD_USUARIO_INGRESO = ?,
												@COD_USUARIO_SALIDA = ?,
												@TXT_GLOSA_PESO_IN = ?,
												@TXT_GLOSA_PESO_OUT = ?,
												@COD_CONCEPTO_CENTRO_COSTO = ?,

												@TXT_CONCEPTO_CENTRO_COSTO = ?,
												@TXT_REFERENCIA = ?,
												@TXT_TIPO_REFERENCIA = ?,
												@IND_COSTO_ARBITRARIO = ?,
												@COD_ESTADO = ?,

												@COD_USUARIO_REGISTRO = ?,
												@COD_TIPO_ESTADO = ?,
												@TXT_TIPO_ESTADO = ?,
												@TXT_GLOSA_ASIENTO = ?,
												@TXT_CUENTA_CONTABLE = ?,

												@COD_ASIENTO_PROVISION = ?,
												@COD_ASIENTO_EXTORNO = ?,
												@COD_ASIENTO_CANJE = ?,
												@COD_TIPO_DOCUMENTO = ?,
												@COD_DOCUMENTO_CTBLE = ?,

												@TXT_SERIE_DOCUMENTO = ?,
												@TXT_NUMERO_DOCUMENTO = ?,
												@COD_GASTO_FUNCION = ?,
												@COD_CENTRO_COSTO = ?,
												@COD_ORDEN_COMPRA = ?,

												@FEC_FECHA_SERV = ?,
												@COD_CATEGORIA_TIPO_SERV_ORDEN = ?,
												@IND_GASTO_COSTO = ?,
												@CAN_PORCENTAJE_PERCEPCION = ?,
												@CAN_VALOR_PERCEPCION = ?


												');




	        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmt->bindParam(2, $COD_TABLA  ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $COD_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(5, $NRO_LINEA  ,PDO::PARAM_STR);

	        $stmt->bindParam(6, $TXT_NOMBRE_PRODUCTO ,PDO::PARAM_STR);
	        $stmt->bindParam(7, $TXT_DETALLE_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(8, $CAN_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(9, $CAN_PRODUCTO_ENVIADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(10,$CAN_PESO  ,PDO::PARAM_STR);

	        $stmt->bindParam(11, $CAN_PESO_PRODUCTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(12, $CAN_PESO_ENVIADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(13, $CAN_PESO_INGRESO  ,PDO::PARAM_STR);
	        $stmt->bindParam(14, $CAN_PESO_SALIDA  ,PDO::PARAM_STR);
	        $stmt->bindParam(15, $CAN_PESO_BRUTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(16, $CAM_PESO_TARA ,PDO::PARAM_STR);
	        $stmt->bindParam(17, $CAN_PESO_NETO  ,PDO::PARAM_STR);
	        $stmt->bindParam(18, $CAN_TASA_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(19, $CAN_PRECIO_UNIT_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(20,$CAN_PRECIO_UNIT  ,PDO::PARAM_STR);

	        $stmt->bindParam(21, $CAN_PRECIO_ORIGEN ,PDO::PARAM_STR);                   
	        $stmt->bindParam(22, $CAN_PRECIO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(23, $CAN_PRECIO_BRUTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(24, $CAN_PRECIO_KILOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(25, $CAN_PRECIO_SACOS  ,PDO::PARAM_STR);

	        $stmt->bindParam(26, $CAN_VALOR_VTA ,PDO::PARAM_STR);
	        $stmt->bindParam(27, $CAN_VALOR_VENTA_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(28, $CAN_KILOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(29, $CAN_SACOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(30,$CAN_PENDIENTE  ,PDO::PARAM_STR);

	        $stmt->bindParam(31, $CAN_PORCENTAJE_DESCUENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(32, $CAN_DESCUENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(33, $CAN_ADELANTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(34, $TXT_DESCRIPCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(35, $IND_MATERIAL_SERVICIO  ,PDO::PARAM_STR);

	        $stmt->bindParam(36, $IND_IGV ,PDO::PARAM_STR);
	        $stmt->bindParam(37, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(38, $TXT_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(39, $COD_OPERACION  ,PDO::PARAM_STR);
	        $stmt->bindParam(40,$COD_OPERACION_AUX  ,PDO::PARAM_STR);

	        $stmt->bindParam(41, $COD_EMPR_SERV ,PDO::PARAM_STR);                   
	        $stmt->bindParam(42, $TXT_EMPR_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(43, $NRO_CONTRATO_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(44, $NRO_CONTRATO_CULTIVO_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(45, $NRO_HABILITACION_SERV  ,PDO::PARAM_STR);

	        $stmt->bindParam(46, $CAN_PRECIO_EMPR_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(47, $NRO_CONTRATO_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(48, $NRO_CONTRATO_CULTIVO_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(49, $NRO_HABILITACION_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(50,$COD_CATEGORIA_TIPO_PAGO  ,PDO::PARAM_STR);

	        $stmt->bindParam(51, $COD_USUARIO_INGRESO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(52, $COD_USUARIO_SALIDA  ,PDO::PARAM_STR);
	        $stmt->bindParam(53, $TXT_GLOSA_PESO_IN  ,PDO::PARAM_STR);
	        $stmt->bindParam(54, $TXT_GLOSA_PESO_OUT  ,PDO::PARAM_STR);
	        $stmt->bindParam(55, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(56, $TXT_CONCEPTO_CENTRO_COSTO ,PDO::PARAM_STR);
	        $stmt->bindParam(57, $TXT_REFERENCIA  ,PDO::PARAM_STR);
	        $stmt->bindParam(58, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
	        $stmt->bindParam(59, $IND_COSTO_ARBITRARIO  ,PDO::PARAM_STR);
	        $stmt->bindParam(60,$COD_ESTADO  ,PDO::PARAM_STR);

	        $stmt->bindParam(61, $COD_USUARIO_REGISTRO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(62, $COD_TIPO_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(63, $TXT_TIPO_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(64, $TXT_GLOSA_ASIENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(65, $TXT_CUENTA_CONTABLE  ,PDO::PARAM_STR);

	        $stmt->bindParam(66, $COD_ASIENTO_PROVISION ,PDO::PARAM_STR);
	        $stmt->bindParam(67, $COD_ASIENTO_EXTORNO  ,PDO::PARAM_STR);
	        $stmt->bindParam(68, $COD_ASIENTO_CANJE  ,PDO::PARAM_STR);
	        $stmt->bindParam(69, $COD_TIPO_DOCUMENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(70,$COD_DOCUMENTO_CTBLE  ,PDO::PARAM_STR);

	        $stmt->bindParam(71, $TXT_SERIE_DOCUMENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(72, $TXT_NUMERO_DOCUMENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(73, $COD_GASTO_FUNCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(74, $COD_CENTRO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(75, $COD_ORDEN_COMPRA  ,PDO::PARAM_STR);

	        $stmt->bindParam(76, $FEC_FECHA_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(77, $COD_CATEGORIA_TIPO_SERV_ORDEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(78, $IND_GASTO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(79, $CAN_PORCENTAJE_PERCEPCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(80,$CAN_VALOR_PERCEPCION  ,PDO::PARAM_STR);


	        $stmt->execute();

		}
	}



	private function insert_detalle_producto($orden,$detalleproducto,$ordeningreso_id) {


        $conexionbd         = 'sqlsrv';
        if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }


		$COD_EMPR            		=       $orden->COD_EMPR;
		$COD_CENTRO            		=       $orden->COD_CENTRO;
		$idusuario 					=		Session::get('usuario')->name;




		foreach($detalleproducto as $index => $item){


			//DOLARES
			$CANPRECIOUNITIGV 			=	$item->CAN_PRECIO_UNIT_IGV;
			$CANPRECIOUNIT 				=	$item->CAN_PRECIO_UNIT;
			$CANPRECIOCOSTO 			=	$item->CAN_PRECIO_COSTO;
			$CANVALORVTA 				=	$item->CAN_VALOR_VTA;
			$CANVALORVENTAIGV 			=	$item->CAN_VALOR_VENTA_IGV;


			if($orden->COD_CATEGORIA_MONEDA=='MON0000000000002'){

				$CANPRECIOUNITIGV 		=	$item->CAN_PRECIO_UNIT_IGV*$orden->CAN_TIPO_CAMBIO;
				$CANPRECIOUNIT 			=	$item->CAN_PRECIO_UNIT*$orden->CAN_TIPO_CAMBIO;
				$CANPRECIOCOSTO 		=	$item->CAN_PRECIO_UNIT*$orden->CAN_TIPO_CAMBIO;
				$CANVALORVTA 			=	$item->CAN_VALOR_VTA*$orden->CAN_TIPO_CAMBIO;
				$CANVALORVENTAIGV 		=	$item->CAN_VALOR_VENTA_IGV*$orden->CAN_TIPO_CAMBIO;

			}


			$IND_TIPO_OPERACION='I';
			$COD_TABLA=$ordeningreso_id;
			$COD_PRODUCTO=$item->COD_PRODUCTO;
			$COD_LOTE=$item->COD_LOTE;
			$NRO_LINEA=$item->NRO_LINEA;

			$TXT_NOMBRE_PRODUCTO=$item->TXT_NOMBRE_PRODUCTO;
			$TXT_DETALLE_PRODUCTO='';
			$CAN_PRODUCTO=$item->CAN_PRODUCTO;
			$CAN_PRODUCTO_ENVIADO=$item->CAN_PRODUCTO_ENVIADO;
			$CAN_PESO=$item->CAN_PESO;

			$CAN_PESO_PRODUCTO=$item->CAN_PESO_PRODUCTO;
			$CAN_PESO_ENVIADO=$item->CAN_PESO_ENVIADO;
			$CAN_PESO_INGRESO=$item->CAN_PESO_INGRESO;
			$CAN_PESO_SALIDA=$item->CAN_PESO_SALIDA;
			$CAN_PESO_BRUTO=$item->CAN_PESO_BRUTO;

			$CAM_PESO_TARA=$item->CAM_PESO_TARA;
			$CAN_PESO_NETO=$item->CAN_PESO_NETO;
			$CAN_TASA_IGV=0;
			$CAN_PRECIO_UNIT_IGV=$CANPRECIOUNITIGV;
			$CAN_PRECIO_UNIT=$CANPRECIOUNIT;

			$CAN_PRECIO_ORIGEN=$item->CAN_PRECIO_ORIGEN;
			$CAN_PRECIO_COSTO=$CANPRECIOCOSTO;
			$CAN_PRECIO_BRUTO=$item->CAN_PRECIO_BRUTO;
			$CAN_PRECIO_KILOS=$item->CAN_PRECIO_KILOS;
			$CAN_PRECIO_SACOS=$item->CAN_PRECIO_SACOS;

			$CAN_VALOR_VTA=$CANVALORVTA;
			$CAN_VALOR_VENTA_IGV=$CANVALORVENTAIGV;
			$CAN_KILOS=$item->CAN_KILOS;
			$CAN_SACOS=$item->CAN_SACOS;
			$CAN_PENDIENTE=0;

			$CAN_PORCENTAJE_DESCUENTO=$item->CAN_PORCENTAJE_DESCUENTO;
			$CAN_DESCUENTO=$item->CAN_DESCUENTO;
			$CAN_ADELANTO=$item->CAN_ADELANTO;
			$TXT_DESCRIPCION='';
			$IND_MATERIAL_SERVICIO=$item->IND_MATERIAL_SERVICIO;

			$IND_IGV=$item->IND_IGV;
			$COD_ALMACEN=$item->COD_ALMACEN;
			$TXT_ALMACEN=$item->TXT_ALMACEN;
			$COD_OPERACION=$item->COD_OPERACION;
			$COD_OPERACION_AUX=$item->COD_OPERACION_AUX;

			$COD_EMPR_SERV=$item->COD_EMPR_SERV;
			$TXT_EMPR_SERV=$item->TXT_EMPR_SERV;
			$NRO_CONTRATO_SERV=$item->NRO_CONTRATO_SERV;
			$NRO_CONTRATO_CULTIVO_SERV=$item->NRO_CONTRATO_CULTIVO_SERV;
			$NRO_HABILITACION_SERV=$item->NRO_HABILITACION_SERV;

			$CAN_PRECIO_EMPR_SERV=$item->CAN_PRECIO_EMPR_SERV;
			$NRO_CONTRATO_GRUPO=$item->NRO_CONTRATO_GRUPO;
			$NRO_CONTRATO_CULTIVO_GRUPO=$item->NRO_CONTRATO_CULTIVO_GRUPO;
			$NRO_HABILITACION_GRUPO=$item->NRO_HABILITACION_GRUPO;
			$COD_CATEGORIA_TIPO_PAGO=$item->COD_CATEGORIA_TIPO_PAGO;

			$COD_USUARIO_INGRESO=$item->COD_USUARIO_INGRESO;
			$COD_USUARIO_SALIDA=$item->COD_USUARIO_SALIDA;
			$TXT_GLOSA_PESO_IN=$item->TXT_GLOSA_PESO_IN;
			$TXT_GLOSA_PESO_OUT=$item->TXT_GLOSA_PESO_OUT;
			$COD_CONCEPTO_CENTRO_COSTO='';

			$TXT_CONCEPTO_CENTRO_COSTO='';
			$TXT_REFERENCIA=$item->TXT_REFERENCIA;
			$TXT_TIPO_REFERENCIA=$item->TXT_TIPO_REFERENCIA;
			$IND_COSTO_ARBITRARIO=$item->IND_COSTO_ARBITRARIO;
			$COD_ESTADO=$item->COD_ESTADO;

			$COD_USUARIO_REGISTRO=$idusuario;
			$COD_TIPO_ESTADO=$item->COD_TIPO_ESTADO;
			$TXT_TIPO_ESTADO=$item->TXT_TIPO_ESTADO;
			$TXT_GLOSA_ASIENTO=$item->TXT_GLOSA_ASIENTO;
			$TXT_CUENTA_CONTABLE=$item->TXT_CUENTA_CONTABLE;

			$COD_ASIENTO_PROVISION=$item->COD_ASIENTO_PROVISION;
			$COD_ASIENTO_EXTORNO=$item->COD_ASIENTO_EXTORNO;
			$COD_ASIENTO_CANJE=$item->COD_ASIENTO_CANJE;
			$COD_TIPO_DOCUMENTO=$item->COD_TIPO_DOCUMENTO;
			$COD_DOCUMENTO_CTBLE=$item->COD_DOCUMENTO_CTBLE;

			$TXT_SERIE_DOCUMENTO=$item->TXT_SERIE_DOCUMENTO;
			$TXT_NUMERO_DOCUMENTO=$item->TXT_NUMERO_DOCUMENTO;
			$COD_GASTO_FUNCION=$item->COD_GASTO_FUNCION;
			$COD_CENTRO_COSTO=$item->COD_CENTRO_COSTO;
			$COD_ORDEN_COMPRA=$item->COD_ORDEN_COMPRA;

			$FEC_FECHA_SERV=$item->FEC_FECHA_SERV;
			$COD_CATEGORIA_TIPO_SERV_ORDEN=$item->COD_CATEGORIA_TIPO_SERV_ORDEN;
			$IND_GASTO_COSTO=$item->IND_GASTO_COSTO;
			$CAN_PORCENTAJE_PERCEPCION=$item->CAN_PORCENTAJE_PERCEPCION;
			$CAN_VALOR_PERCEPCION=$item->CAN_VALOR_PERCEPCION;



			$stmt 					= 		DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.DETALLE_PRODUCTO_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_TABLA = ?,
												@COD_PRODUCTO = ?,
												@COD_LOTE = ?,
												@NRO_LINEA = ?,

												@TXT_NOMBRE_PRODUCTO = ?,
												@TXT_DETALLE_PRODUCTO = ?,
												@CAN_PRODUCTO = ?,
												@CAN_PRODUCTO_ENVIADO = ?,
												@CAN_PESO = ?,

												@CAN_PESO_PRODUCTO = ?,
												@CAN_PESO_ENVIADO = ?,
												@CAN_PESO_INGRESO = ?,
												@CAN_PESO_SALIDA = ?,
												@CAN_PESO_BRUTO = ?,

												@CAM_PESO_TARA = ?,
												@CAN_PESO_NETO = ?,
												@CAN_TASA_IGV = ?,
												@CAN_PRECIO_UNIT_IGV = ?,
												@CAN_PRECIO_UNIT = ?,

												@CAN_PRECIO_ORIGEN = ?,
												@CAN_PRECIO_COSTO = ?,
												@CAN_PRECIO_BRUTO = ?,
												@CAN_PRECIO_KILOS = ?,
												@CAN_PRECIO_SACOS = ?,

												@CAN_VALOR_VTA = ?,
												@CAN_VALOR_VENTA_IGV = ?,
												@CAN_KILOS = ?,
												@CAN_SACOS = ?,
												@CAN_PENDIENTE = ?,

												@CAN_PORCENTAJE_DESCUENTO = ?,
												@CAN_DESCUENTO = ?,
												@CAN_ADELANTO = ?,
												@TXT_DESCRIPCION = ?,
												@IND_MATERIAL_SERVICIO = ?,

												@IND_IGV = ?,
												@COD_ALMACEN = ?,
												@TXT_ALMACEN = ?,
												@COD_OPERACION = ?,
												@COD_OPERACION_AUX = ?,


												@COD_EMPR_SERV = ?,
												@TXT_EMPR_SERV = ?,
												@NRO_CONTRATO_SERV = ?,
												@NRO_CONTRATO_CULTIVO_SERV = ?,
												@NRO_HABILITACION_SERV = ?,

												@CAN_PRECIO_EMPR_SERV = ?,
												@NRO_CONTRATO_GRUPO = ?,
												@NRO_CONTRATO_CULTIVO_GRUPO = ?,
												@NRO_HABILITACION_GRUPO = ?,
												@COD_CATEGORIA_TIPO_PAGO = ?,

												@COD_USUARIO_INGRESO = ?,
												@COD_USUARIO_SALIDA = ?,
												@TXT_GLOSA_PESO_IN = ?,
												@TXT_GLOSA_PESO_OUT = ?,
												@COD_CONCEPTO_CENTRO_COSTO = ?,

												@TXT_CONCEPTO_CENTRO_COSTO = ?,
												@TXT_REFERENCIA = ?,
												@TXT_TIPO_REFERENCIA = ?,
												@IND_COSTO_ARBITRARIO = ?,
												@COD_ESTADO = ?,

												@COD_USUARIO_REGISTRO = ?,
												@COD_TIPO_ESTADO = ?,
												@TXT_TIPO_ESTADO = ?,
												@TXT_GLOSA_ASIENTO = ?,
												@TXT_CUENTA_CONTABLE = ?,

												@COD_ASIENTO_PROVISION = ?,
												@COD_ASIENTO_EXTORNO = ?,
												@COD_ASIENTO_CANJE = ?,
												@COD_TIPO_DOCUMENTO = ?,
												@COD_DOCUMENTO_CTBLE = ?,

												@TXT_SERIE_DOCUMENTO = ?,
												@TXT_NUMERO_DOCUMENTO = ?,
												@COD_GASTO_FUNCION = ?,
												@COD_CENTRO_COSTO = ?,
												@COD_ORDEN_COMPRA = ?,

												@FEC_FECHA_SERV = ?,
												@COD_CATEGORIA_TIPO_SERV_ORDEN = ?,
												@IND_GASTO_COSTO = ?,
												@CAN_PORCENTAJE_PERCEPCION = ?,
												@CAN_VALOR_PERCEPCION = ?


												');




	        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmt->bindParam(2, $COD_TABLA  ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $COD_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(5, $NRO_LINEA  ,PDO::PARAM_STR);

	        $stmt->bindParam(6, $TXT_NOMBRE_PRODUCTO ,PDO::PARAM_STR);
	        $stmt->bindParam(7, $TXT_DETALLE_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(8, $CAN_PRODUCTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(9, $CAN_PRODUCTO_ENVIADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(10,$CAN_PESO  ,PDO::PARAM_STR);

	        $stmt->bindParam(11, $CAN_PESO_PRODUCTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(12, $CAN_PESO_ENVIADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(13, $CAN_PESO_INGRESO  ,PDO::PARAM_STR);
	        $stmt->bindParam(14, $CAN_PESO_SALIDA  ,PDO::PARAM_STR);
	        $stmt->bindParam(15, $CAN_PESO_BRUTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(16, $CAM_PESO_TARA ,PDO::PARAM_STR);
	        $stmt->bindParam(17, $CAN_PESO_NETO  ,PDO::PARAM_STR);
	        $stmt->bindParam(18, $CAN_TASA_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(19, $CAN_PRECIO_UNIT_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(20,$CAN_PRECIO_UNIT  ,PDO::PARAM_STR);

	        $stmt->bindParam(21, $CAN_PRECIO_ORIGEN ,PDO::PARAM_STR);                   
	        $stmt->bindParam(22, $CAN_PRECIO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(23, $CAN_PRECIO_BRUTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(24, $CAN_PRECIO_KILOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(25, $CAN_PRECIO_SACOS  ,PDO::PARAM_STR);

	        $stmt->bindParam(26, $CAN_VALOR_VTA ,PDO::PARAM_STR);
	        $stmt->bindParam(27, $CAN_VALOR_VENTA_IGV  ,PDO::PARAM_STR);
	        $stmt->bindParam(28, $CAN_KILOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(29, $CAN_SACOS  ,PDO::PARAM_STR);
	        $stmt->bindParam(30,$CAN_PENDIENTE  ,PDO::PARAM_STR);

	        $stmt->bindParam(31, $CAN_PORCENTAJE_DESCUENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(32, $CAN_DESCUENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(33, $CAN_ADELANTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(34, $TXT_DESCRIPCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(35, $IND_MATERIAL_SERVICIO  ,PDO::PARAM_STR);

	        $stmt->bindParam(36, $IND_IGV ,PDO::PARAM_STR);
	        $stmt->bindParam(37, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(38, $TXT_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(39, $COD_OPERACION  ,PDO::PARAM_STR);
	        $stmt->bindParam(40,$COD_OPERACION_AUX  ,PDO::PARAM_STR);

	        $stmt->bindParam(41, $COD_EMPR_SERV ,PDO::PARAM_STR);                   
	        $stmt->bindParam(42, $TXT_EMPR_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(43, $NRO_CONTRATO_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(44, $NRO_CONTRATO_CULTIVO_SERV  ,PDO::PARAM_STR);
	        $stmt->bindParam(45, $NRO_HABILITACION_SERV  ,PDO::PARAM_STR);

	        $stmt->bindParam(46, $CAN_PRECIO_EMPR_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(47, $NRO_CONTRATO_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(48, $NRO_CONTRATO_CULTIVO_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(49, $NRO_HABILITACION_GRUPO  ,PDO::PARAM_STR);
	        $stmt->bindParam(50,$COD_CATEGORIA_TIPO_PAGO  ,PDO::PARAM_STR);

	        $stmt->bindParam(51, $COD_USUARIO_INGRESO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(52, $COD_USUARIO_SALIDA  ,PDO::PARAM_STR);
	        $stmt->bindParam(53, $TXT_GLOSA_PESO_IN  ,PDO::PARAM_STR);
	        $stmt->bindParam(54, $TXT_GLOSA_PESO_OUT  ,PDO::PARAM_STR);
	        $stmt->bindParam(55, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);

	        $stmt->bindParam(56, $TXT_CONCEPTO_CENTRO_COSTO ,PDO::PARAM_STR);
	        $stmt->bindParam(57, $TXT_REFERENCIA  ,PDO::PARAM_STR);
	        $stmt->bindParam(58, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
	        $stmt->bindParam(59, $IND_COSTO_ARBITRARIO  ,PDO::PARAM_STR);
	        $stmt->bindParam(60,$COD_ESTADO  ,PDO::PARAM_STR);

	        $stmt->bindParam(61, $COD_USUARIO_REGISTRO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(62, $COD_TIPO_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(63, $TXT_TIPO_ESTADO  ,PDO::PARAM_STR);
	        $stmt->bindParam(64, $TXT_GLOSA_ASIENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(65, $TXT_CUENTA_CONTABLE  ,PDO::PARAM_STR);

	        $stmt->bindParam(66, $COD_ASIENTO_PROVISION ,PDO::PARAM_STR);
	        $stmt->bindParam(67, $COD_ASIENTO_EXTORNO  ,PDO::PARAM_STR);
	        $stmt->bindParam(68, $COD_ASIENTO_CANJE  ,PDO::PARAM_STR);
	        $stmt->bindParam(69, $COD_TIPO_DOCUMENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(70,$COD_DOCUMENTO_CTBLE  ,PDO::PARAM_STR);

	        $stmt->bindParam(71, $TXT_SERIE_DOCUMENTO ,PDO::PARAM_STR);                   
	        $stmt->bindParam(72, $TXT_NUMERO_DOCUMENTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(73, $COD_GASTO_FUNCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(74, $COD_CENTRO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(75, $COD_ORDEN_COMPRA  ,PDO::PARAM_STR);

	        $stmt->bindParam(76, $FEC_FECHA_SERV ,PDO::PARAM_STR);
	        $stmt->bindParam(77, $COD_CATEGORIA_TIPO_SERV_ORDEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(78, $IND_GASTO_COSTO  ,PDO::PARAM_STR);
	        $stmt->bindParam(79, $CAN_PORCENTAJE_PERCEPCION  ,PDO::PARAM_STR);
	        $stmt->bindParam(80,$CAN_VALOR_PERCEPCION  ,PDO::PARAM_STR);


	        $stmt->execute();

		}
	}
	private function insert_referencia_asoc($orden,$detalleproducto,$ordeningreso_id) {




        $conexionbd         = 'sqlsrv';
        if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }

		$COD_EMPR            		=       $orden->COD_EMPR;
		$COD_CENTRO            		=       $orden->COD_CENTRO;
		$idusuario 					=		Session::get('usuario')->name;

		$IND_TIPO_OPERACION='I';
		$COD_TABLA=$ordeningreso_id;
		$COD_TABLA_ASOC=$orden->COD_ORDEN;
		$TXT_TABLA='CMP.ORDEN';
		$TXT_TABLA_ASOC='CMP.ORDEN';
		$TXT_GLOSA='';
		$TXT_TIPO_REFERENCIA='';
		$TXT_REFERENCIA='INGRESO POR COMPRAS';
		$COD_ESTADO=1;
		$COD_USUARIO_REGISTRO=$idusuario;
		$TXT_DESCRIPCION='';
		$CAN_AUX1=0;
		$CAN_AUX2=0;
		$CAN_AUX3=0;



		$stmt 					= 		DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.REFERENCIA_ASOC_IUD 
											@IND_TIPO_OPERACION = ?,
											@COD_TABLA = ?,
											@COD_TABLA_ASOC = ?,
											@TXT_TABLA = ?,
											@TXT_TABLA_ASOC = ?,

											@TXT_GLOSA = ?,
											@TXT_TIPO_REFERENCIA = ?,
											@TXT_REFERENCIA = ?,
											@COD_ESTADO = ?,
											@COD_USUARIO_REGISTRO = ?,

											@TXT_DESCRIPCION = ?,
											@CAN_AUX1 = ?,
											@CAN_AUX2 = ?,
											@CAN_AUX3 = ?

											');

        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(2, $COD_TABLA  ,PDO::PARAM_STR);
        $stmt->bindParam(3, $COD_TABLA_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(4, $TXT_TABLA  ,PDO::PARAM_STR);
        $stmt->bindParam(5, $TXT_TABLA_ASOC  ,PDO::PARAM_STR);

        $stmt->bindParam(6, $TXT_GLOSA ,PDO::PARAM_STR);
        $stmt->bindParam(7, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(8, $TXT_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(9, $COD_ESTADO  ,PDO::PARAM_STR);
        $stmt->bindParam(10,$COD_USUARIO_REGISTRO  ,PDO::PARAM_STR);

        $stmt->bindParam(11, $TXT_DESCRIPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(12, $CAN_AUX1  ,PDO::PARAM_STR);
        $stmt->bindParam(13, $CAN_AUX2  ,PDO::PARAM_STR);
        $stmt->bindParam(14, $CAN_AUX3  ,PDO::PARAM_STR);

        $stmt->execute();
	}
	private function insert_orden($orden,$detalleproducto) {



        $conexionbd         = 'sqlsrv';
        if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }


		$CANSUBTOTAL 	=	$orden->CAN_SUB_TOTAL;
		$CANIMPUESTOVTA =	$orden->CAN_IMPUESTO_VTA;
		$CANTOTAL 		=	$orden->CAN_TOTAL;

		
		if($orden->COD_CATEGORIA_MONEDA=='MON0000000000002'){

			$CANSUBTOTAL 	=	$orden->CAN_SUB_TOTAL*$orden->CAN_TIPO_CAMBIO;
			$CANIMPUESTOVTA =	$orden->CAN_IMPUESTO_VTA*$orden->CAN_TIPO_CAMBIO;
			$CANTOTAL 		=	$orden->CAN_TOTAL*$orden->CAN_TIPO_CAMBIO;

		}


		$COD_EMPR            	=       $orden->COD_EMPR;
		$COD_CENTRO            	=       $orden->COD_CENTRO;
		$empresa 				=		STDEmpresa::where('COD_EMPR','=',$orden->COD_EMPR)->first();
		$tipopago 				=		CMPCategoria::where('COD_CATEGORIA','=',$orden->COD_CATEGORIA_TIPO_PAGO)->first();


		$hoy 					= 		date_format(date_create(date('Ymd h:i:s')), 'Ymd');
		$fechapago 				= 		date('Y-m-j');
		$nuevafecha 			= 		strtotime ( '+'.$tipopago->COD_CTBLE.' day' , strtotime($fechapago));
		$nuevafecha 			= 		date ('Y-m-j' , $nuevafecha);
		$fecha_pago 			= 		date_format(date_create($nuevafecha), 'Ymd');

		$fecha_sin 				=		'1901-01-01 00:00:00';
		$vacio 					=		'';
		$activo 				=		'1';
		$idusuario 				=		Session::get('usuario')->name;

		$IND_TIPO_OPERACION='I';
		$COD_ORDEN='';
		$COD_EMPR=$orden->COD_EMPR;
		$COD_EMPR_CLIENTE=$orden->COD_EMPR;
		$TXT_EMPR_CLIENTE=$empresa->NOM_EMPR;

		$COD_EMPR_LICITACION='';
		$TXT_EMPR_LICITACION='';
		$COD_EMPR_TRANSPORTE='';
		$TXT_EMPR_TRANSPORTE='';
		$COD_EMPR_ORIGEN='';

		$TXT_EMPR_ORIGEN='';
		$COD_CENTRO=$orden->COD_CENTRO;
		$COD_CENTRO_DESTINO=$orden->COD_CENTRO;
		$COD_CENTRO_ORIGEN='';
		$FEC_ORDEN=$hoy;

		$FEC_RECEPCION='1901-01-01';
		$FEC_ENTREGA=$hoy;
		$FEC_ENTREGA_2='1901-01-01';
		$FEC_ENTREGA_3='1901-01-01';
		$FEC_PAGO=$fecha_pago;

		$FEC_NOTA_PEDIDO='1901-01-01';
		$FEC_RECOJO_MERCADERIA='1901-01-01';
		$FEC_ENTREGA_LIMA='1901-01-01';
		$FEC_GRACIA='1901-01-01';
		$FEC_EJECUCION='1901-01-01';

		$IND_MATERIAL_SERVICIO=$orden->IND_MATERIAL_SERVICIO;
		$COD_CATEGORIA_ESTADO_REQ='';
		$COD_CATEGORIA_TIPO_ORDEN='TOR0000000000002';
		$TXT_CATEGORIA_TIPO_ORDEN='INGRESO';
		$COD_CATEGORIA_TIPO_PAGO=$orden->COD_CATEGORIA_TIPO_PAGO;

		$COD_CATEGORIA_MONEDA='MON0000000000001';
		$TXT_CATEGORIA_MONEDA='SOLES';
		$COD_CATEGORIA_ESTADO_ORDEN='EOR0000000000001';
		$TXT_CATEGORIA_ESTADO_ORDEN='GENERADA';

		$COD_CATEGORIA_MOVIMIENTO_INVENTARIO='MIN0000000000007';
		$TXT_CATEGORIA_MOVIMIENTO_INVENTARIO='INGRESO POR COMPRAS';
		if (in_array($orden->COD_CATEGORIA_TIPO_ORDEN, ['TOR0000000000026','TOR0000000000022','TOR0000000000021'])) {
			$COD_CATEGORIA_MOVIMIENTO_INVENTARIO='MIN0000000000034';
			$TXT_CATEGORIA_MOVIMIENTO_INVENTARIO='INGRESO POR COMPRA DE ARROZ';
		}

		$COD_CATEGORIA_PROCESO_SEL='';
		$TXT_CATEGORIA_PROCESO_SEL='';
		$COD_CATEGORIA_MODALIDAD_SEL='';
		$TXT_CATEGORIA_MODALIDAD_SEL='';

		$COD_CATEGORIA_AREA_EMPRESA='';
		$TXT_CATEGORIA_AREA_EMPRESA='';
		$COD_CONCEPTO_CENTRO_COSTO='';
		$COD_CHOFER='';
		$COD_VEHICULO='';

		$COD_CARRETA='';
		$TXT_CARRETA='';
		$COD_CONTRATO_ORIGEN='';
		$COD_CULTIVO_ORIGEN='';
		$COD_CONTRATO_LICITACION='';

		$COD_CULTIVO_LICITACION='';
		$COD_CONTRATO_TRANSPORTE='';
		$COD_CULTIVO_TRANSPORTE='';
		$COD_CONTRATO=$orden->COD_CONTRATO;
		$COD_CULTIVO=$orden->COD_CULTIVO;

		$COD_HABILITACION='';
		$COD_HABILITACION_DCTO='';
		$COD_ALMACEN_ORIGEN='';
		$COD_ALMACEN_DESTINO='';
		$COD_TRABAJADOR_SOLICITA=$orden->COD_TRABAJADOR_SOLICITA;;

		$COD_TRABAJADOR_ENCARGADO=$orden->COD_TRABAJADOR_ENCARGADO;;
		$COD_TRABAJADOR_COMISIONISTA=$orden->COD_TRABAJADOR_COMISIONISTA;;
		$COD_CONTRATO_COMISIONISTA='';
		$COD_CULTIVO_COMISIONISTA='';
		$COD_HABILITACION_COMISIONISTA='';

		$COD_TRABAJADOR_VENDEDOR='';
		$COD_ZONA_COMERCIAL='';
		$TXT_ZONA_COMERCIAL='';
		$COD_LOTE_CC='';
		$CAN_SUB_TOTAL=$CANSUBTOTAL;

		$CAN_IMPUESTO_VTA=$CANIMPUESTOVTA;
		$CAN_IMPUESTO_RENTA=$orden->CAN_IMPUESTO_RENTA;
		$CAN_TOTAL=$CANTOTAL;
		$CAN_DSCTO=$orden->CAN_DSCTO;
		$CAN_TIPO_CAMBIO=$orden->CAN_TIPO_CAMBIO;

		$CAN_PERCEPCION=$orden->CAN_PERCEPCION;
		$CAN_DETRACCION=$orden->CAN_DETRACCION;
		$CAN_RETENCION=$orden->CAN_RETENCION;
		$CAN_NETO_PAGAR=$orden->CAN_NETO_PAGAR;
		$CAN_TOTAL_COMISION=$orden->CAN_TOTAL_COMISION;

		$COD_EMPR_BANCO='';
		$NRO_CUENTA_BANCARIA='';
		$NRO_CARRO='';
		$IND_VARIAS_ENTREGAS=$orden->IND_VARIAS_ENTREGAS;
		$IND_TIPO_COMPRA='';

		$NOM_CHOFER_EMPR_TRANSPORTE='';
		$NRO_ORDEN_CEN='';
		$NRO_LICITACION='';
		$NRO_NOTA_PEDIDO='';
		$NRO_OPERACIONES_CAJA='';

		$TXT_NRO_PLACA='';
		$TXT_CONTACTO='';
		$TXT_MOTIVO_ANULACION='';
		$TXT_CONFORMIDAD='';
		$TXT_A_TIEMPO='';

		$TXT_DESTINO='';
		$TXT_TIPO_DOC_ASOC='';
		$TXT_DOC_ASOC='';
		$TXT_ORDEN_ASOC='';
		$COD_CATEGORIA_MODULO=$orden->COD_CATEGORIA_MODULO;

		$TXT_GLOSA_ATENCION='';
		$TXT_GLOSA=$orden->TXT_GLOSA;
		$TXT_TIPO_REFERENCIA='CMP.ORDEN';
		$TXT_REFERENCIA=$orden->COD_ORDEN;
		$COD_OPERACION='';

		$TXT_GRR='';
		$TXT_GRR_TRANSPORTISTA='';
		$TXT_CTC='';
		$IND_ZONA=0;
		$IND_CERRADO=0;

		$COD_EMP_PROV_SERV=$orden->COD_EMPR;
		$TXT_EMP_PROV_SERV='';
		$COD_ESTADO=1;
		$COD_USUARIO_REGISTRO=$idusuario;
		$COD_CTA_GASTO_FUNCION='';

		$NRO_CTA_GASTO_FUNCION='';
		$COD_CATEGORIA_ACTIVIDAD_NEGOCIO=$orden->COD_CATEGORIA_ACTIVIDAD_NEGOCIO;
		$COD_EMPR_PROPIETARIO=$orden->COD_EMPR;
		$TXT_EMPR_PROPIETARIO='';
		$COD_CATEGORIA_TIPO_COSTEO='';

		$TXT_CATEGORIA_TIPO_COSTEO='';
		$TXT_CORRELATIVO='';
		$COD_MOVIMIENTO_INVENTARIO_EXTORNADO='';
		$COD_ORDEN_EXTORNADA='';
		$IND_ENV_CLIENTE=0;

		$IND_ORDEN='SI';
		$COD_MOTIVO_EXTORNO='';
		$GLOSA_EXTORNO='';



		$stmt 					= 		DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC CMP.ORDEN_IUD 
											@IND_TIPO_OPERACION = ?,
											@COD_ORDEN = ?,
											@COD_EMPR = ?,
											@COD_EMPR_CLIENTE = ?,
											@TXT_EMPR_CLIENTE = ?,

											@COD_EMPR_LICITACION = ?,
											@TXT_EMPR_LICITACION = ?,
											@COD_EMPR_TRANSPORTE = ?,
											@TXT_EMPR_TRANSPORTE = ?,
											@COD_EMPR_ORIGEN = ?,

											@TXT_EMPR_ORIGEN = ?,
											@COD_CENTRO = ?,
											@COD_CENTRO_DESTINO = ?,
											@COD_CENTRO_ORIGEN = ?,
											@FEC_ORDEN = ?,

											@FEC_RECEPCION = ?,
											@FEC_ENTREGA = ?,
											@FEC_ENTREGA_2 = ?,
											@FEC_ENTREGA_3 = ?,
											@FEC_PAGO = ?,

											@FEC_NOTA_PEDIDO = ?,
											@FEC_RECOJO_MERCADERIA = ?,
											@FEC_ENTREGA_LIMA = ?,
											@FEC_GRACIA = ?,
											@FEC_EJECUCION = ?,

											@IND_MATERIAL_SERVICIO = ?,
											@COD_CATEGORIA_ESTADO_REQ = ?,
											@COD_CATEGORIA_TIPO_ORDEN = ?,
											@TXT_CATEGORIA_TIPO_ORDEN = ?,
											@COD_CATEGORIA_TIPO_PAGO = ?,

											@COD_CATEGORIA_MONEDA = ?,
											@TXT_CATEGORIA_MONEDA = ?,
											@COD_CATEGORIA_ESTADO_ORDEN = ?,
											@TXT_CATEGORIA_ESTADO_ORDEN = ?,
											@COD_CATEGORIA_MOVIMIENTO_INVENTARIO = ?,

											@TXT_CATEGORIA_MOVIMIENTO_INVENTARIO = ?,
											@COD_CATEGORIA_PROCESO_SEL = ?,
											@TXT_CATEGORIA_PROCESO_SEL = ?,
											@COD_CATEGORIA_MODALIDAD_SEL = ?,
											@TXT_CATEGORIA_MODALIDAD_SEL = ?,

											@COD_CATEGORIA_AREA_EMPRESA = ?,
											@TXT_CATEGORIA_AREA_EMPRESA = ?,
											@COD_CONCEPTO_CENTRO_COSTO = ?,
											@COD_CHOFER = ?,
											@COD_VEHICULO = ?,

											@COD_CARRETA = ?,
											@TXT_CARRETA = ?,
											@COD_CONTRATO_ORIGEN = ?,
											@COD_CULTIVO_ORIGEN = ?,
											@COD_CONTRATO_LICITACION = ?,


											@COD_CULTIVO_LICITACION = ?,
											@COD_CONTRATO_TRANSPORTE = ?,
											@COD_CULTIVO_TRANSPORTE = ?,
											@COD_CONTRATO = ?,
											@COD_CULTIVO = ?,

											@COD_HABILITACION = ?,
											@COD_HABILITACION_DCTO = ?,
											@COD_ALMACEN_ORIGEN = ?,
											@COD_ALMACEN_DESTINO = ?,
											@COD_TRABAJADOR_SOLICITA = ?,

											@COD_TRABAJADOR_ENCARGADO = ?,
											@COD_TRABAJADOR_COMISIONISTA = ?,
											@COD_CONTRATO_COMISIONISTA = ?,
											@COD_CULTIVO_COMISIONISTA = ?,
											@COD_HABILITACION_COMISIONISTA = ?,

											@COD_TRABAJADOR_VENDEDOR = ?,
											@COD_ZONA_COMERCIAL = ?,
											@TXT_ZONA_COMERCIAL = ?,
											@COD_LOTE_CC = ?,
											@CAN_SUB_TOTAL = ?,

											@CAN_IMPUESTO_VTA = ?,
											@CAN_IMPUESTO_RENTA = ?,
											@CAN_TOTAL = ?,
											@CAN_DSCTO = ?,
											@CAN_TIPO_CAMBIO = ?,

											@CAN_PERCEPCION = ?,
											@CAN_DETRACCION = ?,
											@CAN_RETENCION = ?,
											@CAN_NETO_PAGAR = ?,
											@CAN_TOTAL_COMISION = ?,
											
											@COD_EMPR_BANCO = ?,
											@NRO_CUENTA_BANCARIA = ?,
											@NRO_CARRO = ?,
											@IND_VARIAS_ENTREGAS = ?,
											@IND_TIPO_COMPRA = ?,

											@NOM_CHOFER_EMPR_TRANSPORTE = ?,
											@NRO_ORDEN_CEN = ?,
											@NRO_LICITACION = ?,
											@NRO_NOTA_PEDIDO = ?,
											@NRO_OPERACIONES_CAJA = ?,

											@TXT_NRO_PLACA = ?,
											@TXT_CONTACTO = ?,
											@TXT_MOTIVO_ANULACION = ?,
											@TXT_CONFORMIDAD = ?,
											@TXT_A_TIEMPO = ?,

											@TXT_DESTINO = ?,
											@TXT_TIPO_DOC_ASOC = ?,
											@TXT_DOC_ASOC = ?,
											@TXT_ORDEN_ASOC = ?,
											@COD_CATEGORIA_MODULO = ?,


											@TXT_GLOSA_ATENCION = ?,
											@TXT_GLOSA = ?,
											@TXT_TIPO_REFERENCIA = ?,
											@TXT_REFERENCIA = ?,
											@COD_OPERACION = ?,
											
											@TXT_GRR = ?,
											@TXT_GRR_TRANSPORTISTA = ?,
											@TXT_CTC = ?,
											@IND_ZONA = ?,
											@IND_CERRADO = ?,

											@COD_EMP_PROV_SERV = ?,
											@TXT_EMP_PROV_SERV = ?,
											@COD_ESTADO = ?,
											@COD_USUARIO_REGISTRO = ?,
											@COD_CTA_GASTO_FUNCION = ?,

											@NRO_CTA_GASTO_FUNCION = ?,
											@COD_CATEGORIA_ACTIVIDAD_NEGOCIO = ?,
											@COD_EMPR_PROPIETARIO = ?,
											@TXT_EMPR_PROPIETARIO = ?,
											@COD_CATEGORIA_TIPO_COSTEO = ?,

											@TXT_CATEGORIA_TIPO_COSTEO = ?,
											@TXT_CORRELATIVO = ?,
											@COD_MOVIMIENTO_INVENTARIO_EXTORNADO = ?,
											@COD_ORDEN_EXTORNADA = ?,
											@IND_ENV_CLIENTE = ?,

											@IND_ORDEN = ?,
											@COD_MOTIVO_EXTORNO = ?,
											@GLOSA_EXTORNO = ?

											');

        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(2, $COD_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(3, $COD_EMPR  ,PDO::PARAM_STR);
        $stmt->bindParam(4, $COD_EMPR_CLIENTE  ,PDO::PARAM_STR);
        $stmt->bindParam(5, $TXT_EMPR_CLIENTE  ,PDO::PARAM_STR);

        $stmt->bindParam(6, $COD_EMPR_LICITACION ,PDO::PARAM_STR);
        $stmt->bindParam(7, $TXT_EMPR_LICITACION  ,PDO::PARAM_STR);
        $stmt->bindParam(8, $COD_EMPR_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(9, $TXT_EMPR_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(10,$COD_EMPR_ORIGEN  ,PDO::PARAM_STR);

        $stmt->bindParam(11, $TXT_EMPR_ORIGEN ,PDO::PARAM_STR);                   
        $stmt->bindParam(12, $COD_CENTRO  ,PDO::PARAM_STR);
        $stmt->bindParam(13, $COD_CENTRO_DESTINO  ,PDO::PARAM_STR);
        $stmt->bindParam(14, $COD_CENTRO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(15, $FEC_ORDEN  ,PDO::PARAM_STR);

        $stmt->bindParam(16, $FEC_RECEPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(17, $FEC_ENTREGA  ,PDO::PARAM_STR);
        $stmt->bindParam(18, $FEC_ENTREGA_2  ,PDO::PARAM_STR);
        $stmt->bindParam(19, $FEC_ENTREGA_3  ,PDO::PARAM_STR);
        $stmt->bindParam(20, $FEC_PAGO  ,PDO::PARAM_STR);

        $stmt->bindParam(21, $FEC_NOTA_PEDIDO ,PDO::PARAM_STR);
        $stmt->bindParam(22, $FEC_RECOJO_MERCADERIA  ,PDO::PARAM_STR);
        $stmt->bindParam(23, $FEC_ENTREGA_LIMA  ,PDO::PARAM_STR);
        $stmt->bindParam(24, $FEC_GRACIA  ,PDO::PARAM_STR);
        $stmt->bindParam(25,$FEC_EJECUCION  ,PDO::PARAM_STR);

        $stmt->bindParam(26, $IND_MATERIAL_SERVICIO ,PDO::PARAM_STR);                   
        $stmt->bindParam(27, $COD_CATEGORIA_ESTADO_REQ  ,PDO::PARAM_STR);
        $stmt->bindParam(28, $COD_CATEGORIA_TIPO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(29, $TXT_CATEGORIA_TIPO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(30, $COD_CATEGORIA_TIPO_PAGO  ,PDO::PARAM_STR);

        $stmt->bindParam(31, $COD_CATEGORIA_MONEDA ,PDO::PARAM_STR);                   
        $stmt->bindParam(32, $TXT_CATEGORIA_MONEDA  ,PDO::PARAM_STR);
        $stmt->bindParam(33, $COD_CATEGORIA_ESTADO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(34, $TXT_CATEGORIA_ESTADO_ORDEN  ,PDO::PARAM_STR);
        $stmt->bindParam(35, $COD_CATEGORIA_MOVIMIENTO_INVENTARIO  ,PDO::PARAM_STR);

        $stmt->bindParam(36, $TXT_CATEGORIA_MOVIMIENTO_INVENTARIO ,PDO::PARAM_STR);
        $stmt->bindParam(37, $COD_CATEGORIA_PROCESO_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(38, $TXT_CATEGORIA_PROCESO_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(39, $COD_CATEGORIA_MODALIDAD_SEL  ,PDO::PARAM_STR);
        $stmt->bindParam(40,$TXT_CATEGORIA_MODALIDAD_SEL  ,PDO::PARAM_STR);

        $stmt->bindParam(41, $COD_CATEGORIA_AREA_EMPRESA ,PDO::PARAM_STR);                   
        $stmt->bindParam(42, $TXT_CATEGORIA_AREA_EMPRESA  ,PDO::PARAM_STR);
        $stmt->bindParam(43, $COD_CONCEPTO_CENTRO_COSTO  ,PDO::PARAM_STR);
        $stmt->bindParam(44, $COD_CHOFER  ,PDO::PARAM_STR);
        $stmt->bindParam(45, $COD_VEHICULO  ,PDO::PARAM_STR);

        $stmt->bindParam(46, $COD_CARRETA ,PDO::PARAM_STR);                   
        $stmt->bindParam(47, $TXT_CARRETA  ,PDO::PARAM_STR);
        $stmt->bindParam(48, $COD_CONTRATO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(49, $COD_CULTIVO_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(50, $COD_CONTRATO_LICITACION  ,PDO::PARAM_STR);

        $stmt->bindParam(51, $COD_CULTIVO_LICITACION ,PDO::PARAM_STR);
        $stmt->bindParam(52, $COD_CONTRATO_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(53, $COD_CULTIVO_TRANSPORTE  ,PDO::PARAM_STR);
        $stmt->bindParam(54, $COD_CONTRATO  ,PDO::PARAM_STR);
        $stmt->bindParam(55,$COD_CULTIVO  ,PDO::PARAM_STR);

        $stmt->bindParam(56, $COD_HABILITACION ,PDO::PARAM_STR);                   
        $stmt->bindParam(57, $COD_HABILITACION_DCTO  ,PDO::PARAM_STR);
        $stmt->bindParam(58, $COD_ALMACEN_ORIGEN  ,PDO::PARAM_STR);
        $stmt->bindParam(59, $COD_ALMACEN_DESTINO  ,PDO::PARAM_STR);
        $stmt->bindParam(60, $COD_TRABAJADOR_SOLICITA  ,PDO::PARAM_STR);


        $stmt->bindParam(61, $COD_TRABAJADOR_ENCARGADO ,PDO::PARAM_STR);                   
        $stmt->bindParam(62, $COD_TRABAJADOR_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(63, $COD_CONTRATO_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(64, $COD_CULTIVO_COMISIONISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(65, $COD_HABILITACION_COMISIONISTA  ,PDO::PARAM_STR);

        $stmt->bindParam(66, $COD_TRABAJADOR_VENDEDOR ,PDO::PARAM_STR);
        $stmt->bindParam(67, $COD_ZONA_COMERCIAL  ,PDO::PARAM_STR);
        $stmt->bindParam(68, $TXT_ZONA_COMERCIAL  ,PDO::PARAM_STR);
        $stmt->bindParam(69, $COD_LOTE_CC  ,PDO::PARAM_STR);
        $stmt->bindParam(70,$CAN_SUB_TOTAL  ,PDO::PARAM_STR);

        $stmt->bindParam(71, $CAN_IMPUESTO_VTA ,PDO::PARAM_STR);                   
        $stmt->bindParam(72, $CAN_IMPUESTO_RENTA  ,PDO::PARAM_STR);
        $stmt->bindParam(73, $CAN_TOTAL  ,PDO::PARAM_STR);
        $stmt->bindParam(74, $CAN_DSCTO  ,PDO::PARAM_STR);
        $stmt->bindParam(75, $CAN_TIPO_CAMBIO  ,PDO::PARAM_STR);

        $stmt->bindParam(76, $CAN_PERCEPCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(77, $CAN_DETRACCION  ,PDO::PARAM_STR);
        $stmt->bindParam(78, $CAN_RETENCION  ,PDO::PARAM_STR);
        $stmt->bindParam(79, $CAN_NETO_PAGAR  ,PDO::PARAM_STR);
        $stmt->bindParam(80, $CAN_TOTAL_COMISION  ,PDO::PARAM_STR);

        $stmt->bindParam(81, $COD_EMPR_BANCO ,PDO::PARAM_STR);
        $stmt->bindParam(82, $NRO_CUENTA_BANCARIA  ,PDO::PARAM_STR);
        $stmt->bindParam(83, $NRO_CARRO  ,PDO::PARAM_STR);
        $stmt->bindParam(84, $IND_VARIAS_ENTREGAS  ,PDO::PARAM_STR);
        $stmt->bindParam(85,$IND_TIPO_COMPRA  ,PDO::PARAM_STR);

        $stmt->bindParam(86, $NOM_CHOFER_EMPR_TRANSPORTE ,PDO::PARAM_STR);                   
        $stmt->bindParam(87, $NRO_ORDEN_CEN  ,PDO::PARAM_STR);
        $stmt->bindParam(88, $NRO_LICITACION  ,PDO::PARAM_STR);
        $stmt->bindParam(89, $NRO_NOTA_PEDIDO  ,PDO::PARAM_STR);
        $stmt->bindParam(90, $NRO_OPERACIONES_CAJA  ,PDO::PARAM_STR);

        $stmt->bindParam(91, $TXT_NRO_PLACA ,PDO::PARAM_STR);                   
        $stmt->bindParam(92, $TXT_CONTACTO  ,PDO::PARAM_STR);
        $stmt->bindParam(93, $TXT_MOTIVO_ANULACION  ,PDO::PARAM_STR);
        $stmt->bindParam(94, $TXT_CONFORMIDAD  ,PDO::PARAM_STR);
        $stmt->bindParam(95, $TXT_A_TIEMPO  ,PDO::PARAM_STR);

        $stmt->bindParam(96, $TXT_DESTINO ,PDO::PARAM_STR);
        $stmt->bindParam(97, $TXT_TIPO_DOC_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(98, $TXT_DOC_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(99, $TXT_ORDEN_ASOC  ,PDO::PARAM_STR);
        $stmt->bindParam(100,$COD_CATEGORIA_MODULO  ,PDO::PARAM_STR);

        $stmt->bindParam(101, $TXT_GLOSA_ATENCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(102, $TXT_GLOSA  ,PDO::PARAM_STR);
        $stmt->bindParam(103, $TXT_TIPO_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(104, $TXT_REFERENCIA  ,PDO::PARAM_STR);
        $stmt->bindParam(105, $COD_OPERACION  ,PDO::PARAM_STR);

        $stmt->bindParam(106, $TXT_GRR ,PDO::PARAM_STR);                   
        $stmt->bindParam(107, $TXT_GRR_TRANSPORTISTA  ,PDO::PARAM_STR);
        $stmt->bindParam(108, $TXT_CTC  ,PDO::PARAM_STR);
        $stmt->bindParam(109, $IND_ZONA  ,PDO::PARAM_STR);
        $stmt->bindParam(110, $IND_CERRADO  ,PDO::PARAM_STR);

        $stmt->bindParam(111, $COD_EMP_PROV_SERV ,PDO::PARAM_STR);
        $stmt->bindParam(112, $TXT_EMP_PROV_SERV  ,PDO::PARAM_STR);
        $stmt->bindParam(113, $COD_ESTADO  ,PDO::PARAM_STR);
        $stmt->bindParam(114, $COD_USUARIO_REGISTRO  ,PDO::PARAM_STR);
        $stmt->bindParam(115,$COD_CTA_GASTO_FUNCION  ,PDO::PARAM_STR);

        $stmt->bindParam(116, $NRO_CTA_GASTO_FUNCION ,PDO::PARAM_STR);                   
        $stmt->bindParam(117, $COD_CATEGORIA_ACTIVIDAD_NEGOCIO  ,PDO::PARAM_STR);
        $stmt->bindParam(118, $COD_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
        $stmt->bindParam(119, $TXT_EMPR_PROPIETARIO  ,PDO::PARAM_STR);
        $stmt->bindParam(120, $COD_CATEGORIA_TIPO_COSTEO  ,PDO::PARAM_STR);


        $stmt->bindParam(121, $TXT_CATEGORIA_TIPO_COSTEO ,PDO::PARAM_STR);
        $stmt->bindParam(122, $TXT_CORRELATIVO  ,PDO::PARAM_STR);
        $stmt->bindParam(123, $COD_MOVIMIENTO_INVENTARIO_EXTORNADO  ,PDO::PARAM_STR);
        $stmt->bindParam(124, $COD_ORDEN_EXTORNADA  ,PDO::PARAM_STR);
        $stmt->bindParam(125,$IND_ENV_CLIENTE  ,PDO::PARAM_STR);

        $stmt->bindParam(126, $IND_ORDEN ,PDO::PARAM_STR);                   
        $stmt->bindParam(127, $COD_MOTIVO_EXTORNO  ,PDO::PARAM_STR);
        $stmt->bindParam(128, $GLOSA_EXTORNO  ,PDO::PARAM_STR);

        $stmt->execute();

        $codorden = $stmt->fetch();

        return $codorden;
	}
	private function insert_almacen_lote($orden,$detalleproducto) {


        $conexionbd         = 'sqlsrv';
        if($orden->COD_CENTRO == 'CEN0000000000004'){ //rioja
            $conexionbd         = 'sqlsrv_r';
        }else{
            if($orden->COD_CENTRO == 'CEN0000000000006'){ //bellavista
                $conexionbd         = 'sqlsrv_b';
            }
        }



		$COD_EMPR            		=       $orden->COD_EMPR;
		$COD_CENTRO            		=       $orden->COD_CENTRO;

		foreach($detalleproducto as $index => $item){

			$IND_TIPO_OPERACION 	=		'I';
			$fecha_sin 				=		'1901-01-01 00:00:00';
			$vacio 					=		'';
			$activo 				=		'1';
			$idusuario 				=		Session::get('usuario')->name;
			$COD_ALMACEN            =       $item->COD_ALMACEN;
			$COD_LOTE            	=       $item->COD_LOTE;

			$stmt 					= 		DB::connection($conexionbd)->getPdo()->prepare('SET NOCOUNT ON;EXEC ALM.ALMACEN_LOTE_IUD 
												@IND_TIPO_OPERACION = ?,
												@COD_ALMACEN = ?,
												@COD_LOTE = ?,
												@COD_EMPR = ?,
												@COD_CENTRO = ?,

												@TXT_UBICACION = ?,
												@FEC_HORA_IN = ?,
												@FEC_HORA_OUT = ?,
												@COD_EQUIPO = ?,
												@TIPO_LOTE = ?,

												@COD_GRIFO = ?,
												@COD_LUG_GRIFO = ?,
												@COD_EMPR_PROPIETARIO = ?,
												@COD_EMPR_PROVEEDOR_SERV = ?,
												@COD_ESTADO = ?,

												@COD_USUARIO_REGISTRO = ?
												');

	        $stmt->bindParam(1, $IND_TIPO_OPERACION ,PDO::PARAM_STR);                   
	        $stmt->bindParam(2, $COD_ALMACEN  ,PDO::PARAM_STR);
	        $stmt->bindParam(3, $COD_LOTE  ,PDO::PARAM_STR);
	        $stmt->bindParam(4, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmt->bindParam(5, $COD_CENTRO  ,PDO::PARAM_STR);

	        $stmt->bindParam(6, $vacio ,PDO::PARAM_STR);
	        $stmt->bindParam(7, $fecha_sin  ,PDO::PARAM_STR);
	        $stmt->bindParam(8, $fecha_sin  ,PDO::PARAM_STR);
	        $stmt->bindParam(9, $vacio  ,PDO::PARAM_STR);
	        $stmt->bindParam(10,$vacio  ,PDO::PARAM_STR);

	        $stmt->bindParam(11, $vacio ,PDO::PARAM_STR);                   
	        $stmt->bindParam(12, $vacio  ,PDO::PARAM_STR);
	        $stmt->bindParam(13, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmt->bindParam(14, $COD_EMPR  ,PDO::PARAM_STR);
	        $stmt->bindParam(15, $activo  ,PDO::PARAM_STR);
	        $stmt->bindParam(16, $idusuario  ,PDO::PARAM_STR);
	        $stmt->execute();

		}
	}


}