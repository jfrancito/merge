<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ValeRendirTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendir;
use App\Modelos\WEBValeRendirDetalle;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDEmpresa;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Session;
use App\WEBRegla, APP\User, App\CMPCategoria;
use View;
use Validator;



class ValeRendirController extends Controller
{
    use ValeRendirTraits;  

      public function actionValeRendir(Request $request)

    {
       $trabajador     =   DB::table('STD.TRABAJADOR')
                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                            ->first();
        $dni            =       '';
        $centro_id      =       '';

        if ($trabajador) {
            $dni = $trabajador->NRO_DOCUMENTO;
        }

        $trabajadorespla = DB::table('WEB.platrabajadores')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
            ->where('dni', $dni)
            ->first();

        if (!$trabajadorespla) {
            return view('valerendir.modal.modalerrorempresa', [
                'mensaje' => 'No puede realizar un registro porque no es la empresa a cual pertenece.',
                'ajax' => true
            ]);
        }

        $centro_id = $trabajadorespla->centro_osiris_id;

        $centrot        =   DB::table('ALM.CENTRO')
                            ->where('COD_CENTRO', $centro_id)
                            ->first();

        $cod_centro = $centrot->COD_CENTRO; 
        $nom_centro = $centrot->NOM_CENTRO; 


        $usuariosAu = DB::table('WEB.VALE_PERSONAL_AUTORIZA')
            ->where('COD_PERSONAL', Session::get('usuario')->usuarioosiris_id)
            ->where('COD_CENTRO', $cod_centro)
            ->where('COD_ESTADO', '!=', 0)
            ->pluck('TXT_AUTORIZA', 'COD_AUTORIZA')
            ->toArray();

        $usuariosAp =  DB::table('WEB.VALE_PERSONAL_APRUEBA')->where('cod_centro', $cod_centro)->pluck('txt_aprueba', 'cod_aprueba')->toArray();
        $tipoMotivo = WEBTipoMotivoValeRendir::where('cod_estado',1)->pluck('txt_motivo', 'cod_motivo')->toArray();
        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;


        //CUENTA BANCARIA

         $cod_empr_cli = DB::table('users as usu')
            ->join('SGD.USUARIO as us', 'usu.usuarioosiris_id', '=', 'us.COD_TRABAJADOR')
            ->join('STD.TRABAJADOR as tra', 'tra.COD_TRAB', '=', 'us.COD_TRABAJADOR')
            ->join('STD.EMPRESA as emp', 'emp.NRO_DOCUMENTO', '=', 'tra.NRO_DOCUMENTO')
            ->where('usu.id', $cod_usuario_registro)
            ->value('emp.COD_EMPR');


        $empresatrabjador = STDEmpresa::where('COD_EMPR','=',$cod_empr_cli)->first();
        $nrodocumentotrab = $empresatrabjador->NRO_DOCUMENTO;

        $values                 =   [$nrodocumentotrab,$cod_empr];
        $datoscuentasueldo      =   DB::select('exec ListaTrabajadorCuentaSueldo ?,?',$values);   

        $txt_categoria_banco = $datoscuentasueldo[0]->entidad ?? null;
        $numero_cuenta  = $datoscuentasueldo[0]->numcuenta ?? null;



        // DETALLE - VALE A RENDIR 
         $destino = DB::table('WEB.REGISTRO_IMPORTE_GASTOS')
        ->select('COD_DISTRITO', 'NOM_DISTRITO')
        ->where('COD_CENTRO', $cod_centro)
        ->where('COD_ESTADO', 1)
        ->groupBy('COD_DISTRITO', 'NOM_DISTRITO')
        ->pluck('NOM_DISTRITO', 'COD_DISTRITO')
        ->toArray();


        $importeDestinos = DB::table('WEB.REGISTRO_IMPORTE_GASTOS as main')
                ->select(
                    'main.COD_DISTRITO',
                    'main.NOM_DISTRITO',
                    'main.COD_CENTRO', 
                    'main.IND_DESTINO',
                    // Lista de nombres (para mostrar)
                    DB::raw("
                        STUFF((
                            SELECT ', ' + sub.TXT_NOM_TIPO + ': ' + CAST(sub.CAN_TOTAL_IMPORTE AS VARCHAR)
                            FROM WEB.REGISTRO_IMPORTE_GASTOS AS sub
                            WHERE 
                                sub.COD_DISTRITO = main.COD_DISTRITO
                                AND sub.COD_CENTRO = main.COD_CENTRO
                                AND sub.IND_DESTINO = main.IND_DESTINO
                                AND sub.COD_ESTADO = 1
                            FOR XML PATH(''), TYPE
                        ).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS TXT_NOM_TIPO
                    "),
                    // Lista de códigos (para usar en lógica JS)
                    DB::raw("
                        STUFF((
                            SELECT ', ' + sub.COD_TIPO + ':' + CAST(sub.CAN_TOTAL_IMPORTE AS VARCHAR)
                            FROM WEB.REGISTRO_IMPORTE_GASTOS AS sub
                            WHERE 
                                sub.COD_DISTRITO = main.COD_DISTRITO
                                AND sub.COD_CENTRO = main.COD_CENTRO
                                AND sub.IND_DESTINO = main.IND_DESTINO
                                AND sub.COD_ESTADO = 1
                            FOR XML PATH(''), TYPE
                        ).value('.', 'NVARCHAR(MAX)'), 1, 2, '') AS COD_TIPO
                    ")
                )
                ->where('main.COD_CENTRO', $cod_centro)
                ->where('main.COD_ESTADO', 1)
                ->groupBy(
                    'main.COD_DISTRITO',
                    'main.NOM_DISTRITO',
                    'main.COD_CENTRO',
                    'main.IND_DESTINO'
                )
                ->get()
                ->toArray();

            $moneda = DB::table('CMP.CATEGORIA')
            ->whereIn('COD_CATEGORIA', ['MON0000000000001', 'MON0000000000002'])
            ->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')
            ->toArray();

            $listacabecera = DB::table('LQG_DETLIQUIDACIONGASTO')
                ->where('ID_DOCUMENTO', 'LIQG00000158')
                ->where('COD_TIPODOCUMENTO', 'TDO0000000000001')
                ->where('ACTIVO', 1)
                ->get();

            $tipopago = [
                    0 => 'EFECTIVO',
                    1 => 'TRANSFERENCIA'
                ];

            reset($usuariosAu);
            $usuario_autoriza_predeterminado = key($usuariosAu);

            reset($usuariosAp);
            $usuario_aprueba_predeterminado = key($usuariosAp);


        $combo = array('' => 'Seleccione Usuario Autoriza') + $usuariosAu;
        $combo1 = array('' => 'Seleccione Usuario Aprueba') + $usuariosAp;
        $combo2 = array('' => 'Seleccione Tipo o Motivo') + $tipoMotivo;
        $combo3 = array('' => 'Seleccione Destino') + $destino;
        $combo4 = array('' => 'Seleccione Moneda') + $moneda;
        $combo5 = array('' => 'Seleccione Tipo Pago') + $tipopago;

        $listarusuarios = $this->listaValeRendir(
    	        "GEN",
    	        "",
    	        "",
    	        "",
    	        "",
                "",
                "",
    	        "",
    	        0.0,
    	        0.0,
    	        ""
    	    );

         $listarusuariosDetalle = $this->listaValeRendirDetalle(
                "GEN",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                0.0,
                ""
            );  

         $listarValePendientes =  $this->listaValeRendirPendientes(
                "$cod_usuario_registro"
               
            );

         $listarLiquidacionesPendientes =  $this->listaLiquidacionesPendientes(
                "$cod_usuario_registro"
               
            );

         $listarDocumentoXML_CDR =  $this->listaDocumentoXML_CDR(
                "$cod_empr",
                "$cod_usuario_registro"
               
            );
         $listarlistanegra =  $this->listaNegraProveedores(
                "$cod_empr"  
            );

        return view('valerendir.ajax.modalvalerendir', [
        	'listausuarios' => $combo,
            'listausuarios1' => $combo1,
            'listausuarios2' => $combo2,
            'listausuarios3' => $combo3,
            'listausuarios4' => $combo4,
            'listausuarios5' => $combo5,
            'txt_categoria_banco'   => $txt_categoria_banco,
            'numero_cuenta'         => $numero_cuenta,
            'usuario_aprueba_predeterminado' => $usuario_aprueba_predeterminado,
            'usuario_autoriza_predeterminado' => $usuario_autoriza_predeterminado,
            'listarusuarios' => $listarusuarios,      
            'nom_centro' => $nom_centro,
            'importeDestinos' => $importeDestinos,
            'listarValePendientes' => $listarValePendientes,
            'listarLiquidacionesPendientes' => $listarLiquidacionesPendientes,
            'listarDocumentoXML_CDR' => $listarDocumentoXML_CDR,
            'listarlistanegra' => $listarlistanegra,
            'ajax'=>true,   
        ]);
    }


 public function insertValeRendirAction(Request $request)
    {
        $usuario_autoriza   = $request->input('usuario_autoriza');
        $usuario_aprueba    = $request->input('usuario_aprueba');
        $tipo_motivo        = $request->input('tipo_motivo');
        $txt_glosa          = $request->input('txt_glosa');
        $can_total_importe  = $request->input('can_total_importe');
        $can_total_saldo    = $request->input('can_total_saldo');
        $cod_moneda         = $request->input('cod_moneda');
        $tipo_pago          = (int) $request->input('tipo_pago');
        $txt_categoria_banco   = $request->input('txt_categoria_banco');
        $numero_cuenta         = $request->input('numero_cuenta');
        $vale_rendir_id     = $request->input('vale_rendir_id');
        $opcion             = $request->input('opcion');
        $array_detalle      = $request->input('array_detalle');

        $cod_categoria_estado_vale = 'ETM0000000000001'; // GENERADO
        $txt_categoria_estado_vale = 'GENERADO';
        $cod_usuario_registro      = Session::get('usuario')->id;
        $txt_nom_solicita          = User::where('id', $cod_usuario_registro)->value('nombre');

        $registro_autoriza = DB::table('WEB.VALE_PERSONAL_AUTORIZA')
            ->where('cod_autoriza', $usuario_autoriza)
            ->first();
        $registro_aprueba = DB::table('WEB.VALE_PERSONAL_APRUEBA')
            ->where('cod_aprueba', $usuario_aprueba)
            ->first();

        $txt_nom_autoriza = $registro_autoriza->TXT_AUTORIZA ?? '';
        $txt_nom_aprueba  = $registro_aprueba->TXT_APRUEBA ?? '';

        $cod_empr_cli = DB::table('users as usu')
            ->join('SGD.USUARIO as us', 'usu.usuarioosiris_id', '=', 'us.COD_TRABAJADOR')
            ->join('STD.TRABAJADOR as tra', 'tra.COD_TRAB', '=', 'us.COD_TRABAJADOR')
            ->join('STD.EMPRESA as emp', 'emp.NRO_DOCUMENTO', '=', 'tra.NRO_DOCUMENTO')
            ->where('usu.id', $cod_usuario_registro)
            ->value('emp.COD_EMPR');

        $trabajador     =   DB::table('STD.TRABAJADOR')
                            ->where('COD_TRAB', Session::get('usuario')->usuarioosiris_id)
                            ->first();
        $dni            =       '';
        $centro_id      =       '';

        if ($trabajador) {
            $dni = $trabajador->NRO_DOCUMENTO;
        }

        $trabajadorespla = DB::table('WEB.platrabajadores')
            ->where('situacion_id', 'PRMAECEN000000000002')
            ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
            ->where('dni', $dni)
            ->first();

        if (!$trabajadorespla) {
            return view('valerendir.modal.modalerrorempresa', [
                'mensaje' => 'No puede realizar un registro porque no es la empresa a cual pertenece.',
                'ajax' => true
            ]);
        }

        $centro_id = $trabajadorespla->centro_osiris_id;

        $centrot        =   DB::table('ALM.CENTRO')
                            ->where('COD_CENTRO', $centro_id)
                            ->first();

        $cod_centro = $centrot->COD_CENTRO; 

        // ACTUALIZACIÓN
        if ($opcion === 'U') {

            $estado_vale = WEBValeRendir::where('id', $vale_rendir_id)->value('cod_categoria_estado_vale');
            if ($estado_vale === 'ETM0000000000005') {
                return response()->json(['error' => 'Vale de rendir procesado correctamente.']);
            }

            $this->insertValeRendir(
                "U",
                $vale_rendir_id,
                "", "", "", "", "",
                $cod_empr_cli,
                $txt_nom_solicita,
                $usuario_autoriza,
                $txt_nom_autoriza,
                $usuario_aprueba,
                $txt_nom_aprueba,
                "", "",
                $tipo_motivo,
                $cod_moneda,
                $tipo_pago,
                $txt_glosa,
                "", "", "",
                $can_total_importe,
                $can_total_saldo,
                $txt_categoria_banco, 
                $numero_cuenta,
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale,
                true,
                ""
            );

            // Eliminar y volver a insertar el detalle
            $this->insertValeRendirDetalle(
                "D",
                $vale_rendir_id,
                "01/01/1901",
                "01/01/1901",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                "",
                0.0,
                "",
                "",
                "",
                false,
                $txt_nom_solicita
            );

            if (count($array_detalle) > 0) {
                foreach ($array_detalle as $array) {
                    $this->insertValeRendirDetalle(
                        "I",
                        $vale_rendir_id,
                        $array['fec_inicio'],
                        $array['fec_fin'],
                        "",
                        "",
                        $array['cod_destino'],
                        $array['nom_destino'],
                        $array['nom_tipos'],
                        $array['dias'],
                        $array['can_unitario'],
                        $array['can_unitario_total'],
                        $array['can_total_importe'],
                        $array['ind_destino'],
                        $array['ind_propio'],
                        $array['ind_aereo'],
                        true,
                        ""
                    );
                }
            }

            return response()->json([
                'success' => 'Vale actualizado correctamente.',
                'vale_rendir_id' => $vale_rendir_id
            ]);
        }

        // INSERCIÓN
        else {
           $cod_usuario_registro = Session::get('usuario')->id;

                // Subconsulta 1
                $sub1 = DB::table('WEB.VALE_RENDIR as VR')
                    ->select([
                        'AD.COD_AUTORIZACION',
                        'DC.CAN_SALDO',
                        DB::raw("CASE WHEN AD.COD_AUTORIZACION IS NULL THEN VR.ID ELSE AD.COD_AUTORIZACION END as IDS")
                    ])
                    ->leftJoin('TES.AUTORIZACION_DETALLE as AD', 'VR.ID_OSIRIS', '=', 'AD.COD_AUTORIZACION')
                    ->leftJoin('CMP.DOCUMENTO_CTBLE as DC', 'AD.COD_DOC_CTBLE', '=', 'DC.COD_DOCUMENTO_CTBLE')
                    ->where('VR.COD_USUARIO_CREA_AUD', $cod_usuario_registro)
                    ->whereIn('VR.COD_CATEGORIA_ESTADO_VALE', [
                        'ETM0000000000007',
                        'ETM0000000000001',
                        'ETM0000000000005'
                    ])
                    ->whereNotExists(function ($query) {
                        $query->select(DB::raw(1))
                              ->from('TES.AUTORIZACION as A2')
                              ->whereRaw('A2.COD_AUTORIZACION = VR.ID_OSIRIS')
                              ->where('A2.COD_TIPO_ESTADO', 'IACHTE0000000001');
                    })
                    ->where(function ($query) use ($cod_usuario_registro) {
                        $query->whereNotExists(function ($q) use ($cod_usuario_registro) {
                            $q->select(DB::raw(1))
                              ->from('LQG_LIQUIDACION_GASTO as LG')
                              ->whereRaw('LG.ARENDIR_ID = VR.ID')
                              ->whereIn('LG.COD_ESTADO', [
                                  'ETM0000000000005',
                                  'ETM0000000000006'
                              ])
                              ->where('LG.USUARIO_CREA', $cod_usuario_registro);
                        })
                        ->orWhere(function ($q2) {
                            $q2->where('DC.CAN_SALDO', '>', 0)
                               ->orWhereNull('DC.CAN_SALDO'); // <-- Aquí agregamos el IS NULL
                        });
                    });

                // Subconsulta 2
                $sub2 = DB::table('users as U')
                    ->select([
                        'A.COD_AUTORIZACION',
                        'DC.CAN_SALDO',
                        'A.COD_AUTORIZACION as IDS'
                    ])
                    ->join('STD.TRABAJADOR as T', 'U.usuarioosiris_id', '=', 'T.COD_TRAB')
                    ->join('STD.EMPRESA as E', 'E.NRO_DOCUMENTO', '=', 'T.NRO_DOCUMENTO')
                    ->join('CMP.CONTRATO as C', function ($join) {
                        $join->on('C.COD_EMPR_CLIENTE', '=', 'E.COD_EMPR')
                             ->where('C.COD_CATEGORIA_CANAL_VENTA', 'CVE0000000000034');
                    })
                    ->join('TES.AUTORIZACION as A', function ($join) {
                        $join->on('A.COD_CONTRATO', '=', 'C.COD_CONTRATO')
                             ->where('A.COD_TIPO_ESTADO', '<>', 'IACHTE0000000001');
                    })
                    ->join('TES.AUTORIZACION_DETALLE as AD', function ($join) {
                        $join->on('AD.COD_AUTORIZACION', '=', 'A.COD_AUTORIZACION')
                             ->where('AD.COD_TIPO_DOCUMENTO', 'TDO0000000000072');
                    })
                    ->join('CMP.DOCUMENTO_CTBLE as DC', 'DC.COD_DOCUMENTO_CTBLE', '=', 'AD.COD_DOC_CTBLE')
                    ->where('U.id', $cod_usuario_registro)
                    ->where(function ($q) {
                        $q->where('DC.CAN_SALDO', '>', 0)
                          ->orWhereNull('DC.CAN_SALDO'); // <-- Aquí también agregamos el IS NULL
                    });

                // Unión de subconsultas
                $query = $sub1->unionAll($sub2);

                // Contar pendientes
                $pendienteCount = DB::table(DB::raw("({$query->toSql()}) as P"))
                    ->mergeBindings($query)
                    ->distinct()
                    ->count('IDS');

                if ($pendienteCount >= 2) {
                    return response()->json([
                        'error' => 'Usted tiene 2 o más vales pendientes por rendir. No puede generar un tercer vale.'
                    ]);
                }

            
            $this->insertValeRendir(
                "I",
                "", "", "", "", "", "",
                $cod_empr_cli,
                $txt_nom_solicita,
                $usuario_autoriza,
                $txt_nom_autoriza,
                $usuario_aprueba,
                $txt_nom_aprueba,
                "", "",
                $tipo_motivo,
                $cod_moneda,
                $tipo_pago,
                $txt_glosa,
                "", 
                "", 
                "",
                $can_total_importe,
                $can_total_saldo,
                $txt_categoria_banco, 
                $numero_cuenta,
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale,
                true,
                ""
            );

            $cod_empr_aux = Session::get('empresas')->COD_EMPR;
            $ultimoVale = WEBValeRendir::where('COD_EMPR', $cod_empr_aux)
                ->where('COD_CENTRO', $cod_centro) 
                ->orderBy('id', 'DESC')
                ->first();
            if (!$ultimoVale) {
                return response()->json(['error' => 'Error al recuperar el ID del vale recién insertado.']);
            }

            $nuevo_vale_id = $ultimoVale->ID;

            if (count($array_detalle) > 0) {
                foreach ($array_detalle as $array) {
                    $opcion_detalle = $array['opcion_detalle'];

                    if ($opcion_detalle === 'U') {
                        $detalle_id = $array['detalle_id'] ?? null;
                        $this->insertValeRendirDetalle(
                            "U",
                            $detalle_id,
                            $array['fec_inicio'],
                            $array['fec_fin'],
                            "", "", $array['cod_destino'], "", "", "", "", "",
                            $array['can_total_importe'],
                            $array['ind_destino'],
                            $array['ind_propio'],
                            $array['ind_aereo'],
                            true,
                            ""
                        );
                    } elseif ($opcion_detalle === 'I') {
                        $this->insertValeRendirDetalle(
                            "I",
                            $nuevo_vale_id,
                            $array['fec_inicio'],
                            $array['fec_fin'],
                            "", "", $array['cod_destino'],
                            $array['nom_destino'],
                            $array['nom_tipos'],
                            $array['dias'],
                            $array['can_unitario'],
                            $array['can_unitario_total'],
                            $array['can_total_importe'],
                            $array['ind_destino'],
                            $array['ind_propio'],
                            $array['ind_aereo'],
                            true,
                            ""
                        );
                    }
                }
            }

            return response()->json([
                'success' => 'Vale insertado correctamente.',
                'vale_rendir_id' => $nuevo_vale_id
            ]);
        }
    }



     public function actionEliminarValeRendir(Request $request)
	{ 
        $id_buscar = $request->input('valerendir_id'); 

           $cod_categoria_estado_vale = 'ETM0000000000010';  
           $txt_categoria_estado_vale = 'ANULADO'; 
           $txt_glosa_autorizado = "";
           $txt_glosa_rechazado = "";
           $txt_nom_solicita = "";
           $txt_nom_autoriza = "";
           $txt_nom_aprueba = "";

            $this->insertValeRendir(
                'D', 
                $id_buscar,
                '', 
                '',
                '',
                '',
                '',
                '',
                '', 
                '',
                '', 
                '',
                '',
                '',
                '', 
                '',
                '',
                '',
                '',
                $txt_glosa_autorizado,
                $txt_glosa_rechazado,
                '', 
                0.0, 
                0.0,
                '',
                '',
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale, 
                false,
                Session::get('usuario')->id 
            );

        return response()->json(['success' => 'Vale de rendir eliminado correctamente.']);
    }


    public function actionEliminarValeRendirDetalle(Request $request)
    {
        $idDetalle = $request->input('id_detalle');
        
        if (!$idDetalle) {
            return response()->json(['error' => 'ID del detalle no proporcionado.'], 400);
        }

        $this->insertValeRendirDetalle(
            "X",              
            $idDetalle,        
            "",
            "", 
            "", 
            "", 
            "", 
            "",
            "", 
            "", 
            "", 
            "",  
            0.0, 
            "",
            "",  
            "",            
            true,
            Session::get('usuario')->id
        );

        return response()->json(['success' => 'Detalle del vale de rendir eliminado correctamente.']);
    }


	public function traerdataValeRendirAction(Request $request)
    {
        $id_buscar = $request->input('valerendir_id');
        $usuarios = WEBValeRendir::where('ID', $id_buscar)->get(['ID', 'USUARIO_AUTORIZA', 'USUARIO_APRUEBA', 'TIPO_MOTIVO',  'CAN_TOTAL_IMPORTE', 'CAN_TOTAL_SALDO', 'TIPO_PAGO' , 'TXT_CATEGORIA_BANCO', 'NRO_CUENTA' , 'TXT_GLOSA', 'TXT_CATEGORIA_ESTADO_VALE', 'COD_MONEDA'])->toJson();
        return $usuarios;

    }

    public function traerdataValeRendirActionDetalle(Request $request)
    {
        $id_buscar = $request->input('valerendir_id');
        $detalle = WEBValeRendirDetalle::where('ID', $id_buscar)->WHERE('COD_ESTADO', 1)->get(['ID', 'FEC_INICIO', 'FEC_FIN', 'COD_DESTINO', 'NOM_DESTINO', 'NOM_TIPOS', 'DIAS', 'CAN_UNITARIO', 'CAN_UNITARIO_TOTAL', 'CAN_TOTAL_IMPORTE', 'IND_DESTINO'])->toJson();
        return $detalle;

    }

    public function actionDetalleImporteVale(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
   
    $detallesImporte = WEBValeRendirDetalle::where('ID', $id_buscar)->get(); 

    return view('valerendir.ajax.modaldetalleimporte', [
        'ajax' => true,
        'detalles' => $detallesImporte
    ]);  

    }   

    public function actionMensajeValeRendir(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
         return view('valerendir.ajax.modalmensajesolicitudvale', [
             'ajax'=>true,
        ]);           
    }

    public function actionValePendientes(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
         return view('valerendir.ajax.modalvalependientes', [
             'ajax'=>true,
        ]);           
    }

    public function actionLiquidacionesSinProcesar(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
         return view('valerendir.ajax.modalliquidacionessinprocesar', [
             'ajax'=>true,
        ]);           
    }

    public function actionDocumentosSinXmlCdr(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
         return view('valerendir.ajax.modaldocumentossinxmlcdr', [
             'ajax'=>true,
        ]);           
    }

}

