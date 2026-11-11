<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\RegistroPersonalApruebaTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBRegistroPersonalAprueba;
use App\Modelos\ALMCentro;
use App\Modelos\CMPCategoria;
use Session;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, APP\User;
use View;
use Validator;


class RegistroPersonalApruebaController extends Controller
{
	 use RegistroPersonalApruebaTraits;



	 public function actionRegistroPersonalAprueba(Request $request)
	 {

  		$cod_empr = Session::get('empresas')->COD_EMPR;

		$sede = DB::table('WEB.ListaplatrabajadoresGenereal')
			    ->select('centro_osiris_id', 'cadlocal')
			    ->whereIn('centro_osiris_id', [
			        'CEN0000000000001',
			        'CEN0000000000002',
			        'CEN0000000000004',
			        'CEN0000000000006'
			    ])
			    ->groupBy('centro_osiris_id', 'cadlocal')
			    ->pluck('cadlocal', 'centro_osiris_id')
			    ->toArray();


	 	$usuario_aprueba = DB::table('WEB.ListaplatrabajadoresGenereal')
			    ->select(
			        'COD_TRAB',
			        DB::raw("RTRIM(LTRIM(apellidopaterno)) + ' ' + RTRIM(LTRIM(apellidomaterno)) + ' ' + RTRIM(LTRIM(nombres)) AS nombre_completo")
			    )
			    ->where('situacion_id', 'PRMAECEN000000000002')
			    ->orderBy('nombre_completo')
			    ->pluck('nombre_completo', 'COD_TRAB')  
			    ->toArray();


        $combo = array('' => 'Seleccione Sede') + $sede;
        $combo3 = array('' => 'Seleccione usuario ') + $usuario_aprueba;


        $cod_usuario_registro = Session::get('usuario')->id;
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;


           $listarpersonalaprueba = $this->listaRegistroPersonalAprueba(
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
                ""          
        );


	 return view('valerendir.ajax.modalpersonalaprueba', [
            'listarpersonalaprueba' => $listarpersonalaprueba,
	 	    'listasede' => $combo,
	 	/*    'listaarea' => $combo1,
	 	    'listacargo' => $combo2,*/
	 	    'listausuario' => $combo3,
            'ajax'=>true,   
        ]);

     }


    public function insertPersonalAprueba(Request $request) { 
        $sede = $request->input('sede');
        $area = $request->input('area');
        $cargo = $request->input('cargo');
        $usuario_aprueba = $request->input('usuario_aprueba');
        $personal_aprueba_id = $request->input('personal_aprueba_id'); 
        $opcion = $request->input('opcion'); 

        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_usuario_registro = Session::get('usuario')->id;

	    $txt_area = DB::table('WEB.ListaplatrabajadoresGenereal')
	      ->where('area_id', $area)
	      ->first();

	    $txt_cargo = DB::table('WEB.ListaplatrabajadoresGenereal')
	      ->where('cargo_id', $cargo)
	      ->first();

	     $txt_aprueba = DB::table('WEB.ListaplatrabajadoresGenereal')
	      ->where('COD_TRAB', $usuario_aprueba)
	      ->first();


        if ($opcion === 'I') {
            $existe = DB::table('WEB.VALE_PERSONAL_APRUEBA') 
                ->where('COD_CENTRO', $sede)
                ->where('COD_ESTADO', '!=', '0') 
                ->exists();

            if ($existe) {
                return response()->json(['error' => 'La sede ya está registrada.']);
            }
         }

        if ($opcion === 'U') {
        
            $this->insertRegistroPersonalAprueba(
                "U", 
                $personal_aprueba_id,
                "",
                $sede, 
                $area,
                $txt_area->cadarea,
                $cargo,
                $txt_cargo->cadcargo,
                $usuario_aprueba,
                $txt_aprueba->nombres . ' ' . $txt_aprueba->apellidopaterno . ' ' . $txt_aprueba->apellidomaterno,
                true,
                ""
            );

        } else {
            $this->insertRegistroPersonalAprueba(
                "I", 
                $personal_aprueba_id,
                "",
                $sede, 
                $area,
                $txt_area->cadarea,
                $cargo,
                $txt_cargo->cadcargo,
                $usuario_aprueba,
                $txt_aprueba->nombres . ' ' . $txt_aprueba->apellidopaterno . ' ' . $txt_aprueba->apellidomaterno,
                true,
                ""
            );
        }

        return response()->json(['success' => 'Registro Importe procesado correctamente.']);
    }



    public function actionEliminarRegistroPersonalAprueba(Request $request)
    { 
        $id_buscar = $request->input('personalaprueba_id'); 

            $this->insertRegistroPersonalAprueba(
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
                false,
                Session::get('usuario')->id 
            );

        return response()->json(['success' => 'Registro de Importe eliminado correctamente.']);
    }


    public function traerdataPersonalApruebaAction(Request $request)
    {
        $id_buscar = $request->input('personalaprueba_id');
        $usuarios = WEBRegistroPersonalAprueba::where('ID', $id_buscar)->get(['ID', 'COD_CENTRO', 'COD_AREA', 'COD_CARGO', 'COD_APRUEBA'])->toJson();

        return $usuarios;
    }

    public function obtenerAreaYCargo(Request $request)
    {
        $cod_trab = $request->input('cod_trab');


        $trabajador = DB::table('WEB.ListaplatrabajadoresGenereal')
            ->select('area_id', 'cadarea', 'cargo_id', 'cadcargo')
            ->where('COD_TRAB', $cod_trab)
            ->first();

        if ($trabajador) {
            return response()->json([
                'area_id'   => $trabajador->area_id,
                'cadarea'   => $trabajador->cadarea,
                'cargo_id'  => $trabajador->cargo_id,
                'cadcargo'  => $trabajador->cadcargo,
            ]);
        }

        return response()->json(['error' => 'Usuario no encontrado'], 404);
    }

}