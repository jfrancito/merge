<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Traits\RegistroImporteGastosTraits;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoImporteMotivoValeRendir;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\CMPCategoria;
use Session;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, APP\User;
use View;
use Validator;



class RegistroImporteGastosController extends Controller
{
    use RegistroImporteGastosTraits;  

      public function actionRegistroImporteGastos(Request $request)


    {
      $nombreCentro = ALMCentro::where('cod_estado', 1)
                        ->orderBy('nom_centro', 'asc')
                        ->pluck('nom_centro', 'cod_centro')
                        ->toArray();


       $nombreDep = CMPCategoria::selectRaw('c.cod_categoria, c.nom_categoria')
                        ->from('CMP.CATEGORIA as c')
                        ->where('c.ind_activo', 1)
                        ->where('c.txt_grupo', 'DEPARTAMENTO')
                        ->orderBy('c.nom_categoria', 'asc')
                        ->pluck('nom_categoria', 'cod_categoria')
                        ->toArray();


        $nombreProv = CMPCategoria::selectRaw('c.cod_categoria, c.nom_categoria')
                        ->from('CMP.CATEGORIA as c')
                        ->where('c.ind_activo', 1)
                        ->where('c.txt_grupo', 'PROVINCIA')
                        ->orderBy('c.nom_categoria', 'asc')
                        ->pluck('nom_categoria', 'cod_categoria')
                        ->toArray();

         $nombreDis = CMPCategoria::selectRaw('c.cod_categoria, c.nom_categoria')
                        ->from('CMP.CATEGORIA as c')
                        ->where('c.ind_activo', 1)
                        ->where('c.txt_grupo', 'DISTRITO')
                        ->orderBy('c.nom_categoria', 'asc')
                         ->pluck('nom_categoria', 'cod_categoria')
                        ->toArray();

         $tipoImporteMotivo = WEBTipoImporteMotivoValeRendir::where('cod_estado',1)->pluck('txt_importe_motivo', 'cod_importe_motivo')->toArray();

    


        $combo = array('' => 'Seleccione Origen') + $nombreCentro;
        $combo1 = array('' => 'Seleccione Departamento') + $nombreDep;
        $combo2 = array('' => 'Seleccione Provincia') + $nombreProv;
        $combo3 = array('' => 'Seleccione Distrito') + $nombreDis;
        $combo4 = array('' => 'Seleccione Tipo Importe') + $tipoImporteMotivo;


        $cod_usuario_registro = Session::get('usuario')->id;
        $cod_empr = Session::get('empresas')->COD_EMPR;
        $usuario_logueado_id = Session::get('usuario')->usuarioosiris_id;

   


        $listarimportegastos = $this->listaRegistroImporteGastos(
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
                "",
                "",
                0.0,
                ""            
        );
        
        return view('valerendir.ajax.modalregistroimportegastos', [
            'listacentro' => $combo,
            'listadepartamento' => $combo1,
            'listaprovincia' => $combo2,
            'listadistrito' => $combo3,
            'listatipoimporte' => $combo4,
            'listarimportegastos' => $listarimportegastos,
            'ajax'=>true,   
        ]);
    }



    public function insertImporteGastosAction(Request $request) { 
        $cod_centro = $request->input('cod_centro');
        $cod_departamento = $request->input('cod_departamento');
        $cod_provincia = $request->input('cod_provincia');
        $cod_distrito = $request->input('cod_distrito');
        $can_total_importe = $request->input('can_total_importe');
        $cod_tipo = $request->input('cod_tipo');
        $ind_destino = $request->input('ind_destino');
        $can_combustible = $request->input('can_combustible');
        $importe_gastos_id = $request->input('importe_gastos_id'); 
        $opcion = $request->input('opcion'); 

        $cod_empr = Session::get('empresas')->COD_EMPR;
        $cod_usuario_registro = Session::get('usuario')->id;

       
        $txt_nom_centro = ALMCentro::where('cod_centro', $cod_centro)->get();
        $txt_nom_departamento = CMPCategoria::where('cod_categoria', $cod_departamento)->get();
        $txt_nom_provincia = CMPCategoria::where('cod_categoria', $cod_provincia)->get();
        $txt_nom_distrito = CMPCategoria::where('cod_categoria', $cod_distrito)->get();

    
        $txt_nom_tipo = WEBTipoImporteMotivoValeRendir::where('cod_importe_motivo', $cod_tipo)->get();
 

        // dd($txt_nom_tipo);

        if ($opcion === 'U') {
        
            $this->insertRegistroImporteGastos(
                "U", 
                $importe_gastos_id,
                "",
                $cod_centro, 
                $txt_nom_centro[0]['NOM_CENTRO'],
                $cod_departamento,
                $txt_nom_departamento[0]['NOM_CATEGORIA'],
                $cod_provincia,
                $txt_nom_provincia[0]['NOM_CATEGORIA'],
                $cod_distrito,
                $txt_nom_distrito[0]['NOM_CATEGORIA'],
                $can_total_importe, 
                $cod_tipo,
                $txt_nom_tipo[0]['TXT_IMPORTE_MOTIVO'],
                $ind_destino,
                $can_combustible,
                true,
                ""
            );

        } else {
            $this->insertRegistroImporteGastos(
                "I", 
                $importe_gastos_id,
                "",
                $cod_centro, 
                $txt_nom_centro[0]['NOM_CENTRO'],
                $cod_departamento,
                $txt_nom_departamento[0]['NOM_CATEGORIA'],
                $cod_provincia,
                $txt_nom_provincia[0]['NOM_CATEGORIA'],
                $cod_distrito,
                $txt_nom_distrito[0]['NOM_CATEGORIA'],
                $can_total_importe, 
                $cod_tipo,
                $txt_nom_tipo[0]['TXT_IMPORTE_MOTIVO'],
                $ind_destino,
                $can_combustible,
                true,
                ""
            );
        }

        return response()->json(['success' => 'Registro Importe procesado correctamente.']);
    }



    public function actionEliminarRegistroImporteGastos(Request $request)
    { 
        $id_buscar = $request->input('importegastos_id'); 

            $this->insertRegistroImporteGastos(
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
                0.0, 
                '',
                '', 
                '',
                0.0,    
                false,
                Session::get('usuario')->id 
            );

        return response()->json(['success' => 'Registro de Importe eliminado correctamente.']);
    }

    public function traerdataImporteGastosAction(Request $request)
        {
            $id_buscar = $request->input('importegastos_id');
            $usuarios = WEBRegistroImporteGastos::where('ID', $id_buscar)->get(['ID', 'COD_CENTRO', 'COD_DEPARTAMENTO', 'COD_PROVINCIA', 'COD_DISTRITO', 'COD_TIPO',  'CAN_TOTAL_IMPORTE',  'IND_DESTINO',  'CAN_COMBUSTIBLE'])->toJson();
            return $usuarios;
        }



    public function listarProvinciasPorDepartamento(Request $request)
    {
        $cod_departamento = $request->input('cod_departamento');

        $provincias = CMPCategoria::select('c.cod_categoria', 'c.nom_categoria')
            ->from('CMP.CATEGORIA as c')
            ->where('c.ind_activo', 1)
            ->where('c.txt_grupo', 'PROVINCIA')
            ->where('c.cod_categoria_sup', $cod_departamento)  
            ->orderBy('c.nom_categoria', 'asc')
            ->get();

        return response()->json($provincias); 
    }



    public function listarDistritosPorProvincias(Request $request)
    {
        $cod_provincia = $request->cod_provincia;

        $distritos = CMPCategoria::selectRaw('c.cod_categoria, c.nom_categoria')
            ->from('CMP.CATEGORIA as c')
            ->where('c.ind_activo', 1)
            ->where('c.txt_grupo', 'DISTRITO')
            ->where('c.cod_categoria_sup', $cod_provincia) 
            ->orderBy('c.nom_categoria', 'asc')
            ->get();

        return response()->json($distritos);
    }

    public function validarDestinoPorDistrito(Request $request)
    {
        $cod_distrito = $request->cod_distrito;
        $cod_centro = $request->cod_centro;

        $registro = DB::table('WEB.REGISTRO_IMPORTE_GASTOS')
                      ->where('COD_DISTRITO', $cod_distrito)
                      ->where('COD_CENTRO', $cod_centro)
                      ->where('COD_ESTADO', 1)
                      ->first();

        return response()->json(['ind_destino' => $registro->IND_DESTINO ?? null]);
    }



}



