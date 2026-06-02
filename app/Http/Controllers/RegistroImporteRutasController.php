<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;
use App\Modelos\STDTrabajadorVale;
use App\Modelos\WEBTipoImporteMotivoValeRendir;
use App\Modelos\WEBRegistroImporteGastos;
use App\Modelos\ALMCentro;
use App\Modelos\CMPCategoria;
use Session;
use App\WEBRegla, App\STDTrabajador, App\STDEmpresa, APP\User;
use View;
use Validator;



class RegistroImporteRutasController extends Controller
{
    public function actionRegistroImporteRutas(Request $request)
    {
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
            'tipo_importe' => $tipo_importe
        ]);
    }
}



