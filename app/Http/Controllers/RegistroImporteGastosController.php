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
         $tipoLinea = DB::table('WEB.TIPO_LINEA')->where('cod_estado', 1)->pluck('txt_linea', 'cod_linea')->toArray();


        $combo = array('' => 'Seleccione Origen') + $nombreCentro;
        $combo1 = array('' => 'Seleccione Departamento') + $nombreDep;
        $combo2 = array('' => 'Seleccione Provincia') + $nombreProv;
        $combo3 = array('' => 'Seleccione Distrito') + $nombreDis;
        $combo4 = array('' => 'Seleccione Tipo Importe') + $tipoImporteMotivo;
        $combo5 = array('' => 'Seleccione Tipo Linea') + $tipoLinea;


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

          $agrupado = collect($listarimportegastos)
        ->groupBy(function ($item) {
            return $item['NOM_CENTRO'] . '|' .
                   $item['NOM_DEPARTAMENTO'] . '|' .
                   $item['NOM_PROVINCIA'] . '|' .
                   $item['NOM_DISTRITO'] . '|' .
                   $item['TIPO'] . '|' .
                   $item['IND_DESTINO'];
        })
        ->map(function ($items) {
            $base = $items->first();

            // Limpiar posibles campos previos
            $base['IMP_GERENTE'] = $base['IMP_JEFE'] = $base['IMP_DEMAS'] = 0;
            $base['ID_GERENTE'] = $base['ID_JEFE'] = $base['ID_DEMAS'] = null;

            foreach ($items as $i) {
                switch ($i['COD_LINEA']) {
                    case 'TPL0000000000001': // Gerente
                        $base['IMP_GERENTE'] = $i['CAN_TOTAL_IMPORTE'];
                        $base['ID_GERENTE'] = $i['ID'];
                        break;
                    case 'TPL0000000000002': // Jefe
                        $base['IMP_JEFE'] = $i['CAN_TOTAL_IMPORTE'];
                        $base['ID_JEFE'] = $i['ID'];
                        break;
                    case 'TPL0000000000003': // Demás líneas
                        $base['IMP_DEMAS'] = $i['CAN_TOTAL_IMPORTE'];
                        $base['ID_DEMAS'] = $i['ID'];
                        break;
                }
            }

            return $base;
        })
        ->values()
        ->toArray();
        
        return view('valerendir.ajax.modalregistroimportegastos', [
            'listacentro' => $combo,
            'listadepartamento' => $combo1,
            'listaprovincia' => $combo2,
            'listadistrito' => $combo3,
            'listatipoimporte' => $combo4,
            'listatipolinea' => $combo5,
            'listarimportegastos' => $listarimportegastos,
            'listarimportegastos' => $agrupado,
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
        $cod_linea = $request->input('cod_linea');
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
        $tipoLinea = DB::table('WEB.TIPO_LINEA')->where('cod_estado', 1)->pluck('txt_linea', 'cod_linea');

        $txt_linea = $tipoLinea->get($cod_linea);

         $registroExistente = DB::table('WEB.REGISTRO_IMPORTE_GASTOS')
        ->where('COD_CENTRO', $cod_centro)
        ->where('COD_DEPARTAMENTO', $cod_departamento)
        ->where('COD_PROVINCIA', $cod_provincia)
        ->where('COD_DISTRITO', $cod_distrito)
        ->where('COD_TIPO', $cod_tipo)
        ->where('COD_LINEA', $cod_linea)
        ->where('IND_DESTINO', $ind_destino)
        ->where('COD_ESTADO', 1)
        ->first();

        // ===================== DETERMINAR SI SE INSERTA O ACTUALIZA =====================
        if ($registroExistente) {
            // Ya existe → Actualizar
            $opcion = 'U';
            $importe_gastos_id = $registroExistente->ID;
        } else {
            // No existe → Insertar
            $opcion = 'I';
        }
 

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
                $cod_linea,
                $txt_linea,
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
                $cod_linea,
                $txt_linea,
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
                '',
                '',    
                false,
                Session::get('usuario')->id 
            );

        return response()->json(['success' => 'Registro de Importe eliminado correctamente.']);
    }

    public function traerdataImporteGastosAction(Request $request)
        {
            $id_buscar = $request->input('importegastos_id');
            $usuarios = WEBRegistroImporteGastos::where('ID', $id_buscar)->get(['ID', 'COD_CENTRO', 'COD_DEPARTAMENTO', 'COD_PROVINCIA', 'COD_DISTRITO', 'COD_TIPO',  'CAN_TOTAL_IMPORTE',  'IND_DESTINO',  'CAN_COMBUSTIBLE', 'COD_LINEA'])->toJson();
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



