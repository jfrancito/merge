<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\OrdenPedidoTraits;
use App\Traits\EnviarCorreoOPApruebaGerenciaTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;

//use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class GestionOrdenPedidoController extends Controller
{
    use OrdenPedidoTraits;
    use EnviarCorreoOPApruebaGerenciaTraits;

    public function actionOrdenPedido(Request $request)
    {
        $usuarioSesion = Session::get('usuario');
        $usuario_solicita = $usuarioSesion->usuarioosiris_id;

        $nombre_solicita = $usuarioSesion->nombre;
        $combo4 = ['' => 'Seleccione Empresa'] + [$usuario_solicita => $nombre_solicita];

        $empresaSesion = Session::get('empresas');

        $empresa = $empresaSesion->COD_EMPR;
        $nombre = $empresaSesion->NOM_EMPR;
        $combo = ['' => 'Seleccione Empresa'] + [$empresa => $nombre];


        $dni = DB::table('STD.TRABAJADOR')
            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
            ->value('NRO_DOCUMENTO');

        $centro_id = DB::table('WEB.platrabajadores')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
            ->where('dni', $dni)
            ->value('centro_osiris_id');

        $centro = DB::table('ALM.CENTRO')->where('COD_CENTRO', $centro_id)->first();

        $cod_centro = $centro->COD_CENTRO;
        $nom_centro = $centro->NOM_CENTRO;

        $combo_sede = [];
        if ($usuario_solicita == 'ISTR000000000205') {
            $combo_sede = DB::table('ALM.CENTRO')
                ->whereIn('COD_CENTRO', [$cod_centro, 'CEN0000000000006'])
                ->pluck('NOM_CENTRO', 'COD_CENTRO')
                ->toArray();
        }

        $tipoOrden = DB::table('WEB.TIPO_PEDIDO_ORDEN')->where('cod_estado', 1)->pluck('TXT_TIPO_PEDIDO', 'COD_TIPO_PEDIDO')->toArray();
        $combo2 = array('' => 'Seleccione Tipo Orden de Pedido') + $tipoOrden;

        $usuarioAutoriza = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where(function ($query) {
                $query->where('cadcargo', 'LIKE', '%JEFE%')
                    ->orWhere('cadcargo', 'COORDINADOR DE CONTROL DE CALIDAD')
                    ->orWhere('COD_TRAB', 'IITR000000000391');
            })
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->whereIn('empresa_osiris_id', [
                'IACHEM0000010394',
                'IACHEM0000007086'
            ])
            ->orderBy('apellidopaterno')
            ->orderBy('apellidomaterno')
            ->orderBy('nombres')
            ->pluck(
                DB::raw("
					            LTRIM(RTRIM(
					                ISNULL(apellidopaterno,'') + ' ' +
					                ISNULL(apellidomaterno,'') + ' ' +
					                ISNULL(nombres,'')
					            ))
					        "),
                'COD_TRAB'
            )
            ->toArray();
        $combo5 = array('' => 'Seleccione Jefe Autoriza') + $usuarioAutoriza;

        $usuario_aprueba_ger = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('cadcargo', 'LIKE', '%GERENTE%')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->whereIn('empresa_osiris_id', [
                'IACHEM0000010394',
                'IACHEM0000007086'
            ])
            ->orderBy('apellidopaterno')
            ->orderBy('apellidomaterno')
            ->orderBy('nombres')
            ->pluck(
                DB::raw("
							            LTRIM(RTRIM(
							                ISNULL(apellidopaterno,'') + ' ' +
							                ISNULL(apellidomaterno,'') + ' ' +
							                ISNULL(nombres,'')
							            ))
							        "),
                'COD_TRAB'
            )
            ->toArray();
        $combo6 = array('' => 'Seleccione  Aprueba Gerente') + $usuario_aprueba_ger;

        $usuario_aprueba_adm = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->whereIn('empresa_osiris_id', [
                'IACHEM0000010394',
                'IACHEM0000007086'
            ])
            ->whereIn('cod_trab', [
                'IITR000000000391',
                'IATR000000000199'
            ])
            ->orderBy('apellidopaterno')
            ->orderBy('apellidomaterno')
            ->orderBy('nombres')
            ->pluck(
                DB::raw("
							            LTRIM(RTRIM(
							                ISNULL(apellidopaterno,'') + ' ' +
							                ISNULL(apellidomaterno,'') + ' ' +
							                ISNULL(nombres,'')
							            ))
							        "),
                'COD_TRAB'
            )
            ->toArray();
        $combo7 = array('' => 'Seleccione  Aprueba Administracion') + $usuario_aprueba_adm;
        $estadosMerge = DB::table('CMP.CATEGORIA')->where('TXT_GRUPO', 'ESTADO_MERGE')->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')->toArray();
        $estado_merge = 'ETM0000000000001';


        /* $periodo_anio = DB::table('Web.periodos')
         ->select('anio')
         ->whereIn('anio', ['2026'])
         ->where('COD_EMPR', $empresa)
         ->where('activo', 1)
         ->distinct()
         ->orderBy('anio')
         ->pluck('anio', 'anio')
         ->toArray();
         $combo8 = ['' => 'Seleccione Año'] + $periodo_anio;*/

        $periodo_anio = DB::table('Web.periodos')->where('activo', 1)->where('COD_EMPR', $empresa)->pluck('anio', 'anio')->toArray();
        $combo8 = array('' => 'Seleccione Año') + $periodo_anio;


        /*$periodo_mes = DB::table('Web.periodos')
         ->where('anio', $periodo_anio)
         ->where('COD_EMPR', $empresa)
         ->where('activo', 1)
         ->orderBy('anio')
         ->orderByRaw("CAST(SUBSTRING(TXT_NOMBRE, 2, CHARINDEX(')', TXT_NOMBRE)-2) AS INT)")
         ->pluck('TXT_NOMBRE', 'COD_PERIODO')
         ->toArray();
         $combo9 = ['' => 'Seleccione Mes'] + $periodo_mes;*/

        $periodo_mes = DB::table('Web.periodos')
            ->where('activo', 1)
            ->where('COD_EMPR', $empresa)
            ->pluck('TXT_NOMBRE', 'COD_PERIODO')
            ->toArray();

        $registrosPeriodos = DB::table('Web.periodos')
            ->where('activo', 1)
            ->where('COD_EMPR', $empresa)
            ->get(['COD_PERIODO', 'mes']);

        $tipFecoOrden = '';

        $combo9 = array('' => 'Seleccione Mes') + $periodo_mes;


        $area = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
            ->select('area_id', 'cadarea')
            ->first();

        $area_id = $area->area_id ?? '';
        $nomArea = $area->cadarea ?? '';

        $nro_pedido = $this->obtenerNumeroPedido($empresa, $cod_centro);


        // DETALLE DEL PEDIDO

        // $producto = DB::table('ALM.PRODUCTO')->where('cod_estado', 1)->pluck('NOM_PRODUCTO', 'COD_PRODUCTO')->toArray();
        /*$producto = DB::table('ALM.PRODUCTO as PRD')
         ->leftJoin('CMP.CATEGORIA as CAT', 'PRD.COD_CATEGORIA_UNIDAD_MEDIDA', '=', 'CAT.COD_CATEGORIA')
         ->where('PRD.COD_ESTADO', 1)
         ->select(
         'PRD.COD_PRODUCTO',
         'PRD.NOM_PRODUCTO',
         'PRD.IND_MATERIAL_SERVICIO',
         'CAT.COD_CATEGORIA as COD_UNIDAD',
         'CAT.NOM_CATEGORIA as UNIDAD')
         ->get();*/

        $producto = DB::select(
            "EXEC WEB.SP_LISTA_PRODUCTOS_ORDEN ?",
            [$empresa]
        );
        $registrosMonto = DB::table('WEB.MONTO_ORDEN_PEDIDO')
            ->where('COD_ESTADO', 1)
            ->orderBy('MONTO', 'asc')
            ->get();


        $listapedido = DB::connection('sqlsrv')->select("
            SELECT OP.*,
            STUFF((
                SELECT ' [SEP] ' + ARCH.NOMBRE_ARCHIVO + ' [FLD] ' + ARCH.URL_ARCHIVO
                FROM dbo.ARCHIVOS ARCH
                WHERE ARCH.ID_DOCUMENTO = OP.ID_PEDIDO
                AND ARCH.ACTIVO = 1
                FOR XML PATH(''), TYPE
            ).value('.', 'NVARCHAR(MAX)'), 1, 7, '') AS MULTI_ARCHIVOS
            FROM WEB.ORDEN_PEDIDO OP
            WHERE OP.ACTIVO = 1
            AND OP.COD_ESTADO <> 'ETM0000000000006'
            ORDER BY OP.FEC_PEDIDO DESC
        ");

        // Convertir el resultado a array asociativo para mantener compatibilidad con la vista
        $listapedido = json_decode(json_encode($listapedido), true);


        return view('ordenpedido.ajax.ordenpedido', [
            'listaempresa' => $combo,
            'empresa' => $empresa,
            'cod_centro' => $cod_centro,
            'nom_centro' => $nom_centro,
            'combo_sede' => $combo_sede,
            'listatipopedido' => $combo2,
            'listasolicita' => $combo4,
            'tipFecoOrden' => $tipFecoOrden,
            'usuario_solicita' => $usuario_solicita,
            'usuario_autoriza' => $combo5,
            'usuario_aprueba_ger' => $combo6,
            'usuario_aprueba_adm' => $combo7,
            'estadosMerge' => $estadosMerge,
            'estado_merge' => $estado_merge,
            'periodo_mes' => $combo9,
            'periodo_anio' => $combo8,
            'nro_pedido' => $nro_pedido,
            'producto' => $producto,
            'listapedido' => $listapedido,
            'nomArea' => $nomArea,
            'area_id' => $area_id,
            'registrosMonto' => $registrosMonto,
            'registrosPeriodos' => $registrosPeriodos,
            'ajax' => true,
        ]);
    }

    /* public function obtenerMeses(Request $request)
     {
     $anio    = $request->anio;
     $empresa = $request->empresa;
     $meses = DB::table('Web.periodos')
     ->where('anio', $anio)
     ->where('COD_EMPR', $empresa)
     ->where('activo', 1)
     ->orderByRaw("CAST(SUBSTRING(TXT_NOMBRE, 2, CHARINDEX(')', TXT_NOMBRE)-2) AS INT)")
     ->pluck('TXT_NOMBRE', 'COD_PERIODO');
     return response()->json($meses);
     }
     */


    private function obtenerNumeroPedido($cod_empr, $cod_centro)
    {
        $prefijo_empr = DB::table('STD.EMPRESA')
            ->where('COD_EMPR', $cod_empr)
            ->value('TXT_ABREVIATURA');

        $prefijo_centro = DB::table('ALM.CENTRO')
            ->where('COD_CENTRO', $cod_centro)
            ->value('TXT_ABREVIATURA');

        $prefijo = trim($prefijo_empr) . trim($prefijo_centro) . 'OP';

        $ultimo = DB::table('WEB.ORDEN_PEDIDO')
            ->where('COD_EMPR', $cod_empr)
            ->where('COD_CENTRO', $cod_centro)
            ->where('ID_PEDIDO', 'like', $prefijo . '%')
            ->orderBy('ID_PEDIDO', 'desc')
            ->value('ID_PEDIDO');

        if ($ultimo) {
            $numero = intval(substr($ultimo, -10)) + 1;
        } else {
            $numero = 1; // 👈 SI NO HAY REGISTROS
        }

        return $prefijo . str_pad($numero, 10, '0', STR_PAD_LEFT);
    }


    public function insertOrdenPedidoAction(Request $request)
    {
        // Capturar valores del formulario
        $fec_pedido = $request->input('fec_pedido');
        $cod_periodo = $request->input('cod_periodo');
        $cod_anio = $request->input('cod_anio');
        $cod_empr = $request->input('cod_empr');
        $cod_centro = $request->input('cod_centro');
        $cod_tipo_pedido = $request->input('cod_tipo_pedido');
        $cod_trabajador_solicita = $request->input('cod_trabajador_solicita');
        $cod_trabajador_autoriza = $request->input('cod_trabajador_autoriza');
        $cod_trabajador_aprueba_ger = $request->input('cod_trabajador_aprueba_ger');
        $cod_trabajador_aprueba_adm = $request->input('cod_trabajador_aprueba_adm');
        $txt_glosa = $request->input('txt_glosa');
        $cod_estado = $request->input('cod_estado');
        $cod_area = $request->input('cod_area');
        $orden_pedido_id = $request->input('orden_pedido_id');
        $opcion = $request->input('opcion');
        //$array_detalle = $request->input('array_detalle');

        $array_detalle = json_decode($request->input('array_detalle'), true) ?? [];

        $archivos_info = []; // Almacenar info de cada archivo para insertar después

        if ($request->hasFile('select_file')) {

            $archivos = $request->file('select_file');

            // Soportar tanto un archivo como múltiples
            if (!is_array($archivos)) {
                $archivos = [$archivos];
            }

            foreach ($archivos as $archivo) {
                $nombre_original = $archivo->getClientOriginalName();
                $extension_item = $archivo->getClientOriginalExtension();
                $nombre_sin_extension = pathinfo($nombre_original, PATHINFO_FILENAME);
                $size_item = $archivo->getSize();
                $mime_item = $archivo->getMimeType();
                $nombre_guardado = time() . '_' . $nombre_original;

                $destino_remoto = '\\\\10.1.50.2\\comprobantes\\ORDENPEDIDO';
                $ruta_item = $destino_remoto . '\\' . $nombre_guardado;

                if (!copy($archivo->getRealPath(), $ruta_item)) {
                    throw new \Symfony\Component\HttpFoundation\File\Exception\FileException(
                        "No se pudo escribir en el directorio de red: " . $destino_remoto
                    );
                }

                $archivos_info[] = [
                    'nombre_original'     => $nombre_original,
                    'nombre_sin_extension'=> $nombre_sin_extension,
                    'extension'           => $extension_item,
                    'size'                => $size_item,
                    'mime'                => $mime_item,
                    'ruta'                => $ruta_item,
                ];
            }
        }

        // =======================
        // Procesar nombres y textos relacionados
        // =======================
        $registro_periodo = DB::table('Web.periodos')
            ->where('COD_PERIODO', $cod_periodo)
            ->first();
        $txt_nombre = $registro_periodo->TXT_NOMBRE ?? '';

        $registro_tipo_pedido = DB::table('WEB.TIPO_PEDIDO_ORDEN')
            ->where('COD_TIPO_PEDIDO', $cod_tipo_pedido)
            ->first();
        $txt_tipo_pedido = $registro_tipo_pedido->TXT_TIPO_PEDIDO ?? '';

        $registro_solicita = DB::table('dbo.users')
            ->where('usuarioosiris_id', $cod_trabajador_solicita)
            ->first();
        $txt_trabajador_solicita = $registro_solicita->nombre ?? '';

        $registro_autoriza = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('COD_TRAB', $cod_trabajador_autoriza)
            ->first();
        $txt_trabajador_autoriza = $registro_autoriza ? trim(
            ($registro_autoriza->nombres ?? '') . ' ' .
            ($registro_autoriza->apellidopaterno ?? '') . ' ' .
            ($registro_autoriza->apellidomaterno ?? '')
        ) : '';

        $registro_aprueba_ger = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('COD_TRAB', $cod_trabajador_aprueba_ger)
            ->first();
        $txt_trabajador_aprueba_ger = $registro_aprueba_ger ? trim(
            ($registro_aprueba_ger->nombres ?? '') . ' ' .
            ($registro_aprueba_ger->apellidopaterno ?? '') . ' ' .
            ($registro_aprueba_ger->apellidomaterno ?? '')
        ) : '';

        $registro_aprueba_adm = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('COD_TRAB', $cod_trabajador_aprueba_adm)
            ->first();
        $txt_trabajador_aprueba_adm = $registro_aprueba_adm ? trim(
            ($registro_aprueba_adm->nombres ?? '') . ' ' .
            ($registro_aprueba_adm->apellidopaterno ?? '') . ' ' .
            ($registro_aprueba_adm->apellidomaterno ?? '')
        ) : '';

        $registro_estado = DB::table('CMP.CATEGORIA')
            ->where('COD_CATEGORIA', $cod_estado)
            ->first();
        $txt_estado = $registro_estado->NOM_CATEGORIA ?? '';

        $registro_area = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->where('area_id', $cod_area)
            ->first();
        $txt_area = $registro_area->cadarea ?? '';

        // =======================
        // Determinar acción: Insertar o Actualizar
        // =======================
        $accion = ($opcion === 'U') ? 'U' : 'I';

        // Insertar cabecera
        $orden_pedido_id =
            $this->insertOrdenPedido(
                $accion,
                $orden_pedido_id,
                $fec_pedido,
                $cod_periodo,
                $txt_nombre,
                $cod_anio,
                $cod_empr,
                $cod_centro,
                $cod_tipo_pedido,
                $txt_tipo_pedido,
                $cod_trabajador_solicita,
                $txt_trabajador_solicita,
                $cod_trabajador_autoriza,
                $txt_trabajador_autoriza,
                $cod_trabajador_aprueba_ger,
                $txt_trabajador_aprueba_ger,
                $cod_trabajador_aprueba_adm,
                $txt_trabajador_aprueba_adm,
                $txt_glosa,
                $cod_estado,
                $txt_estado,
                $cod_area,
                $txt_area,
                true,
                ""
            );

        // determine if update, deactivate existing details
        if ($accion === 'U') {
            DB::table('WEB.ORDEN_PEDIDO_DETALLE')
                ->where('ID_PEDIDO', $orden_pedido_id)
                ->update(['ACTIVO' => 0]);
        }

        if (count($array_detalle) > 0) {
            foreach ($array_detalle as $item) {
                $this->insertOrdenPedidoDetalle(
                    'I',
                    $orden_pedido_id,
                    $cod_empr,
                    $cod_centro,
                    $item['cod_producto'],
                    $item['nom_producto'],
                    $item['cod_categoria'] ?? '',
                    $item['nom_categoria'] ?? '',
                    $item['cantidad'],
                    $item['precio'],
                    $item['txt_observacion'] ?? '',
                    true,
                    ""
                );
            }
        }

        if (count($archivos_info) > 0) {
            if ($accion === 'U') {
                DB::table('dbo.ARCHIVOS')
                    ->where('ID_DOCUMENTO', $orden_pedido_id)
                    ->update(['ACTIVO' => 0]);
            }

            foreach ($archivos_info as $idx => $info) {
                DB::table('dbo.ARCHIVOS')->insert([
                    'ID_DOCUMENTO'       => $orden_pedido_id ?? '',
                    'DOCUMENTO_ITEM'     => $idx + 1,
                    'TIPO_ARCHIVO'       => $info['mime'],
                    'NOMBRE_ARCHIVO'     => $info['nombre_sin_extension'],
                    'DESCRIPCION_ARCHIVO'=> $info['nombre_original'],
                    'URL_ARCHIVO'        => $info['ruta'],
                    'EXTENSION'          => $info['extension'],
                    'SIZE'               => $info['size'],
                    'ACTIVO'             => 1,
                    'FECHA_CREA'         => DB::raw('GETDATE()'),
                    'USUARIO_CREA'       => Session::get('usuario')->usuario ?? 'SISTEMA',
                ]);
            }
        }

        return response()->json(['success' => true]);
    }


    public function actionDetallePedido(Request $request)
    {
        $cod_usuario_session = Session::get('usuario')->usuarioosiris_id;
        $id_buscar = $request->input('orden_pedido_id');


        $pedido = DB::table('WEB.ORDEN_PEDIDO')->where('ID_PEDIDO', $id_buscar)->first();
        $pedillodetalle = DB::table('WEB.ORDEN_PEDIDO_DETALLE')
            ->where('ID_PEDIDO', $id_buscar)
            ->where('ACTIVO', 1)
            ->get();


        $id_pedido = $pedillodetalle->pluck('ID_PEDIDO');
        $nom_producto = $pedillodetalle->pluck('NOM_PRODUCTO');
        $nom_categoria = $pedillodetalle->pluck('NOM_CATEGORIA');
        $cantidad = $pedillodetalle->pluck('CANTIDAD');
        $txt_observacion = $pedillodetalle->pluck('TXT_OBSERVACION');

        return view('ordenpedido.modal.modaldetallepedido', [
            'ajax' => true,
            'pedido' => $pedido,
            'id_pedido' => $id_pedido,
            'nom_producto' => $nom_producto,
            'nom_categoria' => $nom_categoria,
            'cantidad' => $cantidad,
            'txt_observacion' => $txt_observacion,
            'pedillodetalle' => $pedillodetalle

        ]);
    }


    public function insertEmitirOrdenPedido(Request $request)
    {
        $id_buscar = $request->input('orden_pedido_id');
        $orden_pedido_id = $request->input('orden_pedido_id');

        $pedido = DB::table('WEB.ORDEN_PEDIDO')
            ->where('ID_PEDIDO', $orden_pedido_id)
            ->first();
        $estado = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'ESTADO_MERGE')
            ->where('COD_CATEGORIA', 'ETM0000000000010')
            ->first();


        $this->insertOrdenPedido(
            'U',
            $id_buscar,
            $pedido->FEC_PEDIDO,
            $pedido->COD_PERIODO,
            $pedido->TXT_NOMBRE,
            $pedido->COD_ANIO,
            $pedido->COD_EMPR,
            $pedido->COD_CENTRO,
            $pedido->COD_TIPO_PEDIDO,
            $pedido->TXT_TIPO_PEDIDO,
            $pedido->COD_TRABAJADOR_SOLICITA,
            $pedido->TXT_TRABAJADOR_SOLICITA,
            $pedido->COD_TRABAJADOR_AUTORIZA,
            $pedido->TXT_TRABAJADOR_AUTORIZA,
            $pedido->COD_TRABAJADOR_APRUEBA_GER,
            $pedido->TXT_TRABAJADOR_APRUEBA_GER,
            $pedido->COD_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_GLOSA,
            $estado->COD_CATEGORIA,
            $estado->NOM_CATEGORIA,
            $pedido->COD_AREA,
            $pedido->TXT_AREA,
            true,
            ""
        );

        $this->enviarCorreoOPApruebaGerencia($orden_pedido_id);

        return response()->json([
            'success' => true
        ]);
    }

    public function actionAjaxPedidoEditar(Request $request)
    {
        try {
            $id_pedido = $request->input('id_pedido');

            // 1. Cabecera del pedido
            $header = DB::table('WEB.ORDEN_PEDIDO')
                ->where('ID_PEDIDO', $id_pedido)
                ->first();

            if (!$header) {
                return response()->json(['success' => false, 'mensaje' => 'No se encontró el pedido.'], 404);
            }

            // Formatear fecha para el input date (AAAA-MM-DD)
            if ($header->FEC_PEDIDO) {
                $header->FEC_PEDIDO = date('Y-m-d', strtotime($header->FEC_PEDIDO));
            }

            // 2. Detalle del pedido (productos registrados)
            $details = DB::table('WEB.ORDEN_PEDIDO_DETALLE')
                ->where('ID_PEDIDO', $header->ID_PEDIDO)
                ->where('ACTIVO', 1)
                ->get();

            // 3. Precios actualizados desde el SP solicitado
            $empresa = $header->COD_EMPR;
            $productos_precios = DB::select("EXEC WEB.SP_LISTA_PRODUCTOS_ORDEN ?", [$empresa]);

            // Mapear precios por producto para inyectar al detalle
            $precios_map = [];
            foreach ($productos_precios as $p) {
                $precios_map[$p->COD_PRODUCTO] = $p->PRECIO;
            }

            // Inyectar el precio actualizado en cada item del detalle
            foreach ($details as $d) {
                $d->PRECIO = isset($precios_map[$d->COD_PRODUCTO]) ? $precios_map[$d->COD_PRODUCTO] : 0;
            }

            // 4. Buscar si ya existe un archivo subido para este pedido
            $archivo = DB::table('dbo.ARCHIVOS')
                ->where('ID_DOCUMENTO', $id_pedido)
                ->where('ACTIVO', 1)
                ->select('ID_DOCUMENTO', 'URL_ARCHIVO', 'NOMBRE_ARCHIVO', 'DESCRIPCION_ARCHIVO')
                ->first();

            return response()->json([
                'success' => true,
                'pedido' => $header,
                'detalle' => $details,
                'archivo' => $archivo
            ]);
        } catch (\Exception $e) {
            Log::error("Error en actionAjaxPedidoEditar: " . $e->getMessage());
            return response()->json(['success' => false, 'mensaje' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function insertAnularOrdenPedido(Request $request)
    {

        $id_buscar = $request->input('orden_pedido_id');
        $orden_pedido_id = $request->input('orden_pedido_id');

        $pedido = DB::table('WEB.ORDEN_PEDIDO')
            ->where('ID_PEDIDO', $orden_pedido_id)
            ->first();
        $estado = DB::table('CMP.CATEGORIA')
            ->where('TXT_GRUPO', 'ESTADO_MERGE')
            ->where('NOM_CATEGORIA', 'ANULADO')
            ->first();


        $this->insertOrdenPedido(
            'D',
            $id_buscar,
            $pedido->FEC_PEDIDO,
            $pedido->COD_PERIODO,
            $pedido->TXT_NOMBRE,
            $pedido->COD_ANIO,
            $pedido->COD_EMPR,
            $pedido->COD_CENTRO,
            $pedido->COD_TIPO_PEDIDO,
            $pedido->TXT_TIPO_PEDIDO,
            $pedido->COD_TRABAJADOR_SOLICITA,
            $pedido->TXT_TRABAJADOR_SOLICITA,
            $pedido->COD_TRABAJADOR_AUTORIZA,
            $pedido->TXT_TRABAJADOR_AUTORIZA,
            $pedido->COD_TRABAJADOR_APRUEBA_GER,
            $pedido->TXT_TRABAJADOR_APRUEBA_GER,
            $pedido->COD_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_TRABAJADOR_APRUEBA_ADM,
            $pedido->TXT_GLOSA,
            $estado->COD_CATEGORIA,
            $estado->NOM_CATEGORIA,
            $pedido->COD_AREA,
            $pedido->TXT_AREA,
            true,
            ""
        );

        DB::table('WEB.ORDEN_PEDIDO_DETALLE')
            ->where('ID_PEDIDO', $orden_pedido_id)
            ->update([
                'ACTIVO' => 0
            ]);

        return response()->json([
            'success' => true
        ]);
    }

    public function actionAjaxObtenerCorrelativoPedido(Request $request)
    {
        $cod_empr = $request->input('cod_empr');
        $cod_centro = $request->input('cod_centro');
        $nro_pedido = $this->obtenerNumeroPedido($cod_empr, $cod_centro);
        return response()->json($nro_pedido);
    }

    public function actionAjaxBuscarProducto(Request $request)
    {
        $term = $request->input('term');
        $tipo = $request->input('tipo'); // Material o Servicio
        $empresa = Session::get('empresas')->COD_EMPR;

        $productos = DB::table('ALM.PRODUCTO as PRD')
            ->leftJoin('CMP.CATEGORIA as CAT', 'PRD.COD_CATEGORIA_UNIDAD_MEDIDA', '=', 'CAT.COD_CATEGORIA')
            ->where('PRD.COD_EMPR', $empresa)
            ->where('PRD.COD_ESTADO', 1)
            ->when($term, function ($query) use ($term) {
                $query->where(function ($sub) use ($term) {
                    $sub->where('PRD.NOM_PRODUCTO', 'LIKE', '%' . $term . '%')
                        ->orWhere('PRD.COD_PRODUCTO', 'LIKE', '%' . $term . '%');
                });
            })
            ->when($tipo, function ($query) use ($tipo) {
                $query->where('PRD.IND_MATERIAL_SERVICIO', $tipo);
            })
            ->select(
                'PRD.COD_PRODUCTO as id',
                DB::raw("PRD.COD_PRODUCTO + ' - ' + PRD.NOM_PRODUCTO as text"),
                'PRD.NOM_PRODUCTO',
                'CAT.NOM_CATEGORIA as UNIDAD',
                'CAT.COD_CATEGORIA as COD_UNIDAD',
                DB::raw("CAST(PRD.CAN_PRECIO AS FLOAT) as PRECIO"),
                'PRD.IND_MATERIAL_SERVICIO'
            )
            ->limit(100)
            ->get();

        return response()->json($productos);
    }

    public function actionBuscarProductoCompra(Request $request)
    {
        return $this->actionAjaxBuscarProducto($request);
    }
}
