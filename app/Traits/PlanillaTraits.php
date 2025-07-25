<?php

namespace App\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Crypt;
use App\Modelos\VMergeOC;
use App\Modelos\FeDocumento;
use App\Modelos\CMPCategoria;
use App\Modelos\CMPOrden;
use App\Modelos\STDTrabajador;
use App\Modelos\SGDUsuario;
use App\Modelos\VMergeActual;
use App\Modelos\Archivo;
use App\Modelos\VMergeDocumento;
use App\Modelos\VMergeDocumentoActual;
use App\Modelos\CMPDocAsociarCompra;
use App\Modelos\WEBRol;
use App\Modelos\FeRefAsoc;
use App\Modelos\CONRegistroCompras;
use App\Modelos\Estado;
use App\Modelos\CMPDetalleProducto;
use App\Modelos\CMPDocumentoCtble;
use App\Modelos\ViewDPagar;
use App\Modelos\FeDocumentoHistorial;
use App\Modelos\STDEmpresa;
use App\Modelos\CMPReferecenciaAsoc;
use App\Modelos\Whatsapp;

use App\Modelos\PlaMovilidad;
use App\Modelos\PlaDetMovilidad;
use App\Modelos\FePlanillaEntregable;
use App\User;

use ZipArchive;
use SplFileInfo;
use View;
use Session;
use Hashids;
Use Nexmo;
use Keygen;
use SoapClient;
use Carbon\Carbon;

trait PlanillaTraits
{

    private function pl_lista_cabecera_comprobante_total_contabilidad($empresa_id) {

        $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                            ->where('COD_EMPRESA','=',$empresa_id)
                            ->where('COD_ESTADO','=','1')
                            ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000003')
                            ->orderBy('FE_PLANILLA_ENTREGABLE.FECHA_CREA','DESC')
                            ->get();

        return  $listadatos;
    }


    private function pl_lista_planilla_moilidad_consolidado($empresa_id) {

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('COD_ESTADO','=','1')
                                ->orderBy('FE_PLANILLA_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();


        }else{

            $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('COD_ESTADO','=','1')
                                ->whereIn('USUARIO_CREA',[
                                    Session::get('usuario')->id
                                ])
                                ->orderBy('FE_PLANILLA_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();
        }

        return  $listadatos;

    }


    private function pl_lista_planilla_moilidad_sinconsolidar($fecha_inicio,$fecha_fin,$empresa_id) {


        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos = DB::table('LQG_LIQUIDACION_GASTO')
                ->select(
                    'PLA_MOVILIDAD.*',
                    'fechas.FECHA_INICIO',
                    'fechas.FECHA_FIN'
                )
                ->join('LQG_DETLIQUIDACIONGASTO', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO')
                ->join('PLA_MOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.COD_PLA_MOVILIDAD')
                ->join(DB::raw('(SELECT ID_DOCUMENTO, 
                                MIN(FECHA_GASTO) AS FECHA_INICIO, 
                                MAX(FECHA_GASTO) AS FECHA_FIN
                            FROM PLA_DETMOVILIDAD
                            GROUP BY ID_DOCUMENTO) fechas'), 
                    function($join) {
                        $join->on('PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'fechas.ID_DOCUMENTO');
                    })
                ->whereRaw("PLA_MOVILIDAD.FOLIO = '' AND PLA_MOVILIDAD.FOLIO IS NULL")
                ->where('LQG_LIQUIDACION_GASTO.COD_ESTADO', 'ETM0000000000005')
                ->where('LQG_DETLIQUIDACIONGASTO.COD_TIPODOCUMENTO', 'TDO0000000000070')
                ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
                ->where('PLA_MOVILIDAD.COD_EMPRESA','=',$empresa_id)
                ->where('fechas.FECHA_INICIO', '>=', $fecha_inicio)
                ->where('fechas.FECHA_FIN', '<=', $fecha_fin)
                ->get();


        }else{

            $listadatos     =       DB::table('LQG_LIQUIDACION_GASTO')
                                    ->select(
                                        'PLA_MOVILIDAD.*',
                                        'fechas.FECHA_INICIO',
                                        'fechas.FECHA_FIN'
                                    )
                                    ->join('LQG_DETLIQUIDACIONGASTO', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO')
                                    ->join('PLA_MOVILIDAD', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.COD_PLA_MOVILIDAD')
                                    ->join(DB::raw('(SELECT ID_DOCUMENTO, 
                                                    MIN(FECHA_GASTO) AS FECHA_INICIO, 
                                                    MAX(FECHA_GASTO) AS FECHA_FIN
                                                FROM PLA_DETMOVILIDAD
                                                GROUP BY ID_DOCUMENTO) fechas'), 
                                        function($join) {
                                            $join->on('PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'fechas.ID_DOCUMENTO');
                                        })
                                    ->where('LQG_LIQUIDACION_GASTO.COD_ESTADO', 'ETM0000000000005')
                                    ->where('LQG_DETLIQUIDACIONGASTO.COD_TIPODOCUMENTO', 'TDO0000000000070')
                                    ->whereRaw("PLA_MOVILIDAD.FOLIO = '' AND PLA_MOVILIDAD.FOLIO IS NULL")
                                    ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
                                    ->where('PLA_MOVILIDAD.USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->where('PLA_MOVILIDAD.COD_EMPRESA','=',$empresa_id)
                                    ->where('fechas.FECHA_INICIO', '>=', $fecha_inicio)
                                    ->where('fechas.FECHA_FIN', '<=', $fecha_fin)
                                    ->get();


        }


        return  $listadatos;

    }




    private function pla_lista_cabecera_comprobante_total_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){
            $listadatos         =   PlaMovilidad::where('ACTIVO','=','1')
                                    //->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();
        }else{

            $listadatos         =   PlaMovilidad::where('ACTIVO','=','1')
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_EMI','ASC')
                                    ->get();

        }

        return  $listadatos;
    }


    private function pla_lista_cabecera_comprobante_total_administracion() {

        $listadatos         =   PlaMovilidad::where('ACTIVO','=','1')
                                ->where('COD_ESTADO','=','ETM0000000000004')
                                ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                ->orderby('FECHA_EMI','ASC')
                                ->get();

        return  $listadatos;
    }


}