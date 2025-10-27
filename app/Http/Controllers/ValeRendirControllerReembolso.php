<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ValeRendirReembolsoTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoMotivoValeRendir;
use App\Modelos\WEBValeRendirReembolso;
use App\Modelos\WEBValeRendirDetalleReembolso;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\STDTrabajador;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Log;
use Session;
use App\WEBRegla, App\STDEmpresa, APP\User, App\CMPCategoria;
use View;
use Validator;



class ValeRendirControllerReembolso extends Controller
{
    use ValeRendirReembolsoTraits;  

      public function actionValeRendirReembolso(Request $request)

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

        $cadlocal = trim(strtoupper($trabajadorespla->cadlocal ?? ''));

       if (
            stripos($cadlocal, 'SEDE ICA') !== false ||
            stripos($cadlocal, 'SEDE CHIMBOTE') !== false ||
            stripos($cadlocal, 'SEDE TRUJILLO') !== false ||
            stripos($cadlocal, 'SEDE PIURA') !== false 
        ) {
            $trabajadorespla->centro_osiris_id = 'CEN0000000000002';
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

        $areacomercial = DB::table('WEB.platrabajadores')
        ->where('situacion_id', 'PRMAECEN000000000002') // activo
        ->where('empresa_osiris_id', Session::get('empresas')->COD_EMPR)
        ->where('dni', $dni)
        ->value('cadarea');


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

           
            reset($usuariosAu);
            $usuario_autoriza_predeterminado = key($usuariosAu);

            reset($usuariosAp);
            $usuario_aprueba_predeterminado = key($usuariosAp);


        $combo = array('' => 'Seleccione Usuario Autoriza') + $usuariosAu;
        $combo1 = array('' => 'Seleccione Usuario Aprueba') + $usuariosAp;
        $combo2 = array('' => 'Seleccione Tipo o Motivo') + $tipoMotivo;
        $combo3 = array('' => 'Seleccione Destino') + $destino;
        $combo4 = array('' => 'Seleccione Moneda') + $moneda;

        $listarusuarios = $this->listaValeRendirReembolso(
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


        return view('valerendirreembolso.ajax.modalvalerendirreembolso', [
        	'listausuarios' => $combo,
            'listausuarios1' => $combo1,
            'listausuarios2' => $combo2,
            'listausuarios3' => $combo3,
            'listausuarios4' => $combo4,
            'usuario_aprueba_predeterminado' => $usuario_aprueba_predeterminado,
            'usuario_autoriza_predeterminado' => $usuario_autoriza_predeterminado,
            'listarusuarios' => $listarusuarios,      
            'nom_centro' => $nom_centro,
            'importeDestinos' => $importeDestinos,
            'ajax'=>true,   
        ]);
    }


 public function insertValeRendirActionReembolso(Request $request)
    {

        $usuario_autoriza   = $request->input('usuario_autoriza');
        $usuario_aprueba    = $request->input('usuario_aprueba');
        $tipo_motivo        = $request->input('tipo_motivo');
        $txt_glosa          = $request->input('txt_glosa');
        $can_total_importe  = $request->input('can_total_importe');
        $can_total_saldo    = $request->input('can_total_saldo');
        $cod_moneda         = $request->input('cod_moneda');
        $vale_rendir_id     = $request->input('vale_rendir_id');
        $opcion             = $request->input('opcion');
        $array_detalle      = $request->input('array_detalle');

        $cod_categoria_estado_vale = 'ETM0000000000001'; // 
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
        $cadlocal = trim(strtoupper($trabajadorespla->cadlocal ?? ''));


       if (
            stripos($cadlocal, 'SEDE ICA') !== false ||
            stripos($cadlocal, 'SEDE CHIMBOTE') !== false
        ) {
            $trabajadorespla->centro_osiris_id = 'CEN0000000000002';
        }

        if ($opcion === 'U') {

            $estado_vale = WEBValeRendirReembolso::where('id', $vale_rendir_id)->value('cod_categoria_estado_vale');
            if ($estado_vale === 'ETM0000000000005') {
                return response()->json(['error' => 'Vale de rendir procesado correctamente.']);
            }



            $this->insertValeRendirReembolso(
                "U",
                $vale_rendir_id,
                "", 
                "", 
                "", 
                "", 
                "",
                $cod_empr_cli,
                $txt_nom_solicita,
                $usuario_autoriza,
                $txt_nom_autoriza,
                $usuario_aprueba,
                $txt_nom_aprueba,
                "", "",
                $tipo_motivo,
                $cod_moneda,
                "",
                $txt_glosa,
                "", "", "",
                $can_total_importe,
                $can_total_saldo,
                "", "",
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale,
                true,
                ""
            );

            $this->insertValeRendirDetalleReembolso(
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
                    $this->insertValeRendirDetalleReembolso(
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

             //VALIDA CON EL DNI TABLA PERSONAL REEMBOLSO Y DNI PLANILLA
            $personalReembolso = DB::table('WEB.personal_reembolso')
            ->where('nro_documento', $trabajadorespla->dni)
            ->first();

            if (!$personalReembolso && strtoupper($trabajadorespla->cadarea) !== 'MARKETING') {
                    return response()->json([
                        'error' => 'Usted no cuenta con permiso para generar un vale de reembolso.'
                    ]);
                }

            $this->insertValeRendirReembolso(
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
                "",
                $txt_glosa,
                "", "", "",
                $can_total_importe,
                $can_total_saldo,
                "", "",
                $cod_categoria_estado_vale,
                $txt_categoria_estado_vale,
                true,
                ""
            );

            $cod_empr_aux = Session::get('empresas')->COD_EMPR;
            $ultimoVale = WEBValeRendirReembolso::where('COD_EMPR', $cod_empr_aux)
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
                        $this->insertValeRendirDetalleReembolso(
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
                        $this->insertValeRendirDetalleReembolso(
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

            $this->insertValeRendirReembolso(
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

        $this->insertValeRendirDetalleReembolso(
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


	public function traerdataValeRendirActionReembolso(Request $request)
    {
        $id_buscar = $request->input('valerendir_id');
        $usuarios = WEBValeRendirReembolso::where('ID', $id_buscar)->get(['ID', 'USUARIO_AUTORIZA', 'USUARIO_APRUEBA', 'TIPO_MOTIVO',  'CAN_TOTAL_IMPORTE', 'CAN_TOTAL_SALDO', 'TXT_GLOSA', 'TXT_CATEGORIA_ESTADO_VALE', 'COD_MONEDA'])->toJson();
        return $usuarios;

    }

    public function traerdataValeRendirActionDetalle(Request $request)
    {
        $id_buscar = $request->input('valerendir_id');
        $detalle = WEBValeRendirDetalleReembolso::where('ID', $id_buscar)->WHERE('COD_ESTADO', 1)->get(['ID', 'FEC_INICIO', 'FEC_FIN', 'COD_DESTINO', 'NOM_DESTINO', 'NOM_TIPOS', 'DIAS', 'CAN_UNITARIO', 'CAN_UNITARIO_TOTAL', 'CAN_TOTAL_IMPORTE', 'IND_DESTINO'])->toJson();
        return $detalle;

    }

    public function actionDetalleImporteValeReembolso(Request $request)
    { 
        $id_buscar = $request->input('valerendir_id'); 
    
   
    $detallesImporte = WEBValeRendirDetalleReembolso::where('ID', $id_buscar)->get(); 

    return view('valerendirreembolso.ajax.modaldetalleimportereembolso', [
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



