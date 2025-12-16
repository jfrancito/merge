<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;

use App\Modelos\Cliente;
use App\Modelos\Categoria;
use App\Modelos\Proveedor;
use App\Modelos\Producto;
use App\Modelos\Compra;
use App\Modelos\DetalleCompra;
use App\Modelos\Moneda;
use App\Modelos\TipoCambio;
use App\Modelos\EntidadFinanciera;
use App\Modelos\CuentasEmpresa;
use App\Modelos\FeDocumento;


use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;

trait AcopioTraits
{

    private function aco_lista_cabecera_comprobante_total_acopio_estiba($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orWhereNull('area_observacion')
                                      ->orWhereIn('area_observacion',['UCO']);
                            })
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000012')
                            ->get();

        return  $listadatos;
    }

    private function aco_lista_cabecera_comprobante_total_acopio_estiba_obs($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')

                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')

                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000012')
                            ->get();

        return  $listadatos;
    }




    private function aco_lista_cabecera_comprobante_total_acopio_estiba_obs_levantadas($cliente_id,$operacion_id) {

        $listadatos     =   FeDocumento::leftJoin('CMP.DOCUMENTO_CTBLE', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'CMP.DOCUMENTO_CTBLE.COD_DOCUMENTO_CTBLE')
                            ->leftJoin(DB::raw('(SELECT COD_EMPR_CLIENTE, SUM(CAN_SALDO) AS CAN_DEUDA 
                                                 FROM DEUDA_TOTAL_MERGE_SUM 
                                                 GROUP BY COD_EMPR_CLIENTE) AS deuda'), 
                                'CMP.DOCUMENTO_CTBLE.COD_EMPR_EMISOR', '=', 'deuda.COD_EMPR_CLIENTE')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE,FE_DOCUMENTO.TXT_CONTACTO TXT_CONTACTO_UC,deuda.CAN_DEUDA AS CAN_DEUDA'))
                            ->where('OPERACION','=',$operacion_id)
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','CONT')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000012')
                            ->orderBy('ind_observacion','asc')
                            ->get();

        return  $listadatos;
    }





	private function aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('TES.AUTORIZACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'TES.AUTORIZACION.COD_AUTORIZACION')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','LIQUIDACION_COMPRA_ANTICIPO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where(function ($query) {
                                $query->where('ind_observacion', '<>', 1)
                                      ->orWhereNull('ind_observacion');
                            })
                            ->where(function ($query) {
                                $query->where('area_observacion', '=', '')
                                      ->orWhereNull('area_observacion')
                                      ->orWhereIn('area_observacion',['UCO']);
                            })
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000012')
                            ->get();

        return  $listadatos;
    }
	
    private function aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo_obs($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('TES.AUTORIZACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'TES.AUTORIZACION.COD_AUTORIZACION')
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','LIQUIDACION_COMPRA_ANTICIPO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('ind_observacion','=',1)
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000012')
                            ->get();

        return  $listadatos;
    }

    private function aco_lista_cabecera_comprobante_total_acopio_liquidacion_compra_anticipo_obs_levantadas($cliente_id) {

        $listadatos     =   FeDocumento::leftJoin('TES.AUTORIZACION', 'FE_DOCUMENTO.ID_DOCUMENTO', '=', 'TES.AUTORIZACION.COD_AUTORIZACION')                            
                            ->select(DB::raw('* ,FE_DOCUMENTO.COD_ESTADO COD_ESTADO_FE'))
                            ->where('OPERACION','=','LIQUIDACION_COMPRA_ANTICIPO')
                            ->where('FE_DOCUMENTO.COD_EMPR','=',Session::get('empresas')->COD_EMPR)
                            ->where('ind_observacion','=',0)
                            ->where('area_observacion','=','CONT')
                            ->where('FE_DOCUMENTO.COD_ESTADO','=','ETM0000000000012')
                            ->get();

        return  $listadatos;
    }




}