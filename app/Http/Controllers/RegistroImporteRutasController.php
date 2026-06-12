<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoImporteMotivoValeRendir;
use App\Modelos\WEBRegistroImporteViaticos;
use App\Modelos\ALMCentro;
use App\Modelos\CMPCategoria;
use Session;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, APP\User;
use App\Traits\RegistroImporteRutasTraits;
use App\Modelos\WEBTipoLineaValeRendir;
use View;
use Validator;



class RegistroImporteRutasController extends Controller
{
    use RegistroImporteRutasTraits;

    public function actionRegistroImporteRutas(Request $request)
    {
        $tipos_linea = WEBTipoLineaValeRendir::orderBy('COD_LINEA', 'asc')->get();
        $origenes = CMPCategoria::where('TXT_GRUPO', 'LIKE', '%DIS%')->orderBy('NOM_CATEGORIA', 'asc')->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')->toArray();
        $departamentos = CMPCategoria::where('TXT_GRUPO', 'LIKE', '%departamento%')->pluck('NOM_CATEGORIA', 'COD_CATEGORIA')->toArray();
        $tipo_importe = WEBTipoImporteMotivoValeRendir::where('cod_estado', 1)->pluck('txt_importe_motivo', 'cod_importe_motivo')->toArray();
        $provincias = [];
        $distritos = [];

        $origenes = ['' => '-- Seleccione Origen --'] + $origenes;
        $tipo_importe = ['' => '-- Seleccione Tipo Importe --'] + $tipo_importe;

        $departamentos = ['' => '-- Seleccione Departamento --'] + $departamentos;
        $provincias = ['' => '-- Seleccione Provincia --'] + $provincias;
        $distritos = ['' => '-- Seleccione Distrito --'] + $distritos;

        return view('valerendir.rutas.rutasprincipal', [
            'ajax' => true,
            'origenes' => $origenes,
            'departamentos' => $departamentos,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'tipo_importe' => $tipo_importe,
            'tipos_linea' => $tipos_linea
        ]);
    }

    public function actionGuardarRegistroImporteRutas(Request $request)
    {
        try {
            $datos = $request->input('datos');
            $cod_departamento = $request->input('departamento');
            $nom_departamento = $request->input('nom_departamento');
            $cod_provincia = $request->input('provincia');
            $nom_provincia = $request->input('nom_provincia');
            $cod_distrito = $request->input('distrito');
            $nom_distrito = $request->input('nom_distrito');
            $nom_origen = $request->input('nom_origen');
            
            // Convertir Origen a BIT (1 o 0) basado en el nombre (puedes ajustar esta lógica según tus nombres reales de Origen)
            // Si no podemos determinarlo por nombre, lo enviamos como 0 o 1.
            $ind_destino = (strpos(strtoupper($nom_origen), 'INTERNACIONAL') !== false) ? 1 : 0;

            if (!empty($datos)) {
                foreach ($datos as $fila) {
                    $this->insertRegistroImporteViaticos(
                        'I', // ind_tipo_operacion
                        '', // id
                        '', // cod_empr (tomado de sesion en trait)
                        '', // cod_centro
                        '', // nom_centro
                        $cod_departamento,
                        $nom_departamento,
                        $cod_provincia,
                        $nom_provincia,
                        $cod_distrito,
                        $nom_distrito,
                        $fila['cod_tipo'],
                        $fila['txt_nom_tipo'],
                        $fila['cod_linea'],
                        $fila['txt_linea'],
                        $fila['importe'],
                        $ind_destino,
                        1, // cod_estado
                        '' // cod_usuario_registro (tomado de sesion en trait)
                    );
                }
            }

            return response()->json(['success' => true, 'message' => 'Importes guardados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }
}



