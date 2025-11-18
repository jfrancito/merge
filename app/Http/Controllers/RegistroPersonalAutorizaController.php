<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\ValePersonalAutorizaTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBRegistroValePersonalAutoriza;
use App\Modelos\ALMCentro;
use App\Modelos\CMPCategoria;
use App\Modelos\WEBTipoLineaValeRendir;
use Session;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, APP\User;
use View;
use Validator;


class RegistroPersonalAutorizaController extends Controller
{
	 use ValePersonalAutorizaTraits;

	 public function actionRegistroPersonalAutoriza(Request $request)
	 {
        

        $sede = DB::table('WEB.ListaplatrabajadoresGenereal')
                ->select('centro_osiris_id', 'cadlocal')
                ->whereIn('centro_osiris_id', [
                    'CEN0000000000001',
                    'CEN0000000000002',
                    'CEN0000000000004',
                    'CEN0000000000006'
                ])
                ->where(function ($query) {
                    $query->where('centro_osiris_id', '<>', 'CEN0000000000001') // todos menos el 0001
                          ->orWhere(function ($q) {
                              $q->where('centro_osiris_id', 'CEN0000000000001')
                                ->where('cadlocal', 'LIKE', '%CHICLAYO%'); // solo Chiclayo para el 0001
                          });
                })
                ->groupBy('centro_osiris_id', 'cadlocal')
                ->pluck('cadlocal', 'centro_osiris_id')
                ->toArray();


		$gerencia = DB::table('WEB.ListaplatrabajadoresGenereal')
	    ->select(DB::raw("UPPER(LTRIM(RTRIM(cadgerencia))) AS cadgerencia"))
	    ->whereNotNull('cadgerencia')
	    ->distinct()
	    ->orderBy('cadgerencia')
	    ->pluck('cadgerencia', 'cadgerencia') 
	    ->toArray();

		$area = DB::table('WEB.ListaplatrabajadoresGenereal')
		    ->select(DB::raw("UPPER(LTRIM(RTRIM(cadarea))) AS cadarea"))
		    ->whereNotNull('cadarea')
		    ->distinct()
		    ->orderBy('cadarea')
		    ->pluck('cadarea', 'cadarea') 
		    ->toArray();

        $tipos_linea = WEBTipoLineaValeRendir::pluck('txt_linea', 'cod_linea')->toArray();

		$usuarios_autoriza = DB::table('WEB.ListaplatrabajadoresGenereal')
		    ->select(DB::raw("
		        RTRIM(LTRIM(apellidopaterno)) + ' ' + 
		        RTRIM(LTRIM(apellidomaterno)) + ' ' + 
		        RTRIM(LTRIM(nombres)) AS nombre_completo
		    "))
		    ->distinct()
		    ->orderBy('nombre_completo')
		    ->pluck('nombre_completo')
		    ->toArray();


        $combo = array('' => 'Seleccione Sede') + $sede;
        $combo1 = array('' => 'Seleccione Gerencia') + $gerencia;
        $combo2 = array('' => 'Seleccione Área') + $area;



        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;



	 	return view('valerendir.ajax.modalpersonalautoriza', [
	 		'listasede' => $combo,
	 		'listagerencia' => $combo1,
            'listaarea' => $combo2,
            'listausuarios'  => $usuarios_autoriza,
            'tipos_linea'=>$tipos_linea, 
            'ajax'=>true,   
        ]);
	 }


    public function actionfiltrarPersonalAutoriza(Request $request)
    {
        $sede     = $request->input('sede');
        $gerencia = $request->input('gerencia');
        $area     = $request->input('area');
        $tipos_linea = WEBTipoLineaValeRendir::pluck('txt_linea', 'cod_linea')->toArray();


        $query = DB::table('WEB.ListaplatrabajadoresGenereal as t')
            ->select(
                't.cod_trab',  
                't.nombres',
                't.apellidopaterno',
                't.apellidomaterno',
                't.cadgerencia',
                't.cadarea',
                't.cadcargo',
                't.gerencia_id',
                't.area_id',
                't.cargo_id',
                DB::raw('vpa.COD_AUTORIZA as cod_autorizado'),
                DB::raw('vpa.COD_LINEA as cod_linea_autorizado'),
                DB::raw('vpa.TXT_LINEA as txt_linea_autorizado')
            )
            ->leftJoin('WEB.VALE_PERSONAL_AUTORIZA as vpa', function($join) {
                $join->on(DB::raw("RTRIM(LTRIM(vpa.TXT_PERSONAL))"), DB::raw("RTRIM(LTRIM(t.nombres + ' ' + t.apellidopaterno + ' ' + t.apellidomaterno))"))
                     ->where('vpa.COD_ESTADO', 1);
            })
            ->where('t.situacion_id', 'PRMAECEN000000000002')
            ->whereIn('t.codempresa', ['PRMAECEN000000000003', 'PRMAECEN000000000004']);

        if ($sede != '') {
            $query->where('t.centro_osiris_id', $sede);
        }

        if ($gerencia != '') {
            $query->where(DB::raw("LTRIM(RTRIM(UPPER(t.cadgerencia)))"), strtoupper(trim($gerencia)));
        }

        if ($area != '') {
            $query->where(DB::raw("LTRIM(RTRIM(UPPER(t.cadarea)))"), strtoupper(trim($area)));
        }

        $personal = $query->get();

        return response()->json([
            'data' => $personal,
            'tipos_linea' => $tipos_linea
        ]);
    }

	public function guardarPersonalAutoriza(Request $request)
    {
        $registros = $request->input('registros');
        $cod_usuario = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $centro_osiris_id = $request->input('centro_osiris_id');

        foreach ($registros as $item) {

            /*$registroExistente = DB::table('WEB.VALE_PERSONAL_AUTORIZA')
                ->where(DB::raw("RTRIM(LTRIM(TXT_PERSONAL))"), trim($item['personal']))
                ->where(DB::raw("RTRIM(LTRIM(TXT_AREA))"), trim($item['area']))
                ->where('COD_ESTADO', 1)
                ->first();*/

                $registroExistente = DB::table('WEB.VALE_PERSONAL_AUTORIZA')
                ->where('COD_PERSONAL', $item['cod_trab'])      // Identificador único del trabajador
                ->where('COD_ESTADO', 1)
                ->first();


            if ($registroExistente) {
             
                if (
                    $registroExistente->COD_AUTORIZA != $item['cod_autoriza'] ||
                    trim($registroExistente->TXT_AUTORIZA) != trim($item['txt_autoriza']) ||
                    trim($registroExistente->COD_LINEA) != trim($item['cod_linea']) ||
                    trim($registroExistente->TXT_LINEA) != trim($item['txt_linea'])
                ) {
                    $this->insertRegistroPersonalAutoriza(
                        'U',
                        $registroExistente->ID, 
                        $cod_empr,
                        $centro_osiris_id,
                        $item['cod_trab'],
                        $item['personal'],
                        $item['gerencia_id'],
                        $item['gerencia'],
                        $item['area_id'],
                        $item['area'],
                        $item['cargo_id'],
                        $item['cargo'],
                        $item['cod_autoriza'],
                        $item['txt_autoriza'],
                        $item['cod_linea'],
                        $item['txt_linea'],
                        true,
                        $cod_usuario
                    );
                }
                continue;
            }

            $this->insertRegistroPersonalAutoriza(
                'I',
                '',
                $cod_empr,
                $centro_osiris_id,
                $item['cod_trab'],
                $item['personal'],
                $item['gerencia_id'],
                $item['gerencia'],
                $item['area_id'],
                $item['area'],
                $item['cargo_id'],
                $item['cargo'],
                $item['cod_autoriza'],
                $item['txt_autoriza'],
                $item['cod_linea'],
                $item['txt_linea'],
                true,
                $cod_usuario
            );
        }

        return response()->json(['success' => true]);
    }
}
