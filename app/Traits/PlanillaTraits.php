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
use App\Modelos\Firma;
use App\Modelos\PlaMovilidad;
use App\Modelos\PlaDetMovilidad;
use App\Modelos\FePlanillaEntregable;
use App\Modelos\DetalleSemanaImpulso;
use App\Modelos\SemanaImpulso;
use App\Modelos\LoteImpulso;



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


    private function plm_monto_total_impulsadora($trabajador_id,$fecha_pago) {

        $total = DB::table('SEMANA_IMPULSO')
            ->join('DETALLE_SEMANA_IMPULSO', 'SEMANA_IMPULSO.ID_DOCUMENTO', '=', 'DETALLE_SEMANA_IMPULSO.ID_DOCUMENTO')
            ->where('SEMANA_IMPULSO.COD_TRABAJADOR', $trabajador_id)
            ->where('SEMANA_IMPULSO.COD_ESTADO', 'ETM0000000000005')
            ->where('FECHA', $fecha_pago)
            ->selectRaw('SUM(DETALLE_SEMANA_IMPULSO.MONTO) as total_monto')
            ->first();

        $sumaTotal = $total->total_monto ?? 0;

        return  $sumaTotal;
    }

    private function plm_identificar_si_es_impulsadora($area_id) {

        $ind_impulsadora =  0;
        $configuraciones =  DB::table('CONFIGURACION_IMPULSO')
                            ->where('ACTIVO', 1)
                            ->where('AREA_ID', '=',$area_id)
                            ->get();
        if(count($configuraciones)>0){
            $ind_impulsadora =  1;
        }else{
            $ind_impulsadora =  0;
        }

        return  $ind_impulsadora;
    }


    private function plm_lista_cabecera_comprobante_total_firma() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   Firma::where('ACTIVO','=','1')
                                    ->where('COD_ESTADO','=','ETM0000000000004')
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }else{

            $listadatos         =   Firma::where('ACTIVO','=','1')
                                    ->where('COD_ESTADO','=','ETM0000000000004')
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }

        return  $listadatos;
    }


    private function plm_lista_cabecera_comprobante_total_obs_le_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',0)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }else{

            $listadatos         =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',0)
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }

        return  $listadatos;
    }

    private function plm_lista_cabecera_comprobante_total_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->where(function ($query) {
                                        $query->where('IND_OBSERVACION', '<>', 1)
                                              ->orWhereNull('IND_OBSERVACION');
                                    })
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }else{

            $listadatos         =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->where(function ($query) {
                                        $query->where('IND_OBSERVACION', '<>', 1)
                                              ->orWhereNull('IND_OBSERVACION');
                                    })
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }

        return  $listadatos;
    }

    private function plm_lista_cabecera_comprobante_total_obs_jefe() {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos         =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',1)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }else{

            $listadatos         =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->where('IND_OBSERVACION','=',1)
                                    ->where('COD_USUARIO_AUTORIZA','=',Session::get('usuario')->id)
                                    ->where('COD_ESTADO','=','ETM0000000000010')
                                    ->where('COD_EMPRESA','=',Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','ASC')
                                    ->get();

        }

        return  $listadatos;
    }


    private function calcular_total_movilidad_impulso_masivo($iddocumento,$semana_impulso_id) {

        $lote                   =   LoteImpulso::where('ID_DOCUMENTO','=',$iddocumento)->first();
        $tdetplanillamovilidad  =   DetalleSemanaImpulso::where('LOTE_IMPULSO_ID','=',$lote->ID_DOCUMENTO)->where('ACTIVO','=','1')->get();

        SemanaImpulso::where('LOTE_IMPULSO_ID','=',$lote->LOTE_IMPULSO_ID)->where('ID_DOCUMENTO','=',$semana_impulso_id)
                    ->update(
                            [
                                'MONTO'=> $tdetplanillamovilidad->SUM('MONTO')
                            ]);

        LoteImpulso::where('ID_DOCUMENTO','=',$iddocumento)
                    ->update(
                            [
                                'MONTO'=> $tdetplanillamovilidad->SUM('MONTO')
                            ]);



    }


    private function calcular_total_movilidad_impulso($iddocumento) {

        $tdetplanillamovilidad  =   DetalleSemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)->where('ACTIVO','=','1')->get();

        SemanaImpulso::where('ID_DOCUMENTO','=',$iddocumento)
                    ->update(
                            [
                                'MONTO'=> $tdetplanillamovilidad->SUM('MONTO')
                            ]);



    }

    private function obtenerNombreDiaDinamico($fecha) {
        $carbonFecha = Carbon::parse($fecha);
        
        // Para Laravel 5.4, usar format en español manualmente
        $dias = [
            'Monday' => 'Lunes',
            'Tuesday' => 'Martes',
            'Wednesday' => 'Miércoles',
            'Thursday' => 'Jueves',
            'Friday' => 'Viernes',
            'Saturday' => 'Sábado',
            'Sunday' => 'Domingo'
        ];
        
        $nombreIngles = $carbonFecha->format('l');
        $nombreEspanol = isset($dias[$nombreIngles]) ? $dias[$nombreIngles] : $nombreIngles;
        
        return $nombreEspanol . ' ' . $carbonFecha->format('d/m');
    }
    private function obtenerNombreDia($numeroDia) {
        $dias = [
            1 => 'Lunes',
            2 => 'Martes',
            3 => 'Miércoles',
            4 => 'Jueves',
            5 => 'Viernes',
            6 => 'Sábado',
            7 => 'Domingo'
        ];
        
        return $dias[$numeroDia] ?? 'Día ' . $numeroDia;
    }

    private function pla_lista_planilla_movilidad_impulso_personal($fecha_inicio,$fecha_fin) {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $planillamovilidad  =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                    ->where('COD_EMPRESA','=', Session::get('empresas')->COD_EMPR)
                                    ->whereRaw("ISNULL(LOTE_IMPULSO_ID,'') = ''")
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->orderby('FECHA_CREA','DESC')->get();
                                    
        }else{

            $planillamovilidad  =   SemanaImpulso::where('ACTIVO','=','1')
                                    ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->whereRaw("ISNULL(LOTE_IMPULSO_ID,'') = ''")
                                    ->where('COD_EMPRESA','=', Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','DESC')->get();


        }

        return  $planillamovilidad;
    }

    private function pla_lista_planilla_movilidad_impulso_masivo($fecha_inicio,$fecha_fin,$tipo) {

        $planillamovilidad      =   LoteImpulso::where('ACTIVO','=','1')
                                    ->where('TIPO_LOTE','=',$tipo)
                                    ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->where('COD_EMPRESA','=', Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','DESC')->get();
        return  $planillamovilidad;
    }



    private function pla_lista_planilla_movilidad_personal($fecha_inicio,$fecha_fin) {
        if(Session::get('usuario')->id== '1CIX00000001'){

            $planillamovilidad  =   PlaMovilidad::where('ACTIVO','=','1')
                                    ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                    ->where('COD_EMPRESA','=', Session::get('empresas')->COD_EMPR)
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->orderby('FECHA_CREA','DESC')->get();
                                    
        }else{

            $planillamovilidad  =   PlaMovilidad::where('ACTIVO','=','1')
                                    ->whereRaw("CAST(FECHA_CREA  AS DATE) >= ? and CAST(FECHA_CREA  AS DATE) <= ?", [$fecha_inicio,$fecha_fin])
                                    ->where('USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->where('COD_EMPRESA','=', Session::get('empresas')->COD_EMPR)
                                    ->orderby('FECHA_CREA','DESC')->get();


        }

        return  $planillamovilidad;
    }


    private function pl_lista_cabecera_comprobante_total_contabilidad($empresa_id) {

        $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                            ->where('COD_EMPRESA','=',$empresa_id)
                            ->where('COD_ESTADO','=','1')
                            ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000003')
                            ->orderBy('FE_PLANILLA_ENTREGABLE.FECHA_CREA','DESC')
                            ->get();

        return  $listadatos;
    }


    private function pl_lista_cabecera_comprobante_total_contabilidad_revisadas($empresa_id) {

        $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                            ->where('COD_EMPRESA','=',$empresa_id)
                            ->where('COD_ESTADO','=','1')
                            ->where('COD_CATEGORIA_ESTADO','=','ETM0000000000005')
                            ->orderBy('FE_PLANILLA_ENTREGABLE.FECHA_CREA','DESC')
                            ->get();

        return  $listadatos;
    }


    private function pl_lista_cabecera_comprobante_total_contabilidad_historial($empresa_id) {

        $listadatos     =   DB::table('PLA_MOVILIDAD')
                            ->selectRaw(" DISTINCT PLA_MOVILIDAD.SERIE,
                                PLA_MOVILIDAD.NUMERO,
                                PLA_MOVILIDAD.FECHA_EMI,
                                PLA_MOVILIDAD.TXT_TRABAJADOR,
                                PLA_MOVILIDAD.TXT_PERIODO,
                                PLA_MOVILIDAD.TOTAL,
                                FE_PLANILLA_ENTREGABLE.SERIE as SERIEFOLIO,
                                FE_PLANILLA_ENTREGABLE.NUMERO as NUMEROFOLIO,
                                FE_PLANILLA_ENTREGABLE.TXT_GLOSA as GLOSAFOLIO,
                                LQG_LIQUIDACION_GASTO.ID_DOCUMENTO,
                                LQG_LIQUIDACION_GASTO.TXT_ESTADO,
                                LQG_LIQUIDACION_GASTO.TXT_AREA,
                                LQG_LIQUIDACION_GASTO.TXT_USUARIO_AUTORIZA,
                                WEB.cadcargo,
                                WEB.emailcorp,
                                JEFE.emailcorp AS email_jefe")
                                 ->selectRaw("
                                    (
                                        SELECT TOP 1 TXT_CATEGORIA_ESTADO
                                        FROM FE_PLANILLA_ENTREGABLE
                                        WHERE FOLIO = PLA_MOVILIDAD.FOLIO
                                           OR FOLIO = PLA_MOVILIDAD.FOLIO_RESERVA
                                    ) AS TXT_ESTADO_CONSOLIDADO
                                ")

                            ->join('LQG_DETLIQUIDACIONGASTO', 'PLA_MOVILIDAD.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.COD_PLA_MOVILIDAD')
                            ->join('LQG_LIQUIDACION_GASTO', 'LQG_LIQUIDACION_GASTO.ID_DOCUMENTO', '=', 'LQG_DETLIQUIDACIONGASTO.ID_DOCUMENTO')

                            ->leftJoin('users','users.id','=','LQG_LIQUIDACION_GASTO.COD_USUARIO_AUTORIZA')
                            ->leftJoin('STD.TRABAJADOR','STD.TRABAJADOR.COD_TRAB', '=', 'users.usuarioosiris_id')
                            ->leftJoin(DB::raw("(SELECT dni, MAX(emailcorp) AS emailcorp FROM WEB.platrabajadores 
                                                GROUP BY dni) AS JEFE"),
                                                             'JEFE.dni','=','STD.TRABAJADOR.NRO_DOCUMENTO')
                            ->leftJoin(DB::raw("(SELECT dni,
                                                MAX(cadcargo)  AS cadcargo,
                                                MAX(emailcorp) AS emailcorp
                                                FROM WEB.platrabajadores
                                                    GROUP BY dni
                                                ) AS WEB"),
                                                'WEB.dni',
                                                '=',
                                                'PLA_MOVILIDAD.DOCUMENTO_TRABAJADOR'
                                        )
                            ->leftJoin('FE_PLANILLA_ENTREGABLE', 'FE_PLANILLA_ENTREGABLE.FOLIO', '=', 'PLA_MOVILIDAD.FOLIO')
                            ->where('PLA_MOVILIDAD.ACTIVO', 1)
                            ->where('PLA_MOVILIDAD.COD_EMPRESA','=',$empresa_id)
                            ->where('PLA_MOVILIDAD.COD_ESTADO', '<>', 'ETM0000000000001')
                            ->where('LQG_LIQUIDACION_GASTO.COD_ESTADO', '<>', 'ETM0000000000006')
                            ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
                            ->orderBy('PLA_MOVILIDAD.FECHA_EMI','DESC')
                            ->get();

        return  $listadatos;
    }


    private function pl_lista_planilla_moilidad_consolidado($empresa_id) {

        if(Session::get('usuario')->id== '1CIX00000001'){

            $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('COD_ESTADO','=','1')
                                ->where('COD_CATEGORIA_ESTADO','<>','ETM0000000000001')
                                ->orderBy('FE_PLANILLA_ENTREGABLE.FECHA_CREA','DESC')
                                ->get();


        }else{

            $listadatos     =   FePlanillaEntregable::join('users','users.id','=','FE_PLANILLA_ENTREGABLE.USUARIO_CREA')
                                ->where('COD_EMPRESA','=',$empresa_id)
                                ->where('COD_ESTADO','=','1')
                                ->where('COD_CATEGORIA_ESTADO','<>','ETM0000000000001')
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
                ->whereRaw("ISNULL(PLA_MOVILIDAD.FOLIO,'') = ''")
                ->whereRaw("CAST(PLA_MOVILIDAD.FECHA_EMI AS DATE) >= CAST(? AS DATE)", [$fecha_inicio])
                ->whereRaw("CAST(PLA_MOVILIDAD.FECHA_EMI AS DATE) <= CAST(? AS DATE)", [$fecha_fin])
                ->where('LQG_LIQUIDACION_GASTO.COD_ESTADO', 'ETM0000000000005')
                ->where('LQG_DETLIQUIDACIONGASTO.COD_TIPODOCUMENTO', 'TDO0000000000070')
                ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
                ->where('PLA_MOVILIDAD.COD_EMPRESA','=',$empresa_id)
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
                                    ->whereRaw("ISNULL(PLA_MOVILIDAD.FOLIO,'') = ''")
                                    ->where('LQG_DETLIQUIDACIONGASTO.ACTIVO', 1)
                                    ->where('PLA_MOVILIDAD.USUARIO_CREA','=',Session::get('usuario')->id)
                                    ->where('PLA_MOVILIDAD.COD_EMPRESA','=',$empresa_id)
                                    ->whereRaw("CAST(PLA_MOVILIDAD.FECHA_EMI AS DATE) >= CAST(? AS DATE)", [$fecha_inicio])
                                    ->whereRaw("CAST(PLA_MOVILIDAD.FECHA_EMI AS DATE) <= CAST(? AS DATE)", [$fecha_fin])
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