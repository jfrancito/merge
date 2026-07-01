<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoImporteMotivoValeRendir;
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

        $distritos = $origenes; // Copiamos las opciones sin el texto por defecto

        $origenes = ['' => '-- Seleccione Origen --'] + $origenes;
        $tipo_importe = ['' => '-- Seleccione Tipo Importe --'] + $tipo_importe;
        $distritos = ['' => '-- Seleccione Distrito / Destino --'] + $distritos;

        $registros = DB::table('WEB.REGISTRO_IMPORTE_RUTAS')->where('COD_ESTADO', 1)->orderBy('FEC_USUARIO_CREA_AUD', 'desc')->get();

        // Agrupar los registros para la vista de acordeón
        $rutas_agrupadas = [];
        foreach ($registros as $reg) {
            $key = $reg->COD_ORIGEN . '_' . $reg->COD_DISTRITO;
            if (!isset($rutas_agrupadas[$key])) {
                $rutas_agrupadas[$key] = [
                    'origen' => $reg->NOM_ORIGEN,
                    'destino' => $reg->NOM_DISTRITO,
                    'cod_origen' => $reg->COD_ORIGEN,
                    'cod_destino' => $reg->COD_DISTRITO,
                    'matriz' => []
                ];
            }
            $rutas_agrupadas[$key]['matriz'][$reg->TXT_NOM_TIPO][$reg->TXT_LINEA] = $reg->CAN_IMPORTE;
        }

        return view('valerendir.rutas.rutasprincipal', [
            'ajax' => true,
            'origenes' => $origenes,
            'departamentos' => $departamentos,
            'provincias' => $provincias,
            'distritos' => $distritos,
            'tipo_importe' => $tipo_importe,
            'tipos_linea' => $tipos_linea,
            'registros' => $registros,
            'rutas_agrupadas' => $rutas_agrupadas
        ]);
    }

    public function actionGuardarRegistroImporteRutas(Request $request)
    {
        try {
            $datos = $request->input('datos');
            $cod_origen = $request->input('origen');
            $nom_origen = $request->input('nom_origen');
            $cod_distrito = $request->input('distrito');
            $nom_distrito = $request->input('nom_distrito');
            
            $ind_tipo_operacion = $request->input('ind_tipo_operacion', 'I');
            
            // Validar si la ruta (Origen -> Destino) ya existe, SOLO si es Inserción Nueva
            if ($ind_tipo_operacion == 'I') {
                $existeRuta = DB::table('WEB.REGISTRO_IMPORTE_RUTAS')
                    ->where('COD_ORIGEN', $cod_origen)
                    ->where('COD_DISTRITO', $cod_distrito)
                    ->where('COD_ESTADO', 1)
                    ->exists();

                if ($existeRuta) {
                    return response()->json([
                        'success' => false, 
                        'message' => "La ruta desde $nom_origen hacia $nom_distrito ya se encuentra registrada. No se pueden guardar duplicados."
                    ]);
                }
            }

            // Convertir Origen a BIT (1 o 0) basado en el nombre (puedes ajustar esta lógica según tus nombres reales de Origen)
            // Si no podemos determinarlo por nombre, lo enviamos como 0 o 1.
            $ind_destino = (strpos(strtoupper($nom_origen), 'INTERNACIONAL') !== false) ? 1 : 0;

            if (!empty($datos)) {
                foreach ($datos as $fila) {
                    if ($ind_tipo_operacion == 'U') {
                        // Actualizar directamente por llaves compuestas
                        DB::table('WEB.REGISTRO_IMPORTE_RUTAS')
                            ->where('COD_ORIGEN', $cod_origen)
                            ->where('COD_DISTRITO', $cod_distrito)
                            ->where('COD_TIPO', $fila['cod_tipo'])
                            ->where('COD_LINEA', $fila['cod_linea'])
                            ->where('COD_ESTADO', 1)
                            ->update([
                                'CAN_IMPORTE' => $fila['importe'],
                                'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id ?? '',
                                'FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                            ]);
                    } else {
                        // Insertar mediante el SP
                        $this->insertRegistroImporteRutas(
                            'I', // Siempre 'I' para insertar
                            '', // id
                            '', // cod_empr
                            '', // cod_centro
                            '', // nom_centro
                            $cod_origen,
                            $nom_origen,
                            $cod_distrito,
                            $nom_distrito,
                            $fila['cod_tipo'],
                            $fila['txt_nom_tipo'],
                            $fila['cod_linea'],
                            $fila['txt_linea'],
                            $fila['importe'],
                            $ind_destino,
                            1, // cod_estado
                            '' // cod_usuario_registro
                        );
                    }
                }
            }

            return response()->json(['success' => true, 'message' => 'Importes guardados correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Ocurrió un error: ' . $e->getMessage()]);
        }
    }

    public function actionEliminarRegistroImporteRutas(Request $request)
    {
        try {
            $cod_origen = $request->input('origen');
            $cod_distrito = $request->input('distrito');

            // Eliminar de forma lógica (inactivar) usando Query Builder directamente
            DB::table('WEB.REGISTRO_IMPORTE_RUTAS')
                ->where('COD_ORIGEN', $cod_origen)
                ->where('COD_DISTRITO', $cod_distrito)
                ->where('COD_ESTADO', 1)
                ->update([
                    'COD_ESTADO' => 0,
                    'COD_USUARIO_MODIF_AUD' => Session::get('usuario')->id ?? '',
                    'FEC_USUARIO_MODIF_AUD' => DB::raw('GETDATE()')
                ]);

            return response()->json(['success' => true, 'message' => 'Ruta eliminada correctamente.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}



