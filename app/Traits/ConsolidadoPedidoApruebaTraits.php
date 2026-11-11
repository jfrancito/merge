<?php

namespace App\Traits;

use App\Modelos\WEBValeRendir;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, App\CMPCategoria;
use App\Modelos\STDTrabajadorVale;
use App\User;
use Session;
use PDO;

trait ConsolidadoPedidoApruebaTraits

{
	 private function lg_lista_consolidado_aprueba($empresa_id, $centro_pedido,$mes_pedido, $anio_pedido)
    {
        $empresa_session_id = Session::get('empresas')->COD_EMPR;

        $query = DB::connection('sqlsrv')
            ->table(DB::raw("
            WEB.ORDEN_PEDIDO_CONSOLIDADO C
            INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE D
                ON C.ID_PEDIDO_CONSOLIDADO = D.ID_PEDIDO_CONSOLIDADO
            INNER JOIN STD.EMPRESA E
                ON E.COD_EMPR = C.COD_EMPR
            INNER JOIN ALM.CENTRO CEN
                ON CEN.COD_CENTRO = C.COD_CENTRO

            OUTER APPLY (
                SELECT 
                    MAX(OP2.COD_ANIO) AS COD_ANIO,
                    MAX(OP2.COD_PERIODO) AS COD_PERIODO,

                    STUFF((
                        SELECT 
                            ' [SEP] '
                            + CONVERT(VARCHAR(10), OP.FEC_PEDIDO, 103)
                            + ' [FLD] ' + OP.ID_PEDIDO
                            + ' [FLD] ' + OP.TXT_AREA
                            + ' [FLD] ' + ISNULL(OP.TXT_GLOSA,'')
                            + ' [FLD] ' + CAST(SUM(
                                    COALESCE(
                                        OPD.CAN_MODIF_ADM, 
                                        OPD.CAN_MODIF_GER, 
                                        OPD.CAN_MODIF_JEF_AUT, 
                                        OPD.CANTIDAD
                                    )
                                ) AS VARCHAR(20))
                            + ' [FLD] ' + CEN_ORIG.NOM_CENTRO
                            + ' [FLD] ' + ISNULL((
                                SELECT ' [DOC] ' + ARCH.NOMBRE_ARCHIVO + ' [URI] ' + ARCH.URL_ARCHIVO
                                FROM dbo.ARCHIVOS ARCH
                                WHERE ARCH.ID_DOCUMENTO = OP.ID_PEDIDO
                                AND ARCH.ACTIVO = 1
                                FOR XML PATH(''), TYPE
                            ).value('.', 'NVARCHAR(MAX)'), '')
                        FROM CMP.REFERENCIA_ASOC RA
                        INNER JOIN WEB.ORDEN_PEDIDO OP
                            ON OP.ID_PEDIDO = RA.COD_TABLA
                        INNER JOIN ALM.CENTRO CEN_ORIG
                            ON CEN_ORIG.COD_CENTRO = OP.COD_CENTRO
                        INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                            ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                        WHERE RA.COD_TABLA_ASOC = C.ID_PEDIDO_CONSOLIDADO
                          AND RA.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                          AND RA.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                          AND RA.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                          AND OPD.COD_PRODUCTO = D.COD_PRODUCTO
                               AND OPD.ACTIVO = 1
                          AND OPD.ACTIVO = 1
                        GROUP BY 
                            OP.FEC_PEDIDO,
                            OP.ID_PEDIDO,
                            OP.TXT_AREA,
                            OP.TXT_GLOSA,
                            CEN_ORIG.NOM_CENTRO
                        ORDER BY OP.FEC_PEDIDO
                        FOR XML PATH(''), TYPE
                    ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS DETALLE_POR_AREA

                FROM CMP.REFERENCIA_ASOC RA2
                INNER JOIN WEB.ORDEN_PEDIDO OP2
                    ON OP2.ID_PEDIDO = RA2.COD_TABLA
                WHERE RA2.COD_TABLA_ASOC = C.ID_PEDIDO_CONSOLIDADO
                  AND RA2.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                  AND RA2.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                  AND RA2.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
            ) PED
        "))
            ->when($empresa_id, function ($q) use ($empresa_id) {
                $q->where('C.COD_EMPR', $empresa_id);
            })
            ->where('C.COD_ESTADO', 'ETM0000000000015')
            ->where('C.ACTIVO', 1)
            ->where('D.ACTIVO', 1)
            ->whereNull('C.CONSOLIDADO_GENERAL')
            ->when($centro_pedido && $centro_pedido != 'TODO', function ($q) use ($centro_pedido) {
                $q->where('C.COD_CENTRO', $centro_pedido);
            })
            ->select(
                'C.ID_PEDIDO_CONSOLIDADO',
                'C.FEC_PEDIDO',
                'PED.COD_ANIO',
                'PED.COD_PERIODO',
                'C.TXT_NOMBRE',
                'E.NOM_EMPR',
                'CEN.NOM_CENTRO',
                'C.COD_ESTADO',
                'C.TXT_ESTADO',
                'D.COD_PRODUCTO',
                'D.NOM_PRODUCTO',
                'D.COD_CATEGORIA_MEDIDA',
                'D.NOM_CATEGORIA_MEDIDA',
                'D.COD_CATEGORIA_FAMILIA',
                'D.NOM_CATEGORIA_FAMILIA',
                'D.CANTIDAD',
                'D.STOCK',
                'D.RESERVADO',
                'D.DIFERENCIA',
                'PED.DETALLE_POR_AREA'
            )
            ->when($mes_pedido && $mes_pedido != 'TODO', function ($q) use ($mes_pedido) {
                $q->where('PED.COD_PERIODO', $mes_pedido);
            })
            ->when($anio_pedido && $anio_pedido != 'TODO', function ($q) use ($anio_pedido) {
                $q->where('PED.COD_ANIO', $anio_pedido);
            })
            ->orderBy('C.ID_PEDIDO_CONSOLIDADO', 'ASC')
            ->get()
            ->groupBy('ID_PEDIDO_CONSOLIDADO');

        return $query;
    }

    private function lg_lista_detalle_consolidado_aprobado($id_consolidado)
    {

        $pedido = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
            ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
            ->first();

        $query = DB::connection('sqlsrv')
            ->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D')
            ->join('WEB.ORDEN_PEDIDO_CONSOLIDADO as C',
                'C.ID_PEDIDO_CONSOLIDADO', '=', 'D.ID_PEDIDO_CONSOLIDADO')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->select(
                'D.*',
                'C.COD_ESTADO',
                'C.COD_EMPR',
                'C.COD_CENTRO',
                'CEN.NOM_CENTRO as NOM_CENTRO_CONSOLIDADO',
                DB::raw("
            STUFF((
                SELECT 
                    ' [SEP] ' 
                    + CONVERT(VARCHAR(10), OP.FEC_PEDIDO, 103)
                    + ' [FLD] ' + OP.ID_PEDIDO
                    + ' [FLD] ' + OP.TXT_AREA
                    + ' [FLD] ' + ISNULL(OPD.TXT_OBSERVACION,'')
                    + ' [FLD] ' + CAST(SUM(
                        COALESCE(
                            OPD.CAN_MODIF_ADM, 
                            OPD.CAN_MODIF_GER, 
                            OPD.CAN_MODIF_JEF_AUT, 
                            OPD.CANTIDAD
                        )
                    ) AS VARCHAR(20))
                    + ' [FLD] ' + ISNULL((
                        SELECT ' [DOC] ' + ARCH.NOMBRE_ARCHIVO + ' [URI] ' + ARCH.URL_ARCHIVO
                        FROM dbo.ARCHIVOS ARCH
                        WHERE ARCH.ID_DOCUMENTO = OP.ID_PEDIDO
                        AND ARCH.ACTIVO = 1
                        FOR XML PATH(''), TYPE
                    ).value('.', 'NVARCHAR(MAX)'), '')
                FROM CMP.REFERENCIA_ASOC RA
                INNER JOIN WEB.ORDEN_PEDIDO OP
                    ON OP.ID_PEDIDO = RA.COD_TABLA
                INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                    ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                WHERE RA.COD_TABLA_ASOC = D.ID_PEDIDO_CONSOLIDADO
                    AND RA.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                    AND RA.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                    AND RA.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                    AND OPD.COD_PRODUCTO = D.COD_PRODUCTO
                    AND OPD.ACTIVO = 1
                    AND OP.ACTIVO = 1
                    AND OP.COD_PERIODO = '" . $pedido->COD_PERIODO . "' 
                GROUP BY 
                    OP.FEC_PEDIDO,
                    OP.ID_PEDIDO,
                    OP.TXT_AREA,
                    OPD.TXT_OBSERVACION
                ORDER BY OP.FEC_PEDIDO
                FOR XML PATH(''), TYPE
            ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS DETALLE_POR_AREA
        ")
            )
            ->where('D.ID_PEDIDO_CONSOLIDADO', $id_consolidado)
            ->where('C.COD_PERIODO', $pedido->COD_PERIODO)
            ->get();

        return $query;
    }

    private function lg_lista_consolidado_aprobados($empresa_id, $centro_pedido, $mes_pedido, $anio_pedido)
    {
        $query = DB::connection('sqlsrv')
            ->table(DB::raw("
            WEB.ORDEN_PEDIDO_CONSOLIDADO C
            INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE D
                ON C.ID_PEDIDO_CONSOLIDADO = D.ID_PEDIDO_CONSOLIDADO
            INNER JOIN STD.EMPRESA E
                ON E.COD_EMPR = C.COD_EMPR
            INNER JOIN ALM.CENTRO CEN
                ON CEN.COD_CENTRO = C.COD_CENTRO

            OUTER APPLY (
                SELECT 
                    MAX(OP2.COD_ANIO) AS COD_ANIO,
                    MAX(OP2.COD_PERIODO) AS COD_PERIODO
                FROM CMP.REFERENCIA_ASOC RA2
                INNER JOIN WEB.ORDEN_PEDIDO OP2
                    ON OP2.ID_PEDIDO = RA2.COD_TABLA
                WHERE RA2.COD_TABLA_ASOC = C.ID_PEDIDO_CONSOLIDADO
                  AND RA2.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                  AND RA2.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                  AND RA2.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
            ) PED
        "))
            ->when($empresa_id, function ($q) use ($empresa_id) {
                $q->where('C.COD_EMPR', $empresa_id);
            })
            ->where('C.COD_ESTADO', 'ETM0000000000005') // APROBADO
            ->where('C.ACTIVO', 1)
            ->where('D.ACTIVO', 1)
            ->when($centro_pedido && $centro_pedido != 'TODO', function ($q) use ($centro_pedido) {
                $q->where('C.COD_CENTRO', $centro_pedido);
            })
            ->select(
                'C.ID_PEDIDO_CONSOLIDADO',
                'C.FEC_PEDIDO',
                'PED.COD_ANIO',
                'PED.COD_PERIODO',
                'C.TXT_NOMBRE',
                'E.NOM_EMPR',
                'CEN.NOM_CENTRO',
                'C.COD_ESTADO',
                'C.TXT_ESTADO',
                'D.COD_PRODUCTO',
                'D.NOM_PRODUCTO',
                'D.COD_CATEGORIA_MEDIDA',
                'D.NOM_CATEGORIA_MEDIDA',
                'D.COD_CATEGORIA_FAMILIA',
                'D.NOM_CATEGORIA_FAMILIA',
                'D.CANTIDAD',
                'D.STOCK',
                'D.RESERVADO',
                'D.DIFERENCIA'
            )
            ->when($mes_pedido && $mes_pedido != 'TODO', function ($q) use ($mes_pedido) {
                $q->where('PED.COD_PERIODO', $mes_pedido);
            })
            ->when($anio_pedido && $anio_pedido != 'TODO', function ($q) use ($anio_pedido) {
                $q->where('PED.COD_ANIO', $anio_pedido);
            })
            ->orderBy('C.ID_PEDIDO_CONSOLIDADO', 'DESC')
            ->get()
            ->groupBy('ID_PEDIDO_CONSOLIDADO');

        return $query;
    }

}
