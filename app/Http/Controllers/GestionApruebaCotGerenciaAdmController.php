<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use App\Modelos\CMPOrden;
use App\Modelos\CMPDetalleProducto;
use Carbon\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;


class GestionApruebaCotGerenciaAdmController extends Controller
{
    public function actionGestionApruebaCotGerenciaAdm($idopcion)
    {
        $subquery_total_pedido = DB::raw('(SELECT ISNULL(SUM(OPD.CAN_PRECIO), 0) 
                                           FROM WEB.ORDEN_PEDIDO_DETALLE AS OPD 
                                           WHERE OPD.ACTIVO = 1 
                                             AND OPD.ID_PEDIDO IN (
                                                 SELECT REF.COD_TABLA 
                                                 FROM CMP.REFERENCIA_ASOC AS REF 
                                                 WHERE REF.COD_TABLA_ASOC = C.ID_COTIZACION
                                             )
                                          ) as CAN_TOTAL_PEDIDO');

        // 1. Cotizaciones Pendientes (ETM0000000000018)
        $pendientes = DB::table('WEB.ORDEN_COTIZACION as C')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->where('C.ACTIVO', 1)
            ->where('C.COD_ESTADO', 'ETM0000000000018')
            ->select('C.*', 'CEN.TXT_ABREVIATURA as ABREV_CENTRO', $subquery_total_pedido)
            ->orderBy('C.FEC_COTIZACION', 'desc')
            ->get();

        // 2. Cotizaciones Aprobadas (ETM0000000000005)
        $aprobados = DB::table('WEB.ORDEN_COTIZACION as C')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->where('C.ACTIVO', 1)
            ->where('C.COD_ESTADO', 'ETM0000000000005')
            ->where('C.COD_USUARIO_MODIF_AUD', '1CIX00000401')
            ->select('C.*', 'CEN.TXT_ABREVIATURA as ABREV_CENTRO', $subquery_total_pedido)
            ->orderBy('C.FEC_COTIZACION', 'desc')
            ->get();

        // 3. Cotizaciones Rechazadas / Anuladas (ETM0000000000014)
        $rechazados = DB::table('WEB.ORDEN_COTIZACION as C')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->where('C.ACTIVO', 1)
            ->where('C.COD_ESTADO', 'ETM0000000000014')
            ->where('C.COD_USUARIO_MODIF_AUD', '1CIX00000401')
            ->select('C.*', 'CEN.TXT_ABREVIATURA as ABREV_CENTRO', $subquery_total_pedido)
            ->orderBy('C.FEC_COTIZACION', 'desc')
            ->get();

        return view('ordenpedido.cotizacion.listacotizacionaprueba', [
            'idopcion' => $idopcion,
            'pendientes' => $pendientes,
            'aprobados' => $aprobados,
            'rechazados' => $rechazados,
            'titulo' => 'Aprobar Cotizacion',
        ]);
    }

    public function actionAjaxBuscarResumenCotizacion(Request $request)
    {
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $empresa_id = $request->input('empresa_id');
        $centro_id = $request->input('centro_id');
        $moneda_id = $request->input('moneda_id');

        $f_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $f_fin = date('Y-m-d', strtotime($fecha_fin));

        $subquery_total_pedido = DB::raw('(SELECT ISNULL(SUM(OPD.CAN_PRECIO), 0) 
                                           FROM WEB.ORDEN_PEDIDO_DETALLE AS OPD 
                                           WHERE OPD.ACTIVO = 1 
                                             AND OPD.ID_PEDIDO IN (
                                                 SELECT REF.COD_TABLA 
                                                 FROM CMP.REFERENCIA_ASOC AS REF 
                                                 WHERE REF.COD_TABLA_ASOC = C.ID_COTIZACION
                                             )
                                          ) as CAN_TOTAL_PEDIDO');

        $query = DB::table('WEB.ORDEN_COTIZACION as C')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->whereBetween(DB::raw('CAST(C.FEC_COTIZACION AS DATE)'), [$f_inicio, $f_fin])
            ->where('C.ACTIVO', 1)
            ->where('C.COD_ESTADO', 'ETM0000000000018'); // CRITICAL STATE FILTER: POR APROBAR GERENCIA ADMINISTRATIVA

        if ($empresa_id && $empresa_id !== 'TODO') {
            $query->where('C.COD_EMPR', $empresa_id);
        }

        if ($centro_id && $centro_id !== 'TODO') {
            $query->where('C.COD_CENTRO', $centro_id);
        }

        if ($moneda_id && $moneda_id !== 'TODO') {
            $query->where('C.COD_CATEGORIA_MONEDA', $moneda_id);
        }

        $listacotizaciones = $query->select(
                'C.*',
                'CEN.TXT_ABREVIATURA as ABREV_CENTRO',
                $subquery_total_pedido
            )
            ->orderBy('C.FEC_COTIZACION', 'desc')
            ->get();

        return view('ordenpedido.cotizacion.ajax.listacotizacionaprueba_ajax', [
            'listacotizaciones' => $listacotizaciones
        ]);
    }
}
