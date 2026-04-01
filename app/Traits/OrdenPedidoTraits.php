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

trait OrdenPedidoTraits

{

    public function insertOrdenPedido($ind_tipo_operacion, $id_pedido, $fec_pedido, $cod_periodo, $txt_nombre, $cod_anio, $cod_empr, $cod_centro,
                                      $cod_tipo_pedido, $txt_tipo_pedido, $cod_trabajador_solicita, $txt_trabajador_solicita,
                                      $cod_trabajador_autoriza, $txt_trabajador_autoriza, $cod_trabajador_aprueba_ger, $txt_trabajador_aprueba_ger, $cod_trabajador_aprueba_adm, $txt_trabajador_aprueba_adm, $txt_glosa, $cod_estado, $txt_estado, $cod_area, $txt_area, $activo, $cod_usuario_registro)
    {
        try {
            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_PEDIDO = ?,
                                                                        @FEC_PEDIDO = ?,
                                                                        @COD_PERIODO = ?,
                                                                        @TXT_NOMBRE = ?,
                                                                        @COD_ANIO = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_TIPO_PEDIDO = ?,
                                                                        @TXT_TIPO_PEDIDO = ?,
                                                                        @COD_TRABAJADOR_SOLICITA = ?,
                                                                        @TXT_TRABAJADOR_SOLICITA = ?,
                                                                        @COD_TRABAJADOR_AUTORIZA = ?,
                                                                        @TXT_TRABAJADOR_AUTORIZA = ?,
                                                                        @COD_TRABAJADOR_APRUEBA_GER = ?,
                                                                        @TXT_TRABAJADOR_APRUEBA_GER = ?,
                                                                        @COD_TRABAJADOR_APRUEBA_ADM = ?,
                                                                        @TXT_TRABAJADOR_APRUEBA_ADM = ?,
                                                                        @TXT_GLOSA = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @TXT_ESTADO = ?,
                                                                        @COD_AREA = ?,
                                                                        @TXT_AREA = ?,
                                                                        @ACTIVO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

            $cod_usuario_registro = Session::get('usuario')->id;
            $cod_empr = Session::get('empresas')->COD_EMPR;


            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_pedido, PDO::PARAM_STR);
            $stmt->bindParam(3, $fec_pedido, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_periodo, PDO::PARAM_STR);
            $stmt->bindParam(5, $txt_nombre, PDO::PARAM_STR);
            $stmt->bindParam(6, $cod_anio, PDO::PARAM_STR);
            $stmt->bindParam(7, $cod_empr, PDO::PARAM_STR);
            $stmt->bindParam(8, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(9, $cod_tipo_pedido, PDO::PARAM_STR);
            $stmt->bindParam(10, $txt_tipo_pedido, PDO::PARAM_STR);
            $stmt->bindParam(11, $cod_trabajador_solicita, PDO::PARAM_STR);
            $stmt->bindParam(12, $txt_trabajador_solicita, PDO::PARAM_STR);
            $stmt->bindParam(13, $cod_trabajador_autoriza, PDO::PARAM_STR);
            $stmt->bindParam(14, $txt_trabajador_autoriza, PDO::PARAM_STR);
            $stmt->bindParam(15, $cod_trabajador_aprueba_ger, PDO::PARAM_STR);
            $stmt->bindParam(16, $txt_trabajador_aprueba_ger, PDO::PARAM_STR);
            $stmt->bindParam(17, $cod_trabajador_aprueba_adm, PDO::PARAM_STR);
            $stmt->bindParam(18, $txt_trabajador_aprueba_adm, PDO::PARAM_STR);
            $stmt->bindParam(19, $txt_glosa, PDO::PARAM_STR);
            $stmt->bindParam(20, $cod_estado, PDO::PARAM_STR);
            $stmt->bindParam(21, $txt_estado, PDO::PARAM_STR);
            $stmt->bindParam(22, $cod_area, PDO::PARAM_STR);
            $stmt->bindParam(23, $txt_area, PDO::PARAM_STR);
            $stmt->bindParam(24, $activo, PDO::PARAM_STR);
            $stmt->bindParam(25, $cod_usuario_registro, PDO::PARAM_STR);


            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_pedido = $resultado['ID_PEDIDO'];
            return $id_pedido;

        } catch (\Exception $e) {
            Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
            throw $e;
        }
    }


    public function insertOrdenPedidoDetalle($ind_tipo_operacion, $id_pedido, $cod_empr, $cod_centro, $cod_producto, $nom_producto, $cod_categoria,
                                             $nom_categoria, $cantidad, $precio, $txt_observacion, $activo, $cod_usuario_registro)
    {


        try {


            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_DETALLE_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_PEDIDO = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_PRODUCTO = ?,
                                                                        @NOM_PRODUCTO = ?,
                                                                        @COD_CATEGORIA = ?,
                                                                        @NOM_CATEGORIA = ?,
                                                                        @CANTIDAD = ?,
                                                                        @CAN_PRECIO = ?,
                                                                        @TXT_OBSERVACION = ?,
                                                                        @ACTIVO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

            $cod_usuario_registro = Session::get('usuario')->id;
            $cod_empr = Session::get('empresas')->COD_EMPR;


            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_pedido, PDO::PARAM_STR);
            $stmt->bindParam(3, $cod_empr, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(5, $cod_producto, PDO::PARAM_STR);
            $stmt->bindParam(6, $nom_producto, PDO::PARAM_STR);
            $stmt->bindParam(7, $cod_categoria, PDO::PARAM_STR);
            $stmt->bindParam(8, $nom_categoria, PDO::PARAM_STR);
            $stmt->bindParam(9, $cantidad, PDO::PARAM_STR);
            $stmt->bindParam(10, $precio, PDO::PARAM_STR);
            $stmt->bindParam(11, $txt_observacion, PDO::PARAM_STR);
            $stmt->bindParam(12, $activo, PDO::PARAM_BOOL);
            $stmt->bindParam(13, $cod_usuario_registro, PDO::PARAM_STR);


            $stmt->execute();

        } catch (\Exception $e) {
            Log::error('Error al insertar el vale rendir detalle: ' . $e->getMessage());
            throw $e;
        }
    }


    public function listaOrdenPedido($ind_tipo_operacion, $id_pedido, $fec_pedido, $cod_periodo, $cod_anio, $cod_empr, $cod_centro,
                                     $cod_tipo_pedido, $cod_trabajador_solicita,
                                     $cod_trabajador_autoriza, $cod_trabajador_aprueba_ger, $cod_trabajador_aprueba_adm,
                                     $txt_glosa, $cod_estado, $cod_usuario_registro)
    {
        $array_lista_retail = array();

        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;


        $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_LISTAR

                                                             @IND_TIPO_OPERACION = ?,
                                                             @ID_PEDIDO = ?, 
                                                             @FEC_PEDIDO = ?, 
                                                             @COD_PERIODO = ?, 
                                                             @COD_ANIO = ?, 
                                                             @COD_EMPR = ?, 
                                                             @COD_CENTRO = ?,
                                                             @COD_TIPO_PEDIDO = ?,
                                                             @COD_TRABAJADOR_SOLICITA = ?,
                                                             @COD_TRABAJADOR_AUTORIZA = ?,
                                                             @COD_TRABAJADOR_APRUEBA_GER = ?,
                                                             @COD_TRABAJADOR_APRUEBA_ADM = ?,
                                                             @TXT_GLOSA = ?,
                                                             @COD_ESTADO = ?,
                                                             @COD_USUARIO = ?');


        $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
        $stmt->bindParam(2, $id_pedido, PDO::PARAM_STR);
        $stmt->bindParam(3, $fec_pedido, PDO::PARAM_STR);
        $stmt->bindParam(4, $cod_periodo, PDO::PARAM_STR);
        $stmt->bindParam(5, $cod_anio, PDO::PARAM_INT);
        $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
        $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
        $stmt->bindParam(8, $cod_tipo_pedido, PDO::PARAM_STR);
        $stmt->bindParam(9, $cod_trabajador_solicita, PDO::PARAM_STR);
        $stmt->bindParam(10, $cod_trabajador_autoriza, PDO::PARAM_STR);
        $stmt->bindParam(11, $cod_trabajador_aprueba_ger, PDO::PARAM_STR);
        $stmt->bindParam(12, $cod_trabajador_aprueba_adm, PDO::PARAM_STR);
        $stmt->bindParam(13, $txt_glosa, PDO::PARAM_STR);
        $stmt->bindParam(14, $cod_estado, PDO::PARAM_STR);
        $stmt->bindParam(15, $cod_usuario_registro, PDO::PARAM_STR);

        $stmt->execute();

        while ($row = $stmt->fetch()) {
            array_push($array_lista_retail, $row);
        }

        return $array_lista_retail;
    }

    private function lg_lista_cabecera_pedido($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido)
    {
        $query = DB::table('WEB.ORDEN_PEDIDO as OP')
            ->select([
                'OP.ID_PEDIDO',
                'OP.FEC_PEDIDO',
                'OP.COD_ANIO',
                'OP.TXT_NOMBRE',
                'OP.COD_CENTRO',
                'OP.COD_EMPR',
                'E.NOM_EMPR',
                'C.NOM_CENTRO',
                'OP.TXT_AREA',
                'OP.TXT_TIPO_PEDIDO',
                'OP.TXT_TRABAJADOR_SOLICITA',
                'OP.TXT_TRABAJADOR_AUTORIZA',
                'OP.TXT_TRABAJADOR_APRUEBA_GER',
                'OP.TXT_TRABAJADOR_APRUEBA_ADM',
                'OP.TXT_GLOSA',
                'OP.TXT_ESTADO',
                'OP.COD_USUARIO_MODIF_AUD',
                'U.nombre as USUARIO_MODIF',

                'OD.ID_PEDIDO as ID_PEDIDO_DETALLE',
                'OD.COD_PRODUCTO',
                'OD.NOM_PRODUCTO',
                'OD.NOM_CATEGORIA',
                'OD.CANTIDAD',
                'CAT.NOM_CATEGORIA as NOM_CATEGORIA_FAMILIA',
                'OD.TXT_OBSERVACION'
            ])
            ->join('WEB.ORDEN_PEDIDO_DETALLE as OD', 'OD.ID_PEDIDO', '=', 'OP.ID_PEDIDO')
            ->join('STD.EMPRESA as E', 'E.COD_EMPR', '=', 'OP.COD_EMPR')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'OP.COD_CENTRO')
            ->leftJoin('ALM.PRODUCTO as P', 'P.COD_PRODUCTO', '=', 'OD.COD_PRODUCTO')
            ->leftJoin('CMP.CATEGORIA as CAT', 'CAT.COD_CATEGORIA', '=', 'P.COD_CATEGORIA_FAMILIA')
            ->leftJoin('users as U', 'U.id', '=', 'OP.COD_USUARIO_MODIF_AUD')
            ->where('OP.ACTIVO', 1)
            ->where('OD.ACTIVO', 1)
            ->when($empresa_id && $empresa_id != 'TODO', function ($q) use ($empresa_id) {
                $q->where('OP.COD_EMPR', $empresa_id);
            })
            ->when($centro_pedido && $centro_pedido != 'TODO', function ($q) use ($centro_pedido) {
                $q->where('OP.COD_CENTRO', $centro_pedido);
            })
            ->when($fecha_inicio && $fecha_fin, function ($q) use ($fecha_inicio, $fecha_fin) {
                $q->whereBetween(DB::raw('CAST(OP.FEC_PEDIDO AS DATE)'), [$fecha_inicio, $fecha_fin]);
            })
            ->orderBy('E.NOM_EMPR', 'ASC')
            ->orderBy('OP.ID_PEDIDO', 'ASC');

        return $query->get();
    }

    public function generar_combo_periodo_web($titulo, $todo, $codigo_empresa, $anio)
    {

        $array = DB::table('Web.periodos')
            ->where('anio','=', $anio)
            ->where('COD_EMPR','=', $codigo_empresa)
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        if ($todo == 'TODO') {
            $combo = array('' => $titulo, $todo => $todo) + $array;
        } else {
            $combo = array('' => $titulo) + $array;
        }

        return $combo;

    }

    private function lg_lista_cabecera_pedido_resumen($fecha_inicio, $fecha_fin, $empresa_id, $centro_pedido, $area = 'TODO')
    {

        $query = DB::table('WEB.ORDEN_PEDIDO as OP')
            ->select([
                'OP.ID_PEDIDO',
                'OP.FEC_PEDIDO',
                'OP.COD_ANIO',
                'OP.TXT_NOMBRE',
                'OP.COD_CENTRO',
                'OP.COD_EMPR',
                'E.NOM_EMPR',
                'C.NOM_CENTRO',
                'OP.TXT_AREA',

                // 🔑 FAMILIAS CONCATENADAS
                DB::raw("
                STUFF((
                    SELECT DISTINCT
                        ' / ' + CAT.NOM_CATEGORIA
                    FROM WEB.ORDEN_PEDIDO_DETALLE OD2
                    INNER JOIN ALM.PRODUCTO PRD
                        ON OD2.COD_PRODUCTO = PRD.COD_PRODUCTO
                    INNER JOIN CMP.CATEGORIA CAT
                        ON CAT.COD_CATEGORIA = PRD.COD_CATEGORIA_FAMILIA
                    WHERE OD2.ID_PEDIDO = OP.ID_PEDIDO
                      AND OD2.ACTIVO = 1
                    FOR XML PATH(''), TYPE
                ).value('.', 'VARCHAR(MAX)'), 1, 3, '')
                AS NOM_CATEGORIA_FAMILIA
            "),

                'OP.TXT_TIPO_PEDIDO',
                'OP.TXT_TRABAJADOR_SOLICITA',
                'OP.TXT_TRABAJADOR_AUTORIZA',
                'OP.TXT_TRABAJADOR_APRUEBA_GER',
                'OP.TXT_TRABAJADOR_APRUEBA_ADM',
                'OP.TXT_GLOSA',
                'OP.TXT_ESTADO',
                'OP.COD_ESTADO_TEMP',
                'OP.TXT_ESTADO_TEMP'
            ])
            ->join('STD.EMPRESA as E', 'E.COD_EMPR', '=', 'OP.COD_EMPR')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'OP.COD_CENTRO')
            ->where('OP.ACTIVO', 1)
            ->when($empresa_id && $empresa_id != 'TODO', function ($q) use ($empresa_id) {
                $q->where('OP.COD_EMPR', $empresa_id);
            })
            ->when($centro_pedido && $centro_pedido != 'TODO', function ($q) use ($centro_pedido) {
                $q->where('OP.COD_CENTRO', $centro_pedido);
            })
            ->when($fecha_inicio && $fecha_fin, function ($q) use ($fecha_inicio, $fecha_fin) {
                $q->whereBetween(DB::raw('CAST(OP.FEC_PEDIDO AS DATE)'), [$fecha_inicio, $fecha_fin]);
            })
            ->when($area && $area != 'TODO', function ($q) use ($area) {
                $q->where('OP.TXT_AREA', $area);
            })
            ->orderBy('E.NOM_EMPR', 'ASC') // 1️⃣ Empresa
            ->orderBy('OP.ID_PEDIDO', 'ASC');

        $listaordenpedido = $query->get();

        return $listaordenpedido;
    }

    private function lg_lista_cabecera_pedido_consolidado($empresa_id, $centro_id, $mes_pedido, $anio_pedido)
    {
        $empresa_session_id = Session::get('empresas')->COD_EMPR;

        //$empresa_session_id = $empresa_id;

        $query = DB::table('WEB.ORDEN_PEDIDO as OP')
            ->select(
                'OP.ID_PEDIDO',
                'OP.FEC_PEDIDO',
                'OP.COD_CENTRO',
                'OP.COD_PERIODO',
                'OP.COD_ANIO',
                'OP.TXT_AREA',
                'OP.TXT_GLOSA',
                'OP.COD_ESTADO',
                'OP.TXT_ESTADO',
                'OP.TXT_TRABAJADOR_SOLICITA',
                'OP.TXT_TRABAJADOR_AUTORIZA',
                'OP.TXT_TRABAJADOR_APRUEBA_ADM',
                'OD.COD_PRODUCTO',
                'OD.NOM_PRODUCTO',
                DB::raw("
                COALESCE(
                    OD.CAN_MODIF_ADM,
                    OD.CAN_MODIF_GER,
                    OD.CAN_MODIF_JEF_AUT,
                    OD.CANTIDAD
                ) AS CANTIDAD
            "),
                'OD.COD_CATEGORIA AS COD_UNIDAD',
                'OD.NOM_CATEGORIA',
                'CAT.COD_CATEGORIA AS COD_FAMILIA',
                'CAT.NOM_CATEGORIA AS NOM_CATEGORIA_FAMILIA',
                DB::raw("(
                SELECT ISNULL(SUM(IAP.CAN_FIN_MAT), 0)
                FROM ALM.INVENTARIO_ALMACEN IAP
                      INNER JOIN ALM.ALMACEN ALC 
                      ON ALC.COD_ALMACEN = IAP.COD_ALMACEN
                WHERE IAP.COD_PRODUCTO = OD.COD_PRODUCTO
                  AND IAP.COD_CENTRO = OP.COD_CENTRO
                  AND IAP.COD_EMPR = '$empresa_id'
                  AND IAP.COD_EMPR_PROPIETARIO = '$empresa_id'
                  AND IAP.COD_EMPR_PROVEEDOR_SERV = '$empresa_id'
                  AND IAP.IND_STK_ACTUAL = 1
                  AND IAP.COD_ESTADO = 1
                  AND IAP.CAN_FIN_MAT > 0
                  AND ALC.COD_CATEGORIA_AREA='AEM0000000000015'
                  AND ALC.NOM_ALMACEN LIKE '%SUMINISTRO%'
            ) AS STOCK"),
                'PRD.CAN_STOCK_REQUERIDO AS CAN_STOCK_RESERVADO'
            )
            ->join('WEB.ORDEN_PEDIDO_DETALLE as OD', 'OP.ID_PEDIDO', '=', 'OD.ID_PEDIDO')
            ->join('STD.EMPRESA as E', 'E.COD_EMPR', '=', 'OP.COD_EMPR')
            ->join('ALM.PRODUCTO as PRD', 'PRD.COD_PRODUCTO', '=', 'OD.COD_PRODUCTO')
            ->join('CMP.CATEGORIA as CAT', 'CAT.COD_CATEGORIA', '=', 'PRD.COD_CATEGORIA_FAMILIA')
            //->where('OP.ID_PEDIDO', 'IICHOP0000000028')
            ->where('OP.ACTIVO', 1)
            ->where('OD.ACTIVO', 1)
            ->whereNull('OP.CONSOLIDADO')
            ->where('OP.COD_EMPR', $empresa_session_id)
            ->where('OP.COD_ESTADO', 'ETM0000000000005');

        // FILTROS CONDICIONALES
        if ($centro_id && $centro_id != 'TODO') {
            $query->where('OP.COD_CENTRO', $centro_id);
        }

        if ($mes_pedido && $mes_pedido != 'TODO') {
            $query->where('OP.COD_PERIODO', $mes_pedido);
        }

        if ($anio_pedido && $anio_pedido != 'TODO') {
            $query->where('OP.COD_ANIO', $anio_pedido);
        }

        $query->orderBy('OP.ID_PEDIDO', 'ASC');

        // VER SQL GENERADO (para debug)
        // dd($query->toSql(), $query->getBindings());

        return $query->get()->groupBy('ID_PEDIDO');
    }

    public function insertOrdenPedidoConsolidado($ind_tipo_operacion, $id_pedido_consolidado, $fec_pedido, $cod_periodo, $txt_nombre, $cod_empr, $cod_centro, $cod_categoria_familia, $nom_categoria_familia, $cod_estado, $txt_estado, $activo, $cod_usuario_registro)
    {
        try {
            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_CONSOLIDADO_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_PEDIDO_CONSOLIDADO = ?,
                                                                        @FEC_PEDIDO = ?,
                                                                        @COD_PERIODO = ?,
                                                                        @TXT_NOMBRE = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_CATEGORIA_FAMILIA = ?,
                                                                        @NOM_CATEGORIA_FAMILIA = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @TXT_ESTADO = ?,
                                                                        @ACTIVO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

            $cod_usuario_registro = Session::get('usuario')->id;
            $cod_empr = Session::get('empresas')->COD_EMPR;

            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_pedido_consolidado, PDO::PARAM_STR);
            $stmt->bindParam(3, $fec_pedido, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_periodo, PDO::PARAM_STR);
            $stmt->bindParam(5, $txt_nombre, PDO::PARAM_STR);
            $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
            $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(8, $cod_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(9, $nom_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(10, $cod_estado, PDO::PARAM_STR);
            $stmt->bindParam(11, $txt_estado, PDO::PARAM_STR);
            $stmt->bindParam(12, $activo, PDO::PARAM_STR);
            $stmt->bindParam(13, $cod_usuario_registro, PDO::PARAM_STR);


            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_pedido_consolidado = $resultado['ID_PEDIDO_CONSOLIDADO'] ?? $resultado['ID_PEDIDO'] ?? null;
            return $id_pedido_consolidado;

        } catch (\Exception $e) {
            Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
            throw $e;
        }
    }

    public function insertOrdenPedidoConsolidadoGeneral($ind_tipo_operacion, $id_pedido_consolidado_general, $fec_pedido, $cod_periodo, $txt_nombre, $cod_empr, $cod_centro, $cod_categoria_familia, $nom_categoria_familia, $cod_estado, $txt_estado, $activo, $cod_usuario_registro)
    {
        try {
            $stmt = DB::connection('sqlsrv')->getPdo()->prepare('SET NOCOUNT ON;EXEC WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_IUD
                                                                        @IND_TIPO_OPERACION = ?,
                                                                        @ID_PEDIDO_CONSOLIDADO_GENERAL = ?,
                                                                        @FEC_PEDIDO = ?,
                                                                        @COD_PERIODO = ?,
                                                                        @TXT_NOMBRE = ?,
                                                                        @COD_EMPR = ?,
                                                                        @COD_CENTRO = ?,
                                                                        @COD_CATEGORIA_FAMILIA = ?,
                                                                        @NOM_CATEGORIA_FAMILIA = ?,
                                                                        @COD_ESTADO = ?,
                                                                        @TXT_ESTADO = ?,
                                                                        @ACTIVO = ?,
                                                                        @COD_USUARIO_REGISTRO = ?');

            $cod_usuario_registro = Session::get('usuario')->id;
            $cod_empr = Session::get('empresas')->COD_EMPR;


            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_pedido_consolidado_general, PDO::PARAM_STR);
            $stmt->bindParam(3, $fec_pedido, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_periodo, PDO::PARAM_STR);
            $stmt->bindParam(5, $txt_nombre, PDO::PARAM_STR);
            $stmt->bindParam(6, $cod_empr, PDO::PARAM_STR);
            $stmt->bindParam(7, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(8, $cod_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(9, $nom_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(10, $cod_estado, PDO::PARAM_STR);
            $stmt->bindParam(11, $txt_estado, PDO::PARAM_STR);
            $stmt->bindParam(12, $activo, PDO::PARAM_STR);
            $stmt->bindParam(13, $cod_usuario_registro, PDO::PARAM_STR);


            $stmt->execute();

            $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_pedido_consolidado_general = $resultado['ID_PEDIDO_CONSOLIDADO_GENERAL'] ?? $resultado['ID_PEDIDO_CONSOLIDADO'] ?? null;
            return $id_pedido_consolidado_general;

        } catch (\Exception $e) {
            Log::error('Error al insertar el vale rendir: ' . $e->getMessage());
            throw $e;
        }
    }


    public function insertOrdenPedidoConsolidadoGeneralDetalle($ind_tipo_operacion, $id_pedido_consolidado_general, $cod_centro, $cod_producto, $nom_producto,
                                                               $cod_categoria_medida, $nom_categoria_medida, $cantidad, $stock, $reservado, $diferencia, $cod_categoria_familia,
                                                               $nom_categoria_familia, $activo)
    {

        try {

            $stmt = DB::connection('sqlsrv')->getPdo()->prepare(
                'SET NOCOUNT ON; EXEC WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE_IUD
                        @IND_TIPO_OPERACION = ?,
                        @ID_PEDIDO_CONSOLIDADO_GENERAL = ?,
                        @COD_CENTRO = ?,
                        @COD_PRODUCTO = ?,
                        @NOM_PRODUCTO = ?,
                        @COD_CATEGORIA_MEDIDA = ?,
                        @NOM_CATEGORIA_MEDIDA = ?,
                        @CANTIDAD = ?,
                        @STOCK = ?,
                        @RESERVADO = ?,
                        @DIFERENCIA = ?,
                        @COD_CATEGORIA_FAMILIA = ?,
                        @NOM_CATEGORIA_FAMILIA = ?,
                        @ACTIVO = ?,
                        @COD_USUARIO_REGISTRO = ?'
            );

            $cod_usuario_registro = Session::get('usuario')->id;

            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_pedido_consolidado_general, PDO::PARAM_STR);
            $stmt->bindParam(3, $cod_centro, PDO::PARAM_STR);
            $stmt->bindParam(4, $cod_producto, PDO::PARAM_STR);
            $stmt->bindParam(5, $nom_producto, PDO::PARAM_STR);
            $stmt->bindParam(6, $cod_categoria_medida, PDO::PARAM_STR);
            $stmt->bindParam(7, $nom_categoria_medida, PDO::PARAM_STR);
            $stmt->bindParam(8, $cantidad, PDO::PARAM_STR);
            $stmt->bindParam(9, $stock, PDO::PARAM_STR);
            $stmt->bindParam(10, $reservado, PDO::PARAM_STR);
            $stmt->bindParam(11, $diferencia, PDO::PARAM_STR);
            $stmt->bindParam(12, $cod_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(13, $nom_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(14, $activo, PDO::PARAM_STR);
            $stmt->bindParam(15, $cod_usuario_registro, PDO::PARAM_STR);

            $stmt->execute();

        } catch (\Exception $e) {
            Log::error('Error al insertar ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE: ' . $e->getMessage());
            throw $e;
        }
    }


    public function insertOrdenPedidoConsolidadoDetalle($ind_tipo_operacion, $id_pedido_consolidado, $cod_producto, $nom_producto,
                                                        $cod_categoria_medida, $nom_categoria_medida, $cantidad, $stock, $reservado, $diferencia, $cod_categoria_familia,
                                                        $nom_categoria_familia, $activo)
    {

        try {

            $stmt = DB::connection('sqlsrv')->getPdo()->prepare(
                'SET NOCOUNT ON; EXEC WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE_IUD
                        @IND_TIPO_OPERACION = ?,
                        @ID_PEDIDO_CONSOLIDADO = ?,
                        @COD_PRODUCTO = ?,
                        @NOM_PRODUCTO = ?,
                        @COD_CATEGORIA_MEDIDA = ?,
                        @NOM_CATEGORIA_MEDIDA = ?,
                        @CANTIDAD = ?,
                        @STOCK = ?,
                        @RESERVADO = ?,
                        @DIFERENCIA = ?,
                        @COD_CATEGORIA_FAMILIA = ?,
                        @NOM_CATEGORIA_FAMILIA = ?,
                        @ACTIVO = ?,
                        @COD_USUARIO_REGISTRO = ?'
            );

            $cod_usuario_registro = Session::get('usuario')->id;

            $stmt->bindParam(1, $ind_tipo_operacion, PDO::PARAM_STR);
            $stmt->bindParam(2, $id_pedido_consolidado, PDO::PARAM_STR);
            $stmt->bindParam(3, $cod_producto, PDO::PARAM_STR);
            $stmt->bindParam(4, $nom_producto, PDO::PARAM_STR);
            $stmt->bindParam(5, $cod_categoria_medida, PDO::PARAM_STR);
            $stmt->bindParam(6, $nom_categoria_medida, PDO::PARAM_STR);
            $stmt->bindParam(7, $cantidad, PDO::PARAM_STR);
            $stmt->bindParam(8, $stock, PDO::PARAM_STR);
            $stmt->bindParam(9, $reservado, PDO::PARAM_STR);
            $stmt->bindParam(10, $diferencia, PDO::PARAM_STR);
            $stmt->bindParam(11, $cod_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(12, $nom_categoria_familia, PDO::PARAM_STR);
            $stmt->bindParam(13, $activo, PDO::PARAM_STR);
            $stmt->bindParam(14, $cod_usuario_registro, PDO::PARAM_STR);

            $stmt->execute();

        } catch (\Exception $e) {
            Log::error('Error al insertar ORDEN_PEDIDO_CONSOLIDADO_DETALLE: ' . $e->getMessage());
            throw $e;
        }
    }

    private function lg_lista_cabecera_consolidado()
    {
        $empresa_session_id = Session::get('empresas')->COD_EMPR;
        $usuario_id = Session::get('usuario')->usuarioosiris_id;

        $centro = DB::table('STD.TRABAJADOR as T')
            ->join('WEB.platrabajadores as P', 'P.dni', '=', 'T.NRO_DOCUMENTO')
            ->join('ALM.CENTRO as C', 'C.COD_CENTRO', '=', 'P.centro_osiris_id')
            ->where('T.COD_TRAB', $usuario_id)
            // ->where('P.empresa_osiris_id', $empresa_session_id)
            ->where('P.situacion_id', 'PRMAECEN000000000002')
            ->where('C.COD_ESTADO', 1)
            ->select('C.COD_CENTRO', 'C.NOM_CENTRO')
            //->get();
            ->first();

        /*
        $empresas = DB::table('STD.EMPRESA')
            ->where('COD_ESTADO', 1)
            ->where('IND_SISTEMA', 1)
            ->where('COD_EMPR', $empresa_session_id)
            ->select('COD_EMPR', 'NOM_EMPR')
            ->get();

        if ($centro) {
            $centro = DB::table('ALM.CENTRO')
                ->where('COD_ESTADO', 1)
                ->select('COD_CENTRO', 'NOM_CENTRO')
                ->get();
            $empresas = DB::table('STD.EMPRESA')
                ->where('COD_ESTADO', 1)
                ->where('IND_SISTEMA', 1)
                ->select('COD_EMPR', 'NOM_EMPR')
                ->get();
        }
        */

        $query = DB::connection('sqlsrv')->table('WEB.ORDEN_PEDIDO_CONSOLIDADO as C')
            ->join('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D',
                'C.ID_PEDIDO_CONSOLIDADO', '=', 'D.ID_PEDIDO_CONSOLIDADO')
            ->join('STD.EMPRESA as E', 'E.COD_EMPR', '=', 'C.COD_EMPR')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->where('C.COD_EMPR', $empresa_session_id)
            ->where('C.COD_CENTRO', $centro->COD_CENTRO)
            //->whereIn('C.COD_EMPR', $empresas->pluck('COD_EMPR')->toArray())
            //->whereIn('C.COD_CENTRO', $centro->pluck('COD_CENTRO')->toArray())
            ->select(
                'C.ID_PEDIDO_CONSOLIDADO',
                'C.FEC_PEDIDO',
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
                DB::raw("
                STUFF((
                    SELECT 
                        ', ' 
                        + CONVERT(VARCHAR(10), OP.FEC_PEDIDO, 103)
                        + ' - ' + OP.ID_PEDIDO
                        + ' - ' + OP.TXT_AREA
                        + ' - ' + ISNULL(OP.TXT_GLOSA,'')
                        + ' (' + CAST(SUM(OPD.CANTIDAD) AS VARCHAR(10)) + ')'
                    FROM CMP.REFERENCIA_ASOC RA
                    INNER JOIN WEB.ORDEN_PEDIDO OP
                        ON OP.ID_PEDIDO = RA.COD_TABLA
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
                        OP.TXT_GLOSA
                    ORDER BY OP.FEC_PEDIDO
                    FOR XML PATH(''), TYPE
                ).value('.', 'NVARCHAR(MAX)'), 1, 2, '')
                AS DETALLE_POR_AREA
            ")
            )
            ->orderBy('C.ID_PEDIDO_CONSOLIDADO', 'ASC')
            ->get()
            ->groupBy('ID_PEDIDO_CONSOLIDADO');

        return $query;
    }


    private function lg_lista_detalle_consolidado($id_consolidado, $familia_id)
    {

        $pedido = DB::table('WEB.ORDEN_PEDIDO_CONSOLIDADO')
            ->where('ID_PEDIDO_CONSOLIDADO', $id_consolidado)
            ->first();

        $query = DB::connection('sqlsrv')
            ->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE as D')
            ->join('WEB.ORDEN_PEDIDO_CONSOLIDADO as C',
                'C.ID_PEDIDO_CONSOLIDADO', '=', 'D.ID_PEDIDO_CONSOLIDADO')
            ->select(
                'D.*',
                'C.COD_ESTADO',
                DB::raw("
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
                    AND OP.COD_PERIODO = '" . $pedido->COD_PERIODO . "'  /* 👈 COMILLAS AGREGADAS */
                GROUP BY 
                    OP.FEC_PEDIDO,
                    OP.ID_PEDIDO,
                    OP.TXT_AREA,
                    OP.TXT_GLOSA
                ORDER BY OP.FEC_PEDIDO
                FOR XML PATH(''), TYPE
            ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS DETALLE_POR_AREA
        ")
            )
            ->where('D.ID_PEDIDO_CONSOLIDADO', $id_consolidado)
            //->where('D.COD_PRODUCTO', 'PRD0000000018837')
            ->where('C.COD_PERIODO', $pedido->COD_PERIODO)
            ->where(function ($q) use ($familia_id) {
                if (!empty($familia_id) && $familia_id != 'TODO') {
                    $q->where('D.COD_CATEGORIA_FAMILIA', $familia_id);
                }
            })
            ->get();

        //DD($id_consolidado);

        return $query;
    }

    private function lg_lista_cabecera_pedido_consolidado_general($empresa_id, $mes_pedido, $anio_pedido)
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
            ->where('C.COD_EMPR', $empresa_session_id)
            ->where('C.COD_ESTADO', 'ETM0000000000015')
            ->where('C.ACTIVO', 1)
            ->where('D.ACTIVO', 1)
            ->whereNull('C.CONSOLIDADO_GENERAL')
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

    private function lg_lista_cabecera_pedido_consolidado_general_terminado()
    {
        $empresa_session_id = Session::get('empresas')->COD_EMPR;

        $query = DB::connection('sqlsrv')
            ->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL as C')
            ->join(
                'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE as D',
                'C.ID_PEDIDO_CONSOLIDADO_GENERAL',
                '=',
                'D.ID_PEDIDO_CONSOLIDADO_GENERAL'
            )
            ->join('STD.EMPRESA as E', 'E.COD_EMPR', '=', 'C.COD_EMPR')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'C.COD_CENTRO')
            ->where('C.COD_EMPR', $empresa_session_id)
            ->select(
                'C.ID_PEDIDO_CONSOLIDADO_GENERAL',
                'C.FEC_PEDIDO',
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

                DB::raw("
                    ISNULL(
                        STUFF((
                            SELECT 
                                ', ' 
                                + CONVERT(VARCHAR(10), OP.FEC_PEDIDO, 103)
                                + ' - ' + OP.ID_PEDIDO
                                + ' - ' + OP.TXT_AREA
                                + ' - ' + ISNULL(OP.TXT_GLOSA,'')
                                + ' (' + CAST(SUM(
                                        COALESCE(
                                            OPD.CAN_MODIF_ADM,
                                            OPD.CAN_MODIF_GER,
                                            OPD.CAN_MODIF_JEF_AUT,
                                            OPD.CANTIDAD
                                        )
                                    ) AS VARCHAR(20)) + ')'
                            FROM CMP.REFERENCIA_ASOC RA_OP
                            INNER JOIN WEB.ORDEN_PEDIDO OP
                                ON OP.ID_PEDIDO = RA_OP.COD_TABLA
                            INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                                ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                            WHERE RA_OP.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                              AND RA_OP.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                              AND RA_OP.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                              AND OPD.COD_PRODUCTO = D.COD_PRODUCTO
                              AND OPD.ACTIVO = 1
                              AND OPD.ACTIVO = 1
                              AND RA_OP.COD_TABLA_ASOC IN (
                                    SELECT RA_CONS.COD_TABLA
                                    FROM CMP.REFERENCIA_ASOC RA_CONS
                                    WHERE RA_CONS.COD_TABLA_ASOC = C.ID_PEDIDO_CONSOLIDADO_GENERAL
                                      AND RA_CONS.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
                                      AND RA_CONS.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                                      AND RA_CONS.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
                              )
                            GROUP BY 
                                OP.FEC_PEDIDO,
                                OP.ID_PEDIDO,
                                OP.TXT_AREA,
                                OP.TXT_GLOSA
                            ORDER BY OP.FEC_PEDIDO
                            FOR XML PATH(''), TYPE
                        ).value('.', 'NVARCHAR(MAX)'), 1, 2, ''),
                    '')
                    AS DETALLE_POR_AREA
                ")
            )
            ->orderBy('C.ID_PEDIDO_CONSOLIDADO_GENERAL', 'ASC')
            ->get()
            ->groupBy('ID_PEDIDO_CONSOLIDADO_GENERAL');

        return $query;
    }

    public function lg_lista_detalle_consolidado_general($id_consolidado_general, $familia_id)
    {
        $query = DB::connection('sqlsrv')
            ->table('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE as D')
            ->join('WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL as C',
                'C.ID_PEDIDO_CONSOLIDADO_GENERAL', '=', 'D.ID_PEDIDO_CONSOLIDADO_GENERAL')
            ->join('ALM.CENTRO as CEN', 'CEN.COD_CENTRO', '=', 'D.COD_CENTRO')
            ->select(
                'D.*',
                'C.COD_ESTADO',
                'CEN.NOM_CENTRO',

                // 🔹 CAN_COMPRADA SIN DUPLICAR
                DB::raw("(
                    SELECT ISNULL(SUM(OCD.CAN_COMPRADA),0)
                    FROM CMP.REFERENCIA_ASOC RA_CONS
                    INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO OPC
                        ON OPC.ID_PEDIDO_CONSOLIDADO = RA_CONS.COD_TABLA
                    INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE OCD
                        ON OCD.ID_PEDIDO_CONSOLIDADO = OPC.ID_PEDIDO_CONSOLIDADO
                    WHERE RA_CONS.COD_TABLA_ASOC = D.ID_PEDIDO_CONSOLIDADO_GENERAL
                      AND RA_CONS.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
                      AND RA_CONS.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                      AND RA_CONS.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
                      AND OCD.COD_PRODUCTO = D.COD_PRODUCTO
                ) AS CAN_COMPRADA_CALCULADA"),

                // 🔹 TU LÓGICA ORIGINAL STUFF (NO TOCADA)
                DB::raw("
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
                        FROM CMP.REFERENCIA_ASOC RA_CONS
                        INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO OPC
                            ON OPC.ID_PEDIDO_CONSOLIDADO = RA_CONS.COD_TABLA
                        INNER JOIN ALM.CENTRO CEN_ORIG
                            ON CEN_ORIG.COD_CENTRO = OPC.COD_CENTRO
                        INNER JOIN CMP.REFERENCIA_ASOC RA_OP
                            ON RA_OP.COD_TABLA_ASOC = OPC.ID_PEDIDO_CONSOLIDADO
                        INNER JOIN WEB.ORDEN_PEDIDO OP
                            ON OP.ID_PEDIDO = RA_OP.COD_TABLA
                        INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                            ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                        WHERE RA_CONS.COD_TABLA_ASOC = D.ID_PEDIDO_CONSOLIDADO_GENERAL
                          AND RA_CONS.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
                          AND RA_CONS.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                          AND RA_CONS.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
                          AND RA_OP.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                          AND RA_OP.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                          AND RA_OP.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                          AND OPD.COD_PRODUCTO = D.COD_PRODUCTO
                          AND OP.COD_PERIODO = C.COD_PERIODO
                          AND OPD.ACTIVO = 1
                        GROUP BY 
                            OP.FEC_PEDIDO,
                            OP.ID_PEDIDO,
                            OP.TXT_AREA,
                            OP.TXT_GLOSA,
                            CEN_ORIG.NOM_CENTRO
                        ORDER BY OP.FEC_PEDIDO
                        FOR XML PATH(''), TYPE
                    ).value('.', 'NVARCHAR(MAX)'), 1, 7, '')
                    AS DETALLE_POR_AREA
                "),

                DB::raw("
                        STUFF((
                            SELECT CHAR(13) + CHAR(10) + '(' + OP.TXT_AREA + ' / ' + ISNULL(OPD.TXT_OBSERVACION, '') + ')'
                            FROM CMP.REFERENCIA_ASOC RA_CONS
                            INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO OPC
                                ON OPC.ID_PEDIDO_CONSOLIDADO = RA_CONS.COD_TABLA
                            INNER JOIN ALM.CENTRO CEN_ORIG
                                ON CEN_ORIG.COD_CENTRO = OPC.COD_CENTRO
                            INNER JOIN CMP.REFERENCIA_ASOC RA_OP
                                ON RA_OP.COD_TABLA_ASOC = OPC.ID_PEDIDO_CONSOLIDADO
                            INNER JOIN WEB.ORDEN_PEDIDO OP
                                ON OP.ID_PEDIDO = RA_OP.COD_TABLA
                            INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                                ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                            WHERE RA_CONS.COD_TABLA_ASOC = D.ID_PEDIDO_CONSOLIDADO_GENERAL
                              AND RA_CONS.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
                              AND RA_CONS.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                              AND RA_CONS.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
                              AND RA_OP.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                              AND RA_OP.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                              AND RA_OP.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                              AND OPD.COD_PRODUCTO = D.COD_PRODUCTO
                              AND OP.COD_PERIODO = C.COD_PERIODO
                              AND OPD.ACTIVO = 1
                            GROUP BY 
                                OP.FEC_PEDIDO,
                                OP.ID_PEDIDO,
                                OP.TXT_AREA,
                                OP.TXT_GLOSA,
                                CEN_ORIG.NOM_CENTRO,
                                OPD.TXT_OBSERVACION
                            ORDER BY OP.FEC_PEDIDO
                            FOR XML PATH(''), TYPE
                        ).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS DETALLE_POR_AREA_GLOSA
                    ")
            )
            ->where('D.ID_PEDIDO_CONSOLIDADO_GENERAL', $id_consolidado_general)
            ->where(function ($q) use ($familia_id) {
                if ($familia_id != '') {
                    $q->where('D.COD_CATEGORIA_FAMILIA', $familia_id);
                }
            })
            ->orderBy('D.NOM_PRODUCTO', 'asc') // 👈 ORDER BY agregado
            ->get();

        return $query;
    }

    public function lg_lista_detalle_consolidado_general_excel($id_consolidado_general, $familia_id)
    {
        $sql = "
        SELECT OPCD.COD_PRODUCTO,
               OPCD.NOM_PRODUCTO,
               OPCD.NOM_CATEGORIA_MEDIDA,
               SUM(OPCD.CANTIDAD) AS CANTIDAD,
               SUM(OPCD.STOCK) AS STOCK,
               SUM(OPCD.RESERVADO) AS RESERVADO,
               SUM(OPCD.DIFERENCIA) AS DIFERENCIA,
               COALESCE(MAX(OPCDGD.CAN_COMPRADA), SUM(OPCD.CAN_COMPRADA)) AS CAN_COMPRADA_CALCULADA,
               OPCD.COD_CATEGORIA_FAMILIA,
               OPCD.NOM_CATEGORIA_FAMILIA,
               C.COD_CENTRO,
               C.NOM_CENTRO,
               E.COD_EMPR,
               E.NOM_EMPR,
               ISNULL(CA.DETALLE_POR_AREA, '') AS DETALLE_POR_AREA,
               ISNULL(CO.OBSERVACION_POR_AREA, '') AS OBSERVACION_POR_AREA
        FROM WEB.ORDEN_PEDIDO_CONSOLIDADO AS OPC
                 INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE AS OPCD
                            ON OPC.ID_PEDIDO_CONSOLIDADO = OPCD.ID_PEDIDO_CONSOLIDADO
                 INNER JOIN CMP.REFERENCIA_ASOC AS RA 
                            ON RA.COD_TABLA = OPC.ID_PEDIDO_CONSOLIDADO 
                            AND RA.COD_ESTADO = 1
                 INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL AS OPCG
                            ON OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL = RA.COD_TABLA_ASOC 
                            AND OPCG.ACTIVO = 1
                            AND OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL = :id_consolidado
                 INNER JOIN ALM.CENTRO AS C 
                            ON C.COD_CENTRO = OPC.COD_CENTRO 
                            AND C.COD_ESTADO = 1
                 INNER JOIN STD.EMPRESA AS E 
                            ON E.COD_EMPR = OPC.COD_EMPR 
                            AND E.COD_ESTADO = 1
                 LEFT JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE AS OPCDGD
                            ON OPCDGD.ID_PEDIDO_CONSOLIDADO_GENERAL = OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL
                            AND OPCDGD.COD_PRODUCTO = OPCD.COD_PRODUCTO
                            AND OPCDGD.ACTIVO = 1
                 OUTER APPLY (
                     SELECT STUFF((
                         SELECT DISTINCT ' [SEP] ' + OP.TXT_AREA
                         FROM WEB.ORDEN_PEDIDO OP
                                  INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                                             ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                                  INNER JOIN CMP.REFERENCIA_ASOC AS RAF
                                             ON RAF.COD_TABLA = OP.ID_PEDIDO
                                                 AND RAF.COD_ESTADO = 1
                                  INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO AS OPCF
                                             ON OPCF.ID_PEDIDO_CONSOLIDADO = RAF.COD_TABLA_ASOC
                                                 AND OPCF.ACTIVO = 1
                         WHERE RAF.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                           AND RAF.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                           AND RAF.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                           AND OPCF.ID_PEDIDO_CONSOLIDADO = OPC.ID_PEDIDO_CONSOLIDADO
                           AND OPD.COD_PRODUCTO = OPCD.COD_PRODUCTO
                         FOR XML PATH(''), TYPE
                     ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS DETALLE_POR_AREA
                 ) CA
                 OUTER APPLY (
                     SELECT STUFF((
                         SELECT DISTINCT ' [SEP] ' + (OP.TXT_AREA + ': ' + ISNULL(OPD.TXT_OBSERVACION, ''))
                         FROM WEB.ORDEN_PEDIDO OP
                                  INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                                             ON OP.ID_PEDIDO = OPD.ID_PEDIDO
                                  INNER JOIN CMP.REFERENCIA_ASOC AS RAF
                                             ON RAF.COD_TABLA = OP.ID_PEDIDO
                                                 AND RAF.COD_ESTADO = 1
                                  INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO AS OPCF
                                             ON OPCF.ID_PEDIDO_CONSOLIDADO = RAF.COD_TABLA_ASOC
                                                 AND OPCF.ACTIVO = 1
                         WHERE RAF.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                           AND RAF.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                           AND RAF.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                           AND OPCF.ID_PEDIDO_CONSOLIDADO = OPC.ID_PEDIDO_CONSOLIDADO
                           AND OPD.COD_PRODUCTO = OPCD.COD_PRODUCTO
                         FOR XML PATH(''), TYPE
                     ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS OBSERVACION_POR_AREA
                 ) CO
        WHERE OPC.CONSOLIDADO_GENERAL = 'SI'
          AND RA.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
          AND RA.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
          AND RA.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
          AND OPC.ACTIVO = 1
          AND OPCD.ACTIVO = 1
    ";

        // Agregar filtro por familia si se proporciona
        if (!empty($familia_id)) {
            $sql .= " AND OPCD.COD_CATEGORIA_FAMILIA = :familia_id";
        }

        $sql .= " GROUP BY OPCD.COD_PRODUCTO, 
                        OPCD.NOM_PRODUCTO, 
                        OPCD.NOM_CATEGORIA_MEDIDA, 
                        OPCD.COD_CATEGORIA_FAMILIA,
                        OPCD.NOM_CATEGORIA_FAMILIA, 
                        C.COD_CENTRO, 
                        C.NOM_CENTRO, 
                        E.COD_EMPR, 
                        E.NOM_EMPR,
                        CA.DETALLE_POR_AREA,
                        CO.OBSERVACION_POR_AREA
                  ORDER BY OPCD.NOM_PRODUCTO ASC;";

        // Preparar parámetros
        $params = [
            'id_consolidado' => $id_consolidado_general
        ];

        if (!empty($familia_id)) {
            $params['familia_id'] = $familia_id;
        }

        // Ejecutar consulta raw
        return DB::connection('sqlsrv')->select($sql, $params);
    }

    public function lg_lista_detalle_consolidado_general_excel_area($id_consolidado_general, $familia_id)
    {
        $sql = "
        SELECT OP.COD_AREA,
       OP.TXT_AREA AS NOM_AREA,
       OPD.TXT_OBSERVACION,
       OP.COD_ANIO,
       OP.COD_PERIODO,
       OP.COD_EMPR,
       OP.COD_CENTRO,
       C.NOM_CENTRO,
       OPD.COD_PRODUCTO,
       OPD.NOM_PRODUCTO,
       OPD.COD_CATEGORIA AS COD_CATEGORIA_MEDIDA,
       OPD.NOM_CATEGORIA AS NOM_CATEGORIA_MEDIDA,
       OPCD.COD_CATEGORIA_FAMILIA,
       OPCD.NOM_CATEGORIA_FAMILIA,
       OPD.CANTIDAD       AS CANT_ORIGINAL,
       COALESCE(
               OPD.CAN_MODIF_ADM,
               OPD.CAN_MODIF_GER,
               OPD.CAN_MODIF_JEF_AUT,
               OPD.CANTIDAD
       )                  AS CANT_APROBADA,
       COALESCE(
               OPCD.CANTIDAD,
               OPCDG.CANTIDAD
       )                  AS CANT_ORIGINAL_CONSOLIDADO_FINAL,
       COALESCE(
               OPCD.STOCK,
               OPCDG.STOCK
       )                  AS CANT_STOCK_CONSOLIDADO_FINAL,
       COALESCE(
               OPCD.RESERVADO,
               OPCDG.RESERVADO
       )                  AS CANT_RESERVADO_CONSOLIDADO_FINAL,
       COALESCE(
               OPCD.DIFERENCIA,
               OPCDG.DIFERENCIA
       )                  AS CANT_DIFERENCIA_CONSOLIDADO_FINAL,
       COALESCE(
               OPCD.CAN_COMPRADA,
               OPCDG.CAN_COMPRADA
       )                  AS CANT_COMPRADA_CONSOLIDADO_FINAL
FROM WEB.ORDEN_PEDIDO AS OP
         INNER JOIN WEB.ORDEN_PEDIDO_DETALLE AS OPD ON OP.ID_PEDIDO = OPD.ID_PEDIDO
         INNER JOIN ALM.CENTRO AS C ON C.COD_CENTRO = OP.COD_CENTRO AND C.COD_ESTADO = 1
         INNER JOIN STD.EMPRESA AS E ON E.COD_EMPR = OP.COD_EMPR AND E.COD_ESTADO = 1
         INNER JOIN CMP.REFERENCIA_ASOC AS RA ON RA.COD_TABLA = OP.ID_PEDIDO AND RA.COD_ESTADO = 1
         INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO AS OPC
                    ON OPC.ID_PEDIDO_CONSOLIDADO = RA.COD_TABLA_ASOC AND OPC.ACTIVO = 1
         INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE AS OPCD
                    ON OPCD.ID_PEDIDO_CONSOLIDADO = OPC.ID_PEDIDO_CONSOLIDADO AND
                       OPCD.COD_PRODUCTO = OPD.COD_PRODUCTO AND OPCD.ACTIVO = 1
         INNER JOIN CMP.REFERENCIA_ASOC AS RE ON RE.COD_TABLA = OPC.ID_PEDIDO_CONSOLIDADO AND RE.COD_ESTADO = 1
         INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL AS OPCG
                    ON OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL = RE.COD_TABLA_ASOC AND OPCG.ACTIVO = 1 AND
                       OPCG.COD_CATEGORIA_FAMILIA = OPC.COD_CATEGORIA_FAMILIA
         INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE AS OPCDG
                    ON OPCDG.ID_PEDIDO_CONSOLIDADO_GENERAL = OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL AND
                       OPCDG.COD_PRODUCTO = OPD.COD_PRODUCTO AND OPCDG.ACTIVO = 1
WHERE OP.CONSOLIDADO = 'SI'
  AND OP.COD_ESTADO = 'ETM0000000000005'
  AND OP.ACTIVO = 1
  AND OPD.ACTIVO = 1
  AND RE.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
  AND RE.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
  AND RE.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
  AND RA.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
  AND RA.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
  AND RA.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
  AND OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL = :id_consolidado
    ";

        // Agregar filtro por familia si se proporciona
        if (!empty($familia_id)) {
            $sql .= " AND OPCD.COD_CATEGORIA_FAMILIA = :familia_id ";
        }

        $sql .= " ORDER BY OPCDG.NOM_PRODUCTO ASC; "; // 👈 ORDER BY agregado

        // Preparar parámetros
        $params = [
            'id_consolidado' => $id_consolidado_general
        ];

        if (!empty($familia_id)) {
            $params['familia_id'] = $familia_id;
        }

        // Ejecutar consulta raw
        $resultados = DB::connection('sqlsrv')->select($sql, $params);

        // Procesar en PHP para descontar cantidades
        $productos = [];
        $resultado_final = [];

        foreach ($resultados as $row) {
            $producto = $row->COD_PRODUCTO;
            $compra_original = $row->CANT_COMPRADA_CONSOLIDADO_FINAL;
            $aprobada = $row->CANT_APROBADA;

            // Inicializar si es primera vez que vemos este producto
            if (!isset($productos[$producto])) {
                $productos[$producto] = [
                    'compra_disponible' => $compra_original,
                    'acumulado_aprobado' => 0,
                    'compra_asignada' => 0
                ];
            }

            // Calcular cuánto se puede comprar en este pedido
            $disponible_actual = $productos[$producto]['compra_disponible'] - $productos[$producto]['acumulado_aprobado'];
            $compra_asignada = min($aprobada, max(0, $disponible_actual));

            // Actualizar acumulado
            $productos[$producto]['acumulado_aprobado'] += $compra_asignada;
            $productos[$producto]['compra_asignada'] += $compra_asignada;

            // Calcular compra disponible restante
            $compra_disponible = max(0, $productos[$producto]['compra_disponible'] - $productos[$producto]['acumulado_aprobado']);

            // Agregar campos calculados al resultado
            $row->CAN_COMPRADA_DISPONIBLE = $compra_disponible;
            $row->CAN_COMPRADA_ASIGNADA = $compra_asignada; // 👈 Nuevo campo: lo que realmente se compra en este pedido
            $row->ACUMULADO_APROBADO = $productos[$producto]['acumulado_aprobado'];
            $row->COMPRA_ORIGINAL = $compra_original;
            $row->FALTANTE = max(0, $aprobada - $compra_asignada); // 👈 Opcional: lo que no se pudo comprar

            $resultado_final[] = $row;
        }

        return $resultado_final;

    }

    public function reporte_pedidos_estado($periodo, $empresa_id, $centro, $anio)
    {
        $sql = "
        SELECT DISTINCT OP.ID_PEDIDO,
                OP.COD_AREA,
                OP.TXT_AREA                          AS NOM_AREA,
                OP.FEC_PEDIDO,
                OP.COD_ANIO,
                OP.COD_PERIODO,
                PER.TXT_NOMBRE                       AS NOM_PERIODO,
                OP.COD_EMPR,
                OP.COD_CENTRO,
                C.NOM_CENTRO,
                OP.COD_ESTADO,
                OP.TXT_ESTADO,
                ISNULL(ARCH.URL_ARCHIVO,'') AS URL_ARCHIVO,
                COALESCE(CS.CONSOLIDADO_SEDE, '')    AS ID_PEDIDO_CONSOLIDADO,
                COALESCE(CG.CONSOLIDADO_GENERAL, '') AS ID_PEDIDO_CONSOLIDADO_GENERAL
FROM WEB.ORDEN_PEDIDO AS OP
         INNER JOIN ALM.CENTRO AS C ON C.COD_CENTRO = OP.COD_CENTRO AND C.COD_ESTADO = 1
         INNER JOIN STD.EMPRESA AS E ON E.COD_EMPR = OP.COD_EMPR AND E.COD_ESTADO = 1
         INNER JOIN WEB.periodos AS PER ON PER.anio = OP.COD_ANIO AND PER.COD_PERIODO = OP.COD_PERIODO
         LEFT JOIN dbo.ARCHIVOS AS ARCH ON ARCH.ID_DOCUMENTO = OP.ID_PEDIDO AND ARCH.ACTIVO = 1     
         OUTER APPLY (SELECT STUFF((SELECT DISTINCT ', ' + CAST(OPC.ID_PEDIDO_CONSOLIDADO AS NVARCHAR)
                                    FROM WEB.ORDEN_PEDIDO OP2
                                             INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                                                        ON OP2.ID_PEDIDO = OPD.ID_PEDIDO AND OPD.ACTIVO = 1
                                             INNER JOIN CMP.REFERENCIA_ASOC AS RAF
                                                        ON RAF.COD_TABLA = OP.ID_PEDIDO
                                                            AND RAF.COD_ESTADO = 1
                                             INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO AS OPC
                                                        ON OPC.ID_PEDIDO_CONSOLIDADO = RAF.COD_TABLA_ASOC
                                                            AND OPC.ACTIVO = 1
                                             INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE AS OPCD
                                                        ON OPCD.ID_PEDIDO_CONSOLIDADO =
                                                           OPC.ID_PEDIDO_CONSOLIDADO AND OPCD.ACTIVO = 1 AND
                                                           OPCD.COD_PRODUCTO = OPD.COD_PRODUCTO
                                    WHERE RAF.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                                      AND RAF.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                                      AND RAF.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                                      AND OP2.ID_PEDIDO = OP.ID_PEDIDO
                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2,
                                   '') AS CONSOLIDADO_SEDE) CS
         OUTER APPLY (SELECT STUFF((SELECT DISTINCT ', ' + CAST(OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL AS NVARCHAR)
                                    FROM WEB.ORDEN_PEDIDO OP2
                                             INNER JOIN WEB.ORDEN_PEDIDO_DETALLE OPD
                                                        ON OP2.ID_PEDIDO = OPD.ID_PEDIDO AND OPD.ACTIVO = 1
                                             INNER JOIN CMP.REFERENCIA_ASOC AS RAF
                                                        ON RAF.COD_TABLA = OP.ID_PEDIDO
                                                            AND RAF.COD_ESTADO = 1
                                             INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO AS OPC
                                                        ON OPC.ID_PEDIDO_CONSOLIDADO = RAF.COD_TABLA_ASOC
                                                            AND OPC.ACTIVO = 1
                                             INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_DETALLE AS OPCD
                                                        ON OPCD.ID_PEDIDO_CONSOLIDADO =
                                                           OPC.ID_PEDIDO_CONSOLIDADO AND OPCD.ACTIVO = 1 AND
                                                           OPCD.COD_PRODUCTO = OPD.COD_PRODUCTO
                                             INNER JOIN CMP.REFERENCIA_ASOC AS RE
                                                        ON RE.COD_TABLA = OPC.ID_PEDIDO_CONSOLIDADO AND
                                                           RE.COD_ESTADO = 1
                                             INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL AS OPCG
                                                        ON OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL =
                                                           RE.COD_TABLA_ASOC AND OPCG.ACTIVO = 1 AND
                                                           OPCG.COD_CATEGORIA_FAMILIA = OPC.COD_CATEGORIA_FAMILIA
                                             INNER JOIN WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL_DETALLE AS OPCDG
                                                        ON OPCDG.ID_PEDIDO_CONSOLIDADO_GENERAL =
                                                           OPCG.ID_PEDIDO_CONSOLIDADO_GENERAL AND
                                                           OPCDG.COD_PRODUCTO = OPD.COD_PRODUCTO AND
                                                           OPCDG.ACTIVO = 1
                                    WHERE RAF.TXT_TIPO_REFERENCIA = 'CONSOLIDADO'
                                      AND RAF.TXT_TABLA = 'WEB.ORDEN_PEDIDO'
                                      AND RAF.TXT_TABLA_ASOC = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                                      AND OP2.ID_PEDIDO = OP.ID_PEDIDO
                                      AND RE.TXT_TIPO_REFERENCIA = 'CONSOLIDADO_GENERAL'
                                      AND RE.TXT_TABLA = 'WEB.ORDEN_PEDIDO_CONSOLIDADO'
                                      AND RE.TXT_TABLA_ASOC =
                                          'WEB.ORDEN_PEDIDO_CONSOLIDADO_GENERAL'
                                    FOR XML PATH(''), TYPE).value('.', 'NVARCHAR(MAX)'), 1, 2,
                                   '') AS CONSOLIDADO_GENERAL) CG
WHERE OP.ACTIVO = 1
  AND OP.COD_ESTADO <> 'ETM0000000000006'
  AND OP.COD_EMPR = :empresa_id
  AND OP.COD_PERIODO = :periodo_id
  AND OP.COD_ANIO = :anio_id
    ";

        // Agregar filtro por familia si se proporciona
        if (!empty($centro)) {
            $sql .= " AND OP.COD_CENTRO = :centro_id ";
        }

        // Preparar parámetros
        $params = [
            'empresa_id' => $empresa_id,
            'periodo_id' => $periodo,
            'anio_id' => $anio,
        ];

        if (!empty($centro)) {
            $params['centro_id'] = $centro;
        }

        // Ejecutar consulta raw
        return DB::connection('sqlsrv')->select($sql, $params);
    }
}
